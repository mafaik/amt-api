<?php

/**
 * Class OutletUpdatePasswordModel
 */
class OutletUpdatePasswordModel extends CI_Model
{

    /**
     * OutletUpdatePasswordModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function update()
    {

        $this->repository = $this->db->get_where(
            'outlet', array('outlet_id' => $this->input->post('outlet_id')))->row();

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

        $data = [
            'password' => password_hash($this->input->post('new_password'), PASSWORD_DEFAULT)
        ];

        $this->db
            ->where('outlet_id', $this->input->post('outlet_id'))
            ->update('outlet', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}