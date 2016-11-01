<?php

/**
 * Class BuildingListsModel
 */
class BuildingListsModel extends CI_Model
{
    /**
     * BuildingListsModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function index()
    {
        $this->repository = $this->db->get_where('building')->result();

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