## Hapi - Twitter

The Hapi Twitter Library provides all the functionality of the Twitter API in an easy to user interface. The classes are
broken up logically, so there is no confusion.

### Getting started
Getting started is pretty straight-forward, we take the consumer secret and access tokens required to build the OAuth
header:
```php
<?php

$oauthAccess = new OAuth\Access('<insert access_token>','<insert access_secret>');
$oauthConsumer = new OAuth\Consumer('<insert consumer_key>','<insert consumer_secret>');

$oauthHeader = new OAuth\Header($oauthAccess, $oauthConsumer);
/* If the call you are making requires a callback (request_token - for example) */
$oauthHeader->setCallback('http://example.org/callback'); // your application callback url
```
In 4 or 5 lines of code, you have your OAuth header configured and can start making requests!

### Tweets
The Tweet class allows you to send tweets and/or get information on Tweets, so by setting up the headers described
above, setting up the Tweet object is pretty easy!
```php
$tweet = new Tweet($oauthHeader);
```
Once we have our instance we can make the following calls:
```php
$tweet->getRetweets($statusId);
$tweet->tweet(array('status'=>'This call will post a tweet for authorized user'));
$tweet->delete($statusId);
$tweet->retrieve($statusId);
$tweet->search(array('q'=>'searchQuery','count'=>100));
```
### Direct Messages
The DirectMessage class allows you to send, receive and delete direct messages - setting up a DirectMessage instance is
similar to setting up a tweet
```php
$directMessage = new DirectMessage($oauthHeader);
```
Once the instance is ready, the following interface is available:
```php
$directMessage->retrieveAll();
$directMessage->retrieve($id);
$directMessage->retrieveSent();
$directMessage->delete($id);
$directMessage->create(array('user_id'=>$user_id,'screen_name'=>$screen_name,'text'=>$text));
```
### Friendships
The Friendships class allows you to create new friendships (follow) remove existing friendships (unfollow) and get
information about friendships
```php
$friendship = new Friendship($oauthHeader);
```
Once the instance is ready the following interface is available:
```php
//retrieve all the followers that the authenticated user doesn't receive retweets from
$friendship->retrieveNoRetweets(array('stringify_ids'=>true));
//retrieve all users that you follow and follow you optionally filter by user id, screen name
$friendship->retrieveFriends(array(
                                 'user_id'=>'1234',
                                 'screen_name'=>'username',
                                 'cursor' => 1
                                 'stringify_ids' => true,
                                 'count'=>1000
                             ));
//retrieve followers for the provided user (screen_name or user_id)
$friendship->retrieveFollowers(array(
                                   'user_id' => 1234,
                                   'screen_name' => 'username',
                                   'cursor'=>1,
                                   'stringify_ids'=>false,
                                   'count'=>1000
                               ));
//follow a new user by screen name or id and set follow to initiate a notification (boolean)
$friendship->follow(array('user_id'='1234','screen_name'=>'username','follow'=>true));
//unfollow a user by screen name or user id
$friendship->unfollow(array('user_id'=>'1234','screen_name'=>'username'));
```
