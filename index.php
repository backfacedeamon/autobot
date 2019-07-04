<?php
require_once('./vendor/autoload.php');

//Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token='lWtY8ZGPyvz4W0zzz5KH4eHcR5cerA0sqGCEmjwu976pAaNsikSl4H931y8b1mBxR3GImGGUDhYM6RJKXyZVyQAVn0aY0zxmWxntOYGmw9tQl99TifEWI6oqPmnkhJF+b1V/pExiEk9/fW+7z9yYTwdB04t89/1O/w1cDnyilFU=';
$channel_secret='35e654c7cd3a978fab43c926c660dd98';

//Get message from line API
$content=file_get_contents('php://input');
$events=json_decode($content, true);

if(!is_null($events['events'])){
    //Loop through each event
    foreach($events['events']as $event){
        //line API send a lot of event type, we interted in message only
        if($event['type']=='message'){
            switch($event['message']['type']){
                case 'text':
                    //Get replayToken
                    $replyToken=$event['replyToken'];

                    //Replay message
                    $respMessage='Hello, your message is '.$event['message']['text'];

                    $httpClient = new CurlHTTPClient($channel_token);
                    $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
                    $textMessageBuilder = new TextMessageBuilder($respMessage);
                    $response = $bot->replyMessage($replyToken, $textMessageBuilder);
                break;

                case 'image':
                    $messageID=$event['message']['id'];
                    $respMessage= 'Hello, your image ID is'.$messageID;

                    break;
                default:
                  $respMessage='Please send image only';
                    break;
            }
            $httpClient = new CurlHTTPClient($channel_token);
                    $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
                    $textMessageBuilder = new TextMessageBuilder($respMessage);
                    $response = $bot->replyMessage($replyToken, $textMessageBuilder);
        }

            }
        }
    


echo"OK";
