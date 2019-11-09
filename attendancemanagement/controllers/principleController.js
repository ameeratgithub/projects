
//Initializing Models
const studentAttendanceModel=require('../models/studentAttendanceModel');
const teacherAttendanceModel=require('../models/teacherAttendanceModel');
const dateController=require('./dateController');
//Principal Controller
class principleController{
    async recordStudentAttendance(req,res){
        var record=JSON.parse(req.body.attendancerecord);
        let initialdate=new Date(record.initialDate);
        let finaldate=new Date(record.finalDate);
        let counter=[];
        for(let i=initialdate;i<=finaldate; i.setDate(i.getDate()+1)){
            var newRecord={
                course:record.course,
                date: dateController.S_MMDDYYYY(i),
                present:[],
                absent:record.absent
            };
            let inserted=await studentAttendanceModel.addToRange(newRecord);
            counter.push(inserted);
        }
        res.json(counter);
    }
    async recordTeacherAttendance(req,res){
        var record=JSON.parse(req.body.attendancerecord);
        let initialdate=new Date(record.initialDate);
        let finaldate=new Date(record.finalDate);
        let counter=[];
        for(let i=initialdate;i<=finaldate; i.setDate(i.getDate()+1)){
            var newRecord={
                course:record.course,
                date: dateController.S_MMDDYYYY(i),
                present:[],
                absent:record.absent
            };
            let inserted=await teacherAttendanceModel.addToRange(newRecord);
            counter.push(inserted);
        }
        res.json(counter);
    }
}
//Exporting Controller Object to routes
module .exports=new principleController();