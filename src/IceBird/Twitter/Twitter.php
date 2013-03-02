<?php
namespace IceBird\Twitter;

abstract class Twitter
{
    protected $baseUrl = "https://api.twitter.com/1.1/";

    protected function get($uri)
    {
        $url = $this->baseUrl . $uri;
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

    protected function post($uri,$postFields)
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
