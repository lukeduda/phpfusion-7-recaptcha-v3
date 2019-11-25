<?php
require_once "RecaptchaV3Response.php";
require_once "RecaptchaV3ResponseCodeDict.php";

class RecaptchaV3
{
    const FRONTEND_URL = 'https://www.google.com/recaptcha/api.js?render=';

    const BACKEND_URL = 'https://www.google.com/recaptcha/api/siteverify';

    const INPUT_NAME = 'recaptcha-v3-token';

    /**
     * @var string
     */
    private $siteKey;

    /**
     * @var string
     */
    private $secretKey;

    /**
     * RecaptchaV3 constructor.
     * @param string $siteKey
     * @param string $secretKey
     */
    public function __construct($siteKey, $secretKey)
    {
        $this->siteKey = $siteKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getSiteKey()
    {
        return $this->siteKey;
    }

    /**
     * @return string
     */
    public function getFrontendUrl()
    {
        return self::FRONTEND_URL . $this->siteKey;
    }

    /**
     * @return string
     */
    public function getInputName()
    {
        return self::INPUT_NAME;
    }

    /**
     * @param string $token
     * @param null $userIp
     * @return RecaptchaV3Response
     */
    public function validateToken($token, $userIp = null)
    {
        // post request to server
        $data = array('secret' => $this->secretKey, 'response' => $token);

        if (!is_null($userIp)) {
            $data['remoteip'] = $userIp;
        }

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $response = file_get_contents(self::BACKEND_URL, false, $context);
        $responseKeys = json_decode($response, true);

        $recaptchaV3ResponseCodeDict = new RecaptchaV3ResponseCodeDict();
        $errorDescriptions = $recaptchaV3ResponseCodeDict->getErrorCodeDescriptions();
        $errors = array();
        if (array_key_exists('error-codes', $responseKeys) && is_array($responseKeys['error-codes'])) {
            foreach ($responseKeys['error-codes'] as $errorCode) {
                if (array_key_exists($errorCode, $errorDescriptions)) {
                    $errors[] = $errorDescriptions[$errorCode];
                }
            }
        }

        $responseObj = new RecaptchaV3Response(
            (boolean)$responseKeys['success'],
            (string)$responseKeys['challenge_ts'],
            (string)$responseKeys['hostname'],
            (float)$responseKeys['score'],
            (string)$responseKeys['action'],
            $errors
        );

        return $responseObj;
    }
}

?>
