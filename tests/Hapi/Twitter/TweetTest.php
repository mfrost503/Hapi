<?php
namespace Hapi\Twitter;

class TwitterTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->header = $this->getMockBuilder('\Hapi\OAuth\Header')
            ->disableOriginalConstructor()
            ->getMock();
        $this->tweet = $this->getMock(
            '\Hapi\Twitter\Tweet',
            array('__construct','post','get'),
            array($this->header));
    }

    public function teardown()
    {
        unset($this->tweet);
    }

    /**
     * @test
     * Given an instance of Tweet
     * When the getRetweets method is called
     * Then the get method should be called and return json
     */
    public function Retweets()
    {
        $url = "statuses/retweets/12345.json";
        $json = array();
        $json['reweets']= array(
            0 => array(
                'id'=>'1234567',
                'screen_name'=>'test'
            ),
            1 => array(
                'id'=>'67483234',
                'screen_name' => 'test2'
            )
        );

        $this->tweet->expects($this->once())
            ->method('get')
            ->with($url)
            ->will($this->returnValue(json_encode($json)));

        $retweetsJson = $this->tweet->getRetweets(12345);
        $this->assertContains('1234567',$retweetsJson);
        $this->assertContains('test',$retweetsJson);
        $this->assertContains('test2',$retweetsJson);
        $this->assertContains('67483234',$retweetsJson);
    }

    /**
     * @test
     * Given an instance of Tweet
     * When tweet method is called
     * Then post method should be called and return json
     */
    public function SendTweet()
    {
        $url = "statuses/update.json";
        $tweet = array('status'=>'This is a test tweet');
        $json = array();
        $this->tweet->expects($this->once())
            ->method('post')
            ->with($url,$tweet);
        $this->tweet->tweet($tweet);
    }

    /**
     * @test
     * Given an instance of Tweet
     * When Delete is called
     * Then post should be called and json returned
     */
    public function DeleteTweet()
    {
        $id = 12345;
        $url = 'statuses/destroy/'.$id.'.json';
        $this->tweet->expects($this->once())
            ->method('post')
            ->with($url);
        $this->tweet->delete($id);
    }

    /**
     * @test
     * Given an instance of Tweet
     * When Retrieve is called
     * Then get method should be called
     */
    public function RetrieveTweet()
    {
        $id = 12345;
        $url = 'statuses/show/'.$id.'.json';
        $this->tweet->expects($this->once())
            ->method('get')
            ->with($url);
        $this->tweet->retrieve($id);
    }

    /**
     * @test
     * Given an instance of tweet
     * When Search is called
     * Then the get method should be called with options
     */
    public function SearchTweets()
    {
        $searchArray = array('q'=>'testAccount','count'=> 100);
        $this->tweet->expects($this->once())
            ->method('get')
            ->with('search/tweets.json?q=testAccount&count=100');
        $this->tweet->search($searchArray);
    }
}