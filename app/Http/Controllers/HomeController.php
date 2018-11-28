<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SkypeSDK;
class HomeController extends Controller
{
    function index()
    {
        $dataStorate = new SkypeSDK\Storage\FileStorage(sys_get_temp_dir());
        $config = new SkypeSDK\Config(
            '0fcda35d-d319-4e2d-9139-3432bab9fd95',
            'ialhDNYW121%]qfuRHH18~]'
        );
        $bot = SkypeSDK\SkypeSDK::init($config, $dataStorate);

        $bot->getNotificationListener()->setMessageHandler(
            function($payload) {
                dd($payload);
                file_put_contents(
                    sys_get_temp_dir() . '/Message_id.txt',
                    $payload->getConversation()->getId()
                );
            }
        );
        $bot->getNotificationListener()->setContactHandler(
            function($payload) {
                dd($payload);
                file_put_contents(
                    sys_get_temp_dir() . '/Contact_id.txt',
                    $payload->getConversation()->getId()
                );
            }
        );
        $bot->getNotificationListener()->setConversationHandler(
            function($payload) {
                dd($payload);
                file_put_contents(
                    sys_get_temp_dir() . '/Conversation_id.txt',
                    $payload->getConversation()->getId()
                );
            }
        );
        return view('welcome');
    }
    function send(Request $request)
    {
        $mess = $request->mess;
        $conversation = '1111';
        $dataStorate = new SkypeSDK\Storage\FileStorage(sys_get_temp_dir());
        $config = new SkypeSDK\Config(
            '0fcda35d-d319-4e2d-9139-3432bab9fd95',
            'ialhDNYW121%]qfuRHH18~]'
        );
        $bot = SkypeSDK\SkypeSDK::init($config, $dataStorate);
        $bot->getApiClient()->call(
            new SkypeSDK\Command\SendMessage($mess,$conversation)
        );
        print_r($bot->getApiClient()->getError());
        print_r($bot->getApiClient()->getSuccess());
        dd($bot->getHttpClient()->getError());
       return redirect('/');
    }
}
