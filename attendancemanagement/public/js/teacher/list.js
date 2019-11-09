const teacherTemplate=`
                {{#each teachers}}
                <li class="collection-item">
                    <a class="teacher" href="/teacher/studentabsence/record" data-id="{{this._id}}">{{this.name}}</a>
                </li>
{{/each}}
`;
async function getTeachers() {
    let response = await fetch('/api/teachers/', {
        credentials: 'same-origin'
    });
    let json = await response.json();
    let teachers = {
        teachers: json
    };
    const htmlTemplate=Handlebars.compile(teacherTemplate);
    $("#teachersList").html(htmlTemplate(teachers));
    $("a.teacher").click(function(ev){
        localStorage.setItem('teacherid',$(this).data('id'));
    });
}
getTeachers();