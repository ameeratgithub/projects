// Function that runs when document loaded
$(function () {
    //Initializing date fields
    

    //Initializing date fields
    $(".datepicker").datepicker({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: 'Clear',
        close: 'Ok',
        closeOnSelect: true// Close upon selecting a date,
    }).on('change',function(){
        getTeachersAllAbsents();
    });
    var firstdate=(new Date()).toDateString();
    $("#initialdate").val(firstdate);
    $("#finaldate").val(firstdate);
    M.updateTextFields();
});
//Changing teacher template content on user interaction
function clearThings(){
    $("#teacherTemplate").empty();
    getTeachers();
}
// Template to render absence details
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
//Template to render teachers
const teacherTemplate = `<ul class="collection with-header">
<li class="collection-header">
<h6>
Teacher Name

</h6>
</li>
                {{#each teachers}}
                <li class="collection-item">
                    <a href="/api/teacher/{{this._id}}/absents" data-id="{{this._id}}" style="">{{this.name}}</a>
                    </div>
                </li>
                {{/each}}
            </ul>
`;

getTeachers();
//Function to call api to get teachers
async function getTeachers() {
    let response = await fetch('/api/teachers', {
        credentials: 'same-origin'
    });
    let json = await response.json();
    let teachers = {
        teachers: json
    };
    const htmlTemplate=Handlebars.compile(teacherTemplate);
    $("#teacherTemplate").html(htmlTemplate(teachers));
    $(".collection-item a").click(function(ev){
        ev.preventDefault();
        var teacherId=$(this).data('id');
        if(!teacherId) return;
        var initialDate=(new Date($("#initialdate").val())).toLocaleDateString();
        var finalDate=(new Date($("#finaldate").val())).toLocaleDateString();
        getTeachersAllAbsents(teacherId,initialDate.replace(/\//g,'-'),finalDate.replace(/\//g,'-'));
    });
}
// Getting All absents for specific teacher in date range
async function getTeachersAllAbsents(teacherid,initialDate,finalDate){
    let response = await fetch('/api/teachers/'+teacherid+"/"+initialDate+"/"+finalDate+"/absentdetails", {
        credentials: 'same-origin'
    });
    let json = await response.json();
    if(!json.absents[0])
    {
        $("#teacherTemplate").html('<h5 class="center-align">No absence found' +
            ' &nbsp;&nbsp;&nbsp;<a class="back" style="cursor: pointer">Go back</a></h5>');
        hideThings();
        return;
    }
    const htmlTemplate=Handlebars.compile(absentTemplate);
    $("#teacherTemplate").html(htmlTemplate(json));
    hideThings();

}
function hideThings(){
    $('.input-field').hide();
    $('.back').click(function(){
        $('.input-field').show();
        getTeachers();
    });
}