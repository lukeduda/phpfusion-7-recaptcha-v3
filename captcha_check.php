<?php
if (!defined("IN_FUSION")) {
    die("Access Denied");
}

require "keys.php";
require_once "RecaptchaV3.php";

$recaptchaV3 = new RecaptchaV3($siteKey, $secretKey);

//Check the response
$response = $recaptchaV3->validateToken(
    (string)$_POST[$recaptchaV3->getInputName()],
    (string)$_SERVER["REMOTE_ADDR"]
);

//If it's good and "success" and $error is null
if ($response->isSuccess() == true) {
    $_CAPTCHA_IS_VALID = true; //Tell PHP-Fusion it was good...
} else {
    if (count($response->getErrorCodes())) {
        foreach ($response->getErrorCodes() as $errorCode) {
            echo "<h4>" . $errorCode . "<h4>";
        }
    } else {
        echo "<h2>Google reCAPTCHA v3 thinks that you are a bot, you can't access this feature.<h2>";
    }
}

?>
