<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SendSMS extends Controller
{
    //

    function sendSMS($to, $message)
    {
        $http = new Client();

        $response = $http->request('post',
            config('app.gw_url') . '/api/sms/send', [
                'form_params' => [
                    'secret'  => config('app.gw_secret'),
                    'from'    => config('app.nameAbbr'),
                    'to'      => $to,
                    'message' => $message
                ]
            ]);
        echo $response->getBody();
        return true;
    }
}
