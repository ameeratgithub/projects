
const express = require('express');
const router = express.Router();
const passport = require('passport');

const Register = require('./services/register');
const Login = require('./services/auth/login');
const Onboarding = require('./services/onboarding');
const Settings = require('./services/settings');
const User = require('./services/user');

const isAuthenticated = (req, res, next) => {
    if (req.isAuthenticated()) {
        return next();
    }
    res.redirect('/login');
}
require('./services/auth/local');
require('./services/auth/facebook');
require('./services/auth/google');

router.route('/register')
    .get(function (req, res) {
        if (req.isAuthenticated())
            res.redirect('/dashboard');
        else
            res.render('register', { error: req.flash('error'), message: req.flash('message') });
    })
    .post(Register.addUser);
router.route('/verify').get(Register.verify);
router.route('/onboarding')
    .get(isAuthenticated, function (req, res) {
        res.render('onboarding', { error: req.flash('error') });
    })
    .post(isAuthenticated, Onboarding.addProfiles);
router.route('/login')
    .get(function (req, res, next) {
        if (req.isAuthenticated()) {
            res.redirect('/dashboard');
        }
        else {
            res.render('login', { error: req.flash('error')[0] });
        }
    })
    .post(Login, passport.authenticate('local', {
        successRedirect: "/dashboard",
        failureRedirect: "/login",
        failureMessage: "Invalid username or password",
        failureFlash: true
    }));
router.route('/forgot-password')
    .get(function (req, res) {
        res.render('forgot-password', { error: req.flash('error'), message: req.flash('message') });
    })
    .post(User.sendPasswordResetLink);
router.route('/reset-password')
    .get(User.verifyPasswordResetToken)
    .post(User.resetPassword);
router.get('/auth/facebook', passport.authenticate('facebook'));

router.get('/auth/facebook/callback',
    passport.authenticate('facebook', { failureRedirect: '/login' }),
    function (req, res) {
        res.redirect('/');
    }
);
router.get('/auth/google', passport.authenticate('google', { scope: ['profile'] }));

router.get('/auth/google/callback',
    passport.authenticate('google', { failureRedirect: '/login' }),
    function (req, res) {
        res.redirect('/');
    });

router.get('/', function (req, res) {
    res.render('index');
});
router.get('/dashboard/', isAuthenticated, User.getDashboardData);
router.post('/dashboard/changeavatar', isAuthenticated, function (req, res) {
    User.addAvatar(req, res, '/dashboard');
});
router.post('/dashboard/changesocialprofile', isAuthenticated, function (req, res) {
    User.addSocialProfile(req, res, '/dashboard');
});
router.post('/dashboard/changepublicprofile', isAuthenticated, function (req, res) {
    User.addPublicProfile(req, res, '/dashboard');
});

router.get('/settings', isAuthenticated, function (req, res) {
    if (req.user.isFirstLogin) {
        return res.redirect('/onboarding');
    }
    res.render('settings', { error: req.flash('error'), message: req.flash('message'), user: req.user });
});
router.post('/settings/names', isAuthenticated, Settings.updateNames);
router.post('/settings/changepassword', isAuthenticated, Settings.updatePassword);
router.post('/settings/changeemail', isAuthenticated, Settings.updateEmail);
router.get('/logout', (req, res) => {
    req.logout();
    res.redirect('/login');
});
router.get('/:username', User.getProfiles);
module.exports = router;