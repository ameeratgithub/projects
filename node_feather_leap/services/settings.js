const User = require('../models/User');
const bCrypt = require('bcrypt-nodejs');
module.exports = {
    updateNames: (req, res) => {
        const b = req.body;
        User.findOne({ where: { username: req.user.username } })
            .then(user => {
                if (b.fullName != 0) {
                    user.update({ fullName: b.fullName })
                        .catch(err => {
                            req.flash('error', err.errors[0].message);
                            return res.redirect('/settings');
                        });
                }
                if (b.username != 0) {
                    User.count({ where: { username: b.username } }).then(c => {
                        if (c > 0) {
                            req.flash('error', 'Username Already Exists');
                            return res.redirect('/settings');
                        }
                        user.update({ username: b.username })
                            .catch(err => {
                                req.flash('error', err.errors[0].message);
                                return res.redirect('/settings');
                            });
                    });
                }
                req.flash('message', 'Setting Saved!');
                res.redirect('/settings');
            });
    },
    updatePassword: (req, res) => {
        const b = req.body;
        if (b.oldPassword == 0) {
            req.flash('error', 'Old Password Required');
            return res.redirect('/settings');
        }
        if (b.newPassword == 0) {
            req.flash('error', 'New Password Required');
            return res.redirect('/settings');
        }
        if (b.newPassword.length < 8) {
            req.flash('error', 'Password Must Contain Atleast 8 Characters');
            return res.redirect('/settings');
        }
        if (b.confirmPassword == 0) {
            req.flash('error', 'Confirm Password Required');
            return res.redirect('/settings');
        }
        if (b.newPassword != b.confirmPassword) {
            req.flash('error', 'Password doesn\'t match');
            return res.redirect('/settings');
        }
        User.findOne({ where: { username: req.user.username } }).then(user => {
            const validPassword = bCrypt.compareSync(b.newPassword, user.password);
            if (!validPassword) {
                req.flash('error', 'Old Password is incorrect');
                return res.redirect('/settings');
            }
            user.update({ password: bCrypt.hashSync(b.password, bCrypt.genSaltSync(8), null) })
                .then(u => {
                    req.flash('message', 'Password Changed!');
                    res.redirect('/settings');
                });
        });
    },
    updateEmail: (req, res) => {
        const b = req.body;
        if (b.oldEmail == 0) {
            req.flash('error', 'Old Email Required');
            return res.redirect('/settings');
        }
        if (b.newEmail == 0) {
            req.flash('error', 'New Email Required');
            return res.redirect('/settings');
        }
        if (b.confirmEmail == 0) {
            req.flash('error', 'Confirm Email Required');
            return res.redirect('/settings');
        }
        if (b.newEmail != b.confirmEmail) {
            req.flash('error', 'Email doesn\'t match');
            return res.redirect('/settings');
        }
        User.findOne({ where: { username: req.user.username } }).then(user => {
            if (user.email != b.oldEmail) {
                req.flash('error', 'Old Email is incorrect');
                return res.redirect('/settings');
            }
            user.update({ email: b.newEmail }).then(u => {
                req.flash('message', 'Email Changed!');
                res.redirect('/settings');
            });
        });
    }
}