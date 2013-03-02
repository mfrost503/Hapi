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

        $this->get('statuses/retweets/'.$id.'.json',$this->header);
    }

}