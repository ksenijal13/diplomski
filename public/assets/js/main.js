$(document).ready(function(){
   $("#login").click(login);
   $("#register").click(register);
   $("#year-of-study").change(changeStudyYear);
   $("#add-subject").hide();
   $("#plus-link").click(showFormSubject);
   $("#exams-number").change(addExamDates);
   $("#close-success").click(function(e){
      e.preventDefault();
      $("#success-subject").hide();
      destroySession();
   });
   $(".show-input").click(showInput);
   $(".show-desc-input").click(showDescInput);
   $(".add-new-desc").click(addNewDesc);
   $(".show-final-input").click(showFinalInput);
   $("#btn-cancel").click(function(){
       $("#add-subject").hide();
   });
   $("#search").keyup(searchSubjects);
   $(".s-pagination").click(sendOffset);
   $(".grades-list").change(writeGrade);
   $(".edit-grade").click(getGrades);
   $(".grades-pagination").click(getNextPageGrades);
   $("#sort-grade-list").change(getNextPageGrades);
   $("#sort-grade-by-year-list").change(getNextPageGrades);
   $(".link-time").click(addInputTime);
   $(".link-activity").click(addInputText);
   $("#add-link").click(checkLinkText);
   $(".link-pagination").click(getLinks);
   $(".link-trash").click(deleteLink);
   $(".user-pagination").click(getUsers);
   $(".delete-user").click(deleteUser);
   $("#add-menu-link").click(showAddLinkTable);
    $("#add-link-table").hide();
    $("#close-link-table").click(function(e){
        $("#add-link-table").fadeOut(500);
    })
    $("#btn-add-link").click(checkAddLink);
    $(".delete-link").click(deleteMenuLink);
    $(".menu-pagination").click(getMenuLinks);
    $(".update-icon").click(showUpdateTable);
    $("#update-table").hide();
    $("#regain-access").click(checkEmail);
    $("#check-password").click(checkPass);
    $("#edit-password").click(checkNewPass);
});

function checkNewPass(){
    let password = $("#password").val();
    let repeatPassword = $("#repeat-password").val();
    let passwordReg = /(?=.*[a-z])(?=.*[0-9])(?=.{8,})/;
    let validate = true;

    if(password== ""){
        validate = false;
        $("#password-error").html("Lozinka je obavezno polje.");
    }
    else if(!passwordReg.test(password)){
        validate = false;
        $("#password-error").html("Lozinka može sadržati mala slova, brojeve i može imati najmanje 8 karaktera.");
    }
    if(repeatPassword != password){
        validate = false;
        $("#repeat-password-error").html("Ponovoljena lozinka se ne poklapa sa lozinkom.");
    }
    return validate;
}
function checkPass(){
    let validate = true;
    let pass = $("#mail-password").val();
    if(pass == ""){
        $("#pass-error").html("Lozinka je obavezno polje.");
        validate = false;
    }
    return validate;
}

function checkEmail(){
    let validate = true;
    let email = $("#email").val();
    let emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(email == ""){
        $("#email-error").html("Email je obavezno polje.");
        validate = false;
    }
    if(!emailReg.test(email)){
        $("#email-error").html("Email nije u ispravnom formatu.");
        validate = false;
    }
    return validate;
}

function showUpdateTable(e){
    e.preventDefault();
    $("#update-table").show();
    let linkId = $(this).data("id");
    let text = $(this).data("text");
    let href = $(this).data("href");
    let icon = $(this).data("icon");
    let html= `<tr class="first-row">
                    <th>
                        Tekst
                    </th>
                    <th>
                        Putanja linka
                    </th>
                    <th>
                        Ikonica
                    </th>
                    <th>
                        <i class="fa fa-edit"></i>
                    </th>
                </tr>
                <tr>
                    <td>
                    <input type="text" value="${text}" name="link-text" id="link-text"/>
                    <p class="user-error link-error" id="link-text-error"></p>
                    </td>
                    <td>
                    <input type="text" value="${href}" name="link-href" id="link-href"/>
                    <p class="user-error link-error" id="link-href-error"></p>
                    </td>
                    <td>
                    <input type="text" value="${icon}" name="link-icon" id="link-icon"/>
                    <p class="user-error link-error" id="link-icon-error"></p>
                    </td>
                    <td>
                    <input type="submit" value="Izmeni" id="btn-update"/>
                    <input type="hidden" id="link-id" value="${linkId}" name="link-id"/>
</td>
                </tr>`;
    $("#update-table").html(html);
    $("#btn-update").click(checkUpdateLink);
}

