<?php

class StaffUpdateModel extends CI_Model
{

    /**
     * StaffRegisterModel constructor.
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

        $data = [
            'username' => $this->input->post('username'),
            'name' => $this->input->post('name'),
            'group' => $this->input->post('group'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'region' => $this->input->post('region'),
            'note' => $this->input->post('note')
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