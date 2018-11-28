<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Skype\Client;
class HomeController extends Controller
{
    function index()
    {
        $client = new Client([
            'clientId' => '0fcda35d-d319-4e2d-9139-3432bab9fd95',
            'clientSecret' => 'ialhDNYW121%]qfuRHH18~]',
        ]);
        $client->auth();
        return view('welcome');
    }
    function send(Request $request)
    {
        $mess = $request->mess;
        $conversation = '2ad454dsa';
        $client = new Client([
            'clientId' => '0fcda35d-d319-4e2d-9139-3432bab9fd95',
            'clientSecret' => 'ialhDNYW121%]qfuRHH18~]',
        ]);
        $api = $client->authorize()->api('conversation');   // Skype\Api\Conversation
        $result = $api->CreateActivity();
        dd($result);
        return redirect('/');
    }
}
