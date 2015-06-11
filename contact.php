<?php
error_reporting(-1);
ini_set('display_errors', 'On');

$lastNameErr = $firstNameErr = $emailErr = $addressErr = $cityErr = $zipErr = $phoneErr = "";
$lastName = $firstName = $email = $address = $city = $state = $zip = $phone = "";
$boolLastName = $boolFirstName = $boolEmail = $boolAddress = $boolCity = $boolZip = $boolPhone = FALSE;
$to = "info@primeresources-llc.com";
$subject = "New contact information";
$message = "";
$headers = "";

//*** Uniqid Session ***//
$strSid = md5(uniqid(time()));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["lastName"])) {
		$lastNameErr = "Required";
	} else {
		$lastName = test_input($_POST["lastName"]);
		if (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
			$lastNameErr = "Only letters and white space allowed";
		}
		$boolLastName = TRUE;
	}

	if (empty($_POST["firstName"])) {
		$firstNameErr = "Required";
	} else {
		$firstName = test_input($_POST["firstName"]);
		if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
			$firstNameErr = "Only letters and white space allowed";
		}
		$boolFirstName = TRUE;
	}

	if (empty($_POST["email"])) {
		$emailErr = "Required";
	} else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid";
		}
		$boolEmail = TRUE;
	}

	if (empty($_POST["address"])) {
		$address = "";
		$boolAddress = TRUE;
	} else {
		$address = test_input($_POST["address"]);
		if (!preg_match("/^[a-zA-Z0-9 ]*$/", $address)) {
			$addressErr = "Only numbers, letters and white space allowed";
		}
		$boolAddress = TRUE;
	}

	if (empty($_POST["city"])) {
		$city = "";
		$boolCity = TRUE;
	} else {
		$city = test_input($_POST["city"]);
		if (!preg_match("/^[a-zA-Z ]*$/", $city)) {
			$cityErr = "Only letters and white space allowed";
		}
		$boolCity = TRUE;
	}

	if (empty($_POST["zip"])) {
		$zip = "";
		$boolZip = TRUE;
	} else {
		$zip = test_input($_POST["zip"]);
		if (!preg_match("/^[0-9]*$/", $zip)) {
			$zipErr = "Only numbers allowed";
		}
		$boolZip = TRUE;
	}

	if (empty($_POST["phone"])) {
		$phone = "";
		$boolPhone = TRUE;
	} else {
		$phone = test_input($_POST["phone"]);
		if (!preg_match("/^(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})*$/", $phone)) {
			$phoneErr = "Invalid";
		}
		$boolPhone = TRUE;
	}

	$state = $_POST["state"];
	$message = nl2br("Last name: " . $lastName . "\nFirst name: " . $firstName . "\nEmail: " . $email . "\nAddress: " . $address . "\nCity: " . $city . "\nState: " . $state . "\nZip code: " . $zip . "\nPhone: " . $phone);

	$headers .= "From: " . $_POST["firstName"] . "<" . $_POST["email"] . ">\nReply-To: " . $_POST["email"] . "";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: multipart/mixed; boundary=\"" . $strSid . "\"\n\n";
	$headers .= "This is a multi-part message in MIME format.\n";
	$headers .= "--" . $strSid . "\n";
	$headers .= "Content-type: text/html; charset=utf-8\n";
	$headers .= "Content-Transfer-Encoding: 7bit\n\n";
	$headers .= $message . "\n\n";

	if ($_FILES["fileAttach"]["name"] != "") {
		$strFilesName = $_FILES["fileAttach"]["name"];
		$strContent = chunk_split(base64_encode(file_get_contents($_FILES["fileAttach"]["tmp_name"])));
		$headers .= "--" . $strSid . "\n";
		$headers .= "Content-Type: application/octet-stream; name=\"" . $strFilesName . "\"\n";
		$headers .= "Content-Transfer-Encoding: base64\n";
		$headers .= "Content-Disposition: attachment; filename=\"" . $strFilesName . "\"\n\n";
		$headers .= $strContent . "\n\n";
	}

	if ($boolLastName == TRUE && $boolFirstName == TRUE && $boolEmail == TRUE && $boolAddress == TRUE && $boolCity == TRUE && $boolZip == TRUE && $boolPhone == TRUE) {
		mail($to, $subject, $message, $headers);
		header("Location: thankyou.php");
		exit();
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<!DOCTYPE html>
<html>

	<head>
		<link href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/shift.css" rel="stylesheet">
		<link rel="stylesheet" href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css">
		<link rel="stylesheet" href="main.css">
		
		<meta name="keywords" content="Milwaukee, Wisconsin, Agency, Staffing, Recruiting, Placement, Firm, Prime Resources LLC, Temporary, Engineering, IT, CAD, Proe, Design, Service">

		<title>Contact</title>

	</head>

	<body>

		<?php
		include 'menu.php';
		?>
		<div class="jumbotron" id="contact">
			<div class="container" id="logo">
				<img src="logo.png">
			</div>
			<div class="container" id="whatwedo">
				<h1>Contact Us</h1>
			</div>
		</div>

		<div class="main-object">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="error" id="error-def">
							* required field
						</div>
						<div class="form">
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
								<table>
									<tr>
										<td class="description-cell"> Last Name </td>
										<td>
										<input class="fields" type="text" name="lastName">
										</td>
										<td class="error-cell">
										<p class="error">
											* <?php echo $lastNameErr; ?>
										</p></td>
									</tr>
									<tr>
										<td class="description-cell"> First Name </td>
										<td>
										<input class="fields" type="text" name="firstName">
										</td>
										<td class="error-cell">
										<p class="error">
											* <?php echo $firstNameErr; ?>
										</p></td>
									</tr>
									<tr>
										<td class="description-cell"> Email </td>
										<td>
										<input class="fields" type="text" name="email">
										</td>
										<td class="error-cell">
										<p class="error">
											* <?php echo $emailErr; ?>
										</p></td>
									</tr>
									<tr>
										<td class="description-cell"> Address </td>
										<td>
										<input class="fields" type="text" name="address">
										</td>
										<td class="error-cell">
										<p class="error">
											<?php echo $addressErr; ?>
										</p></td>
									</tr>
									<tr>
										<td class="description-cell"> City </td>
										<td>
										<input class="fields" type="text" name="city">
										</td>
										<td class="error-cell">
										<p class="error">
											<?php echo $cityErr; ?>
										</p></td>
									</tr>
									<tr>
										<td class="description-cell"> State </td>
										<td>
										<select class="fields" name="state">
											<option value="Alabama">Alabama</option>
											<option value="Alaska">Alaska</option>
											<option value="Arizona">Arizona</option>
											<option value="Arkansas">Arkansas</option>
											<option value="California">California</option>
											<option value="Colorado">Colorado</option>
											<option value="Connecticut">Connecticut</option>
											<option value="Delaware">Delaware</option>
											<option value="Florida">Florida</option>
											<option value="Georgia">Georgia</option>
											<option value="Hawaii">Hawaii</option>
											<option value="Idaho">Idaho</option>
											<option value="Illinois">Illinois</option>
											<option value="Indiana">Indiana</option>
											<option value="Iowa">Iowa</option>
											<option value="Kansas">Kansas</option>
											<option value="Kentucky">Kentucky</option>
											<option value="Louisiana">Louisiana</option>
											<option value="Maine">Maine</option>
											<option value="Maryland">Maryland</option>
											<option value="Massachusetts">Massachusetts</option>
											<option value="Michigan">Michigan</option>
											<option value="Minnesota">Minnesota</option>
											<option value="Mississippi">Mississippi</option>
											<option value="Missouri">Missouri</option>
											<option value="Montana">Montana</option>
											<option value="Nebraska">Nebraska</option>
											<option value="Nevada">Nevada</option>
											<option value="New Hampshire">New Hampshire</option>
											<option value="New Jersey">New Jersey</option>
											<option value="New Mexico">New Mexico</option>
											<option value="New York">New York</option>
											<option value="North Carolina">North Carolina</option>
											<option value="North Dakota">North Dakota</option>
											<option value="Ohio">Ohio</option>
											<option value="Oklahoma">Oklahoma</option>
											<option value="Oregon">Oregon</option>
											<option value="Pennsylvania">Pennsylvania</option>
											<option value="Rhode Island">Rhode Island</option>
											<option value="South Carolina">South Carolina</option>
											<option value="South Dakota">South Dakota</option>
											<option value="Tennessee">Tennessee</option>
											<option value="Texas">Texas</option>
											<option value="Utah">Utah</option>
											<option value="Vermont">Vermont</option>
											<option value="Virginia">Virginia</option>
											<option value="Washington">Washington</option>
											<option value="West Virginia">West Virginia</option>
											<option value="Wisconsin" selected>Wisconsin</option>
											<option value="Wyoming">Wyoming</option>
										</select></td>
									</tr>
									<tr>
										<td class="description-cell"> Zip </td>
										<td>
										<input class="fields" type="text" name="zip">
										</td>
										<td class="error-cell">
										<p class="error">
											<?php echo $zipErr; ?>
										</p></td>
									</tr>
									<tr>
										<td class="description-cell"> Phone </td>
										<td>
										<input class="fields" type="text" name="phone">
										</td>
										<td class="error-cell">
										<p class="error">
											<?php echo $phoneErr; ?>
										</p></td>
									</tr>
								</table>
								<div>
									<input name="fileAttach" type="file" value="" id="attach-button">
								</div>
								<div>
									<input type="submit" value="" id="submit-button">
								</div>
							</form>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="contact">
							<div class="spaced-p">
								<p>
									<strong>Prime Resources LLC</strong>
									<br>
									1005 Richards Road, Suite R
									<br>
									Hartland, WI 53029
								</p>
								<p>
									Phone: 262-465-6750
									<br>
									Fax: 262-661-7062
									<br>
									<a href="mailto:info@primeresources-llc.com" class="email" id="contact-email"> info@primeresources-llc.com </a>
								</p>
								<p>
									Mailing Address:
									<br>
									Prime Resources LLC
									<br>
									PO Box 72
									<br>
									Sussex, WI 53089
								</p>
								<img src="map.png">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="info">
			<div class="container">
				<?php
				include 'bottom.php';
				?>
			</div>
		</div>
	</body>
</html>