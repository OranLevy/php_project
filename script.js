

function showQuestions(){
    let q_4 = document.getElementById('new_job').value;
    if(q_4 === 'Yes'){
        document.getElementById('q5').style.display = 'block';
        document.getElementById('q6').style.display = 'block';
    }else{
        document.getElementById('q5').style.display = 'none';
        document.getElementById('q6').style.display = 'none';
    }
}

function showDivsError(){
    if(document.getElementById('php_error').childNodes.length > 1){
        document.getElementById('php_error').style.display = 'block';
    }else{
        document.getElementById('php_error').style.display = 'none';
    }

    if(document.getElementById('php_success').childNodes.length > 1){
        document.getElementById('php_success').style.display = 'block';
    }else{
        document.getElementById('php_success').style.display = 'none';
    }
}

function createUser(){
    var request = new XMLHttpRequest();
    let userData = {
        f_name: $('#f_name').val(),
        l_name: $('#l_name').val(),
        user_id: $('#user_id').val(),
        password: $('#password').val()
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            console.log('oran');
            console.log(request);
            document.getElementById('php_success').innerHTML = request.responseText;
        }
    }
    request.open('POST', 'signup.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(userData);
    request.send(payload);
}

function sendAnswers1(){
    let request = new XMLHttpRequest();
    let data = {
        'part': 1,
        'q1': $('#city_q').val(),
        'q2': $('#age_q').val(),
        'q3': $('#work_in').val(),
        'q4': $('#new_job').val(),
        'q5': $('#work_scope').val(),
        'q6': $('#work_experience').val()
    };
    request.onreadystatechange = function (){
        if(request.readyState === 4 && request.status === 200){
            console.log(request);
            document.getElementById('php_success').innerHTML = request.responseText;
        }
    }
    request.open('POST', 'signup.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(data);
    request.send(payload);

}

showDivsError();