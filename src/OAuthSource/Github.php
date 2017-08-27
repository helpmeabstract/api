<?php

namespace HelpMeAbstract\OAuthSource;

use GuzzleHttp\Client;

class Github implements OAuthSource
{
    public function getUser($code):array
    {
        $client = new Client();
        $response = $client->post('https://github.com/login/oauth/access_token?client_id=' . getenv('GITHUB_CLIENT_ID') . '&redirect_uri=http://0.0.0.0:8080/auth&client_secret=' . getenv('GITHUB_SECRET') . '&code=' . $code);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Something went terribly terribly wrong');
        }

        parse_str($response->getBody()->getContents(), $vals);

        $token = $vals['access_token'];

        $userInfo = $client->get('https://api.github.com/user?access_token=' . $token);
        $userInfo = json_decode($userInfo->getBody()->getContents(), true);

        $name = explode(' ', $userInfo['name']);
        $userInfo['first_name'] = array_shift($name);
        $userInfo['last_name'] = implode(' ', $name);
        $userInfo['token'] = $token;

        return $userInfo;
    }
}
