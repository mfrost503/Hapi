<?php
namespace Hapi\Twitter;

class DirectMessageTest extends \PHPUnit_Framework_TestCase
{
    public function setup(){
        $this->header = $this->getMockBuilder('\Hapi\Twitter\OAuthHeader')
            ->disableOriginalConstructor()
            ->getMock();
        $this->dm = $this->getMock(
            '\Hapi\Twitter\DirectMessage',
            array('__construct','get','post'),
            array($this->header));
    }

    public function tearDown()
    {
        unset($this->header);
        unset($this->dm);
    }

    /**
     * @test
     * Given an instance of DirectMessage
     * When the retrieveAll method is called
     * Then all the direct messages should be returned via get
     */
    public function GetDirectMessages()
    {
        $this->dm->expects($this->once())
            ->method('get')
            ->with('direct_messages.json');
        $this->dm->retrieveAll();
    }

    /**
     * @test
     * Given an instance of DirectMessage
     * When the retrieveSent method is called
     * Then the sent direct messages should be returned via get
     */
    public function RetrieveSentMessages()
    {
        $this->dm->expects($this->once())
            ->method('get')
            ->with('direct_messages/sent.json');
        $this->dm->retrieveSent();
    }

    /**
     * @test
     * Given an instance of DirectMessage
     * When the retrieve method is called with an id
     * Then the DM corresponding to the id should be returned via get
     */
    public function RetrieveDirectMessage()
    {
        $id = 12345;
        $this->dm->expects($this->once())
            ->method('get')
            ->with('direct_messages/show/'.$id.'.json');
        $this->dm->retrieve(12345);
    }

    /**
     * @test
     * Given an instance of DirectMessage
     * When the delete method is called
     * Then the corresponding DM should be deleted
     */
    public function DeleteDirectMessage()
    {
        $id = 12345;
        $this->dm->expects($this->once())
            ->method('post')
            ->with('direct_messages/destroy.json',array('id' => $id));
        $this->dm->delete($id);
    }

    /**
     * @test
     * Given an instance of DirectMessage
     * When the create method is called with an array parmeter
     * Then a new direct message should be created
     */
    public function NewDirectMessage()
    {
        $params = array('user_id' => 12345,'text' => 'This is a new direct message');
        $this->dm->expects($this->once())
            ->method('post')
            ->with('direct_messages/new.json',$params);
        $this->dm->create($params);
    }

    /**
     * @test
     * Given an instance of DirectMessage
     * When the create method is called with a missing screen_name/user_id key
     * Then a DirectMessageException should be thrown
     * @expectedException \Hapi\Twitter\Exceptions\DirectMessageException
     */
    public function missingUserException()
    {
        $params = array('text' => 'This is a test dm');
        $this->dm->create($params);
    }

    /**
     * @test
     * Given an instance of DirectMessage
     * When the create method is called with a missing text key
     * Then a DirectMessageException should be thrown
     * @expectedException \Hapi\Twitter\Exceptions\DirectMessageException
     */
    public function MissingMessageException()
    {
        $params = array('user_id' => 12345);
        $this->dm->create($params);
    }
}