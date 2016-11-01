<?php

/**
 * Class OutletInsertModel
 */
class OutletInsertModel extends CI_Model
{

    /**
     * OutletInsertModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function save()
    {
        $this->staff_repository = $this->db->get_where(
            'staff', array('staff_id' => $this->input->post('staff_id')))->row();

        if($this->staff_repository === null)
            return [
                'status' => false,
                'message' => 'Technician data not found'
            ];

//        $this->building_repository = $this->db->get_where(
//            'building', array('building_id' => $this->input->post('building_id')))->row();
//
//        if($this->building_repository === null)
//            return [
//                'status' => false,
//                'message' => 'data building tidak ditemukan'
//            ];

        $data = [
            'staff_id' => $this->input->post('staff_id'),
//            'building_id' => $this->input->post('building_id'),
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'name' => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'region' => $this->input->post('region'),
            'contact' => $this->input->post('contact'),
            'note' => $this->input->post('note')
        ];

        $this->db->insert('outlet', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}