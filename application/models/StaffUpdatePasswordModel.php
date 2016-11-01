<?php

/**
 * Class StaffUpdatePasswordModel
 */
class StaffUpdatePasswordModel extends CI_Model
{

    /**
     * StaffUpdatePasswordModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function update()
    {

        $this->repository = $this->db->get_where(
            'staff', array('staff_id' => $this->input->post('staff_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'Data not found'
            ];

        if (! password_verify($this->input->post('password'), $this->repository->password))
            return [
                'status' => false,
                'message' => 'Old password invalid'
            ];

        $data = [
            'password' => password_hash($this->input->post('new_password'), PASSWORD_DEFAULT)
        ];

        $this->db
            ->where('staff_id', $this->input->post('staff_id'))
            ->update('staff', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}