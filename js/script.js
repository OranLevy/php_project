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

function createUser(){
    let request = new XMLHttpRequest();
    let userData = {
        f_name: $('#f_name').val(),
        l_name: $('#l_name').val(),
        user_id: $('#user_id').val(),
        password: $('#password').val(),
        birthday: $('#birthday').val(),
        email: $('#email').val()
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            let response = JSON.parse(request.responseText);
            if('error_fname' in response){
                $('#error-fname').html(response['error_fname']);
            }
            if('error_lname' in response){
                $('#error-lname').html(response['error_lname']);
            }
            if('error_email' in response){
                $('#error-email').html(response['error_email']);
            }
            if('error_birthday' in response){
                $('#error-birthday').html(response['error_birthday']);
            }
            if('error_userid' in response){
                $('#error-userid').html(response['error_userid']);
            }
            if('error_password' in response){
                $('#error-password').html(response['error_password']);
            }
            if('success' in response){
                $('#signup_success').html(response['success']);
            }
            if('dupp_user' in response){
                $('#error-userid').html(response['dupp_user']);
            }
        }
    }
    request.open('POST', 'signup.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(userData);
    request.send(payload);
}

function logout() {
    window.location = '/phpProject/static/logout.php';
}
