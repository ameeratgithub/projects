const passport = require('passport');
const LocalStrategy = require('passport-local').Strategy;
const bCrypt = require('bcrypt-nodejs');
const User = require('../../models/User');

passport.serializeUser(function (user, done) {
    done(null, user);
});

passport.deserializeUser(function (username, done) {
    done(null, username);
});

passport.use('local', new LocalStrategy({
    usernameField: 'username',
    passwordField: 'password',
    passReqToCallback: true
}, (req, username, password, done) => {
    const isValidPassword = function (userpass, password) {
        return bCrypt.compareSync(password, userpass);
    }
    User.findOne({ where: { username: username, verified: true } })
        .then(user => {
            if (!user) {
                return done(null, false, {
                    message: 'User Not Found'
                });
            }
            if (!isValidPassword(user.password, password)) {
                return done(null, false, {
                    message: 'Username or password is not correct'
                });
            }
            if (req.body.rememberMe) {
                req.session.cookie.maxAge = 30 * 24 * 60 * 60 * 1000; // Cookie expires after 30 days
            } else {
                req.session.cookie.expires = false; // Cookie expires at end of session
            }
            return done(null, user.get());
        })
        .catch((err) => {
            console.log(err);
            return done(null, false, {
                message: 'Something went wrong with your Signin'
            });
            
        });;
}
));



