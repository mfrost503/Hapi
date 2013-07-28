<?php
namespace Hapi\OAuth;

class OAuthConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    **/
    public function ConsumerGetters()
    {
        $consumer = new Consumer('123','456');
        $this->assertEquals($consumer->getConsumerKey(),'123');
        $this->assertEquals($consumer->getConsumerSecret(),'456');
    }
}
