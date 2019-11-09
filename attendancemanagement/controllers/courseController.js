
//Initializing Course Model
const Course=require('../models/courseModel');

//Course Controller
class courseController{
    async getCourses(req,res){
        res.json(await Course.getCourses());
    }

}
//Exporting Course Controller for routes
module .exports=new courseController();