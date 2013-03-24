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
}
