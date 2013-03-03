<?php
namespace Hapi\Twitter;

class OAuthAccess
{
    /**
     * @var accessToken
     * Access token for authenticated user
     */
    private $accessToken;

    /**
     * @var accessSecret
     * Access Secret for authenticated user
     */
    private $accessSecret;

    /**
     * @param $accessToken
     * @param $accessSecret
     * Sets the accessToken and accessSecret properties
     */
    public function __construct($accessToken,$accessSecret)
    {
        $this->accessToken = $accessToken;
        $this->accessSecret = $accessSecret;
    }

    /**
     * @return accessToken
     * Retrieve the set accessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return accessSecret
     * Retrieve the set accessSecret
     */
    public function getAccessSecret()
    {
        return $this->accessSecret;
    }
}