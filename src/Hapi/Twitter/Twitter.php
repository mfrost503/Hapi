<?php
namespace Hapi\Twitter;
use \Hapi\OAuth as OAuth;
use \Hapi\Request as Request;

class Twitter implements Request\RequestInterface
{
    protected $baseUrl = "https://api.twitter.com/1.1/";
    protected $header;

    public function __construct(OAuth\OAuthHeader $header) {
        $this->header = $header;
    }

    public function get($uri,$params=array())
    {
        $queryString = '';
        $values = array();
        foreach($params as $key => $value) {
            $values[] = rawurlencode($key) . '=' . rawurlencode($value);
        }
        if(!empty($values)) {
            $queryString .= '?';
        }
        $queryString .= implode("&",$values);
        $url = $this->baseUrl . $uri . $queryString;
        $this->header->setRequestUrl($url);
        $headers = $this->header->getAuthHeader();
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_POST,false);
        curl_setopt($curl,CURLOPT_HTTPHEADER,array($headers,'Expects:'));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_URL,$url);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function post($uri,$postFields)
    {
        $url = $this->baseUrl . $uri;
        $this->header->setHTTPVerb('POST');
        $this->header->setRequestUrl($url);
        $headers = $this->header->getAuthHeader();
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_HTTPHEADER,array($headers,'Expects:'));
        curl_setopt($curl,CURLOPT_POSTFIELDS,$postFields);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_URL,$this->baseUrl . $uri);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
