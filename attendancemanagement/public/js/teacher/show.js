
const coursesTemplate = `
{{#each courses}}
<option value="{{this._id}}">{{this.name}}</option>
{{/each}}

`;

const studentsTemplate = `<ul class="collection with-header">
<input type="hidden" name="recordid" id="recordid" value="{{_id}}">

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
                    <input type="checkbox" id="{{this.id}}"{{ternary this.value 'on' 'checked' ''}}/>
                    <span></span>
                    </label>

                    
                    </span>
                    </div>
                </li>
                {{/each}}
            </ul>`;
async function displayCourses() {
    try {

        const teacherid = localStorage.getItem('teacherid');
        if (!teacherid) return;
        const response = await fetch("/api/teachers/" + teacherid + "/courses", {
            credentials: 'same-origin'
        });
        const courses = {
            courses: await response.json()
        };
        const htmlTemplate = Handlebars.compile(coursesTemplate);
        $("#chooseCourses").append($(htmlTemplate(courses)));
        $('select').formSelect();

    }
    catch (err) {
        console.log(err);
    }
}
displayCourses();
async function getUser(id) {
    let response = fetch('/api/user/' + id, {
        credentials: 'same-origin'
    });
    return response;
}
async function getStudentAttendanceByCourse() {
    let course = $("#chooseCourses").val();
    if (!course) {
        M.toast({ html: "Please choose course first...!", classes: 'red' });
        return;
    }
    let date = (new Date($("#attendancedate").val())).toLocaleDateString();
    let response = await fetch('/api/teacher/studentattendance/' + course + "/" + date.replace(/\//g, "-"), {
        credentials: 'same-origin'
    });

    let rawJson = await response.json();
    if (!rawJson) {
        $("#studentTemplate").html('<h4 class="center-align">No Record Found</h4><br/>');
        return;
    }
    let presentStudents = rawJson.present;
    let absentStudents = rawJson.absent;
    let presentStudentNames = [];
    let absentStudentNames = [];
    for (let s of presentStudents) {
        let user = await getUser(s.id);
        let userjson = await user.json();
        presentStudentNames.push({
            id: s.id,
            value: s.value,
            name: userjson.name
        });
        rawJson.present = presentStudentNames;
    }

    for (let s of absentStudents) {
        let user = await getUser(s.id);
        let userjson = await user.json();
        absentStudentNames.push({
            id: s.id,
            value: s.value,
            name: userjson.name
        });
        rawJson.absent = absentStudentNames;
    }
    rawJson.students = rawJson.present.concat(rawJson.absent);
    let htmlTemplate = Handlebars.compile(studentsTemplate);
    $("#studentTemplate").html(htmlTemplate(rawJson));
}
async function controlChanged() {
    getStudentAttendanceByCourse();
}
$(function () {
    $(".datepicker").datepicker({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: false // Close upon selecting a date,
    });
    var firstdate = (new Date()).toDateString();
    $("#attendancedate").val(firstdate).change(controlChanged);
    M.updateTextFields();
    // Event handler when user changes course
    $("#chooseCourses").on('change', controlChanged);
    // Submit event handler for update form
    $("form").submit(function (ev) {
        ev.preventDefault();
        var absentStudents = $('input:checkbox:checked').map(function () {
            return {
                id: $(this).attr('id'),
                value: this.value
            }
        }).get();
        var course = $("#chooseCourses").val();
        var date = $("#attendancedate").val();
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
        else if (!date) {
            M.toast({ html: 'Please Select Date', classes: 'red' });
            return;
        }
        var attendanceRecord = {
            course: course,
            date: (new Date(date)).toLocaleDateString(),
            present: presentStudents,
            absent: absentStudents

        };
        // Jquery Ajax method to Update Student Absence
        $.ajax({
            method: "PUT",
            accept: 'application/json',
            url: '/teacher/studentabsence/' + $("#recordid").val(),
            data: { attendancerecord: JSON.stringify(attendanceRecord) },
            success: function (data) {
                if (data && data["insertedCount"] > 0) {
                    M.toast({ html: "Attendance has been Updated", classes: 'teal' });

                }
                else if (data["message"]) {
                    M.toast({ html: data["message"], classes: 'red' });
                }
                else
                    M.toast({ html: "Error Occured ", classes: 'red' });

            },
            error: function (xhr, err, status) {
                console.log("Error : " + err + ", Status : " + status);
            }
        });
    });
});
