
const express = require('express');
const bodyParser = require('body-parser');
const cookieParser = require('cookie-parser');
const handlebars = require('express-handlebars');
const app = express();


require('./init/database');

//Setting static public directory

app.use(express.static(__dirname+"/public"));
//Helpers Handlebar
var hbs = handlebars.create({
    // Specify helpers which are only registered on this instance.
    defaultLayout:'main',
    extname:'.hbs',
    partials:{

    }
});


//Setting view engine handlebars

app.engine('hbs',hbs.engine);
app.set('view engine','hbs');
app.set('views',__dirname+"/views");

//Body Parser to access request data

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended:false}));

//Use Cookie Parser to use cookie features

app.use(cookieParser());

//Using Routes

const routes=require('./routes');
app.use('/',routes);


// Starting Server

const host="127.0.0.1";
const port=3000;
app.listen(port,host,()=>console.log(`Server has been started on http://${host}:${port}`));