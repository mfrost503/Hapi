<?php
namespace Hapi\Twitter;

class User extends Twitter
{
    public function retrieveSettings()
    {
        $response = $this->get('account/settings.json');
        return $response;
    }

    public function verifyCredentials(Array $params)
    {
        $response = $this->get('account/verify_credentials.json',$params);
        return $response;
    }

    public function updateProfile(Array $params)
    {
        $response = $this->post('account/settings.json',$params);
        return $response;
    }
}