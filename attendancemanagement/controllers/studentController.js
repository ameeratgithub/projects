//Initializing Models
const User=require('../models/userModel');
const StudentAttendance=require('../models/studentAttendanceModel');
//Student Controller
class studentController{
   async getStudents(req,res){
        res.json(await User.getStudents());
    }
   async getStudentsByCourse(req,res){
        res.json(await User.getStudentsByCourse(req.params.courseid));
    }
    async getStudentsByGrade(req,res){
        res.json(await User.getStudentsByGrade(req.params.grade));
    }
    async getStudentsByGradeCourse(req,res){
        res.json(await User.getStudentsByGradeCourse(req.params.courseid,req.params.grade));
    }
    async getAllAbsents(req,res){
        var startDate=new Date(req.params.startDate);
        var endDate=new Date(req.params.endDate);
        let absents=[];
        for(let i=startDate;i<=endDate; i.setDate(i.getDate()+1)){
            let absent=await StudentAttendance.getAllAbsents(req.params.id,(Number(i.getMonth())+1)+"/"+ i.getDate() +"/"+ i.getFullYear());
            if(!absent)continue;
            absents.push(absent);
        }
        res.json({name:await User.getUser(req.params.id),absents:absents});
    }
}
//Exporting Controller to routes
module .exports=new studentController();