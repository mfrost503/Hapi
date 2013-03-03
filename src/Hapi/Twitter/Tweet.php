<?php
namespace Hapi\Twitter;

class Tweet extends Twitter
{
    /**
     * @var OAuthHeader $header
     * Header instance to sign and authenticate the request
     */
    protected $header;

    /**
     * @param OAuthHeader $header
     * Sets the header property
     */
    public function __construct(\Hapi\OAuth\OAuthHeader $header)
    {
        $this->header = $header;
    }

    /**
     * @param $id
     * @return mixed
     * Takes the id of a tweet/status and returns a json response
     * with information regarding the tweet and the users who retweeted
     */
    public function getRetweets($id)
    {
        $response = $this->get('statuses/retweets/'.$id.'.json');
        return $response;
    }

    /**
     * @param array $tweet
     * @return mixed
     * Takes an array of parameters and makes ap post request
     * to update the status of authenticated user (creates a tweet)
     */
    public function tweet(Array $tweet)
    {
        $response = $this->post('statuses/update.json',$tweet);
        return $response;
    }

    /**
     * @param $id
     * @return mixed
     * Takes a tweet id and deletes the tweet
     */
    public function delete($id)
    {
        $response = $this->post('statuses/destroy/'.$id.'.json',array());
        return $response;
    }

    /**
     * @param $id
     * @return mixed
     * Takes a tweet id and returns associated tweet/status information
     */
    public function retrieve($id)
    {
        $response = $this->get('statuses/show/'.$id.'.json');
        return $response;
    }

    /**
     * @param array $params
     * @return mixed
     * Takes an array of options (q,count,etc) and returns
     * json of all the tweets that match the provided criteria
     */
    public function search(Array $params)
    {
        foreach($params as $key=>$value) {
            $values[] = "$key=$value";
        }
        $queryString = implode("&",$values);
        $response = $this->get('search/tweets.json?'.$queryString);
        return $response;
    }
}

