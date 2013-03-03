<?php
namespace Hapi\Twitter;

class OAuthHeader
{
    /**
     * @var OAuthAccess oauthAccess
     * An oauthAccess instance that holds the users
     * oauth_access_token/secret
     */
    private $oauthAccess;

    /**
     * @var string httpVerb
     * Default HTTP Verb for the baseString
     */
    private $httpVerb ='GET';
    /**
     * @var nonce
     * Unique value to send as part of the header
     * nonce - cryptograhpy term for a number used once
     */
    private $nonce;

    /**
     * @var OAuthConsumer oauthConsumer
     * An oauthConsumer instance that holds the
     * application token/secret
     */
    private $oauthConsumer;

    /**
     * @var requestUrl
     * The URL request being sent to twiiter
     */
    private $requestUrl;
    private $callback='';

    public function __construct(OAuthAccess $oauthAccess,OAuthConsumer $oauthConsumer)
    {
        $this->oauthAccess = $oauthAccess;
        $this->oauthConsumer = $oauthConsumer;
    }

    /**
     * @param $url
     * Sets the callback url
     */
    public function setCallback($url='')
    {
        $this->callback = $url;
    }

    /**
     * @param $verb
     * Sets the httpVerb property for the baseString
     */
    public function setHTTPVerb($verb)
    {
        $this->httpVerb = $verb;
    }

    /**
     * @param $url
     * Set the requestUrl property
     */
    public function setRequestUrl($url)
    {
        $this->requestUrl = $url;
    }
    /**
     * @param $nonce
     * Sets the nonce value
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
    }

    /**
     * @return array|bool
     * compile the header information to create
     * the request headers
     */
    public function setHeaderInfo()
    {
        if(empty($this->nonce))
        {
            $this->nonce = time();
        }
        $timestamp = time();
        $oauth = array(
            'oauth_nonce' => $this->nonce,
            'oauth_callback'=>$this->callback,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => $timestamp,
            'oauth_consumer_key' => $this->oauthConsumer->getConsumerKey(),
            'oauth_token' => $this->oauthAccess->getAccessToken(),
            'oauth_version' => '1.0'
        );
        if($this->callback == '') {
            unset($oauth['oauth_callback']); 
        }
        return $oauth;
    }

    /**
     * @param $params
     * @return string
     * Takes the params from the previous step and the base url
     * and creates the base string
     */
    public function buildBaseString($params)
    {
        $temp_array = array();
        ksort($params);
        foreach($params as $key => $value){
            $temp_array[] = $key . '=' . rawurlencode($value);
        }
        return "$this->httpVerb&" .rawurlencode($this->requestUrl) . '&' . rawurlencode(implode('&',$temp_array));
    }

    /**
     * @return string
     * Creates the composite key
     */
    public function getCompositeKey()
    {
        return rawurlencode($this->oauthConsumer->getConsumerSecret()) . '&' . rawurlencode($this->oauthAccess->getAccessSecret());
    }

    /**
     * @param $params
     * @return string
     * Builds the authorization header to send to twitter
     */
    public function buildAuthHeader($params)
    {
        $headerPrefix = "Authorization: OAuth ";
        $values = array();
        foreach($params as $key => $value) {
            $values[] = "$key=\"". rawurlencode($value) . "\"";
        }
        $headerString = implode(', ',$values);
        return $headerPrefix.$headerString;
    }

    /**
     * @param $baseString
     * @param $compositeKey
     * @return string
     * Users the previously created baseString and compositeKey
     * to sign the request
     */
    public function buildSignature($baseString,$compositeKey)
    {
        return base64_encode(hash_hmac('sha1',$baseString,$compositeKey,true));
    }

    public function getAuthHeader()
    {
        $params = $this->setHeaderInfo();
        $baseString = $this->buildBaseString($params);
        $compositeKey = $this->getCompositeKey();
        $params['oauth_signature'] = $this->buildSignature($baseString,$compositeKey);
        return $this->buildAuthHeader($params);
    }

}
