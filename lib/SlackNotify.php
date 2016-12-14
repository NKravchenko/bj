<?php

namespace Jimm\lib;

//use GuzzleHttp\Client;

class SlackNotify
{
    // appid 33677202723.112700519410
    // token cc3bde010598ea75ba0d9965e6bbfa9c

    const TOKEN = 'xoxb-113381837702-zT0YF5gB86cynVLV6iIXWCmw';
    const DEFAULT_NAME = 'generator';

    const CHANNEL_BEEJEE = "G3AJVPVU3";


    public static function sendMessage($message, $channelId, $name = null, $attachments = null)
    {
        $params = array(
            'username' => $name ?: (defined('SLACK_NOTIFY_NAME') ? SLACK_NOTIFY_NAME : self::DEFAULT_NAME),
            'channel'  => $channelId,
            'text'     => (string)$message,
        );

        if (null != $attachments) {
            $params['attachments'] = $attachments;
        }

        self::send($params);
    }

    /**
     * https://api.slack.com/docs/message-attachments
     * @param array $params2
     */
    private static function sendNew(array $params2)
    {
        $params = [
            'token'  => self::TOKEN,
            "mrkdwn" => true,
        ];

        $params = array_merge($params, $params2);

        if (isset($params['attachments'])) {
            $params['attachments'] = json_encode($params['attachments']);
        }

        $httpClient = new Client();
        $url = 'https://slack.com/api/chat.postMessage';
        $response = $httpClient->post($url, ['form_params' => $params]);
    }

    private static function send(array $params2)
    {
        $params = [
            'token' => self::TOKEN,
            "parse" => 'full',
        ];

        $params = array_merge($params, $params2);
        $res = file_get_contents('https://slack.com/api/chat.postMessage?' . http_build_query($params));
    }
}
