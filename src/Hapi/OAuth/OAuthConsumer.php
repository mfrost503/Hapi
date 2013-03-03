<?php
namespace Hapi\OAuth;

class OAuthConsumer
{
    /**
     * @var consumerKey
     * The consumer key that corresponds to a twitter app
     */
    private $consumerKey;

    /**
     * @var consumerSecret
     * The consumer secret the corresponds to a twitter app
     */
    private $consumerSecret;

    /**
     * @param $consumerKey
     * @param $consumerSecret
     * Sets the consumerKey and consumerSecret properties
     */
    public function __construct($consumerKey,$consumerSecret)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * @return consumerKey
     * Retrieve the stored consumer key
     */
    public function getConsumerKey()
    {
        return $this->consumerKey;
    }

    /**
     * @return consumerSecret
     * Retrieve the stored consumer secret
     */
    public function getConsumerSecret()
    {
        return $this->consumerSecret;
    }
}