<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.slim.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .container
            {
                margin-top: 100px;
            }
        </style>
    </head>
    <body class="container">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="row">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <a href="/reconnect" class="btn btn-success">Reconnect</a>
            <div class="col-12">
                <form method="post" action="/send">
                    @csrf
                    <div class="form-group">
                        <label>Message</label>
                        <input class="form-control" type="text" value="hello" name="mess" id="mess"/>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success">send</button>
                    </div>
                </form>
            </div>
                <div class="col-12">
                    <div id = "webchat">

                    </div>
                </div>
        </div>
        <button onclick="CreateConvention()" class="btn-info btn">Create convertion</button>
        <button onclick="ReconnectConvention()" class="btn-info btn">Reconnect convertion</button>
        <button onclick="OpenSocket()" class="btn-success btn">Open message</button>
        <button onclick="CloseSocket()" class="btn-danger btn">Close message</button>
        <button onclick="sendMessage()" class="btn-success btn">send message</button>
        <button onclick="ReceiveMessage()" class="btn-info btn">receive message</button>

        <div id="error"></div>
    <script>
        var socket;
        var conversationsID;
        var streamUrl;
        var watermark;
        var referenceGrammarId;
        function CreateConvention() {
            var urlPost = "{{secure_url('/api/create')}}";
            $.ajax({
                url:urlPost,
                type: 'GET'})
                .done(function( data ){
                    conversationsID= data.conversationId;
                    streamUrl = data.streamUrl;
                    referenceGrammarId = data.referenceGrammarId;
                    var splitstreamUrl = streamUrl.split("stream?watermark=");
                    watermark = splitstreamUrl[1];
                })
                .fail(function(err) {
                    document.getElementById("error").innerHTML  = err.responseText;
                    console.log(err)
                })
        }
        function ReconnectConvention() {
            var urlPost = "{{secure_url('/api/reconnect')}}";
            var data = {
                watermark:'-&t=H-igKWAqye4.dAA.MwBiAFQAZABEADcAZgBLAFEAVwBPAEUAcABHAHEATQBsADUAaQBOAGQAVAA.EOTRxcOH1AE.NU1anGucKno.8kXbr_HgGvH1JdUkWlTUnn36ToNbHklFvcmtArSvqAs',
                conversationId: '3bTdD7fKQWOEpGqMl5iNdT'
            };
            var CSRF_TOKEN =  $('meta[name="csrf-token"]').attr('content');
            console.log(CSRF_TOKEN);
            $.ajax({
                url:urlPost,
                data: data,
                type: 'POST',
                dataType: 'json',
                headers:
                    { 'X-CSRF-TOKEN': CSRF_TOKEN}
                })
                .done(function( data ){
                    console.log(data);
                    conversationsID= data.conversationId;
                    streamUrl = data.streamUrl;
                    referenceGrammarId = data.referenceGrammarId;
                })
                .fail(function(err) {
                    document.getElementById("error").innerHTML  = err.responseText;
                    console.log(err)
                })
        }
        function OpenSocket() {
            socket = new WebSocket(streamUrl);

            socket.onopen = function(event) {
                console.log("WebSocket is open now.");
            };

            socket.onmessage = function (event) {
                console.log("listening");
                console.log(event.data);
            }
    
            socket.onerror = function(event) {
                console.error("WebSocket error observed:", event);
            };

            socket.onclose = function(event) {
                console.log("WebSocket is closed now.");
            };
        }
        function sendMessage() {
            var message = $('#mess').val();
            var urlPost = "{{secure_url('/api/send')}}";
            var data = {
                watermark:watermark,
                conversationId: conversationsID,
                message: message
            };
            console.log(data);
            var CSRF_TOKEN =  $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:urlPost,
                data: data,
                type: 'POST',
                dataType: 'json',
                headers:
                    { 'X-CSRF-TOKEN': CSRF_TOKEN}
            })
                .done(function( data ){
                    console.log(data);
                })
                .fail(function(err) {
                    document.getElementById("error").innerHTML  = err.responseText;
                    console.log(err)
                })
        }
        function ReceiveMessage() {
            var urlPost = "{{secure_url('/api/receive')}}";
            var data = {
                watermark:watermark,
                conversationId: conversationsID,
            };
            console.log(data);
            var CSRF_TOKEN =  $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:urlPost,
                data: data,
                type: 'POST',
                dataType: 'json',
                headers:
                    { 'X-CSRF-TOKEN': CSRF_TOKEN}
                })
                .done(function( data ){
                    console.log(data);
                })
                .fail(function(err) {
                    document.getElementById("error").innerHTML  = err.responseText;
                    console.log(err)
                })
        }
        function CloseSocket() {
            var urlPost = "{{secure_url('/api/close')}}";
            var data = {
                conversationId: conversationsID,
            };
            console.log(data);
            var CSRF_TOKEN =  $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:urlPost,
                data: data,
                type: 'POST',
                dataType: 'json',
                headers:
                    { 'X-CSRF-TOKEN': CSRF_TOKEN}
            })
                .done(function( data ){
                    console.log(data);
                })
                .fail(function(err) {
                    document.getElementById("error").innerHTML  = err.responseText;
                    console.log(err)
                })
            socket.close();
        }
    </script>
    </body>
</html>
