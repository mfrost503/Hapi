<?php

class Twitter{
    private $apiToken;
    private $user;

    public function __construct($apiToken,$user)
    {
        $this->apiToken = $apiToken;
        $this->user = $user;
    }

}

