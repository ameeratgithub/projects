// Function that runs on page load
$(function () {
   
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
    $("form").submit(function(ev){
        ev.preventDefault();

    });
});
// Change div content on user interaction
function clearThings(){
    $("#teacherTemplate").empty();
    getTeachers();
}

//Template to render teachers
const teacherTemplate = `<ul class="collection with-header">
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
                    </div>
                </li>
                {{/each}}
            </ul>
`;
//Calling function Get Teachers
getTeachers();
//Api Calling Function to get Teachers
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
    console.log(teachers);
}
