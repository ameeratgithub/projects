const User = require('../models/User');
const PublicProfile = require('../models/PublicProfile');
const SocialProfile = require('../models/SocialProfile');
const imgur = require('imgur');
const fs = require('fs');
const crypto = require('crypto');
const Mailer = require('./mailer');
const bCrypt = require('bcrypt-nodejs');
module.exports = {
    addAvatar: (req, res, url) => {
        User.findOne({ where: { id: req.user.id } })
            .then(user => {
                if (req.files && req.files.avatar) {
                    let avatar = req.files.avatar;
                    const path = 'public/images/' + avatar.name;
                    avatar.mv(path, (err) => {
                        if (err) {
                            req.flash('error', 'Can\'t Upload Image');
                            return res.redirect(url);
                        }
                        imgur.uploadFile(path)
                            .then(json => {
                                user.update({ avatar: json.data.link }).then(() => {
                                    fs.unlink(path, () => { });
                                    if (!res.headersSent)
                                        return res.redirect(url);
                                });
                            })
                            .catch(err => {
                                req.flash('error', 'Something Went Wrong');
                                return res.redirect(url);
                            });
                    });
                }
                else {
                    if (url == "/setting") {
                        req.flash('error', 'Avatar Required');
                        return res.redirect(url);
                    }
                    user.update({ avatar: 'https://imgplaceholder.com/420x320/cccccc/757575/fa-user' });
                    if (res.headersSent) return;
                    return res.redirect(url);
                }
            });
    },
    addPublicProfile: (req, res, url) => {
        const b = req.body;
        
        if (b.areaOfExpertise == 0) {
            url = url ? url : req.originalUrl;
            req.flash('error', "Area of Expertise required");
            return res.redirect(url);
        }
        if (b.color == 0) {
            url = url ? url : req.originalUrl;
            req.flash('error', "Color required");
            return res.redirect(url);
        }
        const publicInputs = {
            tagline: b.tagline,
            areaOfExpertise: b.areaOfExpertise,
            color: b.color.trim(),
            greetViewers: b.greetViewers,
            things: b.things,
            buttonText: b.buttonText,
            buttonUrl: b.buttonUrl,
            bio: b.bio
        };
        PublicProfile.findOrCreate({ where: { userId: req.user.id }, defaults: publicInputs })
            .then(([publicProfile, created]) => {
                User.findOne({ where: { id: req.user.id } }).then(user => {
                    user.update({ isFirstLogin: false });
                });
                if (!created && publicProfile) {
                    publicProfile.update(publicInputs).then(pp => {
                        if (url) {
                            req.flash('message', 'Public Profile Updated');
                            return res.redirect(url);
                        }
                    });
                }
            });
    },
    addSocialProfile: (req, res, url) => {
        const b = req.body;

        const socialInputs = {
            instagram: b.instagram,
            twitter: b.twitter,
            github: b.github,
            linkedin: b.linkedin,
            telegram: b.telegram,
            facebook: b.facebook,
            isEmailPublic: b.isEmailPublic == "on"
        };
        SocialProfile.findOrCreate({ where: { userId: req.user.id }, defaults: socialInputs })
            .then(([socialProfile, created]) => {
                if (!created && socialProfile) {
                    socialProfile.update(socialInputs).then(sp => {
                        if (url) {
                            req.flash('message', 'Social Profile Updated');
                            return res.redirect(url);
                        }
                    });
                }
            })
    },
    sendPasswordResetLink: (req, res) => {
        const b = req.body;
        if (b.email == 0) {
            req.flash('error', 'Email Required');
            return res.redirect('/forgot-password');
        }
        User.findOne({ where: { email: b.email } }).then(user => {
            if (!user) {
                req.flash('error', 'Email not found');
                return res.redirect('/forgot-password');
            }
            const token = crypto.randomBytes(16).toString('hex');
            sendPasswordResetLink(b.email, token).then((info, error) => {
                if (!error) {
                    user.update({ verificationToken: token });
                    req.flash('message', "Verfication link sent to your email");
                } else {
                    req.flash('error', "Something went wrong");
                }
                res.redirect('/forgot-password');
            });
        });
    },
    verifyPasswordResetToken: (req, res) => {
        const token = req.query.token;
        User.findOne({ where: { verificationToken: token } })
            .then(user => {
                if (user) {
                    res.render('reset-password', { token: token, error: req.flash('error'), message: req.flash('message') });
                }
                else {
                    res.send('Invalid Token');
                }
            });
    },
    resetPassword: (req, res) => {
        const b = req.body;
        const path = `http://localhost:3000/reset-password?token=${b.token}`;
        if (b.newPassword == 0) {
            req.flash('error', 'New Password Required');
            return res.redirect(path);
        }
        if (b.newPassword.length < 8) {
            req.flash('error', 'Password Must Contain Atleast 8 Characters');
            return res.redirect(path);
        }
        if (b.confirmPassword == 0) {
            req.flash('error', 'Confirm Password Required');
            return res.redirect(path)
        }
        if (b.newPassword != b.confirmPassword) {
            req.flash('error', 'Password doesn\'t match');
            return res.redirect(path)
        }
        User.findOne({ where: { verificationToken: b.token } })
            .then(user => {
                if (user) {
                    const password = bCrypt.hashSync(b.newPassword, bCrypt.genSaltSync(8), null);
                    user.update({ verified: true, verificationToken: null, password: password });
                    res.redirect('/login');
                }
                else {
                    res.send('Invalid Token');
                }
            });
    },
    getProfiles: (req, res) => {
        User.findOne({ where: { username: req.params.username }, include: ['public_profile', 'social_profile'] }).then(user => {
            if (user) {
                let modifiedThings = user.public_profile.things.split(', ');
                modifiedThings.unshift('  ');
                user.public_profile.things = JSON.stringify(modifiedThings)
                return res.render('profile', { user: user });
            }
            res.send("No profile found");
        });
    },
    getDashboardData: (req, res) => {
        User.findOne({ where: { username: req.user.username }, include: ['public_profile', 'social_profile'] }).then(user => {
            if (user.isFirstLogin) {
                return res.redirect('/onboarding');
            }
            res.render('dashboard', { error: req.flash('error'), message: req.flash('message'), user: user });
        });
    }
}
const sendPasswordResetLink = (email, token) => {
    return Mailer.sendEmail(email, 'Password Reset',
        `
        <h3>Password Reset </h3>
        <p>Please click the following link to reset your password </p>
        <a href="http://localhost:3000/reset-password?token=${token}">Click to Verify</a>
    `
    );
}