//Function that runs on document ready

$(function () {
    //Initial Values for date
    

    //Initializing Datepicker

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
    $("select").formSelect();
});
// Template to display absents
const absentTemplate = `<ul class="collection with-header">
<li class="collection-header">
<h6>
Absence Details of {{name.name}} :
<!--<span class="right">
<a class="back" style="cursor: pointer">Go Back</a>
</span>-->
</h6>
</li>
                {{#each absents}}
                <li class="collection-item">
                    <p data-id="{{this._id}}" style=""> Was absent on {{this.date}}</p>
                    <span class="right">
                    </span>
                    </div>
                </li>
                {{/each}}
            </ul>
`;

// Template to render students
const studentTemplate = `{{#each students}}
                <option value="{{this._id}}" data-id="{{this._id}}">{{this.name}}</option>
                {{/each}}`;
// calling function to get students
getStudents();

//Api call to get students
async function getStudents() {
    var email = localStorage.getItem("parentemail");
    let response = await fetch('/api/parent/' + email + '/children', {
        credentials: 'same-origin'
    });
    let json = await response.json();
    let students = {
        students: json
    };
    const htmlTemplate = Handlebars.compile(studentTemplate);
    $("#chooseChildren").append($(htmlTemplate(students)));
    $('select').formSelect();
    $("#chooseChildren").change(function (ev) {
        ev.preventDefault();
        var studentId = $(this).val();
        if (!studentId) {
            console.log("Id Problem");
            return;
        }
        var initialDate = (new Date($("#initialdate").val())).toLocaleDateString();
        var finalDate = (new Date($("#finaldate").val())).toLocaleDateString();
        getStudentsAllAbsents(studentId, initialDate.replace(/\//g, '-'), finalDate.replace(/\//g, '-'));
    });
}

//Getting All Absents for specific student in date range
async function getStudentsAllAbsents(studentid, initialDate, finalDate) {
    let response = await fetch('/api/students/' + studentid + "/" + initialDate + "/" + finalDate + "/absentdetails", {
        credentials: 'same-origin'
    });
    let json = await response.json();
    if (!json.absents[0]) {
        $("#studentTemplate").html('<h5 class="center-align">No absence found' +
            '</h5>');
        //hideThings();
        return;
    }
    const htmlTemplate = Handlebars.compile(absentTemplate);
    $("#studentTemplate").html(htmlTemplate(json));
   // hideThings();
}
//Hiding Date fields on click 'back' link
function hideThings() {
    $('.input-field').hide();
    $('.back').click(function () {
        $('.input-field').show();
        getStudents();
    });
}