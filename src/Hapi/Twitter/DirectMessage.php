<?php
namespace Hapi\Twitter;

class DirectMessage extends Twitter
{
    protected $header;

    public function __construct(OAuthHeader $header)
    {
        $this->header = $header;
    }

    public function retrieveAll()
    {
        $response = $this->get('direct_messages.json');
        return $response;
    }

    public function retrieveSent()
    {
        $response = $this->get('direct_messages/sent.json');
        return $response;
    }

    public function retrieve($id)
    {
        $response = $this->get('direct_messages/show/' . $id . '.json');
        return $response;
    }

    public function delete($id)
    {
        $response = $this->post('direct_messages/destroy.json',array('id'=>$id));
        return $response;
    }

    public function create($messageData)
    {
        if(!isset($messageData['user_id']) && !isset($messageData['screen_name'])){
            throw new Exceptions\DirectMessageException("You must provide a user id or screen name");
        }
        if(!isset($messageData['text']) && empty($messageData['text'])) {
            throw new Exceptions\DirectMessageException("Message text cannot be empty");
        }
        $response = $this->post('direct_messages/new.json',$messageData);
        return $response;
    }
}