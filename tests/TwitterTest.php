<?php
namespace Icebird\Twitter;

class OAuthAccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * Given an instance of OAuthAccess
     * When the setters are called
     * Then the provided values should be returned
     */
    public function Setters()
    {
        $access = new OAuthAccess('12345','123456789');
        $this->assertEquals('12345',$access->getAccessToken());
        $this->assertEquals('123456789',$access->getAccessSecret());
    }
}