function answer_part1(){
    let request = new XMLHttpRequest();
    let answers = {
        action: 'part1',
        q1: $('#city_q').val(),
        q2: $('#age_q').val(),
        q3: $('#work_in').val(),
        q4: $('#new_job').val(),
        q5: $('#work_scope').val(),
        q6: $('#work_experience').val()
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            let resp = JSON.parse(request.responseText);
            console.log(resp);
            if('error' in resp){
                $('#part1-success').hide();
                $('.error-survey').html('');
                $('.error-survey').show();
                let error = resp['error']
                if('q1_error' in error){
                    $('#q1_error').html(error['q1_error']);
                }
                if('q2_error' in error){
                    $('#q2_error').html(error['q2_error']);
                }
                if('q3_error' in error){
                    $('#q3_error').html(error['q3_error']);
                }
                if('q4_error' in error){
                    $('#q4_error').html(error['q4_error']);
                }
                if('q5_error' in error){
                    $('#q5_error').html(error['q5_error']);
                }
                if('q6_error' in error){
                    $('#q6_error').html(error['q6_error']);
                }
            }
            if('success' in resp){
                $('.error-survey').hide();
                $('#part1-success').html(resp['success']);
                $('#part1-success').show();
            }
            console.log('Part 1 submitted');
        }
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(answers);
    request.send(payload);
}

function answer_part1_continue(){
    let request = new XMLHttpRequest();
    let answers = {
        action: 'part1',
        q1: $('#city_q').val(),
        q2: $('#age_q').val(),
        q3: $('#work_in').val(),
        q4: $('#new_job').val(),
        q5: $('#work_scope').val(),
        q6: $('#work_experience').val()
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            console.log('Part 1 submitted');
            let resp = JSON.parse(request.responseText);
            console.log(resp);
            if('success' in resp){
                if($('#work_experience').val() === 'Yes'){
                    $('#survey-part1').hide();
                    $('#survey-part2').show();
                    $('#part1-continue-success').html(resp['success']);
                    $('#part1-continue-success').show();
                }else{
                    $('#survey-part1').hide();
                    $('#survey-part3').show();
                    $('#part2-continue-success').html(resp['success']);
                    $('#part2-continue-success').show();
                }

            }
            if('error' in resp){
                $('.error-survey').html('');
                $('.error-survey').show();
                let error = resp['error']
                if('q1_error' in error){
                    $('#q1_error').html(error['q1_error']);
                }
                if('q2_error' in error){
                    $('#q2_error').html(error['q2_error']);
                }
                if('q3_error' in error){
                    $('#q3_error').html(error['q3_error']);
                }
                if('q4_error' in error){
                    $('#q4_error').html(error['q4_error']);
                }
                if('q5_error' in error){
                    $('#q5_error').html(error['q5_error']);
                }
                if('q6_error' in error){
                    $('#q6_error').html(error['q6_error']);
                }
            }
        }
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(answers);
    request.send(payload);
}

function answer_part2(){
    let request = new XMLHttpRequest();
    let answers = {
        action: 'part2',
        q7: $('#work_city').val(),
        q8: $('#position_q').val(),
        q9: $('#work_time').val(),
        q10: $('#salary').val(),
        q11: $('#get_job').val(),
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            let resp = JSON.parse(request.responseText);
            console.log(resp);
            if('error' in resp){
                $('#part1-continue-success').hide();
                $('#part2-success').hide();
                $('.error-survey').html('');
                $('.error-survey').show();
                let error = resp['error']
                if('q7_error' in error){
                    $('#q7_error').html(error['q7_error']);
                }
                if('q8_error' in error){
                    $('#q8_error').html(error['q8_error']);
                }
                if('q9_error' in error){
                    $('#q9_error').html(error['q9_error']);
                }
                if('q10_error' in error){
                    $('#q10_error').html(error['q10_error']);
                }
                if('q11_error' in error){
                    $('#q11_error').html(error['q11_error']);
                }
            }
            if('success' in resp){
                $('#part1-continue-success').hide();
                $('.error-survey').hide();
                $('#part2-success').html(resp['success']);
                $('#part2-success').show();
            }
            console.log('Part 2 submitted');
        }
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(answers);
    request.send(payload);
}

function answer_part2_continue(){
    let request = new XMLHttpRequest();
    let answers = {
        action: 'part2',
        q7: $('#work_city').val(),
        q8: $('#position_q').val(),
        q9: $('#work_time').val(),
        q10: $('#salary').val(),
        q11: $('#get_job').val(),
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            let resp = JSON.parse(request.responseText);
            console.log(resp);
            console.log('Part 2 submitted');
            if('success' in resp){
                $('#survey-part2').hide();
                $('#survey-part3').show();
                $('#part2-continue-success').html(resp['success']);
                $('#part2-continue-success').show();
            }
            if('error' in resp){
                $('.error-survey').html('');
                $('.error-survey').show();
                let error = resp['error']
                if('q7_error' in error){
                    $('#q7_error').html(error['q7_error']);
                }
                if('q8_error' in error){
                    $('#q8_error').html(error['q8_error']);
                }
                if('q9_error' in error){
                    $('#q9_error').html(error['q9_error']);
                }
                if('q10_error' in error){
                    $('#q10_error').html(error['q10_error']);
                }
                if('q11_error' in error){
                    $('#q11_error').html(error['q11_error']);
                }
            }
        }
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(answers);
    request.send(payload);
}

