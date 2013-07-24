<?php
namespace Hapi\Twitter;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->header = $this->getMockBuilder('\Hapi\OAuth\OAuthHeader')
            ->disableOriginalConstructor()
            ->getMock();
        $this->user = $this->getMock('\Hapi\Twitter\User',
                                     array('__construct','get','post'),
                                     array($this->header)
        );
    }

    public function tearDown()
    {
        unset($this->header);
        unset($this->user);
    }

    /**
     * @test
     * Given an instance of User
     * When retrieveSettings is called
     * The get request should be made
     */
    public function RetrieveSettings()
    {
        $this->user->expects($this->any())
            ->method('get')
            ->with('account/settings.json');
        $this->user->retrieveSettings();
    }

    /**
     * @test
     * Given a user instance
     * When verifyCredentials is called
     * Then the get request should be made
     */
    public function VerifyCredentials()
    {
        $params = array('include_entities'=>true,'skip_status'=>1);
        $this->user->expects($this->once())
            ->method('get')
            ->with('account/verify_credentials.json',$params);
        $this->user->verifyCredentials($params);
    }

    /**
     * @test
     * Given a user instance
     * When updateProfile is called with params
     * Then the post request should be made with post fields
     */
    public function UpdateProfile()
    {
        $params = array('name'=>'Testy McTesterson','location'=>'Chicago,IL');
        $this->user->expects($this->once())
            ->method('post')
            ->with('account/settings.json',$params);
        $this->user->updateProfile($params);
    }

    /**
     * @test
     * Given a user instance
     * When retrieveBlockedUsers is called with ids set to false
     * Then the proper get request should be called
     */
    public function RetrieveBlockedUsersList()
    {
        $params = array('include_entities'=>true);
        $this->user->expects($this->once())
            ->method('get')
            ->with('blocks/list.json',$params);
        $this->user->retrieveBlockedUsers($params);
    }

    /**
     * @test
     * Given a user instance
     * When retrieveBlockedUsers is called with ids set to true
     * Then the proper get request should be called
     */
    public function RetrieveBlockedUsersIds()
    {
        $params = array('include_entities'=>true);
        $this->user->expects($this->once())
            ->method('get')
            ->with('blocks/ids.json',$params);
        $this->user->retrieveBlockedUsers($params,true);
    }

    /**
     * @test
     * Given a user instance
     * When block is called with a user_id
     * Then the proper get request should be made
     */
    public function BlockId()
    {
        $params = array('user_id'=>'1234');
        $this->user->expects($this->once())
            ->method('post')
            ->with('blocks/create.json',$params);
        $this->user->block($params);
    }

    /**
     * @test
     * Given a user instance
     * When block is called with a screen_name
     * Then the proper get request should be made
     */
    public function BlockScreenName()
    {
        $params = array('screen_name'=>'test');
        $this->user->expects($this->once())
            ->method('post')
            ->with('blocks/create.json',$params);
        $this->user->block($params);
    }

    /**
     * @test
     * Given an instance of user
     * When Block is called with no user_id/screen_name
     * Then an \Exception should be thrown
     * @expectedException \Exception
     */
    public function BlockException()
    {
        $params = array();
        $this->user->block($params);
    }

    /**
     * @test
     * Given an instance of user
     * When unblock is called with a user_id
     * Then the proper post request should be made
     */
    public function UnBlockId()
    {
        $params = array('user_id'=>'1234');
        $this->user->expects($this->once())
            ->method('post')
            ->with('blocks/destroy.json',$params);
        $this->user->unblock($params);
    }

    /**
     * @test
     * Given an instance of user
     * When unblock is called with a screen_name
     * Then the proper post request should be made
     */
    public function UnBlockScreenName()
    {
        $params = array('screen_name'=>'test');
        $this->user->expects($this->once())
            ->method('post')
            ->with('blocks/destroy.json',$params);
        $this->user->unblock($params);
    }

    /**
     * @test
     * Given an instance of user
     * When unblock is called with no user_id or screen_name
     * Then an exception should be thrown
     * @expectedException \Exception
     */
    public function UnblockException()
    {
        $params = array();
        $this->user->unblock($params);
    }

    /**
     * @test
     * Given an instance of user
     * When retrieveInfo is called with an id
     * Then the correct get request should be called
     */
    public function RetrieveInfoId()
    {
        $params = array('screen_name'=>'test');
        $this->user->expects($this->once())
            ->method('get')
            ->with('users/show.json',$params);
        $this->user->retrieveInfo($params);
    }

    /**
     * @test
     * Given an instance of user
     * When retrieveInfo is called with a screen name
     * Then the correct request should be called
     */
    public function RetrieveInfoScreenName()
    {
        $params = array('screen_name'=>'test');
        $this->user->expects($this->once())
            ->method('get')
            ->with('users/show.json',$params);
        $this->user->retrieveInfo($params);
    }

    /**
     * @test
     * Given an instance of user
     * When no user id or screen name is set
     * Then an \Exception should be thrown
     * @expectedException \Exception
     */
    public function RetrieveInfoException()
    {
        $params = array();
        $this->user->retrieveInfo($params);
    }

    /**
     * @test
     * Given an instance of user
     * When lookup is called with an id or comma separated list of ids
     * Then the correct get request should be made
     */
}
