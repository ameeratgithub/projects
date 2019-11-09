const passport = require('passport');

const GoogleStrategy = require('passport-google-oauth20').Strategy;

passport.use(new GoogleStrategy({
    clientID: "983381165866-1uv28c61t54kr2hb4dmpsmop4um13vjv.apps.googleusercontent.com",
    clientSecret: "ogdu2FfaUsX3_OVfemIxzkAd",
    callbackURL: "http://localhost:3000/auth/google/callback"
},
    function (accessToken, refreshToken, profile, cb) {
        console.log(profile);
        return cb(null, profile);
    }
));