function checkUpdateLink(){
    let validate = true;
    let text = $("#link-text").val();
    let href= $("#link-href").val();
    let icon = $("#link-icon").val();
    let specRegex = /^[^<>%$;]*$/;
    if(text == ""){
        $("#link-text-error").html("Tekst linka ne sme biti prazan.");
        validate = false;
    }
    if(!specRegex.test(text)){
        $("#link-text-error").html("Uneli ste nedozvoljene znakove.");
        validate = false;
    }
    if(href == ""){
        $("#link-href-error").html("Tekst putanje ne sme biti prazan.");
        validate = false;
    }
    if(!specRegex.test(href)){
        $("#link-href-error").html("Uneli ste nedozvoljene znakove.");
        validate = false;
    }
    if(icon == ""){
        $("#link-icon-error").html("Ikonica ne sme biti prazna.");
        validate = false;
    }
    if(!specRegex.test(icon)){
        $("#link-icon-error").html("Uneli ste nedozvoljene znakove.");
        validate = false;
    }
    return validate;
}

function getMenuLinks(e){
    e.preventDefault();
    $("#menu-pagination ul li a").removeClass("active");
    $(this).addClass("active");
    let offset = $(this).data("offset");
    var link_id = $(this).attr("id");
    sessionStorage.setItem("linkId", ""+link_id);
    sessionStorage.setItem("offset", ""+offset);
    $.ajax({
        url: "/get-menu-links",
        method: "get",
        data: {
            offset
        },
        dataType: "json",
        success: function (links) {
            showMenuLinks(links);
        }
    });
}
function deleteMenuLink(e){
    e.preventDefault();
    let linkId = $(this).data("id");
    let offset = sessionStorage.getItem("offset");
    if(offset == null){
        offset = 0;
    }
    console.log(linkId);
    console.log(offset);
    $.ajax({
        url: "/delete-menu-link",
        data: {
            linkId,
            offset
        },
        dataType: "json",
        success: function (links) {
            console.log(links);
            showMenuLinks(links[0]);
            showMenuLinkPagination(links[1]);
        }
    });
}
function showMenuLinkPagination(links){
    let html = `<ul class='flex-element'>`;
    for(let i = 0; i < links; i++){
        html +=`<li>
            <a href="#"  id = "link${i}" data-offset="${i}"  class="menu-pagination">${i+1}</a></li>`;
    }
    html += `</ul>`;
    $("#menu-pagination").html(html);
    let linkId = sessionStorage.getItem("linkId");
    $("#menu-pagination ul li #"+linkId).addClass("active");
    $(".menu-pagination").click(getLinks);
}
function showMenuLinks(links){
    let html = ` <tr class="first-row">
                    <th>
                        Tekst
                    </th>
                    <th>
                        Putanja linka
                    </th>
                    <th>
                        Ikonica
                    </th>
                    <th>
                        <i class="fa fa-edit"></i>
                    </th>
                </tr>`;
    for(let m of links){
        html += `<tr>
                            <td>
                                ${m.text}
                            </td>
                            <td>
                                ${m.href}
                            </td>
                            <td>
                                ${m.icon}
                            </td>
                            <td>
                                <a href="#" data-id="${m.link_id}" class="delete-link">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                  </tr>`;
    }
    $("#menu-table").html(html);
    $(".delete-link").click(deleteMenuLink);
}
function checkAddLink() {
    let validate = true;
    let tekst = $("#link-text").val();
    let path = $("#link-path").val();
    let icon = $("#link-icon").val();
    let specRegex = /^[^<>%$;]*$/;
    if(tekst == ""){
        $("#link-text-error").html("Tekst linka je obavezno polje.");
        validate = false;
    }
    if(!specRegex.test(tekst)){
        $("#link-text-error").html("Uneli ste nedozvoljene znakove.");
        validate = false;
    }
    if(path == ""){
        $("#link-path-error").html("Putanja linka je obavezno polje.");
        validate = false;
    }
    if(!specRegex.test(path)){
        $("#link-path-error").html("Uneli ste nedozvoljene znakove.");
        validate = false;
    }
    if(icon == ""){
        $("#link-icon-error").html("Ikonica linka je obavezno polje.");
        validate = false;
    }
    if(!specRegex.test(icon)){
        $("#link-icon-error").html("Uneli ste nedozvoljene znakove.");
        validate = false;
    }
    return validate;
}
function showAddLinkTable(e) {
    e.preventDefault();
    $("#add-link-table").fadeIn(500);
}
function deleteUser(e) {
    e.preventDefault();
    let userId = $(this).data("id");
    let offset = sessionStorage.getItem("offset");
    if(offset == null){
        offset = 0;
    }
    $.ajax({
        url: "/delete-user",
        data: {
            userId,
            offset
        },
        dataType: "json",
        success: function (users) {
            showUsers(users[0]);
            showUsersPagination(users[1]);
        }
    });

}
function showUsersPagination(users){
    let html = `<ul class="flex-element" id="user-list">`;
    for(let i = 0; i < users; i++){
        html +=`<li>
            <a href="#"  id = "link${i}" data-offset="${i}"  class="user-pagination">${i+1}</a></li>`;
    }
    html+=`</ul>`;
    $("#user-pagination").html(html);
    let linkId = sessionStorage.getItem("linkId");
    $(".admin-pagination #user-list li #"+linkId).addClass("active");
    $(".user-pagination").click(getLinks);
}
function getUsers(e){
    console.log("uslo u get users");
    e.preventDefault();
    let offset = $(this).data("offset");
    $("#user-pagination ul li a").removeClass("active");
    $(this).addClass("active");
    let link_id = $(this).attr("id");
    sessionStorage.setItem("linkId", ""+link_id);
    $.ajax({
        url: "/get-users",
        method: "get",
        dataType: "json",
        data:{
            offset,
        },
        success: function (data) {
            showUsers(data);
            console.log(data);
        }
    });
}
function showUsers(data) {
    let html = `<tr class="first-row">
                   <th>
                       Ime
                   </th>
                   <th>
                       Prezime
                   </th>
                   <th>
                       Username
                   </th>
                   <th>
                       Email
                   </th>
                   <th>
                       <i class="fa fa-edit"></i>
                   </th>
               </tr>`;
    for(let user of data){
        html += `
        <tr>
                        <td>
                            ${user.first_name}
                        </td>
                        <td>
                            ${user.last_name}
                        </td>
                        <td>
                            ${user.username}
                        </td>
                        <td>
                            ${user.email}
                        </td>
                        <td>
                            <a href="#" data-id="${user.user_id}" class="delete-user">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
        `;
    }
    $("#users-table").html(html);
    $(".delete-user").click(deleteUser);
}
function deleteLink(e){
    e.preventDefault();
    let linkId = $(this).data("id");
    let offset = sessionStorage.getItem("offset");
    if(offset == null){
        offset = 0;
    }
    console.log(linkId);
    console.log(offset);
    $.ajax({
       url: "/delete-link",
       data: {
           linkId,
           offset
       },
       dataType: "json",
       success: function (links) {
           console.log(links);
            showLinks(links[0]);
            showLinkPagination(links[1]);
       }
    });
}
function showLinkPagination(links){
    let html = `<ul class='flex-element'>`;
    for(let i = 0; i < links; i++){
        html +=`<li>
            <a href="#"  id = "link${i}" data-offset="${i}"  class="link-pagination">${i+1}</a></li>`;
    }
    html += `</ul>`;
    $("#pagination-block").html(html);
    let linkId = sessionStorage.getItem("linkId");
    $("#pagination-block ul li #"+linkId).addClass("active");
    $(".link-pagination").click(getLinks);
}
function getLinks(e) {
    e.preventDefault();
    $("#pagination-block ul li a").removeClass("active");
    $(this).addClass("active");
    let offset = $(this).data("offset");
    var link_id = $(this).attr("id");
    sessionStorage.setItem("linkId", ""+link_id);
    sessionStorage.setItem("offset", ""+offset);
    $.ajax({
       url: "/get-links",
       method: "get",
       data: {
           offset
       },
        dataType: "json",
        success: function (links) {
            showLinks(links);
        }
    });
}
function showLinks(links){
    let html = `<ul id="links-list" class="flex-element">`;
                    for(let link of links){
                        html +=`<li>
                    <a href="${link.link}" class="link-a">${link.link}</a>
                <a href="#" class="link-trash" data-id="${link.important_id}">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    </li>`;
                    }

            html +=`</ul>`;

    $("#links").html(html);
    $(".link-pagination").click(getLinks);
    $(".link-trash").click(deleteLink);
}
function checkLinkText(){
    let link = $("#new-link").val();
    let specRegex = /^[^<>%$;]*$/;
    let validate  = true;
    if(link == ""){
        $("#link-error").html("Morate uneti link.");
        validate = false;
    }
    if(!specRegex.test(link)){
        $("#link-error").html("Link sadrži nedozvoljene karaktere.");
        validate = false;
    }
    return validate;

}
function addInputText(e) {
    e.preventDefault();
    //let parentId = $(this).parent().attr("id");
    let html = "";
    let textActivity = $(this).text();
    console.log("textActivity: " +textActivity);
    console.log(textActivity.length);
        html = `<input type="text" class="activity" name="activity" placeholder="Moja obaveza"/><a href="#" class="write-activity"><i class="fa fa-check" aria-hidden="true"></i></a>`;
  if(textActivity.length > 0) {
     console.log("uslo ovde");
     if(textActivity.length != 37) {
         //html = `<input type="text" class="activity" name="activity" value="${textActivity}"/><a href="#" class="write-activity"><i class="fa fa-check" aria-hidden="true"></i></a>`;
     }
   }
    //  console.log(parentId);
    //$("#schedule-table tr #"+parentId).html(html);
    let time = $(this).parent().parent().children().find(".time").val();
    if(time == null || time==undefined){
        let timeTd = $(this).parent().parent().find(".td-time");
        let timeHtml = `<input type="time" class="time" name="time" required value="12:45"/>`;
        timeTd.html(timeHtml);
    }
    $(this).parent().html(html);
        $(".write-activity").click(writeActivity);
}
function writeActivity(e) {
    e.preventDefault();
    let day = $(this).parent().data("day");
    let tr = $(this).parent().parent();
    let activityTd = $(this).parent();
    let activity = $(this).parent().find(".activity").val();
    console.log(activity);
    if(activity == null || activity == ""){
        alert("Obaveza ne sme biti prazna.");
        return;
    }
    let time = $(this).parent().parent().children().find(".time").val();
    console.log(time);
    console.log(typeof(time));
    if(time == null){
        alert("Morate izabrati vreme aktivnosti.");
        return;
    }
    $.ajax({
        url: "/write-schedule",
        method: "get",
        data : {
            day,
            activity,
            time
        },
        dataType: "json",
        success: function(data){
            updateScheduleRow(data, activityTd, tr);
        }
    })
}
function updateScheduleRow(data, tdActivity, tr) {
    let tdTime = tr.find(".td-time");
    let time = data[0].time;
    time = time.substr(0, 5);
    tdTimeHtml = `${time}<input type="hidden" class="time" name="time"
                                      value="${data[0].time}"/>`;
    tdTime.html(tdTimeHtml);
    activityHtml = `<a href="#" class="link-activity">${data[0].activity}</a>`;
    tdActivity.html(activityHtml);
    console.log(tdTime);
    console.log(tdActivity);
    $(".link-time").click(addInputTime);
    $(".link-activity").click(addInputText);
}
function addInputTime(e) {
    e.preventDefault();
    let parent = $(this).parent();
    let html = `<input type="time" class="time" name="time" required value="13:45"/>`;
    parent.html(html);
}
function getNextPageGrades(e){
    e.preventDefault();
    let typeList = $(this).data("list");
    let offset = $(this).data("offset");
    let sortGrade = null;
    let sortYear = null;
    if($("#sort-grade-list").val()){
        sortGrade = $("#sort-grade-list").val();
    }
    if($("#sort-grade-by-year-list").val()){
        sortYear = $("#sort-grade-by-year-list").val();
    }
    $("#pagination-block ul li a").removeClass("active");
    $(this).addClass("active");
    let link_id = $(this).attr("id");
    sessionStorage.setItem("linkId", ""+link_id);
   if(typeList == "grade"){
        let html = `<option value="0">Sortiraj po godini studija...</option>
                        <option value="asc">Od najniže ka najvišoj godini</option>
                        <option value="desc">Od najviše ka najnižoj godini</option>`;
        $("#sort-grade-by-year-list").html(html);
    }else if(typeList == "year"){
        let html = ` <option value="0">Sortiraj po ocenama...</option>
                        <option value="asc">Od najniže ka najvišoj oceni</option>
                        <option value="desc">Od najviše ka najnižoj oceni</option>`;
        $("#sort-grade-list").html(html);
    }
    $.ajax({
       url: "/get-subject-grade",
       method: "get",
       dataType: "json",
       data :{
           offset,
           sortGrade,
           sortYear
       },
        success: function (data) {
            showGradesTable(data);
        }
    });
}sh
function showGradesTable(data){
    let html = `<tr id="grades-first">
                            <th>
                                Predmet
                            </th>
                            <th>
                                Godina studija
                            </th>
                            <th>
                                Profesor
                            </th>
                            <th>
                                Ocena
                            </th>
                        </tr>`;
    for(let sg of data[0]){
        html +=`<tr>
                                <td>
                                    ${sg.subject_name}
                                </td>
                                <td>
                                    ${sg.name} (${sg.alt})
                                </td>
                                <td>
                                    ${sg.professor}
                                </td>
                                <td id="column${sg.subject_id}">`;
                                    if(sg.grade == null) {
                                        html += `<select class="grades-list" data-id="${sg.subject_id}">
                                            <option value="0" selected disabled>Ocena...</option>`;
                                            for(let grade of data[2]){
                                                html += `<option value="${grade.grade_id}">${grade.grade}</option>`;
                                            }
                                        html += `</select>`;
                                    }
                                    else{
                                       html += `${sg.grade} (${sg.grade_name}) <a href="#" data-id="${sg.subject_id}" class="edit-grade"><i class="fa fa-edit"></i></a>`;
                                    }
                                html +=`</td>
                            </tr>`;
    }
    $("#grades-table").html(html);
    //showPaginationGrades(data);
    $(".grades-list").change(writeGrade);
    $(".edit-grade").click(getGrades);
}
function showPaginationGrades(data) {
    let number = data[1].number;
    let numberOfLinks = number / 6;
    let html = `<ul class='flex-element'>`;
    for(let i = 0; i < numberOfLinks; i++){
        html +=`<li>
            <a href="#"  id = "link${i}" data-offset="${i}"  class="grades-pagination">${i+1}</a></li>`;
    }
    html += `</ul>`;
    $("#pagination-block").html(html);
    let linkId = sessionStorage.getItem("linkId");
    $("#pagination-block ul li #"+linkId).addClass("active");
    $(".grades-pagination").click(getNextPageGrades);
}
function getGrades(e){
    e.preventDefault();
    let subjectId = $(this).data("id");
    $.ajax({
       url: "/grades",
       method: "get",
       dataType: "json",
       success: function(data){
           let html = `<select class="grades-list" data-id="${subjectId}">
                                            <option value="0" selected disabled>Ocena...</option>`;
                                            for(let grade of data){
                                                if(grade.grade != null){
                                                    html += `<option value="${grade.grade_id}">${grade.grade}</option>`;
                                                }
                                         }
                                        html +=`</select>`;
           $("#column"+subjectId).html(html);
           $(".grades-list").change(writeGrade);
       }
    });
}
function writeGrade() {
    let gradeId = $(this).val();
    let subjectId = $(this).data("id");
    console.log(gradeId);
    console.log(subjectId);
    $.ajax({
        url: "/insert-grade",
        method: "get",
        data: {
            gradeId: gradeId,
            subjectId: subjectId
        },
        dataType: "json",
        success: function(data){
            console.log(data);
            console.log(subjectId);
            updateGradeColumn(data[0], subjectId);
            updateAverageGrade(data[1]);
        }
    })
}
function updateAverageGrade(avg) {
    let html = `<label>Prosek: ${avg}</label>`;
    $("#average-grade").html(html);
}
function updateGradeColumn(data, columnId) {
    let html = `${data.grade} (${data.grade_name}) <a href="#" data-id="${columnId}" class="edit-grade"><i class="fa fa-edit"></i></a>`;
    $("#grades-table tr #column"+columnId).html(html);
    $(".grades-list").change(writeGrade);
    $(".edit-grade").click(getGrades);
}
function sendOffset(e){
    e.preventDefault();
    $("#pagination-block ul li a").removeClass("active");
    $(this).addClass("active");
    let offset = $(this).data("offset");
    let year = $(this).data("year");
    let search = $("#search").val();
    var link_id = $(this).attr("id");
    console.log("Link id: " +link_id);
    sessionStorage.setItem("linkId", ""+link_id);
    $.ajax({
       url: "/subjects-offset",
       method: "get",
       data: {
           offset: offset,
           year: year,
           search: search
       },
        dataType: "json",
        success:function(data){
           showSubjects(data);
    }
    });
}
function showSubjects(data){
    let subj = data[0];
    console.log(data);
    let html = ` <tr id="subjects-h">
                    <th>
                        Predmet
                    </th>
                    <th>
                        Profesor
                    </th>
                    <th>
                        Opis predmeta
                    </th>
                    <th>
                        Termini kolokvijuma
                    </th>
                    <th>
                        Termin ispita
                    </th>
                </tr>`;
    for(let subject of data[0]){
        html += `
            <tr><td>
                      ${subject.subject_name}
                    </td>
                    <td>
                        ${subject.professor}
                    </td>
                    <td id="desc-column${subject.subject_id}" class="td-desc">
                         <textarea id="new-desc">
                            ${subject.description}
                        </textarea><a href="#" class="add-new-desc" data-id="${subject.subject_id}"><i class="fa fa-check"></i></a>
                        <p class="description">
                            ${subject.description}
                        </p>
                            <a href="#" class="show-desc-input" data-id="${subject.subject_id}">`;
                            if(subject.description == null){
                            html += `Dodaj opis`;
                            }
                            else {
                            html += `Izmeni opis`;
                            }
                            html +=`</a>
                    </td>
                    <td id="column${subject.subject_id}">

                    </td>`;
        let subjectId = subject.subject_id;
        html += `<td id="column-final${subject.subject_id}">`;
        if(subject.final_date == null){
            html += ` <a href="#" class="show-final-input" data-id="${subject.subject_id}">Dodaj termin</a>`;
        }else{
            html += `${subject.final_date}`;
        }
        html += `</td> </tr>`;
        $.ajax({
            url: "/get-subject-exams",
            method: "get",
            data: {
                subjectId: subjectId
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                let exams = "<ul class='exams-list'>";
                for(let exam of data) {
                    if(exam.exam_date != null){
                        exams += `<li>${exam.exam_date}</li>`;
                    }
                }
                exams += `</ul><a href="#" class="show-input" data-id="${subject.subject_id}">Dodaj termin</a>`;
                console.log(subject.subject_id);
                $("#column"+subject.subject_id).html(exams);
                $(".show-input").click(showInput);
            }});
    }
    $("#subjects-table").html(html);
    $(".show-final-input").click(showFinalInput);
    $(".show-desc-input").click(showDescInput);
    showPagination(data);
}
function showPagination(data) {
    let number = data[1].number;
    if(number == 0){
        $("#pagination-block").html("<p>Predmeti sa tim informacijama ne postoje.</p>");
        $("#subjects-table").html();
        $("#subjects-h").hide();
        return;
    }
    let year = data[0][0].year_of_study;
    let numberOfLinks = number / 6;
    let html = `<ul class='flex-element'>`;
        for(let i = 0; i < numberOfLinks; i++){
            html +=`<li>
            <a href="#"  id = "link${i}" data-offset="${i}" data-year="${year}" class="s-pagination">${i+1}</a></li>`;
        }
        html += `</ul>`;
        $("#pagination-block").html(html);
    let linkId = sessionStorage.getItem("linkId");
    $("#pagination-block ul li #"+linkId).addClass("active");
    $(".s-pagination").click(sendOffset);
}
function searchSubjects(){
    let searchValue = $("#search").val();
    let year = $(this).data("year");
    let offset = 0;
    $("#pagination-block ul li a").removeClass("active");
    $("#pagination-block ul li a:first").addClass("active");
    sessionStorage.setItem("linkId", "link0");
    $.ajax({
        url: "/subjects-offset",
        method: "get",
        data: {
            offset: offset,
            year: year,
            searchValue: searchValue
        },
        dataType: "json",
        success:function(data){
            showSubjects(data);
        }
    });
}
function destroySession(){
    $.ajax({
        url: "/destroy-session",
        method: "get"
    });
}
function showFinalInput(e){
        e.preventDefault();
        let subject_id = $(this).data("id");
        let html = `<input type="date" name="new-final-date" id="new-final-date"/><a id="add-new-final-date" href="#" data-id="${subject_id}"><i class="fa fa-check" aria-hidden="true"></i></a>`;
        $("#column-final"+subject_id).html(html);
        $("#add-new-final-date").click(addNewFinalDate);
}
function addNewFinalDate(e) {
    e.preventDefault();
    let finalDate = $("#new-final-date").val();
    let id = $(this).data("id");
    $.ajax({
       url: "/add-final-date",
       method: "get",
       data: {
           finalDate: finalDate,
           id: id
       },
       success: function () {
            $("#column-final"+id + "#new-final-date").hide();
           $("#column-final"+id + "a").hide();
           $("#column-final"+id).html(finalDate);
       }
    });
}
function addNewDesc(e) {
    e.preventDefault();
    let id = $(this).data("id");
    let description = $("#subjects-table tr #desc-column"+id + " textarea").val();
    console.log(id);
    console.log("opis je " + description);
    $.ajax({
       url: "/add-new-desc",
       method: "get",
       data: {
           id: id,
           description: description
       },
        success: function () {
            $("#subjects-table tr #desc-column"+id + " p").show();
            $("#subjects-table tr #desc-column"+id + " a").show();
            $("#subjects-table tr #desc-column"+id + " textarea").hide();
            $("#subjects-table tr #desc-column"+id + " .add-new-desc").hide();
            $("#subjects-table tr #desc-column"+id + " p").html(description);
        }
    });
}
function showDescInput(e) {
    e.preventDefault();
    let id = $(this).data("id");
    $("#subjects-table tr #desc-column"+id + " p").hide();
    $("#subjects-table tr #desc-column"+id + " a").hide();
    $("#subjects-table tr #desc-column"+id + " textarea").show();
    $("#subjects-table tr #desc-column"+id + " .add-new-desc").show();
}
function showInput(e){
    e.preventDefault();
    let subject_id = $(this).data("id");
    let html = `<input type="date" name="new-exam-date" id="new-exam-date"/><a id="add-new-date" href="#" data-id="${subject_id}"><i class="fa fa-check" aria-hidden="true"></i></a>`;
    $("#column"+subject_id).html(html);
    $("#add-new-date").click(addNewExamDate);
}
function addNewExamDate(e){
    e.preventDefault();
    let date = $("#new-exam-date").val();
    let subjectId = $(this).data("id");
    $.ajax({
        url: "/add-new-exam",
        method: "get",
        data: {
            date: date,
            subjectId: subjectId
        },
        dataType: "json",
        success: function(subject){
            console.log(subject);
            let html = `
            <td>
                      ${subject.subject_name}
                    </td>
                    <td>
                        ${subject.professor}
                    </td>
                    <td id="desc-column${subject.subject_id}" class="td-desc">
                         <textarea id="new-desc">
                            ${subject.description}
                        </textarea><a href="#" class="add-new-desc" data-id="${subject.subject_id}"><i class="fa fa-check"></i></a>
                        <p class="description">
                            ${subject.description}
                        </p>
                            <a href="#" class="show-desc-input" data-id="${subject.subject_id}">`;
                            if(subject.description == null){
                            html += `Dodaj opis`;
                            }
                            else {
                            html += `Izmeni opis`;
                            }
                           html += ` </a>
                    </td>
                    <td id="column${subject.subject_id}">

                    </td>`;
            let subjectId = subject.subject_id;
                    html += `<td id="column-final${subject.subject_id}">
                        ${subject.final_date}`;
                    if(subject.final_date == null){
                        html += ` <a href="#" class="show-final-input" data-id="${subject.subject_id}">Dodaj termin</a>`;
                    }
                   html += `</td> `;
                    $("#row"+subject.subject_id).html(html);
            $.ajax({
                url: "/get-subject-exams",
                method: "get",
                data: {
                    subjectId: subjectId
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    let exams = "<ul class='exams-list'>";
                        for(let exam of data) {
                            if(exam.exam_date != null){
                                exams += `<li>${exam.exam_date}</li>`;
                            }
                        }

                    exams += `</ul><a href="#" class="show-input" data-id="${data[0].subject_id}">Dodaj termin</a>`;
                    $("#column"+data[0].subject_id).html(exams);
                    $(".show-input").click(showInput);
                }});
        }
    })
    $(".show-final-input").click(showFinalInput);
    $("#add-new-final-date").click(addNewExamDate);
}
function checkNewSubjectInfo(){
    let validate = true;
    let specRegex = /^[^<>%$;]*$/;
    let subjectName = $("#subject-name").val();
    let subjectProfessor =  $("#subject-professor").val();
    let subjectDesc =  $("#subject-desc").val();
    let finalDate = $("#final-date").val();
    console.log(finalDate);
    if(subjectName == "")
    {
        validate = false;
        $("#subject-error").html("Obavezno je upisati ime predmeta.");
    }else{
        if(!specRegex.test(subjectName)){
            validate = false;
            $("#subject-error").html("Ime predmeta ne sme sadržati specijalne karaktere.");
        }
    }
    if(subjectProfessor == "")
    {
        validate = false;
        $("#professor-error").html("Obavezno je upisati ime profesora.");
    }else{
        if(!specRegex.test(subjectProfessor)){
            validate = false;
            $("#professor-error").html("Ime profesora ne sme sadržati specijalne karaktere.");
        }
    }
    if(!specRegex.test(subjectName)){
        validate = false;
        $("#subject-error").html("Ime predmeta ne sme sadržati specijalne karaktere.");
    }
    return validate;
}
function addExamDates() {
    let number = $("#exams-number").val();
    let html = "";
    for(let i = 1; i <= number; i++){
        html += `<label>${i}. kolokvijum termin: </label><input type="date" id="exam${i}" name="exam[]"/><br/>`;
    }
    $("#exams-date").html(html);
}
function showFormSubject() {
    $("#add-subject").show();
}
function checkStudentInfo() {
    let university = $("#university").val();
    let specRegex = /^[^<>%$;]*$/;
    let module = $("#module").val();
    let validate = true;
    if(university != ""){
        if(!specRegex.test(university)){
            validate = false;
            $("#university-error").html("Specijalni karakteri kao što su '%, <>, $, ;', nisu dozvoljeni.");
        }
    }
    if(module != ""){
        if(!specRegex.test(module)){
            validate = false;
            $("#module-error").html("Specijalni karakteri kao što su '%,<>, $, ;', nisu dozvoljeni.");
        }
    }
    return validate;
}
function changeStudyYear(){
    let year = $("#year-of-study").val();
    $.ajax({
        url: "change-study-year/"+year,
        method: "get"
    });
}
function register(){
    let validate = true;
    let username = $("#username").val();
    let password = $("#password").val();
    let repeatPassword = $("#repeat-password").val();
    let firstName = $("#first-name").val();
    let lastName = $("#last-name").val();
    let email = $("#email").val();
    let gender = $("#gender").val();

    let firstNameReg = /^[A-ZŠĐŽČĆŽ][a-zšđžčćž]{2,13}(\s[A-ZŠĐŽČĆ][a-zšđžčć]{2,13})*$/;
    if(firstName == ""){
        validate = false;
        $("#first-name-error").html("Ime je obavezno polje.");
    }
    else if(!firstNameReg.test(firstName)){
        validate = false;
        $("#first-name-error").html("Ime mora početi velikim slovom i imati najmanje 2, a najviše 13 karaktera.");
    }
    let lastNameReg = /^[A-ZŠĐŽČĆŽ][a-zšđžčćž]{2,13}(\s[A-ZŠĐŽČĆ][a-zšđžčć]{2,13})*$/;
    if(lastName == ""){
        validate = false;
        $("#last-name-error").html("Prezime je obavezno polje.");
    }
    else if(!lastNameReg.test(lastName)){
        validate = false;
        $("#last-name-error").html("Prezime mora početi velikim slovom i imati najmanje 2, a najviše 13 karaktera.");
    }
    let usernameReg = /(?=.*[a-z])(?=.*[0-9])(?=.{8,})/;
    if(username == ""){
        validate = false;
        $("#username-error").html("Korisničko ime je obavezno polje.");
    }
    else if(!usernameReg.test(username)){
        validate = false;
        $("#username-error").html("Korisničko ime može sadržati mala slova, brojeve i može imati najmanje 8 karaktera.");
    }
    let passwordReg = /(?=.*[a-z])(?=.*[0-9])(?=.{8,})/;

    if(password== ""){
        validate = false;
        $("#password-error").html("Lozinka je obavezno polje.");
    }
    else if(!passwordReg.test(password)){
        validate = false;
        $("#password-error").html("Lozinka može sadržati mala slova, brojeve i može imati najmanje 8 karaktera.");
    }
    if(repeatPassword != password){
        validate = false;
        $("#repeat-password-error").html("Ponovoljena lozinka se ne poklapa sa lozinkom.");
    }
    let emailReg = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
    if(email == ""){
        validate = false;
        $("#email-error").html("E-mail je obavezno polje.");
    }
    else if(!emailReg.test(email)){
        validate = false;
        $("#email-error").html("E-mail adresa nije u ispravnom formatu.");
    }
    if(gender == "0"){
        validate = false;
        $("#gender-error").html("Morate izabrati pol.");
    }
    if(validate){
        $("#username-error").html();
        $("#password-error").html();
        $("#first-name-error").html();
        $("#last-name-error").html();
        $("#email-error").html();
        $("#repeat-password-error").html();
        $("#gender-error").html();
        //ajax

        $.ajax({
            url: "register-user",
            method: "post",
            data: {
                _token: $("input[name='_token']").val(),
                username: username,
                password: password,
                email: email,
                firstName: firstName,
                lastName: lastName,
                gender: gender
            },
            success: [function(data){
                //redirect
                console.log("uspesna registracija")
                window.location.replace("/");
            }],
            error: [function(xhr, status, error){
                var messageError = "Dogodila se greška. Molimo Vas, pokušajte kasnije.";
                console.log(xhr.status);
                switch (xhr.status) {
                    case 500:
                        messageError = "Sistemska greska";
                        break;
                    case 409:
                        messageError = "Korisnik sa ovim informacijama već postoji. Korisničko ime i e-mail moraju biti jedinstveni.";
                        break;

                }
                $("#error-ajax").html(messageError);
                console.log(messageError);
            }]
        });
    }
}
function login() {
    let validate = true;
    let username = $("#username").val();
    let password = $("#password").val();
    let usernameReg = /(?=.*[a-z])(?=.*[0-9])(?=.{8,})/;
    if(username == ""){
        validate = false;
        $("#username-error").html("Korisničko ime je obavezno polje.");
    }
    else if(!usernameReg.test(username)){
        validate = false;
        $("#username-error").html("Korisničko ime može sadržati mala slova, brojeve i može imati najmanje 8 karaktera.");
    }
    let passwordReg = /(?=.*[a-z])(?=.*[0-9])(?=.{8,})/;

    if(password== ""){
        validate = false;
       $("#password-error").html("Lozinka je obavezno polje.");
    }
    else if(!passwordReg.test(password)){
        validate = false;
        $("#password-error").html("Lozinka može sadržati mala slova, brojeve i može imati najmanje 8 karaktera.");
    }
    if(validate){
        $("#username-error").html();
        $("#password-error").html();
        //ajax

        $.ajax({
           url: "login",
           method: "post",
           dataType: "json",
            data: {
                _token: $("input[name='_token']").val(),
               username: username,
                password: password
            },
            success: [function(data){
                if(data.userRole == "user"){
                    window.location.replace("/pocetna");
                }else{
                    window.location.replace("/admin")
                }
            }],
            error: [function(xhr, status, error){
               var messageError = "Dogodila se greška. Molimo Vas, pokušajte kasnije.";
               console.log(xhr.status);
                switch (xhr.status) {
                    case 404:
                        messageError = "Niste registrovani."
                        break;
                    case 500:
                        messageError = "Sistemska greska";
                        break;

                }
                $("#error-ajax").html(messageError);
                console.log(messageError);
            }]
        });
    }
}
