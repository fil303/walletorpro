<?php

namespace App\Services\SmsService;

use Exception;

use Twilio\Rest\Client;
use App\Services\SmsService\ISmsService;
use App\Services\SmsService\SmsBodyTrait;

class TwilioService implements ISmsService
{
    use SmsBodyTrait;
    public function __construct(){}

    /**
     * Send SMS
     * @param string $phone_number
     * @param string $message
     * @return bool
     */
    public function send(string $phone_number, string $message): bool
    {
        $app = get_settings();
        $sid    = $app->sms_twilio_sid ?? '';
        $token  = $app->sms_twilio_token ?? '';
        $client = new Client($sid, $token);

        try {
            $client->messages->create(
                $phone_number,
                [
                    'from' => $app->sms_twilio_phone ?? '',
                    'body' => $message
                ]
            );
        } catch (Exception $e) {
            logStore("TwilioService send", $e->getMessage());
            return false;
        }
        return true;
    }
}
