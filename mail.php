<?php

$name =""; // Sender Name
$email =""; // Sender's email ID
$phone =""; //Sender's Phone Number
$message =""; // Sender's Message

$nameError ="";
$emailError ="";
$phoneError ="";
$messageError ="";
$errors = 0;
$successMessage ="";

$formcontent=" From: $name \n Email: $email \n Phone: $phone \n Message: $message";
$recipient = "info@computerswithpride.ca";
$subject = "Contact Form";
$mailheader = "From: $email \r\n";

if(isset($_POST['submit'])) { // Checking null values in message.

	$name = $_POST["name"]; // Sender Name
	$email = $_POST["email"]; // Sender's email ID
	$phone = $_POST["phoneNumber"];  //Sender's Phone Number
	$message = $_POST["message"]; // Sender's Message
	
	if (empty($_POST["name"])){
		$nameError = "Name is required";
		$errors = 1;
	}
	if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
	{
		$emailError = "Email is not valid";
		$errors = 1;
	}
	if (empty($_POST["phone"])){
		$phoneError = "Phone number is required";
		$errors = 1;
	}
	if (empty($_POST["message"])){
		$messageError = "Message is required";
		$errors = 1;
	}
}

if($errors == 0){
	$successMessage ="Thank You!" . " -" . "<a href='index.html' style='text-decoration:none;color:#ff0099;'> Return Home</a>"; // IF no errors
}
?>
