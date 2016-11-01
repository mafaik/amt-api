<?php

use Psecio\Jwt\Jwt;

/**
 * Class StaffLoginModel
 */
class StaffLoginModel extends CI_Model
{
    /**
     * @var Jwt
     */
    private $jwtService;

    /**
     * LoginModel constructor.
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
            'staff', array('username' => $this->input->post('username')))->row();

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
            ->jwtId($this->repository->staff_id)
            ->custom([
                'staff_id' => $this->repository->staff_id,
                'group' => $this->repository->group,
                'name' => $this->repository->name,
                'role' => strtoupper($this->repository->group),
            ]);

        $jwtToken = $this->jwtService->encode();
        return [
            'status' => true,
            'data' => [
                'staff_id' => $this->repository->staff_id,
                'group' => $this->repository->group,
                'name' => $this->repository->name,
                'role' => strtoupper($this->repository->group),
                'token' => $jwtToken
            ]
        ];

    }
}