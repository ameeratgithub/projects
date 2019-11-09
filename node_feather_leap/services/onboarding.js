const User = require('./user');
module.exports = {
    addProfiles: (req, res) => {
        User.addPublicProfile(req, res);
        User.addSocialProfile(req, res);
        User.addAvatar(req, res, '/' + req.user.username);
    }
}