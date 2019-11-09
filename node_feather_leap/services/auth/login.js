require('./local');

module.exports = function (req, res, next) {
        const body = req.body;
        if (body.username != 0 && body.password != 0) {
                next();
        }
        else {
                req.flash('error', 'Username and Password Required');
                res.redirect('/login');
        }
}
