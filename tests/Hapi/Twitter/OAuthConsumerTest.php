<?php
namespace Hapi\Twitter;

class OAuthConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    **/
    public function ConsumerGetters()
    {
        $consumer = new OAuthConsumer('123','456');
        $this->assertEquals($consumer->getConsumerKey(),'123');
        $this->assertEquals($consumer->getConsumerSecret(),'456');
    }
}
