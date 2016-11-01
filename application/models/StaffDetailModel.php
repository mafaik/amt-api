<?php
/**
 * Class StaffDetailModel
 */
class StaffDetailModel extends CI_Model
{
    /**
     * StaffDetailModel constructor.
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
            'staff', array('staff_id' => $this->input->get('staff_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'Data not found'
            ];

        return [
            'status' => true,
            'data' => (array) $this->repository
        ];

    }
}