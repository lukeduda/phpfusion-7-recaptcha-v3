<?php


class RecaptchaV3Response
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var string
     */
    private $challenge_ts;

    /**
     * @var string
     */
    private $hostname;

    /**
     * @var float
     */
    private $score;

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $errorCodes;

    /**
     * RecaptchaResponse constructor.
     * @param $success
     * @param $challenge_ts
     * @param $hostname
     * @param $score
     * @param $action
     * @param array $errorCodes
     */
    public function __construct($success, $challenge_ts, $hostname, $score, $action, $errorCodes = array())
    {
        $this->success = $success;
        $this->challenge_ts = $challenge_ts;
        $this->hostname = $hostname;
        $this->score = $score;
        $this->action = $action;
        $this->errorCodes = $errorCodes;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return array
     */
    public function getErrorCodes()
    {
        return $this->errorCodes;
    }
}
