//Requiring Mongoose Module
const mongoose=require('mongoose');

//Connecting to database attendance management

mongoose.connect("mongodb://localhost/attendancemanagement");
let db=mongoose.connection;

//Check for DB Connection

db.once('open',function(){
    console.log("Connected to mongodb");
});

//Check for DB Errors

db.on('error',function(err){
    console.log(err);
});