<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Response;
use Skype\Client;
use BotBuilder\Client as Bot;

use Zalo\ChatBot;
use Zalo\Zalo;
use Zalo\ZaloConfig;
use Zalo\ZaloEndpoint;

class HomeController extends Controller
{

    private $callBackUrl = "http://40a007a6.ngrok.io/arischatbotsdk/home";
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
    function init()
    {
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        return $zalo;
    }
    function index()
    {
//        $authOptions = $this->getAuthOptions();
//        $client = (new Bot($authOptions))->auth();
        $this->zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $helper = $this->zalo -> getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl( $this->callBackUrl); // This is login url
        return view('index',['loginUrl'=>$loginUrl]);
    }
    function home()
    {

        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $helper = $zalo -> getRedirectLoginHelper();
        $oauthCode = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!"; // get oauthoauth code from url params
        $accessToken = $helper->getAccessToken($this->callBackUrl); // get access token
        if ($accessToken != null) {
            $expires = $accessToken->getExpiresAt(); // get expires time
        }
        $zalo->setDefaultAccessToken($accessToken);
        return view('home');
    }
    function getProfile()
    {
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $accessToken = $zalo->getDefaultAccessToken();
        $params = [];
        $response = $zalo->get(ZaloEndpoint::API_GRAPH_ME, $params, $accessToken);
        $result = $response->getDecodedBody(); // result
        dd($result);
        return view('home');
    }
    function getListFriend()
    {
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $accessToken = $zalo->getDefaultAccessToken();
        $params = ['offset' => 0, 'limit' => 20, 'fields' => "id, name"];
        $response = $zalo->get(ZaloEndpoint::API_GRAPH_FRIENDS, $params, $accessToken);
        $result = $response->getDecodedBody(); // result
        dd($result);
        return view('home');
    }
    function getListFriendInvite()
    {
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $accessToken = $zalo->getDefaultAccessToken();
        $params = ['offset' => 0, 'limit' => 20, 'fields' => "id, name"];
        $response = $zalo->get(ZaloEndpoint::API_GRAPH_INVITABLE_FRIENDS, $params, $accessToken);
        $result = $response->getDecodedBody(); // result
        dd($result);
        return view('home');
    }
    function inviteAplication()
    {
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $accessToken = $zalo->getDefaultAccessToken();
        $params = ['message' => 'Sử dụng ứng dụng này đi! < Quốc Trường >', 'to' => '5022149697562506977'];
        $response = $zalo->post(ZaloEndpoint::API_GRAPH_APP_REQUESTS, $params, $accessToken);
        $result = $response->getDecodedBody(); // result
        dd($result);
        return view('home');
    }
    function getFlowers()
    {
//        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
//        $accessToken = $zalo->getDefaultAccessToken();
//        $params = [];
//        $response = $zalo->get(ZaloEndpoint::API_OA_GET_FOLLOWERS, $params);
//        $result = $response->getDecodedBody(); // result
        $chatBot = new ChatBot();
        $data_message = 'Chào bạn';
        $mess = mb_strtolower($data_message,'UTF-8');
        $message_send = $chatBot->getMessage($mess);
        dd($message_send);
        return view('home');
    }
    function webhook(Request $request)
    {

        $data_id = $request->fromuid;
        $data_message = $request->message;
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $accessToken = $zalo->getDefaultAccessToken();
        $chatBot = new ChatBot();
        $mess = mb_strtolower($data_message,'UTF-8');
        $message_send = $chatBot->getMessage($mess);
        $data = array(
            'uid' => $data_id, // user id
            'message' => $message_send
        );
        $params = ['data' => $data];
        if(isset($data_message))
        {
            $response = $zalo->post(ZaloEndpoint::API_OA_SEND_TEXT_MSG, $params);
            $result = $response->getDecodedBody(); // result
        }

    }
    function sendMessToFriend()
    {
        $zalo = new Zalo(ZaloConfig::getInstance()->getConfig());
        $accessToken = $zalo->getDefaultAccessToken();
        $data = array(
            'uid' => 3958437030706763964, // user id
            'message' => 'Chúc buổi chiều tốt lành!'
        );
        $params = ['data' => $data];
        $response = $zalo->post(ZaloEndpoint::API_OA_SEND_TEXT_MSG, $params);
        $result = $response->getDecodedBody(); // result
        dd($result);
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
