//Intializing Grade Model
const Grade=require('../models/gradeModel');
//Grade Controller
class gradeController{
    async getGrades(req,res){
        res.json(await Grade.getGrades());
    }
}
//Exporting Controller Object to routes
module .exports=new gradeController();