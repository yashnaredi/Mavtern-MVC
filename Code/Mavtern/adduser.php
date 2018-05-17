<?php


session_start();


require_once("db.php");

if(isset($_POST)) {

	
	$firstname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lastname = mysqli_real_escape_string($conn, $_POST['lname']);
	$address = mysqli_real_escape_string($conn, $_POST['address']);
	$city = mysqli_real_escape_string($conn, $_POST['city']);
	$state = mysqli_real_escape_string($conn, $_POST['state']);
	$contactno = mysqli_real_escape_string($conn, $_POST['contactno']);
	$qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
	$stream = mysqli_real_escape_string($conn, $_POST['stream']);
	$passingyear = mysqli_real_escape_string($conn, $_POST['passingyear']);
	$dob = mysqli_real_escape_string($conn, $_POST['dob']);
	$age = mysqli_real_escape_string($conn, $_POST['age']);
	$designation = mysqli_real_escape_string($conn, $_POST['designation']);
	$aboutme = mysqli_real_escape_string($conn, $_POST['aboutme']);
	$skills = mysqli_real_escape_string($conn, $_POST['skills']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	//Encrypt Password
	$password = base64_encode(strrev(md5($password)));

	
	$sql = "SELECT email FROM users WHERE email='$email'";
	$result = $conn->query($sql);

	
	if($result->num_rows == 0) {

			.
	$uploadOk = true;

	
	$folder_dir = "uploads/resume/";

	
	$base = basename($_FILES['resume']['name']); 

	
	$resumeFileType = pathinfo($base, PATHINFO_EXTENSION); 

	
	$file = uniqid() . "." . $resumeFileType;   

	
	$filename = $folder_dir .$file;  

	
	if(file_exists($_FILES['resume']['tmp_name'])) { 

		 
		if($resumeFileType == "pdf")  {

		
			if($_FILES['resume']['size'] < 500000) { // File size is less than 5MB

				
				move_uploaded_file($_FILES["resume"]["tmp_name"], $filename);

			} else {
				
				$_SESSION['uploadError'] = "Wrong Size. Max Size Allowed : 5MB";
				$uploadOk = false;
			}
		} else {
			
			$_SESSION['uploadError'] = "Wrong Format. Only PDF Allowed";
			$uploadOk = false;
		}
	} else {
			$_SESSION['uploadError'] = "Something Went Wrong. File Not Uploaded. Try Again.";
			$uploadOk = false;
		}

	if($uploadOk == false) {
		header("Location: register-candidates.php");
		exit();
	}

		$hash = md5(uniqid());


		
		$sql = "INSERT INTO users(firstname, lastname, email, password, address, city, state, contactno, qualification, stream, passingyear, dob, age, designation, resume, hash, aboutme, skills) VALUES ('$firstname', '$lastname', '$email', '$password', '$address', '$city', '$state', '$contactno', '$qualification', '$stream', '$passingyear', '$dob', '$age', '$designation', '$file', '$hash', '$aboutme', '$skills')";

		if($conn->query($sql)===TRUE) {
			
			$_SESSION['registerCompleted'] = true;
			header("Location: login-candidates.php");
			exit();
		} else {
			
			echo "Error " . $sql . "<br>" . $conn->error;
		}
	} else {
		//if email found in database then show email already exists error.
		$_SESSION['registerError'] = true;
		header("Location: register-candidates.php");
		exit();
	}

	//Close database connection. Not compulsory but good practice.
	$conn->close();

} else {
	//redirect them back to register page if they didn't click register button
	header("Location: register-candidates.php");
	exit();
}