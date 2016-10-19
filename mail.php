<?php
	// From http://php.net/manual/en/function.mail.php#108669
	function mailUtf8($to, $from_user, $from_email, $subject, $message) {
			$from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
			$subject = "=?UTF-8?B?".base64_encode($subject)."?=";

			$headers = "From: $from_user <$from_email>\r\n" .
					"MIME-Version: 1.0" . "\r\n" .
					"Content-type: text/html; charset=UTF-8" . "\r\n";

		return mail($to, $subject, $message, $headers);
	}

	// Super simple validation
	$isValid = true;
	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$phone = $_REQUEST['phone'];
	$message = $_REQUEST['message'];
	
	if (trim($name) === '') {
		$isValid = false;
	}
	if (trim($email) === '') {
		$isValid = false;
	}
	// This is actually a bit stricter than the client side validation, but it shouldn't be an issue
	// since valid emails *shouldn't* be failing this...
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$isValid = false;
	}
	if (trim($phone) === '') {
		$isValid = false;
	}
	if (trim($message) === '') {
		$isValid = false;
	}

	if($isValid) {
		// Replace newlines with HTML line breaks for the message
		$message = str_replace("\n", "<br />", $message);

		$emailBody = "From: $name<br/>Email: $email<br />Phone: $phone<br />Message: $message";
		$success = mailUtf8("info@computerswithpride.ca", "Computer with Pride contact form",
				"no-reply@computerswithpride", "Contact Form", $emailBody);

		// Debug: Just print what would have been sent (note nothing printed for invalid form)
		//echo $emailBody;

		// Something is wrong with the mailer -- critical failure
		// Consider just setting `$isValid` to false here instead of the current body, so that
		// failures will send folks to the index page with just a generic message.
		if(!$success) {
			echo "<h1>HTTP 500 error</h1>";
			echo "<p>Something went wrong. This shouldn't have happened. Please try again later or give us a call instead.</p>";
			echo "Details: " . error_get_last()["message"];
			die();
		}
	}

	// Redirect user back to the main page
	if($isValid) {
		header("Location: index.html?success=true");
	}
	else {
		header("Location: index.html?success=false");
	}
	exit();
?>
