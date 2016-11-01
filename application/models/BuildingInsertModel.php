<?php

/**
 * Class BuildingInsertModel
 */
class BuildingInsertModel extends CI_Model
{

    /**
     * BuildingInsertModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function save()
    {
        $data = [
            'name' => $this->input->post('name'),
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'region' => $this->input->post('region')
        ];

        $this->db->insert('building', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}