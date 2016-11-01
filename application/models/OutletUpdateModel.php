<?php

/**
 * Class OutletUpdateModel
 */
class OutletUpdateModel extends CI_Model
{

    /**
     * OutletUpdateModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function update()
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

        $this->repository = $this->db->get_where(
            'outlet', array('outlet_id' => $this->input->post('outlet_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'Outlet data not found'
            ];

        $data = [
            'staff_id' => $this->input->post('staff_id'),
//            'building_id' => $this->input->post('building_id'),
            'username' => $this->input->post('username'),
            'name' => $this->input->post('name'),
            'contact' => $this->input->post('contact'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'region' => $this->input->post('region'),
            'note' => $this->input->post('note')
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