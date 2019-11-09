// Function that runs on page load
$(function () {

    //Initializing datepicker
    $(".datepicker").datepicker({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: true// Close upon selecting a date,
    });
    var firstdate = (new Date()).toDateString();
    $("#initialdate").val(firstdate);
    $("#finaldate").val(firstdate);
    M.updateTextFields();

    $("input[name=userType]").change(function () {
        var val = $(this).val();
        if (val === 'teacher')
            getTeachers();
        else
            clearThings();
    });
    $("#searchInput").on('keyup', function () {
        var input = $(this).val();
        var type = $('input[name=userType]:checked').val();
        input = input.trim();
        if (!input) {
            clearThings();
            return;
        }
        if (type === 'teacher')
            searchTeachers(input);
        else
            searchStudents(input);
    });
});
//Make student template placeholder empty
function clearThings() {
    $("#userTemplate").empty();
}

// Template for courses
const coursesTemplate = `{{#each courses}}
<option value="{{this._id}}">{{this.name}}</option>
{{/each}}
`;
//Template for grades
const gradesTemplate = `

{{#each grades}}
<option value="{{this._id}}">{{this.name}}</option>
{{/each}}
`;
//Template to render students
const studentsTemplate = `<form id="studentForm" method="post" action="/principle/record/studentabsence">
                   <div>
                  <ul class="collection with-header">
<input type="hidden" name="attendancerecord" id="attendancerecord">
<li class="collection-header">
<h6>
Student Name
<span class="right">
Absent
</span>
</h6>
</li>
{{#each students}}
                <li class="collection-item">
                    <a href="javascript:void(0)" style="">{{this.name}}</a>
                    <span class="right">
                    <label>
                    <input type="checkbox" id="{{this._id}}"/>
                    <span></span>
                    </label>
                    </span>
                </li>
                {{/each}}
            </ul>
                    </div>
                    <div class="row">
                        <div class="col offset-l5 offset-m5">
                            <button type="submit" class="btn blue">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
`;

//Template to render teachers
const teacherTemplate = `
<form method="post" id="teacherForm" action="/principle/record/teacherabsence">
<ul class="collection with-header">
<input type="hidden" name="attendancerecord" id="attendancerecord">
<li class="collection-header">
<h6>
Teacher Name
<span class="right">
Absent
</span>
</h6>
</li>
                {{#each teachers}}
                <li class="collection-item">
                    <a href="javascript:void(0)" style="">{{this.name}}</a>
                    <span class="right">
                    <label>
                    <input type="checkbox" id="{{this._id}}"/>
                    <span></span>
                    </label>
                    
                    
                    </span>
                </li>
                {{/each}}
            </ul>
                <div class="row">
                    <div class="col offset-l5 offset-m5">
                        <button type="submit" class="btn blue">
                            Save
                        </button>
                    </div>
                </div>
            </form>
`;


//Method to get and render courses
async function displayCourses() {
    try {
        const response = await fetch("/api/courses", {
            credentials: 'same-origin'
        });
        const courses = {
            courses: await response.json()
        };
        const htmlTemplate = Handlebars.compile(coursesTemplate);
        $("#chooseCourses").append($(htmlTemplate(courses)));
        $('select').formSelect();
        $("#chooseCourses").on('change', function () {
            getStudentsByGradeCourse();
        });

    }
    catch (err) {
        console.log(err);
    }
}
//Method to get and render  grades
async function displayGrades() {
    try {
        const response = await fetch("/api/grades", {
            credentials: 'same-origin'
        });
        const grades = {
            grades: await response.json()
        };
        const htmlTemplate = Handlebars.compile(gradesTemplate);
        $("#chooseGrades").append($(htmlTemplate(grades)));
        $('select').formSelect();
        $("#chooseGrades").on('change', function () {
            getStudentsByGradeCourse();
        });

    }
    catch (err) {
        console.log(err);
    }
}
displayCourses();
displayGrades();

//Getting students by grades and courses

async function getStudentsByGradeCourse() {
    let course = $("#chooseCourses").val();
    let grade = $("#chooseGrades  option:selected").text();
    grade = grade.trim();
    if (!course || grade == "Select Grade") return;
    let isStudent = $("input:checked").val();
    if (isStudent !== "student") return;

    let response = await fetch('/api/students/' + course + "/" + grade, {
        credentials: 'same-origin'
    });
    let json = await response.json();
    let students = {
        students: json
    };
    renderStudents(students);
}
async function searchStudents(input) {
    let response = await fetch('/api/search/student/' + input, {
        credentials: 'same-origin'
    });
    let result = await response.json();
    let students = {
        students: result
    };
    renderStudents(students);
}
async function searchTeachers(input) {
    let response = await fetch('/api/search/teacher/' + input, {
        credentials: 'same-origin'
    });
    let result = await response.json();
    let teachers = {
        teachers: result
    };
    renderTeachers(teachers);
}
function renderStudents(students) {
    if (students.students.length < 1) {
        $("#userTemplate").html(`<h4 class="center-align">No Record Found</h4>`);
        return;
    }
    const htmlTemplate = Handlebars.compile(studentsTemplate);
    $("#userTemplate").html(htmlTemplate(students));
    $("#studentForm").submit(recordStudentAbsence);
}

