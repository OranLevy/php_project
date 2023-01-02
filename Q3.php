<!-- Oran Levy 204809859
    Gal Fogel 316080399
    Or Eshed 316220698 -->
<?php
require_once('survey_part1.php');
require_once('includes/database.php');
include('navbar-menu.html');
session_start();
global $database;
if($database->get_connection()){
	echo "<script>console.log('Connection OK');</script>";
}else{
	die('Connection failed');
}
unset($_SESSION['error']);
unset($_SESSION['error_sql']);

if ($_POST) {
	if (!$_POST['city_q']) {
		$error = 'Q1 is required.<br>';
	}
	if (!$_POST['age_q'] || $_POST['age_q'] == '-') {
		$error = $error . 'Q2 is required.<br>';
	}
	if (!$_POST['work_in'] || $_POST['work_in'] == '-') {
		$error = $error . 'Q3 is required.<br>';
	}
	if ((!$_POST['new_job'] || $_POST['new_job'] == '-')) {
		$error = $error . 'Q4 is required.<br>';
	}
	if ((!$_POST['work_scope'] || $_POST['work_scope'] == '-') && $_POST['new_job'] == 'yes') {
		$error = $error . 'Q5 is required.<br>';
	}
	if ((!$_POST['work_experience'] || $_POST['work_experience'] == '-') && $_POST['new_job'] == 'yes') {
		$error = $error . 'Q6 is required.<br>';
	}

	if (isset($error)) {
		$_SESSION['error'] = $error;
		// echo $error;
	} else {
		if (!$database->id_exist_answers("oranle")) {
			$error_sql = SurveyPart1::add_answers("oranle", $_POST['city_q'], $_POST['age_q'], $_POST['work_in'], $_POST['new_job'], $_POST['work_scope'], $_POST['work_experience']);
		} else {
			$error_sql = SurveyPart1::update_answers("oranle", $_POST['city_q'], $_POST['age_q'], $_POST['work_in'], $_POST['new_job'], $_POST['work_scope'], $_POST['work_experience']);
			$error_sql = $error_sql . 'ID of the answers already exist in DB <br>Updating answers.';
		}
		if (isset($error_sql)) {
			$_SESSION['error_sql'] = $error_sql;
		}
	}
}



?>
<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<main>
			<section>
				<h1 class="headline">Part 1 - General information</h1>
				<form method="post" class="form" action="Q3.php">
					<div class="error" id="error_q">
						<?php if(isset($_SESSION['error'])){
							echo $_SESSION['error'];
						}
						?>
					</div>
					<div id="success_q" style="display: none;">
						<?php if(isset($_SESSION['error_sql'])){
							echo $_SESSION['error_sql'];
						}else{
							if($_POST && !isset($_SESSION['error'])){
								echo 'Answers submitted';
							}
							
						}
						?>
					</div>
					<div id="q1">
						<label  for="city_q">1. In which city do you live?</label>
						<p class="required_message">* Required</p>
						<p class="q_paragraph">
							<input type="text" name="city_q" id="city_q" class="city_q">
						</p>
					</div>
					<br>
					<div id="q2">
						<label for="age_q">2. What age range do you belong to?</label>
						<p class="required_message">* Required</p>
						<p class="q_paragraph">
							<select name="age_q" id="age_q">
								<option value="-"></option>
								<option value="18-21">18-21</option> 
								<option value="22-25">22-25</option>
								<option value="26-30">26-30</option>
								<option value="31-35">31-35</option>
								<option value="35-40">35-40</option>
							</select>
						</p>
					</div>
					<br>
					<div id="q3">
						<label for="work_in">3. Do you work in the high-tech industry?</label>
						<p class="required_message">* Required</p>
						<p class="q_paragraph">
							<select name="work_in" id="work_in">
								<option value="-"></option>
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</p>
					</div>
					<br>
					<div class="q4">
						<label for="new_job">4. Are you looking for a new job?</label>
						<p class="required_message">* Required</p>
						<p class="q_paragraph">
							<select name="new_job" id="new_job" onchange="showQuestions()">
								<option value="-"></option>
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</p>
					</div>
					<br>
					<div id="q5" style="display: none;">
						<label for="work_scope">5. What scope of employment are you looking for?</label>
						<p class="required_message">* Required</p>
						<p class="q_paragraph">
							<select name="work_scope" id="work_scope">
								<option value="-"></option>
								<option value="part_time">Part time</option>
								<option value="full_time">Full time</option>
							</select>
						</p>
					</div>
					<br>
					<div id="q6" style="display: none;">
						<label for="work_experience">6. Do you have work experience?</label>
						<p class="required_message">* Required</p>
						<p class="q_paragraph">
							<select name="work_experience" id="work_experience">
								<option value="-"></option>
								<option value="yes">Yes</option>
								<option value="no">No</option>
							</select>
						</p>
					</div>
					<br>
					<input class="btn-submit
					" type="submit" value="Send">
				</form>
			</section>
		</main>
	</body>
	<script type="text/javascript"> 
		function showQuestions(){
			var q_4 = document.getElementById('new_job').value;
			if(q_4 == 'yes'){
				document.getElementById('q5').style.display = 'block';
				document.getElementById('q6').style.display = 'block';
			}else{
				document.getElementById('q5').style.display = 'none';
				document.getElementById('q6').style.display = 'none';
			}
		}

		if(document.getElementById('error_q').childNodes.length > 1){
			document.getElementById('error_q').style.display = 'block';
		}else{
			document.getElementById('error_q').style.display = 'none';
		}

		if(document.getElementById('success_q').childNodes.length > 1){
			document.getElementById('success_q').style.display = 'block';
		}else{
			document.getElementById('success_q').style.display = 'none';
		}
	</script>
</html>

