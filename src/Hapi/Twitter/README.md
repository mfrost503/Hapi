## Hapi - Twitter

The Hapi Twitter Library provides all the functionality of the Twitter API in an easy to user interface. The classes are
broken up logically, so there is no confusion.

### Getting started
Getting started is pretty straight-forward, we take the consumer secret and access tokens required to build the OAuth
header:

    ```php
    namespace Hapi\Twitter;

    $oauthAccess = new OAuthAccess('<insert access_token>','<insert access_secret>');
    $oauthConsumer = new OAuthConsumer('<insert consumer_key>','<insert consumer_secret>');

    $oauthHeader = new OAuthHeader($oauthAccess, $oauthConsumer);
    /* If the call you are making requires a callback (request_token - for example) */
    $oauthHeader->setCallback('http://example.org/callback'); // your application callback url
    ```
In 4 or 5 lines of code, you have your OAuth header configured and can start making requests!

### Tweets
The Tweet class allows you to send tweets and/or get information on Tweets, so by setting up the headers described
above, setting up the Tweet object is pretty easy!
$tweet = new Tweet($oauthHeader);
Once we have our instance we can make the following calls:

    ```php
    //getRetweets
    $tweet->getRetweets($statusId);
    //tweet
    $tweet->tweet(array('status'=>'This call will post a tweet for authorized user'));
    //delete
    $tweet->delete($statusId);
    retrieve
    $tweet->retrieve($statusId);
    //search
    $tweet->search(array('q'=>'searchQuery','count'=>100));
    ```
