//Student Model
const StudentAttendance = require('../models/studentAttendanceModel');
const Course = require("../models/courseModel");
const User = require('../models/userModel');
const DateController = require('./dateController');
//Controller for attendance
class attendanceController {

    async recordStudentAttendance(req, res) {
        let result = await StudentAttendance.recordStudentAttendance(req.body.attendancerecord);
        res.json(result);
    }

    async getStudentAttendanceByCourse(req, res) {
        var date = req.params.date.replace(/-/g, "/");
        var courseid = req.params.courseid;
        let result = await StudentAttendance.getStudentAttendanceByCourse(courseid, date);
        res.json(result);
    }

    async updateStudentAttendance(req, res) {
        let result = await StudentAttendance.updateStudentAttendance(req.params.id, req.body.attendancerecord);
        res.json(result);
    }

    async getByCourse(req, res) {
        let iDate = new Date(req.params.idate);
        let fDate = new Date(req.params.fdate);
        let newCollection = [];
        let results = [];
        for (let i = iDate; i <= fDate; i.setDate(i.getDate() + 1)) {
            let absent = await StudentAttendance.getByCourseId(DateController.S_MMDDYYYY(i), req.params.courseid);
            let byGradeStudents = await User.getStudentsByGradeCourse(req.params.courseid, req.params.gradename);
            for (let student of byGradeStudents) {
                if (!absent)continue;
                let absentStudents = absent.absent.filter((item)=>student._id == item.id);
                if (absentStudents.length < 1) continue;
                newCollection.push({date:absent.date,id:absentStudents});
            }
            results = await Promise.all(newCollection.map(async (absent)=> {
                let student = await User.getUser(absent.id[0].id);
                return {date: absent.date, name: student.name}
            }));
        }
        res.json(newCollection);
    }

    async getByGrade(req, res) {
        let arr = [];
        let iDate = new Date(req.params.idate);
        let fDate = new Date(req.params.fdate);
        let coursesOfGrade = await User.getCoursesByGrade(req.params.grade);
        let filteredCourses = [];
        let results = [];
        for (let course of coursesOfGrade) {
            for (let innerCourse of course.courses) {
                if (filteredCourses.indexOf(String(innerCourse)) > -1) {
                    continue;
                }
                filteredCourses.push(String(innerCourse));
            }
        }
        for (let i = iDate; i <= fDate; i.setDate(i.getDate() + 1)) {
            for (let courseid of filteredCourses) {
                let absent = await StudentAttendance.getByCourseId(DateController.S_MMDDYYYY(i), courseid);
                let byGradeStudents = await User.getStudentsByGradeCourse(courseid, req.params.grade);

                results.push(byGradeStudents);
                for (let student of byGradeStudents) {
                    if (!absent) continue;
                    let absentStudents = absent.absent.filter((item)=>student._id == item.id);
                    if (absentStudents.length < 1) continue;
                    arr.push({date:absent.date,id:absentStudents});
                }
                results = await Promise.all(arr.map(async (absent)=> {
                    let student = await User.getUser(absent.id[0].id);
                    return {date: absent.date, name: student.name}
                }));
            }
        }
        res.json(results);
    }

    async AllByDate(idate, fdate) {
        let absents = [];
        let iDate = new Date(idate);
        let fDate = new Date(fdate);
        for (let i = iDate; i <= fDate; i.setDate(i.getDate() + 1)) {
            let absentsByCourse = await StudentAttendance.getByDate(DateController.S_MMDDYYYY(i));
            for (let absent of absentsByCourse) {
                absents.push(absent);
            }
        }
        return absents;
    }

    GetAllAbsentIds(absents) {
        let studentIds = [];
        for (let absent of absents) {
            for (let studentID of absent.absent) {
                studentIds.push({id: studentID.id, date: absent.date, courseid: absent.course});
            }
        }
        return studentIds;
    }

    async AllGradesTotal(absents) {
        let grades = [];
        let self = new attendanceController();
        let studentIDs = self.GetAllAbsentIds(absents);
        for (let absent of studentIDs) {
            let grade = await User.getGrade(absent.id);
            let currentObject = grades.filter(item=>item.name == grade.grade);
            if (currentObject.length > 0) {
                let index = grades.indexOf(currentObject[0]);
                grades[index].total += 1;
            }
            else {
                currentObject = {name: grade.grade, total: 1, courses: []};
                grades.push(currentObject);
            }
        }
        return grades;
    }

    async GetCoursesByGrade(grade) {
        let courses = [];
        let gradeCourses = await User.getCoursesByGrade(grade);
        for (let gC of gradeCourses) {
            for (let innerCourse of gC.courses) {
                courses.push(innerCourse);
            }
        }
        return courses;
    }

    async AllCoursesTotal(grades, absents) {
        let rawResult=[];
        let self = new attendanceController();
        let studentIDs = self.GetAllAbsentIds(absents);
        let globalyCompared = [];
        for (let grade of grades) {
            let gradeCourses = await self.GetCoursesByGrade(grade.name);
            for (let gC of gradeCourses) {
                let course = await Course.getOne(gC);
                let totalOfCurrent = 0;
                for (let absent of studentIDs) {

                    //If absent doesn't has Grade Course


                    if(absent.courseid!=gC) continue;

                    // If absents have been gotten before

                    let comparison =  absent.date+"_"+course.name + "_" + grade.name;
                    if (globalyCompared.indexOf(comparison) > -1) continue;
                    let absentsByCourse = await StudentAttendance.getByCourseId(absent.date, gC);
                    if (!absentsByCourse || absentsByCourse.absent.length <= 0)continue;
                    for (let absentId of absentsByCourse.absent) {
                        if (String(absent.id) == String(absentId.id)) {
                            let user = await User.getGrade(absent.id);
                            if (String(user.grade) ==String(grade.name)) {
                                //globalyCompared.push(comparison);
                                totalOfCurrent += 1;
                            }

                        }
                    }
                }
                if (totalOfCurrent <= 0) continue;
               let currentObject=grade.courses.filter(item=>item.name==course.name);
                if(currentObject.length>0){
                    rawResult.push(currentObject);
                    continue;
                }
                currentObject={id:gC,name:course.name,total:totalOfCurrent};
                grade["courses"].push(currentObject);
            }
            grade.courses = grade.courses.sort(function (a, b) {
                return a.total - b.total
            }).reverse();
        }

        return grades;
    }

    async getByRange(req, res) {
        let self = new attendanceController();
        let absents = await self.AllByDate(req.params.idate, req.params.fdate);
        let gradesTotal = await self.AllGradesTotal(absents);
        gradesTotal = gradesTotal.sort(function (a, b) {
            return a.total - b.total;
        }).reverse();
        let coursesTotal = await self.AllCoursesTotal(gradesTotal, absents);
        res.json(coursesTotal);
    }
}
//Exporting object of controller
module.exports = new attendanceController();

