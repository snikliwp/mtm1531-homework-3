<?php 

// This will make error messages visible on edumedia
// temporary and should be deleted when code is debugged.
//error_reporting(-1);
//ini_set('display_errors', 'on');
//var_dump($_POST);
include "includes/filter-wrapper.php";



$possible_languages = array (
	"eng" => "English",
	"fre" => "French",
	"spa" => "Spanish"
	);
	
$errors = array();
$display_thanks = false;
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$notes = filter_input(INPUT_POST, "notes", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$preferedlang = filter_input(INPUT_POST, "preferedlang", FILTER_SANITIZE_STRING);
$acceptterms = filter_input(INPUT_POST, "acceptterms", FILTER_DEFAULT); // don't bother filtering it
$email_message = "";

if($_SERVER["REQUEST_METHOD"] == "POST") { // When you first open the page you get the name error message because it is not submitted yet. 
// the $_SERVER global variable tells us whether the form has been posted (submitted) yet if it hasn't don't put up the error message
// if it is posted validate the inner fields
	if (empty($name)) {
	$errors["name"] = true;
	};
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errors["email"] = true;
	};
	if (mb_strlen($username) > 25 || empty($username)) {
	$errors["username"] = true;
	};
	if (empty($password)) {
	$errors["password"] = true;
	};
	if (!array_key_exists($preferedlang, $possible_languages)) {
	$errors["preferedlang"] = true;
	};
//	if (!isset($_POST["acceptterms"])) { validate without filters
	if (empty($acceptterms)) { // validate with filters
	$errors["acceptterms"] = true;
	} 
	if (empty($errors)) {
		$display_thanks = true;
		
		$email_message = "Name: " . $name . "\r\n"; // "\r\n" is a special character that indicates new line in an email must be in double quotes
		$email_message .= "E-Mail: " . $email . "\r\n"; // the ".=" causes an append to the existing variable
		$email_message .=  "Notes: " . "\r\n" . $notes;
		
		$headers = "From: Pat Wilkins <wilk0146@algonquinlive.com> . \r\n"; // this is the registration form
		 // $headers = "From: " $name . " <" . $email . "> \r\n"; // this is the contact form
		
		mail($email, "Registration Confirmation", $email_message, $headers);
	}
	
};
?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Registration Form</title>
	<link href="css/general.css" rel="stylesheet">
</head>

<body>

<?php if ($display_thanks) : ?>

	<div class = "message">
		<p><strong>Thank you for registering!</strong></p>
		<p>An e-mail will be sent to  <?php echo $email ?> confirming registration</p>
	</div>
<?php else : ?>    
 
<form method="post" action="index.php">
	<h2>Registration Form</h2>
	<div class="name">
		<!-- Every Single input must have a label element associated with it with the attribute for attached to it. This creates an association with <input>-->
		<label for="name">Name: <?php if(isset($errors["name"])) : ?><strong>is a required field!</strong><?php endif ?> </label>
		<!--		Always put in the three fields type, id and name. id is referrenced by HTML name is referenced by php -->
		<input type="text" id="name" name="name" value="<?php echo $name; ?>">  <!--	the required parameter works in some browsers and causes a message to pop up saying the field is required when you submit the form -->	
	</div>
	
	<div class="email">
		<label for="email">E-Mail Address: <?php if(isset($errors["email"])) : ?><strong>is not valid, please re-type!</strong><?php endif ?></label>
		<input type="email" id="email" name="email" value="<?php echo $email; ?>">
	</div>
	
	<div class="username">
		<label for="username">Username: <?php if(isset($errors["username"])) : ?><strong>is not valid!</strong><?php endif ?></label>
		<input type="username" id="username" name="username" value="<?php echo $username; ?>">
	</div>
	
	<div class="password">
		<label for="password">Password: <?php if(isset($errors["password"])) : ?><strong>is not valid!</strong><?php endif ?></label>
		<input type="password" id="password" name="password" value="<?php echo $password; ?>">
	</div>
	
	<div class="preferedlang">
	<fieldset>
		<legend>Preferred Language: </legend>
		<?php if(isset($errors["preferedlang"])) : ?><strong>Select your language of Correspondence!</strong><br><?php endif ?>
		<?php foreach ($possible_languages as $key => $value) : ?>
		<input type="radio" id="<?php echo $key ?>" name="preferedlang" value="<?php echo $key ?>" <?php if ($key == $preferedlang) {echo "checked";} ?>>
		<label for= "<?php echo $key ?>"><?php echo $value?></label>
		<?php endforeach?>
	</fieldset>
	</div>
	
	<div class="notes">
		<label for="notes">Notes: </label>
		<textarea id="notes" name="notes" ><?php echo$notes;?></textarea>
	</div>
	
	<div class="acceptterms">
		<label for="acceptterms">By checking this box you agree to the terms and conditions of this agreement.<?php if(isset($errors["acceptterms"])) : ?><strong>You must agree to the Terms and Conditions!</strong><br><?php endif ?> </label>
		<input type="checkbox" id="acceptterms" name="acceptterms"<?php if(!empty($acceptterms)) echo "checked" ?>>
	</div>
		
	<div class="button">
		<button type="submit">Please press this button to Confirm Registration</button>
	</div>

</form>

<?php endif ?>



</body>
</html>