<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Skype\Client;
class HomeController extends Controller
{
    function index()
    {
        return view('welcome');
    }
    function CreateConersation()
    {
        $client = new Client();
        $api = $client->authorize()->api('conversation');
        $result = $api->CreateConersation();
        $json = \GuzzleHttp\json_decode($result->getBody(), true);
        return response()->json($json);
    }
    function reconnect(Request $request)
    {
        $watermark = $request->watermark;
        $conversationId = $request->conversationId;
        $client = new Client();
        $api = $client->authorize()->api('conversation');
        $result = $api->Reconnect($watermark,$conversationId);
        $json = \GuzzleHttp\json_decode($result->getBody(), true);
        return response()->json($json);
    }
    function send(Request $request)
    {
        $message = $request->message;
        $conversationId =  $request->conversationId;
        $watermark =  $request->watermark;
        $client = new Client();
        $api = $client->authorize()->api('conversation');
        $result = $api->activity($message,$conversationId,$watermark);
        $json = \GuzzleHttp\json_decode($result->getBody(), true);
        return response()->json($json);
    }
    function close(Request $request)
    {
        $conversationId =  $request->conversationId;
        $client = new Client();
        $api = $client->authorize()->api('conversation');
        $result = $api->closeActivity($conversationId);
        $json = \GuzzleHttp\json_decode($result->getBody(), true);
        return response()->json($json);

    }
}
