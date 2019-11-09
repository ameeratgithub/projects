//Intializing Mongoose ORM

const mongoose=require('mongoose');
// Creating Schema

let userSchema=mongoose.Schema({
    id:String,
    name:String,
    email:String,
    type:String,
    grade:String,
    courses:[],
    parent:String
});

// Creating Model
const UserModel=mongoose.model('User',userSchema);

// Class for Model Functions
class User{
    async getUser(userid){
        return await UserModel.findOne({
           _id:userid
        }).exec();
    }
    async getParents(){
        return await UserModel.find({type:'parent'}).exec();
    }
    async getStudents(){
          return await UserModel.find({
              type:'student'
          }).exec();
    }
    async getChildren(email){
        return await UserModel.find({parent:email}).exec();
    }
    async getTeachers(){
        return await UserModel.find({
            type:'teacher'
        }).exec();
    }
    async getStudentsByCourse(courseid){
        return await UserModel.find({
                courses:mongoose.Types.ObjectId(courseid)
        }).exec();
    }
    async getStudentsByGradeCourse(courseid,grade){

        return await UserModel.find({$and:[{
            courses:mongoose.Types.ObjectId(courseid)
        },{grade:grade}]}).exec();
    }
    async getStudentsByGrade(grade){
        return await UserModel.find({grade:grade,type:'student'}).exec();
    }
    async getTeacherCourses(teacherid){
        return await UserModel.findOne({_id:teacherid},{courses:1}).exec();
    }
    async getGradeByCourse(courseid){
        return await UserModel.find({type:'student',courses:mongoose.Types.ObjectId(courseid)},{grade:1}).exec();
    }
    async getGrade(userid){
        return await UserModel.findOne({_id:userid},{grade:1}).exec();
    }
    async searchUser(type,name){
        return await UserModel.find({type:type,name:new RegExp(name,'i')}).exec();
    }
    async getCoursesByGrade(gradename){
        return await UserModel.find({grade:gradename,type:'student'},{courses:1}).exec();
    }
}
//Exporting model to be used in Controllers
module.exports=new User();