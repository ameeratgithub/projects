
//Initializing Models
const User=require('../models/userModel');
const TeacherAttendance=require('../models/teacherAttendanceModel');
const Course=require('../models/courseModel');
const dateController=require('./dateController');

//Teacher Controllers

class teacherController{
    async getTeachers(req,res){
        res.json(await User.getTeachers());
    }
    async getCourses(req,res){
        let courses=await User.getTeacherCourses(req.params.id);
        let newCourses=[];
        for (let i of courses.courses){
            let course=await Course.getOne(i);
            newCourses.push(course);
        }
        res.json(newCourses);
    }
    async getAllAbsents(req,res){
        var startDate=new Date(req.params.startDate);
        var endDate=new Date(req.params.endDate);
        let absents=[];
        for(let i=startDate;i<=endDate; i.setDate(i.getDate()+1)){
            let absent=await TeacherAttendance.getAllAbsents(req.params.id, dateController.S_MMDDYYYY(i));
            if(!absent)continue;
            absents.push(absent);
        }
        res.json({name:await User.getUser(req.params.id),absents:absents});
    }
}

//Exporting controller to routes

module .exports= new teacherController();