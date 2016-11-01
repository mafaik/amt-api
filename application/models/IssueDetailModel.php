<?php

/**
 * Class IssueDetailModel
 */
class IssueDetailModel extends CI_Model
{
    /**
     * IssueDetailModel constructor.
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
        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.issue_id', $this->input->get('issue_id'));

        $this->repository = $this->db->get()->row();

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