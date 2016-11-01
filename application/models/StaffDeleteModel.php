<?php

/**
 * Class StaffDeleteModel
 */
class StaffDeleteModel extends CI_Model
{
    /**
     * StaffDeleteModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function delete()
    {
        $this->db->delete('staff', array('staff_id' => $this->input->get('staff_id')));

        return [
            'status' => true
        ];

    }
}