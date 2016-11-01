<?php

/**
 * Class StaffUpdateGcmTokenModel
 */
class StaffUpdateGcmTokenModel extends CI_Model
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
                'message' => 'data tidak ditemukan'
            ];

        $data = [
            'gcm_token' => $this->input->post('gcm_token')
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