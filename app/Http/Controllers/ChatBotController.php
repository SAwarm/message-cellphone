<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class ChatBotController extends Controller
{
    private $action;

    public function listenToReplies(Request $request)
    {
        $from = $request->input('From');
        $body = $request->input('Body');

        $message = "1- nome do pai\n";

        $message .= "2- nome da mãe\n";

        $message .= "3- nome próprio\n";

        $this->action = $body;

        if ($this->action == 1) {
            return $this->sendWhatsAppMessage('Joe da Rosa Elias', $from);
        }

        if ($this->action == 2) {
            return $this->sendWhatsAppMessage('Adriana Ramos da Silva Elias', $from);
        }

        if ($this->action == 3) {
            return $this->sendWhatsAppMessage('Jonas da Silva Elias', $from);
        }

        $this->sendWhatsAppMessage($message, $from);
    }

    /**
     * Sends a WhatsApp message  to user using
     * @param string $message Body of sms
     * @param string $recipient Number of recipient
     */
    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = getenv('TWILIO_WHATSAPP_NUMBER');
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");

        $client = new Client($account_sid, $auth_token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
}
