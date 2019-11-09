const express = require('express');
const path = require('path');
const exphbs = require('express-handlebars');
const serveStatic = require('serve-static');

const passport = require('passport');
const session = require('express-session');
const cookieParser = require('cookie-parser');
const bodyParser = require('body-parser');
const flash = require('connect-flash');
const routes = require('./routes');

require('./init/database');

require('./init/imgur');

const app = express();
const fileUpload = require('express-fileupload');

app.use(fileUpload());
app.use(serveStatic(path.join(__dirname, 'public')));
app.engine('.hbs', exphbs(
    {
        defaultLayout: null, extname: '.hbs', helpers: {
            isEqual: function (expectedValue, value) {
                return value === expectedValue;
            }
        }
    }
));
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', '.hbs');

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(cookieParser());
app.use(session({ secret: 'keyboard cat', key: 'sid', resave: true, saveUninitialized: true }));
app.use(passport.initialize());
app.use(passport.session());
app.use(flash());

app.use('/', routes);

app.listen(3200, () => {
    console.log('Server is running at port 3200');
});