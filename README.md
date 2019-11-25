# phpfusion 7 reCAPTCHA v3
Google reCAPTCHA v3 for Phpfusion 7

### About
I did this tiny, ugly code because of russian (mostly) bots which attacks my old, phpfusion 7 site.
This captcha based on google reCAPTCHA v3 score and checks if following user is bot.  
If it's true - it stops registration or contact process.  

Keep in mind that there is no any extra reCAPTCHA v2 implementation!

### Compatibility
PHP: 5.2.17  
Phpfusion: v7.02.07

### Installation
Create folder `recaptchaV3` in path `includes/captchas`.
Move there all following files.  

Edit file keys.php and provide there reCAPTCHA v3 site and secret keys.  

Move to admin panel and in security settings select from list newly added captcha script - `recaptchaV3`. Save settings.

Should works!

### Links
More about reCAPTCHA v3 - https://developers.google.com/recaptcha/docs/v3

