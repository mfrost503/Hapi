<?php
namespace Hapi\Request;

interface RequestInterface
{
    public function get($uri, $params = array());
    public function post($uri, $postFields);
}
