<?php
namespace Hapi\Twitter;
use \Hapi\OAuth as OAuth;

class Friendship extends Twitter
{

    public function retrieveNoRetweets(Array $params=array())
    {
        $response = $this->get('friendships/no_retweets/id.json',$params);
        return $response;
    }

    public function retrieveFriends(Array $params = array())
    {
        $response = $this->get('friends/ids.json',$params);
        return $response;
    }

    public function retrieveFollowers(Array $params = array())
    {
        $response = $this->get('followers/ids.json',$params);
        return $response;
    }

    public function follow(Array $params)
    {
        if(!isset($params['user_id']) && !isset($params['screen_name'])) {
            throw new \Exception("You must provide a screen name or user id to follow");
        }
        $response = $this->post('friendships/create.json',$params);
        return $response;
    }

    public function unfollow(Array $params)
    {
        if(!isset($params['screen_name']) && !isset($params['user_id'])) {
            throw new \Exception("You must provide a screen name or user id to unfollow");
        }
        $response = $this->post('friendships/destroy.json',$params);
        return $response;
    }
}