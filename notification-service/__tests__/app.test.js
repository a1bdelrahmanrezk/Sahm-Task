import request from 'supertest';
import crypto from 'crypto';
import app from '../index.js';

const SECRET = 'supersecret';

function signPayload(payload) {
    const hmac = crypto.createHmac('sha256', SECRET);
    return 'sha256=' + hmac.update(JSON.stringify(payload)).digest('hex');
}

describe('Notification Microservice', () => {
    const payload = {
        user_id: 1,
        task_id: 10,
        message: 'Task done',
        timestamp: new Date().toISOString(),
    };

    it('should reject missing signature', async () => {
        const res = await request(app).post('/notify').send(payload);
        expect(res.status).toBe(401);
    });

    it('should reject invalid signature', async () => {
        const res = await request(app)
            .post('/notify')
            .set('X-Signature', 'sha256=invalid')
            .send(payload);
        expect(res.status).toBe(403);
    });

    it('should accept valid signature and store notification', async () => {
        const sig = signPayload(payload);
        const res = await request(app)
            .post('/notify')
            .set('X-Signature', sig)
            .send(payload);
        expect(res.status).toBe(200);
        expect(res.body.success).toBe(true);
    });

    it('should list notifications', async () => {
        const res = await request(app).get('/notifications');
        expect(res.status).toBe(200);
        expect(res.body.length).toBeGreaterThan(0);
    });

    it('should return ok health', async () => {
        const res = await request(app).get('/health');
        expect(res.status).toBe(200);
        expect(res.body.status).toBe('ok');
    });
});
