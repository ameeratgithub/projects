//Intializing Mongoose ORM

const mongoose=require('mongoose');

// Creating Schema
let courseSchema=mongoose.Schema({
    id:String,
    name:String
});
// Creating Model
const courseModel=mongoose.model('Course',courseSchema);
// Class for Model Functions
class Course{
    async getCourses(){
        return await courseModel.find().exec();
    }
    async getOne(courseid){
        return await courseModel.findOne({_id:courseid}).exec();
    }

}
//Exporting model to be used in Controllers
module.exports=new Course();