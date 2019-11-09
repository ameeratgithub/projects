const parentTemplate=`
                {{#each parents}}
                <li class="collection-item">
                    <a class="parent" href="/parent/summary/studentabsence" data-email="{{this.email}}">{{this.name}}</a>
                </li>
{{/each}}
`;
async function getParents() {
    let response = await fetch('/api/parents', {
        credentials: 'same-origin'
    });
    let json = await response.json();
    let parents = {
        parents: json
    };
    const htmlTemplate=Handlebars.compile(parentTemplate);
    $("#parentsList").html(htmlTemplate(parents));
    $("a.parent").click(function(){
        localStorage.setItem('parentemail',$(this).data('email'));
    });
}
getParents();