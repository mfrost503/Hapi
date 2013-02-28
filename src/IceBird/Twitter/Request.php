<?php
namespace IceBird\Twitter;
abstract class Request
{
    protected $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    abstract public function get($params=array());

    abstract public function set($params=array());

    protected function execute($url,$verb)
    {
        $c = curl_init($url);
        curl_setopt($c,$verb,1);
        curl_setopt($c,CURLOPT_RETURNTRANSFER,1);
        return curl_exect($c);

    }

    protected function authenticate()
    {

    }
}