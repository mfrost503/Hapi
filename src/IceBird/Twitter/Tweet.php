<?php
namespace IceBird\Twitter;

class Tweet extends Twitter
{
    protected $header;

    public function __construct(OAuthHeader $header)
    {
        $this->header = $header;
    }

    public function getRetweets($id)
    {
        $response = $this->get('statuses/retweets/'.$id.'.json');
        return $response;
    }

    public function tweet($tweet)
    {
        $response = $this->post('statuses/update.json',array('status'=>$tweet));
        return $response;
    }

    public function delete($id)
    {
        $response = $this->post('statuses/destroy/'.$id.'.json',array());
        return $response;
    }

    public function retrieve($id)
    {
        $response = $this->get('statuses/show/'.$id.'.json');
    }
}

