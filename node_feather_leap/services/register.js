const Op = require('Sequelize').Op;
const bCrypt = require('bcrypt-nodejs');
const crypto = require('crypto');

console.log(bCrypt.hashSync('usingfl123', bCrypt.genSaltSync(8), null))
const User = require('../models/User');
const Mailer = require('./mailer');

module.exports = {
    addUser: (req, res) => {
        const b = req.body;
        const password = b.password;
        const confirmPassword = b.passwordConfirm;
        if ((password && confirmPassword)) {
            if (password != confirmPassword) {
                req.flash('error', "Password doesn't match");
                res.redirect('/register');
            }
        }
        const user = {
            email: b.email,
            fullName: b.fullName,
            username: b.username,
            password: bCrypt.hashSync(b.password, bCrypt.genSaltSync(8), null)
        }
        User.findOrCreate({
            where: {
                [Op.or]: [
                    { username: b.username },
                    { email: b.email },
                ]
            },
            defaults: user
        })
            .then(([user, created]) => {
                if (!created) {
                    let msg = "";
                    if (user.email == b.email) {
                        msg = 'Email'
                    }
                    else if (user.username == b.username) {
                        msg = 'Username'
                    }
                    req.flash('error', msg + " Already Exists");
                    res.redirect('/register');
                }
                const token = crypto.randomBytes(16).toString('hex');
                sendVerificationLink(b.email, token).then((info, error) => {
                    console.log("Error", error, "Info", info);
                    if (!error) {
                        user.update({ verificationToken: token });
                        req.flash('message', "Verfication link sent to your email");
                    } else {
                        req.flash('error', "Something went wrong");
                    }
                    res.redirect('/register');
                });
            })
            .catch(err => {
                req.flash('error', err.errors[0].message);
                res.redirect('/register');
            });
    },
    verify: (req, res) => {
        const token = req.query.token;
        User.findOne({ where: { verificationToken: token } })
            .then(user => {
                if (user) {
                    user.update({ verified: true, verificationToken: null, isFirstLogin: true });
                    req.login(user, function (err) {
                        if (err) console.error(err);
                        res.redirect('/onboarding');
                    })
                }
                else {
                    res.send('Invalid Token');
                }
            });
    }
};
const sendVerificationLink = (email, token) => {
    return Mailer.sendEmail(email, 'Email Verification',
        `
        <h3>Email Verification </h3>
        <p>Please click the following link to verify your email </p>
        <a href="http://localhost:3000/verify?token=${token}">Click to Verify</a>
    `
    );
}