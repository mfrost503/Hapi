<?php
namespace IceBird\Twitter;

class OAuthConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    **/
    public function ConsumerGetters()
    {
        $consumer = new OAuthConsumer('123','123');
    }
}
