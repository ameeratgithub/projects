
// Module used for express routing

const express = require('express');
const router = express.Router();

//  Controllers to perform actions

const userController=require('./controllers/userController');
const studentController=require('./controllers/studentController');
const teacherController=require('./controllers/teacherController');
const courseController=require('./controllers/courseController');
const gradeController=require('./controllers/gradeController');
const attendanceController=require('./controllers/attendanceController');
const principleController=require('./controllers/principleController');



// Routes that doesn't require authentication

router.route('/login')
    .get((req, res)=> {
        if (!req.cookies.email)
            res.render('login');
        else res.redirect("/");
    })
    .post((req, res)=> {
        const info = req.body;
        const duration1D = 24 * 60 * 60 * 1000;
         res.cookie('email', info.email, {path:'/',
         expires: new Date(Date.now(), duration1D)
         });
        res.redirect('/');
    });

// Authentication middleware for routes

router.use((req, res, next)=> {
    if (req.cookies.email) {
        res.locals.email = req.cookies.email;
        return next();
    }
    res.redirect('/login');
});

//Api Routes

router.get('/api/courses',courseController.getCourses);
router.get('/api/grades',gradeController.getGrades);
router.get('/api/grades/:grade/students',studentController.getStudentsByGrade);

router.get('/api/user/:id',userController.getUser);

router.get('/api/students',studentController.getStudents);
router.get('/api/students/:courseid',studentController.getStudentsByCourse);
router.get('/api/students/:courseid/:grade',studentController.getStudentsByGradeCourse);
router.get('/api/students/:id/:startDate/:endDate/absentdetails',studentController.getAllAbsents);

router.get('/api/teachers',teacherController.getTeachers);
router.get('/api/teachers/:id/:startDate/:endDate/absentdetails',teacherController.getAllAbsents);
router.get('/api/teachers/:id/courses',teacherController.getCourses);
router.get('/api/teacher/studentattendance/:courseid/:date',attendanceController.getStudentAttendanceByCourse);

router.get('/api/parents',userController.getParents);
router.get('/api/parent/:email/children',userController.getChildren);

router.get('/api/report/:idate/:fdate',attendanceController.getByRange);
router.get('/api/report/bycourse/:idate/:fdate/:courseid/:gradename',attendanceController.getByCourse);
router.get('/api/report/bygrade/:idate/:fdate/:grade',attendanceController.getByGrade);

router.get('/api/search/student/:input',userController.searchStudent);
router.get('/api/search/teacher/:input',userController.searchTeacher);

// General Routes (index)

router.get('/', (req, res)=> {
    res.render('home');
});
router.get('/principle', (req, res)=> {
    res.render('principle/report/index');
});
router.get('/teacher', async (req, res)=> {
    res.render('teacher/list');
});
router.get('/parents', (req, res)=> {
    res.render('parent/list');
});

// Teacher Routes


router.get('/teacher/:id',function(req,res){
    res.render('teacher');
});
router.route('/teacher/studentabsence/record').get((req, res)=> {
    res.render('teacher/recordstudentabsence');
}).post(attendanceController.recordStudentAttendance);
router.put('/teacher/studentabsence/:id',attendanceController.updateStudentAttendance);



// Principle Routes

router.route('/principal/record/studentabsence').get((req, res)=> {
    res.render('principle/record/student');
}).post(principleController.recordStudentAttendance);
router.route('/principal/record/teacherabsence').get((req, res)=> {
    res.render('principle/record/teacher');
}).post(principleController.recordTeacherAttendance);

router.get('/principal/view/studentabsence',(req,res)=>{
   res.render('principle/view/student');
});
router.get('/principal/view/teacherabsence',(req,res)=>{
    res.render('principle/view/teacher');
});
/*router.get('/principal/report/studentabsence',(req,res)=>{
    res.render('principle/report/student');
});
router.get('/principal/report/teacherabsence',(req,res)=>{
    res.render('principle/report/teacher');
});*/

router.get('/principal/report',(req,res)=>{
    res.render('principle/report/index');
});
router.get('/principal/summary/studentabsence',(req,res)=>{
    res.render('principle/studentsummaryreport');
});

// Routes for Parent
router.get('/parent/summary/studentabsence',(req,res)=>{
    res.render('parent/studentsummaryreport');
});
router.get('/logout', (req, res)=> {

    //Two ways to delete cookie :)

    /*res.cookie('email','',{
        expires:Date.now()
    });*/
    res.clearCookie('email');
    res.redirect('/login');
});



module.exports = router;