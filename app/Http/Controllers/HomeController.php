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
            'd65891ce-568b-4efd-ab57-180717dd30c8',
            'loECPW416^@_[lhgumFSJ33'
        );
        $bot = SkypeSDK\SkypeSDK::init($config, $dataStorate);

        $bot->getNotificationListener()->setMessageHandler(
            function($payload) {
                file_put_contents(
                    sys_get_temp_dir() . '/conversation_id.txt',
                    $payload->getConversation()->getId()
                );
            }
        );
        $bot->getApiClient()->call(
            new SkypeSDK\Command\SendMessage(
                'Hello World.',
                '020202'
            )
        );
        dd($bot);

        return view('welcome');
    }
}
