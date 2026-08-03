const express = require('express');
const { getSock, getStatus, getQR, logout } = require('./whatsapp');

const router = express.Router();

// Middleware to check API Key from Laravel
const requireApiKey = (req, res, next) => {
    const apiKey = req.headers['x-api-key'];
    if (!apiKey || apiKey !== process.env.GATEWAY_API_KEY) {
        return res.status(401).json({ error: 'Unauthorized: Invalid API Key' });
    }
    next();
};

// Apply middleware to all routes
router.use(requireApiKey);

// Get Status
router.get('/status', (req, res) => {
    res.json({ status: getStatus() });
});

// Get QR Code
router.get('/qr', (req, res) => {
    const status = getStatus();
    if (status === 'open') {
        return res.json({ status: 'open', message: 'Already connected', qr: null });
    }
    if (status === 'qr') {
        const qr = getQR();
        return res.json({ status: 'qr', qr });
    }
    res.json({ status, qr: null });
});

// Send Message API
router.post('/send', async (req, res) => {
    const sock = getSock();
    if (!sock || getStatus() !== 'open') {
        return res.status(503).json({ error: 'WhatsApp is not connected' });
    }

    const { jid, type = 'text', text, image, document, fileName, caption, buttons, templateButtons, footer } = req.body;

    if (!jid) {
        return res.status(400).json({ error: 'JID (phone number) is required' });
    }

    try {
        let msg = {};
        
        // Basic formatting of Indonesian numbers (e.g. 0812... -> 62812...@s.whatsapp.net)
        let formattedJid = jid;
        if (formattedJid.startsWith('0')) {
            formattedJid = '62' + formattedJid.substring(1);
        }
        if (!formattedJid.includes('@')) {
            formattedJid = `${formattedJid}@s.whatsapp.net`;
        }

        if (type === 'text') {
            msg = { text: text };
        } else if (type === 'image') {
            // image can be a URL or base64 string
            msg = { image: { url: image }, caption: caption };
        } else if (type === 'document') {
            msg = { document: { url: document }, fileName: fileName, mimetype: 'application/pdf' };
        }
        
        const result = await sock.sendMessage(formattedJid, msg);
        res.json({ success: true, messageId: result.key.id });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

// Logout API
router.post('/logout', async (req, res) => {
    try {
        await logout();
        res.json({ success: true, message: 'Logged out successfully' });
    } catch (error) {
        res.status(500).json({ success: false, error: error.message });
    }
});

module.exports = router;
