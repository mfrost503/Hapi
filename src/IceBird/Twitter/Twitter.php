<?php
namespace IceBird\Twitter;

class Twitter extends Request
{
    private $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function get($array=array())
    {

    }

    public function set($array=array()){}
}

