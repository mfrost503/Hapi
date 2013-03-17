<?php
namespace Hapi\Twitter;

class FriendshipTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->header = $this->getMockBuilder('\Hapi\OAuth\OAuthHeader')
            ->disableOriginalConstructor()
            ->getMock();
        $this->friendship = $this->getMock(
            '\Hapi\Twitter\Friendship',
            array('__construct','get','post'),
            array($this->header)
        );
    }

    public function tearDown()
    {
        unset($this->header);
        unset($this->friendship);
    }

    /**
     * @test
     * Given an instance of Friendship
     * When getNoRetweets is called with stringify_ids=true
     * Then the user ids that you don't want to see retweets
     * from is returned
     */
    public function GetNoRetweetsString()
    {
        $params = array('stringify_ids'=> 'true');
        $this->friendship->expects($this->once())
            ->method('get')
            ->with('friendships/no_retweets/id.json',$params);
        $this->friendship->getNoRetweets($params);
    }

    /**
     * @test
     * Given an instance of Friendship
     * When getNoRetweets is called with stringify_ids=false
     * Then the user ids that you don't want to see retweets
     * from is returned
     */
    public function GetNoRetweetsNoString()
    {
        $params = array('stringify_ids'=>'false');
        $this->friendship->expects($this->once())
            ->method('get')
            ->with('friendships/no_retweets/id.json',$params);
        $this->friendship->getNoRetweets($params);
    }

   /**
    * @test
    * Given an instance of friendship
    * When getFriends method is called
    * Then a get request should be made to return friend ids
    */
    public function GetFriends()
    {
        $this->friendship->expects($this->once())
            ->method('get')
            ->with('friends/ids.json');
        $this->friendship->getFriends();
    }

    /**
     * @test
     * Given a friendship instance
     * When getFriends is call with params
     * Then the get request should append the query string
     */
    public function GetFriendsQuery()
    {
        $params =array('screen_name' => 'test','count' => 100);
        $this->friendship->expects($this->once())
            ->method('get')
            ->with('friends/ids.json',$params);
        $this->friendship->getFriends($params);
    }

    /**
     * @test
     * Given an instance of friendship
     * When getFollowers method is called
     * Then a get request should be made to return follower ids
     */
    public function GetFollowers()
    {
        $this->friendship->expects($this->once())
            ->method('get')
            ->with('followers/ids.json');
        $this->friendship->getFollowers();
    }

    /**
     * @test
     * Given a Friendship instance
     * When getFollowers is called with params
     * Then the get call should append the query string
     */
    public function GetFollowersQuery()
    {
        $params =array('screen_name'=>'test','count'=>100);
        $this->friendship->expects($this->once())
            ->method('get')
            ->with('followers/ids.json',$params);
        $this->friendship->getFollowers($params);
    }
}