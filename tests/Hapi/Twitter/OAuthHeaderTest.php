<?php
namespace Hapi\Twitter;

class OAuthHeaderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->consumer = $this->getMockBuilder('\Hapi\Twitter\OAuthConsumer',array('getConsumerSecret','getConsumerToken'))
            ->disableOriginalConstructor()
            ->getMock();
        $this->access = $this->getMockBuilder('\Hapi\Twitter\OAuthAccess',array('getAccessSecret','getAccessToken'))
            ->disableOriginalConstructor()
            ->getMock();

        $this->consumer->expects($this->any())
            ->method('getConsumerSecret')
            ->will($this->returnValue('Ab456cd983a31232lfdafd'));
        $this->consumer->expects($this->any())
            ->method('getConsumerKey')
            ->will($this->returnValue('CF123BCEFAA0093'));
        $this->access->expects($this->any())
            ->method('getAccessSecret')
            ->will($this->returnValue('bbbc2343fa3e123934'));
        $this->access->expects($this->any())
            ->method('getAccessToken')
            ->will($this->returnValue('bcde32145zr43123'));
    }

    public function tearDown()
    {
        unset($this->consumer);
        unset($this->access);
    }

    /**
     * @test
     * Given a request that doesn't require a callback
     * When the signature is built
     * Then individual components of head should be verifiable
     */
    public function OAuthAuthorizationHeaderNoCallback()
    {
        $header = new OAuthHeader($this->access,$this->consumer);
        $header->setRequestUrl('https://api.twitter.com/1.1/statuses/retweets/12345.json');
        $authHeader = $header->getAuthHeader();
        $this->assertContains('oauth_token="bcde32145zr43123"',$authHeader);
        $this->assertContains('oauth_consumer_key="CF123BCEFAA0093"', $authHeader);
        $this->assertContains('oauth_timestamp="',$authHeader);
        $this->assertContains('oauth_signature_method="HMAC-SHA1"',$authHeader);
        $params = $header->setHeaderInfo();
        $baseString = $header->buildBaseString($params);
        $compositeKey = $header->getCompositeKey();
        $signature = $header->buildSignature($baseString,$compositeKey);
        $this->assertContains('oauth_signature="'.rawurlencode($signature).'"',$authHeader);
        $this->assertContains('oauth_nonce',$authHeader);
        $this->assertContains('oauth_version="1.0"',$authHeader);
    }

    /**
     * @test
     * Given a request that requires a callback
     * When the headers are generated
     * Then the callback should be identifiable in the header
     */
    public function OAuthAuthorizationHeaderCallback()
    {
        $header = new OAuthHeader($this->access,$this->consumer);
        $header->setRequestUrl('https://api.twitter.com/oauth/request_token');
        $header->setCallback('http://example.org/callback');
        $authHeader = $header->getAuthHeader();
        $this->assertContains('oauth_callback="'.rawurlencode('http://example.org/callback').'"',$authHeader);
    }
}