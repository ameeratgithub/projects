//Intializing Mongoose ORM
const mongoose=require('mongoose');
// Creating Schema
let gradeSchema=mongoose.Schema({
    id:String,
    name:String
});
// Creating Model
const gradeModel=mongoose.model('Grade',gradeSchema);
// Class for Model Functions
class Grade{
    async getGrades(){
        return await gradeModel.find().exec();
    }
}
//Exporting model to be used in Controllers
module.exports=new Grade();