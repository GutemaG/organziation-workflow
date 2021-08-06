<?php


namespace App\Http\Controllers\Actions\Services;


use Exception;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SmsNotifier
{
    private $to;
    private $account_sid;
    private $auth_token;
    private $twilio_number;
    private $client;
    private $token;

    /**
     * SmsNotifier constructor.
     * @param $to
     * @param $token
     * @throws ConfigurationException
     */
    public function __construct(string $to, string $token)
    {
        $this->to = $to;
        $this->token = $token;
        $this->account_sid = config('twilio.account_sid');
        $this->auth_token = config('twilio.auth_token');
        $this->twilio_number = config('twilio.twilio_number');
        $this->client = new Client($this->account_sid, $this->auth_token);
    }

    /**
     * Send sms to the given phone number.
     *
     * @throws Exception
     */
    public function sendSms(): void
    {
        try {
            $this->client->messages->create($this->to,
                ['from' => $this->twilio_number, 'body' => "Your token is:-  " . $this->token]
            );
        } catch (TwilioException $e) {
            throw new Exception('The system can\'t send sms; may be your phone number is not registered!');
        }
    }

}
