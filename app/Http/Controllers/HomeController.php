<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Skype\Client;
use BotBuilder\Client as Bot;

use Zalo\Zalo;
use Zalo\ZaloConfig;
class HomeController extends Controller
{
    function getAuthOptions()
    {
        $authOptions = [
            'grantType' => 'client_credentials',
            'clientId' => '0e643480-8951-4eb5-a4d0-1bdcc83aad5f',
            'clientSecret' => 'mrEQW77{fbmcvVAFY566$((',
            'scope' => 'https://graph.microsoft.com/.default',
            'reciveTokenURL' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
        ];
        return $authOptions;
    }
    function index()
    {
//        $authOptions = $this->getAuthOptions();
//        $client = (new Bot($authOptions))->auth();
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $helper = $zalo -> getRedirectLoginHelper();
        $callBackUrl = "https://chatbotsdk.herokuapp.com/home";
        $loginUrl = $helper->getLoginUrl($callBackUrl); // This is login url
        return view('index',['loginUrl'=>$loginUrl]);
    }
    function home()
    {

        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $helper = $zalo -> getRedirectLoginHelper();
        $callBackUrl = "https://chatbotsdk.herokuapp.com/home";
        $oauthCode = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!"; // get oauthoauth code from url params
        $accessToken = $helper->getAccessToken($callBackUrl); // get access token
        if ($accessToken != null) {
            $expires = $accessToken->getExpiresAt(); // get expires time
        }
        dd($accessToken);
        return view('home');
    }
    function SendMessage(Request $request)
    {
//        $arr_profile = [
//            'from' => [
//                "id"    => 'live:truong.nq_2',
//                "name"  => 'Nguyen Quoc Truong'
//            ],
//            'conversation'  => [
//                'id'    => 'DxMSTz7dqcK8D4SA8rONsO'
//            ],
//            'recipient' => [
//                'id'    => 'chat-bot-aris@H-igKWAqye4',
//                "name"  => "chat-bot-aris"
//            ],
//            'channelId' => 'smba',
//        ];
        $authOptions = $this->getAuthOptions();
        $client = (new Bot($authOptions))->auth();
        $result  = $client->createActivity('smba');
        dd($result);
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
        $result = $api->Reconnect($conversationId,$watermark);
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

        $messageBot = "message from bot Hello";
        $api->Botactivity($messageBot,$conversationId,$watermark);

        $json = \GuzzleHttp\json_decode($result->getBody(), true);
        return response()->json($json);
    }
    function receive(Request $request)
    {
        $conversationId =  $request->conversationId;
        $watermark =  $request->watermark;
        $client = new Client();
        $api = $client->authorize()->api('conversation');
        $result = $api->receiveActivity($conversationId,$watermark);
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
