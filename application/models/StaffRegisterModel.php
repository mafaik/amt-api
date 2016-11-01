<?php

class StaffRegisterModel extends CI_Model
{

    /**
     * StaffRegisterModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function save()
    {
        $data = [
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'name' => $this->input->post('name'),
            'group' => $this->input->post('group'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'region' => $this->input->post('region'),
            'note' => $this->input->post('note')
        ];

        $this->db->insert('staff', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}