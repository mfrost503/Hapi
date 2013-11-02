<?php
namespace Hapi\Request;
use \Hapi\OAuth as OAuth;

/**
 * @class Request
 * @implements \Hapi\Request\RequestInterface
 * @author Matt Frost
 *
 * This class is responsible for making a request
 * and returning the results from that call. The response is given back
 * in two components, the response headers and the body.
 */
class Request implements RequestInterface
{
    protected $baseUrl;
    protected $header;
    public $responseHeader;

    /**
     * @params \Hapi\OAuth\OAuthHeader $header
     * 
     * The constructor will take an OAuth Header object as the first
     * parameter and set it as the header property for an instance
     * The header property will be used to generate the OAuth header
     * required for request to be made to the API
     */
    public function __construct(OAuth\Header $header) {
        $this->header = $header;
    }

    /**
     * @param string $uri
     * @param array $params
     * @returns $response
     *
     * The uri provides the path to the resource, relative to the base
     * url. Parameters are any set of available options that can be made
     * with the request (for example: records). These are parse to form
     * a valid request.
     */
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
        curl_setopt($curl,CURLOPT_HEADER,true);
        curl_setopt($curl,CURLOPT_URL,$url);
        $response = curl_exec($curl);
	    $response = $this->processResponse($response);
        curl_close($curl);
        return $response;
    }

    /**
     * @param string $uri
     * @param mixed $postFields
     * @returns $response
     *
     * A post method takes a path relative to the base url and either
     * a string or any array. The values are then parsed and a post
     * request is made with the values provided. A response is provided
     * in two parts, the headers and the body, where the headers are stored
     * in a property called reponseHeaders as an associative array
     */
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
        curl_setopt($curl,CURLOPT_HEADER,true);
        $response = curl_exec($curl);
	$response = $this->processResponse($response);
        curl_close($curl);
        return $response;
    }

    /**
     * @param string $response
     * @returns $output
     *
     * Takes the full response, containing the body and headers and
     * creates an associative array of the headers as a key value pair.
     * The format of the original response is returned unaffected, but
     * the headers are provided in such a way that they are easy to 
     * retrieve
     */
    public function processResponse($response)
    {
    	$responseHeader = array();
        $headers = explode("\r\n", $response);
	    // return the json/xml output - unaffected
	    $output = array_pop($headers);
	    // get rid of the blank line at the end of the headers
	    array_pop($headers);
	    foreach($headers as $header) {
	        $colonPosition = strpos($header, ':');
	        $key = substr($header, 0, $colonPosition);
	        $value = substr($header, $colonPosition + 1);
	        $responseHeader[$key] = trim($value);
	    }
	    $this->responseHeader = $responseHeader;
	    return $output;
    }

    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}

