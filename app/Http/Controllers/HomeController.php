<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Skype\Client;
class HomeController extends Controller
{
    function index()
    {
        $client = new Client([
            'clientId' => '0e643480-8951-4eb5-a4d0-1bdcc83aad5f',
            'clientSecret' => 'mrEQW77{fbmcvVAFY566$((',
        ]);
        $client->auth();
        return view('welcome');
    }
    function send(Request $request)
    {
        $mess = $request->mess;
        $conversation = '29:2ad454dsa';
        $client = new Client([
            'clientId' => '0fcda35d-d319-4e2d-9139-3432bab9fd95',
            'clientSecret' => 'ialhDNYW121%]qfuRHH18~]',
        ]);
        $api = $client->authorize()->api('conversation');   // Skype\Api\Conversation
        $result = $api->CreateActivity($mess);
        dd($result);
        return redirect('/');
    }
}
