<?php
namespace Hapi\Twitter;
use \Hapi\OAuth as OAuth;
use \Hapi\Request as Request;

/**
 * @class Twitter
 * @implements \Hapi\Request\RequestInterface
 * @author Matt Frost
 *
 * This class is responsible for making the request to the Twitter API
 * and returning the results from that call. The response is given back
 * in two components, the response headers and the body. The functionality
 * for making the request is made in \Hapi\Request\Request
 */
class Twitter extends Request\Request implements Request\RequestInterface
{
    public function __construct(OAuth\OAuthHeader $header)
    {
        parent::__construct($header);
	$this->setBaseUrl('https://api.twitter.com/1.1/');
    }
}
