<?php
namespace Hapi\OAuth;

class OAuthAccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function AccessSetters()
    {
        $access = new OAuthAccess('123','456');
        $this->assertEquals($access->getAccessToken(),'123');
        $this->assertEquals($access->getAccessSecret(),'456');
    }
}