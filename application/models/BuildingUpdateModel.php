<?php

/**
 * Class BuildingUpdateModel
 */
class BuildingUpdateModel extends CI_Model
{

    /**
     * BuildingUpdateModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function save()
    {
        $this->repository = $this->db->get_where(
            'building', array('building_id' => $this->input->post('building_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $data = [
            'name' => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'region' => $this->input->post('region')
        ];

        $this->db
            ->where('building_id', $this->input->post('building_id'))
            ->update('building', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}