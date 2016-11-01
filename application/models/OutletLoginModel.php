<?php

use Psecio\Jwt\Jwt;

/**
 * Class OutletLoginModel
 */
class OutletLoginModel extends CI_Model
{
    /**
     * @var Jwt
     */
    private $jwtService;

    /**
     * OutletLoginModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('jwt');
        $this->jwtService = $this->jwt->jwtService;
    }

    /**
     * @param $params
     * @return array
     */
    public function login()
    {
        $this->repository = $this->db->get_where(
            'outlet', array('username' => $this->input->post('username')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'Data not found'
            ];

        if (! password_verify($this->input->post('password'), $this->repository->password))
            return [
                'status' => false,
                'message' => 'Password invalid'
            ];

        $this->jwtService
            ->audience($this->input->post('ip'))
            ->issuedAt(time())
            ->expireTime(time()+86400)
            ->jwtId($this->repository->outlet_id)
            ->custom([
                'outlet_id' => $this->repository->outlet_id,
                'name' => $this->repository->name,
                'role' => strtoupper("outlet"),
            ]);

        $jwtToken = $this->jwtService->encode();
        return [
            'status' => true,
            'data' => [
                'outlet_id' => $this->repository->outlet_id,
                'name' => $this->repository->name,
                'role' => strtoupper("outlet"),
                'token' => $jwtToken
            ]
        ];

    }
}