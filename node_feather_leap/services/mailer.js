var nodemailer = require('nodemailer');
module.exports = {
    sendEmail: (to, subject, html) => {
        var transporter = nodemailer.createTransport({
            host: 'smtp.gmail.com',
            port: 587,
            secure: false,
            requireTLS: true,
            auth: {
                user: '',
                pass: ''
            }
        });

        var mailOptions = {
            from: 'ameeratwork@gmail.com',
            to: to,
            subject: subject,
            html: html
        };
        return transporter.sendMail(mailOptions);
    }
};