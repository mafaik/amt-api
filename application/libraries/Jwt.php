<?php

class Jwt
{
    public $jwtService;

    public function __construct()
    {
        $ci = & get_instance();

        $header = new \Psecio\Jwt\Header($ci->config->item('jwt')['key']);
        $this->jwtService = new \Psecio\Jwt\Jwt($header);
        $this->jwtService
            ->issuer($ci->config->item('jwt')['issuer']);
    }
}