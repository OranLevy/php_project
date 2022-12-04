<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h1 class="headline">Part 1 - General information</h1>
		<form method="post">
			<div id="q1">
				<label  for="city_q">1. In which city do you live?</label>
				<input type="text" name="city_q" id="city_q" class="city_q">
			</div>
			<br>
			<div id="q2">
				<label for="age_q">2. What age range do you belong to?</label>
				<select name="age_q" id="age_q">
					<option value="-"></option>
					<option value="18-21">18-21</option> 
					<option value="22-25">22-25</option>
					<option value="26-30">26-30</option>
					<option value="31-35">31-35</option>
					<option value="35-40">35-40</option>
				</select>
				</div>
			<br>
			<div id="q3">
				<label for="work_in">3. Do you work in the high-tech industry?</label>
				<select name="work_in" id="work_in">
					<option value="-"></option>
					<option value="yes">Yes</option>
					<option value="no">No</option>
				</select>
			</div>
			<br>
			<div class="q4">
				<label for="new_job">4. Are you looking for a new job?</label>
				<select name="new_job" id="new_job" onchange="showQuestions()">
					<option value="-"></option>
					<option value="yes">Yes</option>
					<option value="no">No</option>
				</select>
			</div>
			<br>
			<div id="q5" style="display: none;">
				<label for="work_scope">5. What scope of employment are you looking for?</label>
				<select name="work_scope" id="work_scope">
					<option value="-"></option>
					<option value="part_time">Part time</option>
					<option value="full_time">Full time</option>
				</select>
			</div>
			<br>
			<div id="q6" style="display: none;">
				<label for="work_experience">6. Do you have work experience?</label>
				<select name="work_experience" id="work_experience">
					<option value="-"></option>
					<option value="yes">Yes</option>
					<option value="no">No</option>
				</select>
			</div>
			<br>
			<input type="submit" value="Send">
		</form>
	</body>
	<script type="text/javascript"> 
		function showQuestions(){
			var q_4 = document.getElementById('new_job').value;
			if(q_4 == 'yes'){
				document.getElementById('q5').style.display = 'block';
				document.getElementById('q6').style.display = 'block';
			}
		}
	</script>
</html>

<?php
	if($_POST){
		if(!$_POST['city_q']){
			$error = 'Q1 is required.<br>';
		}
		if(!$_POST['age_q'] || $_POST['age_q'] == '-'){
			$error = $error.'Q2 is required.<br>';
		}
		if(!$_POST['work_in'] || $_POST['work_in'] == '-'){
			$error = $error.'Q3 is required.<br>';
		}
		if((!$_POST['new_job'] || $_POST['new_job'] == '-')){
			$error = $error.'Q4 is required.<br>';
		}
		if((!$_POST['work_scope'] || $_POST['work_scope'] == '-') && $_POST['new_job'] == 'yes'){
			$error = $error.'Q5 is required.<br>';
		}
		if((!$_POST['work_experience'] || $_POST['work_experience'] == '-') && $_POST['new_job'] == 'yes'){
			$error = $error.'Q6 is required.<br>';
		}
	
		if(isset($error)){
			echo $error;
		}else{
			echo 'Answers: <br>';
			echo 'Q1: '.$_POST['city_q'].'<br>';
			echo 'Q2: '.$_POST['age_q'].'<br>';
			echo 'Q3: '.$_POST['work_in'].'<br>';
			echo 'Q4: '.$_POST['new_job'].'<br>';
			if($_POST['new_job'] == 'yes'){
				echo 'Q5: '.$_POST['work_scope'].'<br>';
				echo 'Q6: '.$_POST['work_experience'];
			}
		}
	
	}
	
?>
