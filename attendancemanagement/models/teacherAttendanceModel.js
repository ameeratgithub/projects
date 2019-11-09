//Intializing Mongoose ORM
const mongoose=require('mongoose');
// Creating Schema
let teacherAttendanceSchema=mongoose.Schema({
    id:String,
    date:String,
    present:[],
    absent:[]
});
// Creating Model
const TeacherAttendanceModel=mongoose.model('TeacherAttendance',teacherAttendanceSchema);
// Class for Model Functions
class StudentAttendance{
    async recordTeacherAttendance(attendance){
        return  await TeacherAttendanceModel.collection.insert(attendance);
    }
    async attendanceExists(attendance){
        var query={$and:[{date:attendance.date},
            {
                $or:[{present:attendance.absent[0]},{absent:attendance.absent[0]}]
            }
        ]};
        return await TeacherAttendanceModel.count(query).exec();
    }
    async addToRange(attendance){
        let exists=await this.attendanceExists(attendance);
        if(exists>0){
            var query={date:attendance.date};
            var pullIt={$pull:{present:attendance.absent[0]}};
            let pulled= await  TeacherAttendanceModel.collection.update(query,pullIt);
            let pushIt ={$push:{absent:attendance.absent[0]}};
            return await TeacherAttendanceModel.collection.update(query,pushIt);
        }
        else{
            return await this.recordTeacherAttendance(attendance);
        }
    }
    async getAllAbsents(id,date){
        var query={$and:[
            {absent:{$elemMatch:{id:id}}}
            ,{date:date}]};
        let absent=await TeacherAttendanceModel.findOne(query).exec();
        return absent;
    }
}
//Exporting model to be used in Controllers
module.exports=new StudentAttendance();