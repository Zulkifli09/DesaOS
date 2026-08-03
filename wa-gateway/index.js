require('dotenv').config();
const express = require('express');
const cors = require('cors');
const { initWhatsApp } = require('./src/whatsapp');
const apiRoutes = require('./src/routes');

const app = express();
const PORT = process.env.PORT || 3000;

app.use(cors());
app.use(express.json({ limit: '50mb' }));
app.use(express.urlencoded({ extended: true, limit: '50mb' }));

// API Routes
app.use('/api', apiRoutes);

// Basic health check
app.get('/', (req, res) => {
    res.send('DesaOS WhatsApp Gateway is running.');
});

// Start Server
app.listen(PORT, async () => {
    console.log(`🚀 Gateway Server running on port ${PORT}`);
    
    // Initialize WhatsApp connection
    await initWhatsApp();
});
