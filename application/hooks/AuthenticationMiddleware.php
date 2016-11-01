<?php
use Psecio\Jwt\Jwt;
use Psecio\Jwt\Exception\DecodeException;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Permissions\Acl\Acl;

class AuthenticationMiddleware
{
    /**
     * @var Jwt $jwtService
     */
    private $jwtService;

    /**
     * @var CI_Controller|object
     */
    private $ci;

    /**
     * @var Acl
     */
    private $acl;

    /**
     * @var string
     */
    private $role;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->jwtService = $this->ci->jwt->jwtService;

    }

    public function authentify()
    {
        if ($this->ci->input->get_request_header($this->ci->config->item('jwt')['http_header_name'])) {

            $jwt = $this->ci->input->get_request_header($this->ci->config->item('jwt')['http_header_name']);
            try {
                $claims = $this->jwtService->decode($jwt);
            } catch (DecodeException $e) {
                $this->ci->response(
                    [
                        'status' => false,
                        'expired' => true,
                        'message' => $e->getMessage()
                    ],REST_Controller::HTTP_BAD_REQUEST);
            }

//            $this->checkAudience($claims);
            $this->checkIssuer($claims);
            $this->checkTokenExpiration($claims);

            $this->ci->session->set_userdata((array)$claims);
        }

        $this->routeSecurity();
    }

    /**
     * @param stdClass $claims
     * @throws Exception
     */
    private function checkAudience(\stdClass $claims)
    {
        if ($this->ci->input->get_request_header('Host') !== $claims->aud) {
            $this->ci->response(
                [
                    'status' => false,
                    'expired' => true,
                    'message' => 'audience is invalid'
                ],REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param stdClass $claims
     * @throws Exception
     */
    private function checkIssuer(\stdClass $claims)
    {
        if ($this->ci->config->item('jwt')['issuer'] !== $claims->iss) {
            $this->ci->response(
                [
                    'status' => false,
                    'expired' => true,
                    'message' => 'issuer is invalid'
                ],REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param stdClass $claims
     * @throws Exception
     */
    private function checkTokenExpiration(\stdClass $claims)
    {
        if (time() > $claims->exp) {
            $this->ci->response(
                [
                    'status' => false,
                    'expired' => true,
                    'message' => 'token is expired'
                ],REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    private function initACL()
    {
        $this->acl = new Acl();

        $roleGuest = new Role("GUEST");
        $this->acl->addRole($roleGuest);
        $this->acl->addRole(new Role("OUTLET"), $roleGuest);
        $this->acl->addRole(new Role("ENGINEER"), "OUTLET");
        $this->acl->addRole(new Role("ADMINISTRATOR"), "ENGINEER");

        foreach ($this->ci->config->item('route')["GUEST"] as $key => $value) {
            $this->acl->addResource(new Resource($key));
            $this->acl->allow("GUEST", $key);
        }

        foreach ($this->ci->config->item('route')["ENGINEER"] as $key => $value) {
            $this->acl->addResource(new Resource($key));
            $this->acl->allow("ENGINEER", $key);
        }

        foreach ($this->ci->config->item('route')["OUTLET"] as $key => $value) {
            $this->acl->addResource(new Resource($key));
            $this->acl->allow("OUTLET", $key);
        }

        foreach ($this->ci->config->item('route')["ADMINISTRATOR"] as $key => $value) {
            $this->acl->addResource(new Resource($key));
            $this->acl->allow("ADMINISTRATOR", $key);
        }

    }

    private function routeSecurity()
    {
        if (! array_key_exists($this->ci->uri->uri_string(), $this->ci->router->routes)) {
            $this->ci->response(
                [
                    'status' => false,
                    'message' => 'The uri that you requested is not found'
                ],REST_Controller::HTTP_NOT_FOUND);
        }

        $this->role = $this->ci->session->userdata('role') === null ? "GUEST" :
            $this->ci->session->userdata('role');

        $this->role = "ADMINISTRATOR";
        $this->initACL();

        if (! $this->acl->isAllowed($this->role, $this->ci->uri->uri_string())) {
            $this->ci->response(
                [
                    'status' => false,
                    'message' => 'you are not allowed to access this resource'
                ],REST_Controller::HTTP_METHOD_NOT_ALLOWED);
        }
    }
}