function answer_part3(){
    let request = new XMLHttpRequest();
    let q12 = $("input[name='search_source[]']:checked").map(function(){
        return $(this).val();
    }).get().toString();
    let answers = {
        action: 'part3',
        q12: q12,
        q13: $('#hour_search').val(),
        q14: $('#get_accepted').val(),
        q15: $('#hiring_test').val(),
        q16: $('#test_prepared').val(),
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            let resp = JSON.parse(request.responseText);
            console.log(resp);
            if('success' in resp){
                $('#part3-success').html(resp['success']);
                $('#part3-success').show();
                $('.error-survey').hide();
                $('#part2-continue-success').hide();
            }
            if('error' in resp){
                $('#part3-success').hide();
                $('.error-survey').html('');
                $('.error-survey').show();
                let error = resp['error']
                if('q12_error' in error){
                    $('#q12_error').html(error['q12_error']);
                }
                if('q13_error' in error){
                    $('#q13_error').html(error['q13_error']);
                }
                if('q14_error' in error){
                    $('#q14_error').html(error['q14_error']);
                }
                if('q15_error' in error){
                    $('#q15_error').html(error['q15_error']);
                }
                if('q16_error' in error){
                    $('#q16_error').html(error['q16_error']);
                }
            }
            console.log('Part 3 submitted');
        }
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(answers);
    request.send(payload);
}

function answer_part3_continue(){
    let request = new XMLHttpRequest();
    let q12 = $("input[name='search_source[]']:checked").map(function(){
        return $(this).val();
    }).get().toString();
    let answers = {
        action: 'part3',
        q12: q12,
        q13: $('#hour_search').val(),
        q14: $('#get_accepted').val(),
        q15: $('#hiring_test').val(),
        q16: $('#test_prepared').val(),
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            let resp = JSON.parse(request.responseText);
            console.log(resp);
            console.log('Part 3 submitted');
            if('success' in resp){
                submitAnswers();
                window.location = '../index.php';
            }
            if('error' in resp){
                $('.error-survey').html('');
                $('.error-survey').show();
                let error = resp['error']
                if('q12_error' in error){
                    $('#q12_error').html(error['q12_error']);
                }
                if('q13_error' in error){
                    $('#q13_error').html(error['q13_error']);
                }
                if('q14_error' in error){
                    $('#q14_error').html(error['q14_error']);
                }
                if('q15_error' in error){
                    $('#q15_error').html(error['q15_error']);
                }
                if('q16_error' in error){
                    $('#q16_error').html(error['q16_error']);
                }
            }
            if('success' in resp){
                $('#part3-success').html(resp['success']);
                $('#part3-success').show();
            }
        }
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = JSON.stringify(answers);
    request.send(payload);
}

function getCities(){
    let request = new XMLHttpRequest();
    request.onreadystatechange = function (){
        if(request.readyState === 4 && request.status === 200){
            let cities = JSON.parse(request.responseText)
            $("#city_q").select2({
                data: cities,
                selectionCssClass: '.q_paragraph>select'
            });
            $("#work_city").select2({
                data: cities,
                selectionCssClass: '.q_paragraph>select',
                placeholder: '-'
            });
        }
    fetchUserAnswers();
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = {
        action: 'getCities'
    }
    payload = JSON.stringify(payload);
    request.send(payload);
}

function fetchUserAnswers(){
    let request = new XMLHttpRequest();
    request.onreadystatechange = function (){
        if(request.readyState === 4 && request.status === 200){
            let answers = JSON.parse(request.responseText)
            console.log(answers);
            if('part1' in answers){
                let part1 = answers['part1'];
                $("#city_q").select2().val(part1['q1']).trigger("change");
                $('#age_q').val(part1['q2']),
                $('#work_in').val(part1['q3']),
                $('#new_job').val(part1['q4']),
                $('#work_scope').val(part1['q5']),
                $('#work_experience').val(part1['q6'])
            }
            if('part2' in answers){
                let part2 = answers['part2'];
                $("#work_city").select2().val(part2['q7']).trigger("change");
                $('#position_q').val(part2['q8']),
                $('#work_time').val(part2['q9']),
                $('#salary').val(part2['q10']),
                $('#get_job').val(part2['q11'])
            }
            if('part3' in answers){
                let part3 = answers['part3'];
                let q12 = part3['q12'].split(',');
                for(let i = 0; i < q12.length; i++){
                    document.getElementById(q12[i]).checked = true
                }
                $('#hour_search').val(part3['q13']),
                $('#get_accepted').val(part3['q14']),
                $('#hiring_test').val(part3['q15']),
                $('#test_prepared').val(part3['q16'])
            }
        }
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    let payload = {
        action: 'fetchUserAnswers'
    }
    payload = JSON.stringify(payload);
    request.send(payload);
}

function showPartSection(){
    let url = window.location.hash;
    if(url.includes('#survey-part1')){
        $('#survey-part3').hide();
        $('#survey-part2').hide();
        $('#survey-part1').show()
    }
    if(url.includes('#survey-part2')){
        $('#survey-part1').hide();
        $('#survey-part3').hide();
        $('#survey-part2').show()
    }
    if(url.includes('#survey-part3')){
        $('#survey-part1').hide();
        $('#survey-part2').hide();
        $('#survey-part3').show()
    }
}

function submitAnswers(){
    let request = new XMLHttpRequest();
    let payload = {
        'action': 'userSubmitAnswers'
    }
    request.onreadystatechange = function(){
        if(request.readyState === 4 && request.status === 200){
            console.log('Answers submitted');
        }
    }
    request.open('POST', 'survey.php', true);
    request.setRequestHeader('Content-type', 'application/json');
    payload = JSON.stringify(payload);
    request.send(payload);
}
