const passport = require('passport');
const FacebookStrategy = require('passport-facebook').Strategy;


passport.use(new FacebookStrategy({
    clientID: 1353569551463483,
    clientSecret: "546144d33239a353d2e7be407707bcda",
    callbackURL: "http://localhost:3000/auth/facebook/callback"
}, function (accessToken, refreshToken, profile, done) {
    console.log('Working');
    return done(null, profile);
}));

passport.serializeUser(function (user, cb) {
    cb(null, user);
});

passport.deserializeUser(function (obj, cb) {
    cb(null, obj);
});
