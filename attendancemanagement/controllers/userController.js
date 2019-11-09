//Initializing Model
const UserModel=require('../models/userModel');
//User Controller
class UserController{
   async getUser(req,res){
       let user=await UserModel.getUser(req.params.id);
       res.json(user);
   }
    async getParents(req,res){
        res.json(await UserModel.getParents());
    }
    async getChildren(req,res){
        res.json(await UserModel.getChildren(req.params.email));
    }
    async searchStudent(req,res){
     res.json(await UserModel.searchUser('student',req.params.input));
    }
    async searchTeacher(req,res){
        res.json(await UserModel.searchUser('teacher',req.params.input));
    }

}

//Exporting Controller to routes
module.exports=new UserController();