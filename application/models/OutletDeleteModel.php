<?php

/**
 * Class OutletDeleteModel
 */
class OutletDeleteModel extends CI_Model
{
    /**
     * OutletDeleteModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function remove()
    {
        $this->db->delete('outlet', array('outlet_id' => $this->input->get('outlet_id')));

        return [
            'status' => true
        ];

    }
}