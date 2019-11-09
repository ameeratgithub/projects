// Function that runs on page load
$(function () {
    //Initializing Date Input Fields

    //Initializing datepicker
    $(".datepicker").datepicker({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year,
        today: 'Today',
        clear: false,
        close: 'Ok',
        closeOnSelect: true// Close upon selecting a date,
    }).on('change', function () {
        getAbsencesToRange();
    });

    getAbsencesToRange();
    var firstdate = (new Date()).toDateString();
    $("#initialdate").val(firstdate);
    $("#finaldate").val(firstdate);
    M.updateTextFields();
});
const courseReportTemplate = `
<ul class="collection" >
{{#each absents}}
<li class="collection-item">
<a href="javascript:void(0)"><b>{{this.name}}</b> was absent on <b>{{this.date}}</b></a>
</li>
{{/each}}
</ul>
`;
const gradeReportTemplate = `
<ul class="collection" >
{{#each absents}}
<li class="collection-item">
<a href="javascript:void(0)"><b>{{this.name}}</b> was absent on <b>{{this.date}}</b></a>
</li>
{{/each}}
</ul>
`;
const generalReport = `
<ul class="collection" >
{{#each grades}}
<li class="collection-item" >
<a href="javascript:void(0)" class="grades" data-gradename="{{this.name}}">{{this.name}}  <b style="margin-left: 30px">Total {{this.total}}</b></a>
<ul class="collection" >
{{#each this.courses}}
<li class="collection-item" >
<a href="javascript:void(0)" class="courses" data-gradename="{{../this.name}}" data-courseid="{{this.id}}">{{this.name}}  <b style="margin-left: 30px">Total {{this.total}}</b></a>
</li>
{{/each}}
</ul>
</li>
{{/each}}
</ul>
`;
async function getAbsencesToRange() {
    let response = await fetch('/api/report/' + $("#initialdate").val() + "/" + $("#finaldate").val(), {
        credentials: 'same-origin'
    });
    let result = await response.json();
    if (result.length < 1) {
        $("#reportTemplate").html("<h4 class='center-align'>No Absence</h4>");
        return;
    }
    let report = {
        grades: result
    };
    const htmlTemplate = Handlebars.compile(generalReport);
    $("#reportTemplate").html(htmlTemplate(report));
    $(".grades").on('click', getAbsencesByGrade);
    $(".courses").on('click', getAbsencesByCourse);
}
async function getAbsencesByCourse(ev) {
    let courseId = $(this).data('courseid');
    let gradename = $(this).data('gradename');
    if (!courseId || !gradename)
        return;
    let response = await fetch('/api/report/bycourse/' + $("#initialdate").val() + "/" + $("#finaldate").val() + "/" + courseId + "/" + gradename, {
        credentials: 'same-origin'
    });
    let result = await response.json();
    let absents = {
        absents: result
    };
    const htmlTemplate = Handlebars.compile(courseReportTemplate);
    $("#reportTemplate").html(htmlTemplate(absents));
}


async function getAbsencesByGrade(ev) {
    let gradename = $(this).data('gradename');
    if (!gradename)
        return;
    let response = await fetch('/api/report/bygrade/' + $("#initialdate").val() + "/" + $("#finaldate").val() + "/" + gradename, {
        credentials: 'same-origin'
    });
    let result = await response.json();
    let grades = {
        absents: result
    };
    const htmlTemplate = Handlebars.compile(gradeReportTemplate);
    $("#reportTemplate").html(htmlTemplate(grades));

}



