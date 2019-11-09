
$(function () {
    
    $(".datepicker").datepicker({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: true// Close upon selecting a date,
    });
    var firstdate = (new Date()).toDateString();
    $("#attendancedate").val(firstdate);
    M.updateTextFields();

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
        $.ajax({
            method: "POST",
            accept: 'application/json',
            url: '/teacher/studentabsence/record',
            data: { attendancerecord: JSON.stringify(attendanceRecord) },
            success: function (data) {
                if (data && data["insertedCount"] > 0) {
                    M.toast({ html: "Attendance has been recorded", classes: 'teal' });
                    clearThings();
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
    $("#showbtn").mouseenter(function (ev) {
        $(this).attr('href', "/teacher/" + localStorage.getItem("teacherid"));
    });
});
function clearThings() {
    $("#studentTemplate").empty();
}
const coursesTemplate = `
{{#each courses}}
<option value="{{this._id}}">{{this.name}}</option>
{{/each}}
`;

const studentsTemplate = `<ul class="collection with-header">
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
                    </div>
                </li>
                {{/each}}
            </ul>
`;
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
        $("#chooseCourses").on('change', getStudentsByCourse);

    }
    catch (err) {
        console.log(err);
    }
}
displayCourses();
async function getStudentsByCourse() {
    let response = await fetch('/api/students/' + $(this).val(), {
        credentials: 'same-origin'
    });
    let json = await response.json();
    let students = {
        students: json
    };
    const htmlTemplate = Handlebars.compile(studentsTemplate);
    $("#studentTemplate").html(htmlTemplate(students));
    $("input [type='checkbox']").change(function () {
        console.log($(this).attr('id'));
    });

}
