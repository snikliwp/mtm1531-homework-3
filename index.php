<?php 
$computer_type = array (
	"Tablet",
	"Phone",
	"Laptop",
	"Desktop"
	);
$possible_priorities = array (
	"low" => "Low Priority",
	"normal" => "Normal Priority",
	"high" => "High Priority"
	);
	
	
	
	
	
$errors = array();
$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
$message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
$picknum = filter_input(INPUT_POST, "picknum", FILTER_SANITIZE_NUMBER_INT);
$computer = filter_input(INPUT_POST, "computer", FILTER_SANITIZE_STRING);
$priority = filter_input(INPUT_POST, "priority", FILTER_SANITIZE_STRING);



if($_SERVER["REQUEST_METHOD"] == "POST") { // When you first open the page you get the name error message because it is not submitted yet. 
// the $_SERVER global variable tells us whether the form has been posted (submitted) yet if it hasn't don't put up the error message
	if (empty($name)) {
	$errors["name"] = true;
	};
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$errors["email"] = true;
	};
	if (mb_strlen($message) < 25) { // mb_strlen stands for multibyte string length which incoprorates accented characters as 1 character instead of 2
	$errors["message"] = true;
	};
	if ($picknum <1 || $picknum > 10) {
	$errors["picknum"] = true;
	};
	if (!in_array($computer, $computer_type)) {
	$errors["computer"] = true;
	};
	if (!array_key_exists($priority, $possible_priorities)) {
	$errors["priority"] = true;
	};
	
};

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Contact Form</title>
	<link href="css/general.css" rel="stylesheet">
</head>

<body>
<form method="post" action="index.php">
	<div class="name">
		<!-- Every Single input must have a label element associated with it with the attribute for attached to it. This creates an association with <input>-->
		<label for="name">Name <?php if(isset($errors["name"])) : ?><strong>is required!</strong><?php endif ?> </label>
		<!--		Always put in the three fields type, id and name. id is referrenced by HTML name is referenced by php -->
		<input type="text" id="name" name="name" value="<?php echo $name; ?>" required>  <!--	the required parameter works in some browsers and causes a message to pop up saying the field is required when you submit the form -->	
	</div>
	
	<div class="email">
		<label for="email">E-Mail Address <?php if(isset($errors["email"])) : ?><strong>is not valid!</strong><?php endif ?></label>
		<input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
	</div>
	
	<div class="username">
		<label for="username">Username <?php if(isset($errors["username"])) : ?><strong>is not valid!</strong><?php endif ?></label>
		<input type="username" id="username" name="username" value="<?php echo $username; ?>" required>
	</div>
	
	<div class="password">
		<label for="password">Password <?php if(isset($errors["password"])) : ?><strong>is not valid!</strong><?php endif ?></label>
		<input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
	</div>
	
	<div class="computer">
		<label for="computer">Computer</label>
		<select id= id="computer" name="computer">
			<?php foreach ($computer_type as $type) : ?>
			<option <?php if ($type == $computer) {echo "selected";} ?>><?php echo $type;?></option>
			<?php endforeach?>
		</select>
	</div>
	
	<div class="priority">
	<fieldset>
		<legend>Priority</legend>
		<?php if(isset($errors["priority"])) : ?><strong>Select your language of Corespondance!</strong><?php endif ?>
		<?php foreach ($possible_priorities as $key => $value) : ?>
		<input type="radio" id="<?php echo $key ?>" name="username" value="<?php echo $key ?>" <?php if ($key == $username) {echo "checked";} ?>>
		<label for= "<?php echo $key ?>"><?php echo $value?></label>
		<?php endforeach?>
	</fieldset>
	</div>
	
	<div class="message">
		<label for="message">Message <?php if(isset($errors["message"])) : ?><strong>requires a minimum of 25 characters!</strong><?php endif ?></label>
		<textarea id="message" name="message" required><?php echo $message; ?></textarea>
	</div>
	
	<div class="picknum">
		<label for="picknum">Pick a number between 1 and 10 <?php if(isset($errors["picknum"])) : ?><strong>Try again!</strong><?php endif ?> </label>
		<input type="text" id="picknum" name="picknum" value="<?php echo $picknum; ?>" required>  <!--	the required parameter works in some browsers and causes a message to pop up saying the field is required when you submit the form -->	
	</div>
		
	
	
	
	
	
	
	
	
	<div class="button">
		<button type="submit">Please press this button to send the Message</button>
	</div>

</form>





</body>
</html>