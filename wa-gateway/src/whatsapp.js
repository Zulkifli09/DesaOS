const { 
    makeWASocket, 
    useMultiFileAuthState, 
    DisconnectReason,
    fetchLatestBaileysVersion,
    makeCacheableSignalKeyStore
} = require('@whiskeysockets/baileys');
const pino = require('pino');
const axios = require('axios');
const fs = require('fs');
const path = require('path');

const logger = pino({ level: process.env.LOG_LEVEL || 'info' });

let sock = null;
let qrCode = null;
let connectionStatus = 'connecting'; // connecting, open, close, qr

const initWhatsApp = async () => {
    const { version, isLatest } = await fetchLatestBaileysVersion();
    logger.info(`using WA v${version.join('.')}, isLatest: ${isLatest}`);

    const { state, saveCreds } = await useMultiFileAuthState(path.join(__dirname, '../sessions'));

    sock = makeWASocket({
        version,
        logger,
        printQRInTerminal: true,
        auth: {
            creds: state.creds,
            /** caching makes the store faster to send/recv messages */
            keys: makeCacheableSignalKeyStore(state.keys, logger),
        },
        generateHighQualityLinkPreview: true,
        getMessage: async (key) => {
            return {
                conversation: 'Pesan ini tidak dapat dimuat.'
            };
        }
    });

    sock.ev.on('creds.update', saveCreds);

    sock.ev.on('connection.update', (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (qr) {
            qrCode = qr;
            connectionStatus = 'qr';
            logger.info('QR Code generated. Scan to login.');
        }

        if (connection === 'close') {
            const shouldReconnect = (lastDisconnect.error)?.output?.statusCode !== DisconnectReason.loggedOut;
            logger.info(`Connection closed due to ${lastDisconnect.error}, reconnecting: ${shouldReconnect}`);
            connectionStatus = 'close';
            
            if (shouldReconnect) {
                setTimeout(initWhatsApp, 5000); // Reconnect after 5s
            } else {
                logger.info('Logged out. Session data needs to be cleared.');
                qrCode = null;
                // Delete session folder if logged out manually
                fs.rmSync(path.join(__dirname, '../sessions'), { recursive: true, force: true });
                setTimeout(initWhatsApp, 2000);
            }
        } else if (connection === 'open') {
            logger.info('Opened connection');
            qrCode = null;
            connectionStatus = 'open';
        }
    });

    // Handle Incoming Messages
    sock.ev.on('messages.upsert', async (m) => {
        if (m.type === 'notify') {
            for (let msg of m.messages) {
                // Ignore messages sent by the bot itself
                if (msg.key.fromMe) continue;
                
                // Ignore broadcast messages for now
                if (msg.key.remoteJid === 'status@broadcast') continue;
                
                try {
                    // Send to Laravel Webhook
                    const webhookUrl = process.env.LARAVEL_WEBHOOK_URL;
                    const webhookToken = process.env.LARAVEL_WEBHOOK_TOKEN;
                    
                    if (webhookUrl) {
                        await axios.post(webhookUrl, { message: msg }, {
                            headers: {
                                'Authorization': `Bearer ${webhookToken}`,
                                'Content-Type': 'application/json'
                            }
                        });
                        logger.info(`Forwarded message from ${msg.key.remoteJid} to Laravel`);
                    } else {
                        logger.warn('LARAVEL_WEBHOOK_URL is not set. Cannot forward message.');
                    }
                } catch (error) {
                    logger.error(`Failed to send webhook to Laravel: ${error.message}`);
                }
            }
        }
    });
};

const getSock = () => sock;
const getStatus = () => connectionStatus;
const getQR = () => qrCode;
const logout = async () => {
    if (sock) {
        await sock.logout();
    }
};

module.exports = {
    initWhatsApp,
    getSock,
    getStatus,
    getQR,
    logout
};
