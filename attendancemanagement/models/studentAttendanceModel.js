//Intializing Mongoose ORM

const mongoose=require('mongoose');
// Creating Schema
let studentAttendanceSchema=mongoose.Schema({
    id:String,
    date:String,
    course:String,
    present:[],
absent:[]
});
// Creating Model
const StudentAttendanceModel=mongoose.model('StudentAttendance',studentAttendanceSchema);

// Class for Model Functions
class StudentAttendance{
    async recordStudentAttendance(attendance){
        attendance=JSON.parse(attendance);
        let exists=await this.attendanceExists(attendance);
        if(exists>0)
        {
            return {
                message:"Attendance has already been recorded...!",
                insertedCount:0
            };
        }
        return  await StudentAttendanceModel.collection.insert(attendance);
    }
    async attendanceExists(attendance){
        var query={course:attendance.course,date:attendance.date};
        return await StudentAttendanceModel.count(query).exec();
    }
    async addToRange(attendance){
        let exists=await this.attendanceExists(attendance);
        if(exists>0){
            var query={course:attendance.course,date:attendance.date};
            var pullIt={$pull:{present:attendance.absent[0]}};
            let pulled= await  StudentAttendanceModel.collection.update(query,pullIt);
            var pullAgain={$pull:{absent:attendance.absent[0]}};
            let pulledAgain= await  StudentAttendanceModel.collection.update(query,pullAgain);
            let pushIt ={$push:{absent:attendance.absent[0]}};
             return await StudentAttendanceModel.collection.update(query,pushIt);
        }
        else{
          return await this.recordStudentAttendance(JSON.stringify(attendance));
        }
    }
    async updateStudentAttendance(id,attendance){
        await StudentAttendanceModel.remove({_id:id});
        return  await StudentAttendanceModel.collection.insert(JSON.parse(attendance));
    }
    async getStudentAttendanceByCourse(courseid,date){
        return await StudentAttendanceModel.findOne({
            course:courseid,
            date:date
        }).exec();
    }
    async getAllAbsents(id,date){
        var query={$and:[
            {absent:{$elemMatch:{id:id}}}
            ,{date:date}]};
        let absent=await StudentAttendanceModel.findOne(query).exec();
        return absent;
    }
    async getByCourseId(date,courseid){
        let query={date:date,course:courseid};
        return await StudentAttendanceModel.findOne(query).exec();
    }
    async getByCourse(date){
     let complexQuery=[
         {$match:{date:date}},
         {$unwind:"$absent"},
         {$group:{_id:"$course",size:{$sum:1}}},
         {$group:{_id:{size:"$size",id:"$_id"}}},
         {$sort: {"_id.size":-1}}
     ];
        return await StudentAttendanceModel.aggregate(complexQuery).exec();
    }
    async getByDate(date){
        let query={date:date};
        return await StudentAttendanceModel.find(query).exec();
    }
}

//Exporting model to be used in Controllers
module.exports=new StudentAttendance();