//Api Calling Function to get Teachers
async function getTeachers() {
    let response = await fetch('/api/teachers', {
        credentials: 'same-origin'
    });
    let json = await response.json();
    let teachers = {
        teachers: json
    };
    renderTeachers(teachers);
}
function renderTeachers(teachers) {
    if (teachers.teachers.length < 1) {
        $("#userTemplate").html(`<h4 class="center-align">No Record Found</h4>`);
        return;
    }
    const htmlTemplate = Handlebars.compile(teacherTemplate);
    $("#userTemplate").html(htmlTemplate(teachers));
    $("#teacherForm").submit(recordTeacherAbsence);
}
function recordTeacherAbsence(ev) {
    ev.preventDefault();
    var absentteachers = $('input:checkbox:checked').map(function () {
        return {
            id: $(this).attr('id'),
            value: this.value
        }
    }).get();
    var initialdate = $("#initialdate").val();
    var finaldate = $("#finaldate").val();
    var presentTeachers = $('input:checkbox:not(:checked)').map(function () {
        return {
            id: $(this).attr('id'),
            value: "off"
        }
    }).get();
    if (absentteachers.length <= 0) {
        M.toast({ html: 'Please Select Teacher first', classes: 'red' });
        return;
    }
    else if (!initialdate || !finaldate) {
        M.toast({ html: 'Please Select Initial And Final Dates', classes: 'red' });
        return;
    }
    if (absentteachers.length > 1) {
        M.toast({ html: 'Only one teacher is allowed to update at a time', classes: 'red' });
        return;
    }
    var attendanceRecord = {
        initialDate: (new Date(initialdate)).toLocaleDateString(),
        finalDate: (new Date(finaldate)).toLocaleDateString(),
        present: presentTeachers,
        absent: absentteachers
    };
    $.ajax({
        method: "POST",
        accept: 'application/json',
        url: '/principal/record/teacherabsence',
        data: { attendancerecord: JSON.stringify(attendanceRecord) },
        success: function (data) {
            var success = false;
            if (data && data.length > 0) {
                $.each(data, function (key, val) {
                    if (val.nModified > 0) {
                        success = true;
                    }
                    else if (val.result.n > 0) {
                        success = true;
                    }
                    else success = false;
                });
            }
            if (success) {
                M.toast({ html: "Attendance has been recorded", classes: 'teal' });
                clearThings();
            }
            else M.toast({ html: "Error while recording attendance", classes: 'red' });
        },
        error: function (xhr, err, status) {
            console.log("Error : " + err + ", Status : " + status);
        }
    });
}
function recordStudentAbsence(ev) {
    ev.preventDefault();
    var absentStudents = $('input:checkbox:checked').map(function () {
        return {
            id: $(this).attr('id'),
            value: this.value
        }
    }).get();
    var course = $("#chooseCourses").val();
    var initialdate = $("#initialdate").val();
    var finaldate = $("#finaldate").val();
    var presentStudents = $('input:checkbox:not(:checked)').map(function () {
        return {
            id: $(this).attr('id'),
            value: "off"
        }
    }).get();
    if (!course || (absentStudents.length <= 0 && presentStudents.length <= 0)) {
        M.toast({ html: 'Please Select Course first', classes: 'red' });
        return;
    }
    else if (!initialdate || !finaldate) {
        M.toast({ html: 'Please Select Initial And Final Dates', classes: 'red' });
        return;
    }
    if (absentStudents.length > 1) {
        M.toast({ html: 'Only one student is allowed to update at a time', classes: 'red' });
        return;
    }

    var attendanceRecord = {
        course: course,
        initialDate: (new Date(initialdate)).toLocaleDateString(),
        finalDate: (new Date(finaldate)).toLocaleDateString(),
        present: presentStudents,
        absent: absentStudents
    };
    $.ajax({
        method: "POST",
        accept: 'application/json',
        url: '/principal/record/studentabsence',
        data: { attendancerecord: JSON.stringify(attendanceRecord) },
        success: function (data) {
            var success = false;
            if (data && data.length > 0) {
                $.each(data, function (key, val) {
                    if (val.nModified && val.nModified > 0) {
                        success = true;
                    }
                    else if (val.result.n > 0) {
                        success = true;
                    }
                    else success = false;
                });
            }
            if (success) {
                M.toast({ html: "Attendance has been recorded", classes: 'teal' });
                clearThings();
            }
            else M.toast({ html: "Error while recording attendance", classes: 'red' });
        },
        error: function (xhr, err, status) {
            console.log("Error : " + err + ", Status : " + status);
        }
    });
}