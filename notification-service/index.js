import express from 'express';
import bodyParser from 'body-parser';
import crypto from 'crypto';
import dotenv from 'dotenv';

dotenv.config();

const app = express();
app.use(bodyParser.json());

const PORT = process.env.PORT || 4000;
const SECRET = process.env.WEBHOOK_SECRET || 'supersecret';

let notifications = [];

function verifySignature(req, res, next) {
    const sig = req.headers['x-signature'];
    if (!sig) return res.status(401).json({ error: 'Missing signature' });

    const hmac = crypto.createHmac('sha256', SECRET);
    const digest = 'sha256=' + hmac.update(JSON.stringify(req.body)).digest('hex');

    if (sig !== digest) return res.status(403).json({ error: 'Invalid signature' });
    next();
}

app.post('/notify', verifySignature, (req, res) => {
    notifications.push(req.body);
    console.log('Notification received:', req.body);
    res.status(200).json({ success: true });
});

app.get('/notifications', (req, res) => {
    res.json(notifications);
});

app.get('/health', (req, res) => {
    res.json({ status: 'ok' });
});

// start only when this is run directly
if (process.env.NODE_ENV !== 'test') {
    app.listen(PORT, () => {
        console.log(`Notification service running on port ${PORT}`);
    });
}

export default app;
