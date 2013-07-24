<?php
namespace Hapi\Twitter;

class User extends Twitter
{
    public function retrieveSettings()
    {
        $response = $this->get('account/settings.json');
        return $response;
    }

    public function verifyCredentials(Array $params)
    {
        $response = $this->get('account/verify_credentials.json',$params);
        return $response;
    }

    public function updateProfile(Array $params)
    {
        $response = $this->post('account/settings.json',$params);
        return $response;
    }

    public function retrieveBlockedUsers(Array $params=array(),$retrieveIds=false)
    {
        $uri = 'blocks/list.json';
        if($retrieveIds === true) {
            $uri = 'blocks/ids.json';
        }
        $response = $this->get($uri,$params);
        return $response;
    }

    public function block(Array $params)
    {
        if(!isset($params['user_id']) && !isset($params['screen_name'])) {
            throw new \Exception("Block requires a screen name or user id parameter");
        }
        $response = $this->post('blocks/create.json',$params);
        return $response;
    }

    public function unblock(Array $params)
    {
        if(!isset($params['user_id']) && !isset($params['screen_name'])) {
            throw new \Exception("Unblock requires a screen name or user id parameter");
        }
        $response = $this->post('blocks/destroy.json',$params);
        return $response;
    }

    public function retrieveInfo($params)
    {
        if(!isset($params['user_id']) && !isset($params['screen_name'])) {
            throw new \Exception("Retrieve Info requires a screen name or user id parameter");
        }
        $response = $this->get('users/show.json',$params);
        return $response;
    }
}