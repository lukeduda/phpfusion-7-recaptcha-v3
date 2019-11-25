<?php
if (!defined("IN_FUSION")) {
    die("Access Denied");
}

require "keys.php";
require_once "RecaptchaV3.php";

$recaptchaV3 = new RecaptchaV3($siteKey, $secretKey);
$action = 'default';

if (FUSION_SELF == "register.php") {
    $action = 'register';

    ob_start();
    echo "<label for=\'captcha_code\'>" . $locale['u190'];
    $ob_get_contents = ob_get_contents();
    ob_end_clean();
    $target = $ob_get_contents;
    $replacement = "<span>Protected by reCAPTCHA v3</span>";
    replace_in_output($target, $replacement);
} elseif (FUSION_SELF == "contact.php") {
    $action = 'contact';

    ob_start();
    echo $locale['407'];
    $ob_get_contents = ob_get_contents();
    ob_end_clean();
    $target = $ob_get_contents;
    $replacement = "<span>Protected by reCAPTCHA v3</span>";
    replace_in_output($target, $replacement);
}

// Add script to head
add_to_footer('
<script src="' . $recaptchaV3->getFrontendUrl() . '"></script>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute(\'' . $recaptchaV3->getSiteKey() . '\', {action: \'' . $action . '\'}).then(function(token) {
        document.getElementsByName(\'' . $recaptchaV3->getInputName() . '\')[0].value = token;
    });
});
</script>
');

// Hide extra input
$_CAPTCHA_HIDE_INPUT = true;

// Input for passing token to the backend
echo "<input type='hidden' name='" . $recaptchaV3->getInputName() . "' value='' />";
?>
