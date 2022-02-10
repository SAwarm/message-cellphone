<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class ChatBotController extends Controller
{
    private $from;

    private $body;

    public function __set($atribute, $value)
    {
        $this->$atribute = $value;
    }

    public function __get($atribute)
    {
        return $this->$atribute;
    }

    public function listenToReplies(Request $request)
    {
        $this->__set('from', $request->input('From'));
        $this->__set('body', $request->input('Body'));

        return $this->verifyAction();
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

    public function verifyAction()
    {
        $message = $this->messageInitial();

        if ($this->__get('body') == 1) {
            return $this->sendWhatsAppMessage('Joe da Rosa Elias', $this->__get('from'));
        }

        if ($this->__get('body') == 2) {
            return $this->sendWhatsAppMessage('Adriana Ramos da Silva Elias', $this->__get('from'));
        }

        if ($this->__get('body') == 3) {
            return $this->sendWhatsAppMessage('Jonas da Silva Elias', $this->__get('from'));
        }

        return $this->sendWhatsAppMessage($message, $this->__get('from'));
    }

    public function messageInitial()
    {
        $message = "1- nome do pai\n";

        $message .= "2- nome da mãe\n";

        $message .= "3- nome próprio\n";

        return $message;
    }
}
