// Function that runs on page load
$(function () {
    //Initializing Date Input Fields
    

    //Initializing datepicker
    $(".datepicker").datepicker({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: true// Close upon selecting a date,
    });
    var firstdate=(new Date()).toDateString();
    $("#initialdate").val(firstdate);
    $("#finaldate").val(firstdate);
    M.updateTextFields();

});
//Templates to render grades
const gradesTemplate = `
{{#each grades}}
<option value="{{this._id}}">{{this.name}}</option>
{{/each}}
`;
//Template to render absent persons
const absentTemplate = `<ul class="collection with-header">
<li class="collection-header">
<h6>
Absence Details of {{name.name}} :
<span class="right">
<a class="back" style="cursor: pointer">Go Back</a>
</span>
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

//Template to render students
const studentTemplate = `<ul class="collection with-header">
<li class="collection-header">
<h6>
Student Name
</h6>
</li>
                {{#each students}}
                <li class="collection-item">
                    <a href="/api/students/{{this._id}}/absents" data-id="{{this._id}}" style="">{{this.name}}</a>

                    </div>
                </li>
                {{/each}}
            </ul>
`;
// Display grades in dropdown
async function displayGrades() {
    try {
        const response = await fetch("/api/grades", {
            credentials: 'same-origin'
        });
        const grades= {
            grades: await response.json()
        };
        const htmlTemplate = Handlebars.compile(gradesTemplate);
        $("#chooseGrades").append($(htmlTemplate(grades)));
        $('select').formSelect();
        $("#chooseGrades").on('change', function(){
            getStudentsByGrade();
        });
    }
    catch (err) {
        console.log(err);
    }
}
displayGrades();
//Getting students by grade
async function getStudentsByGrade() {
    let grade=$("#chooseGrades  option:selected").text();
    grade=grade.trim();
    if(grade=="Select Grade") return;
    let response = await fetch('/api/grades/'+grade+'/students', {
        credentials: 'same-origin'
    });
    let json = await response.json();
    let students = {
        students: json
    };
    const htmlTemplate=Handlebars.compile(studentTemplate);
    $("#studentTemplate").html(htmlTemplate(students));
    $(".collection-item a").click(function(ev){
        ev.preventDefault();
        var studentId=$(this).data('id');
        if(!studentId) return;
        var initialDate=(new Date($("#initialdate").val())).toLocaleDateString();
        var finalDate=(new Date($("#finaldate").val())).toLocaleDateString();
        getStudentsAllAbsents(studentId,initialDate.replace(/\//g,'-'),finalDate.replace(/\//g,'-'));
    });
}

// Getting All absents for specific person in date range
async function getStudentsAllAbsents(studentid,initialDate,finalDate){
    let response = await fetch('/api/students/'+studentid+"/"+initialDate+"/"+finalDate+"/absentdetails", {
        credentials: 'same-origin'
    });
    let json = await response.json();
    if(!json.absents[0])
    {
        $("#studentTemplate").html('<h5 class="center-align">No absence found' +
            ' &nbsp;&nbsp;&nbsp;<a class="back" style="cursor: pointer">Go back</a></h5>');
        hideThings();
        return;
    }
    const htmlTemplate=Handlebars.compile(absentTemplate);
    $("#studentTemplate").html(htmlTemplate(json));
    hideThings();
}
// Hiding some controls on 'Back' click
function hideThings(){
    $('.input-field').hide();
    $('.back').click(function(){
        $('.input-field').show();
        getStudentsByGrade();
    });
}