<?php

/**
 * Class NotificationStaffModel
 */
class NotificationStaffModel extends CI_Model
{
    /**
     * NotificationStaffModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $params
     * @return array
     */
    public function pending()
    {

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.type', 'pending')
            ->where('n.status_staff', false)
            ->where('s.staff_id', $this->input->get('staff_id'));

        $this->repository = $this->db->get()->result();

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