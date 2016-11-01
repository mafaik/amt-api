<?php

/**
 * Class BuildingDetailModel
 */
class BuildingDetailModel extends CI_Model
{
    /**
     * BuildingDetailModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function detail()
    {
        $this->repository = $this->db->get_where(
            'building', array('building_id' => $this->input->post('building_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        return [
            'status' => true,
            'data' => (array) $this->repository
        ];

    }
}