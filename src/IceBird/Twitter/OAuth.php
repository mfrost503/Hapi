<?php
namespace IceBird\Twitter;

class OAuth implements \IceBird\Authentication
{
    private $consumerSecret;
    private $callback;
    private $nonce;
    private $consumerToken;
    public function __construct($consumerToken,$consumerSecret)
    {
        $this->consumerSecret = $consumerSecret;
        $this->consumerToken = $consumerToken;
    }

    public function setCallback($url)
    {
        $this->callback = $url;
    }

    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
    }

    private function setHeaderInfo()
    {
        if(empty($this->nonce))
        {
            $this->nonce = time();
        }
        if(empty($this->callback))
        {
            return false;
        }
        if(empty($this->consumerSecret))
        {
            return false;
        }
        $timestamp = time();
        $oauth = array(
            'oauth_nonce' => $this->nonce,            'oauth_callback'=>$this->callback,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => $timestamp,
            'oauth_consumer_key' => $this->consumerToken,
            'oauth_version' => '1.0'
        );
        return $oauth;
    }

    private function buildBaseString($params,$baseUrl="https://api.twitter.com/oauth/request_token")
    {
        $temp_array = array();
        ksort($params);
        foreach($params as $key => $value){
            $temp_array[] = $key . '=' . rawurlencode($value);
        }
        return "POST&" .rawurlencode($baseUrl) . '&' . rawurlencode(implode('&',$temp_array));
    }

    private function getCompositeKey($requestToken=null)
    {
        return rawurlencode($this->consumerSecret) . '&' . rawurlencode($requestToken);
    }

    private function buildAuthHeader($params)
    {
        $headerPrefix = "Authorization: OAuth ";
        $values = array();
        foreach($params as $key => $value) {
            $values[] = "$key=\"". rawurlencode($value) . "\"";
        }
        $headerString = implode(', ',$values);
        return $headerPrefix.$headerString;
    }

    private function buildSignature($baseString,$compositeKey)
    {
        return base64_encode(hash_hmac('sha1',$baseString,$compositeKey,true));
    }

    public function authenticate()
    {
        if(($params = $this->setHeaderInfo()) !== false)
        {
            $baseString = $this->buildBaseString($params);
            $compositeKey = $this->getCompositeKey();
            $signature = $this->buildSignature($baseString,$compositeKey);
            $params['oauth_signature'] = $signature;
            $header = array($this->buildAuthHeader($params), 'Expect:');
            $options = array(
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_HEADER =>false,
                CURLOPT_POSTFIELDS => '',
                CURLOPT_URL => 'https://api.twitter.com/oauth/request_token',
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false);

            $curl = curl_init();
            curl_setopt_array($curl,$options);
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }
    }
}