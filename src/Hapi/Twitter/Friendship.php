<?php
namespace Hapi\Twitter;
use \Hapi\OAuth as OAuth;

class Friendship extends Twitter
{

    public function getNoRetweets(Array $params=array())
    {
        $response = $this->get('friendships/no_retweets/id.json',$params);
        return $response;
    }

    public function getFriends(Array $params = array())
    {
        $response = $this->get('friends/ids.json',$params);
        return $response;
    }

    public function getFollowers(Array $params = array())
    {
        $response = $this->get('followers/ids.json',$params);
        return $response;
    }
}