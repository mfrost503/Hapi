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
        $this->friendship->retrieveNoRetweets($params);
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
        $this->friendship->retrieveNoRetweets($params);
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
        $this->friendship->retrieveFriends();
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
        $this->friendship->retrieveFriends($params);
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
        $this->friendship->retrieveFollowers();
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
        $this->friendship->retrieveFollowers($params);
    }

    /**
     * @test
     * Given a Friendship instance
     * When follow is called with screen_name set
     * Then the call should be made with post fields
     */
    public function FollowScreenName()
    {
        $params = array('screen_name'=>'test');
        $this->friendship->expects($this->once())
            ->method('post')
            ->with('friendships/create.json',$params);
        $this->friendship->follow($params);
    }

    /**
     * @test
     * Given a friendship instance
     * When follow is called and user_id is set
     * Then the call should be made with post fields
     */
    public function FollowUserId()
    {
        $params = array('user_id'=>'1234');
        $this->friendship->expects($this->once())
            ->method('post')
            ->with('friendships/create.json',$params);
        $this->friendship->follow($params);
    }

    /**
     * @test
     * Given a friendship instance
     * When Follow is called an screen_name and user_id are not set
     * Then an Exception should be thrown
     * @expectedException \Exception
     */
    public function FollowThrowException()
    {
        $params = array('follow'=>false);
        $this->friendship->follow($params);
    }

    /**
     * @test
     * Given a friendship instance
     * When Unfollow is called with screen_name
     * Then the post request should be made with post fields
     */
    public function UnfollowScreenName()
    {
        $params = array('screen_name'=>'test');
        $this->friendship->expects($this->once())
            ->method('post')
            ->with('friendships/destroy.json',$params);
        $this->friendship->unfollow($params);
    }

    /**
     * @test
     * Given a friendship instance
     * When Unfollow is called with a user id
     * Then the post request should be with post fields
     */
    public function UnfollowUserId()
    {
        $params = array('user_id'=>'1234');
        $this->friendship->expects($this->once())
            ->method('post')
            ->with('friendships/destroy.json',$params);
        $this->friendship->unfollow($params);
    }

    /**
     * @test
     * Given a friendship instance
     * When unfollow is called with no screen name or user id
     * Then an Exception should be thrown
     * @expectedException \Exception
     */
    public function UnfollowException()
    {
        $params = array();
        $this->friendship->unfollow($params);
    }
}