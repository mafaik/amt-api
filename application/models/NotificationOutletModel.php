<?php

/**
 * Class NotificationOutletModel
 */
class NotificationOutletModel extends CI_Model
{
    /**
     * NotificationOutletModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $this->page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $this->offset = $this->page;

    }

    /**
     * @param $params
     * @return array
     */
    public function all()
    {

        $now = date('Y-m-d H:i:s');

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.status_outlet', false)
            ->where('n.timestamp <=', $now)
            ->where('o.outlet_id', $this->input->get('outlet_id'))
            ->order_by('n.timestamp','DESC');

        $this->repository = $this->db->get()->result();

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

    /**
     * @param $params
     * @return array
     */
    public function all_pagination()
    {

        $now = date('Y-m-d H:i:s');

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('n.timestamp <=', $now)
            ->where('o.outlet_id', $this->input->get('outlet_id'));

        if ($this->input->get('issue_id') !== '')
            $this->db->where('n.id', $this->input->get('issue_id'));

        if ($this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('n.timestamp <=', $now)
            ->where('o.outlet_id', $this->input->get('outlet_id'))
            ->order_by('n.timestamp','DESC')
            ->limit($this->limit, $this->offset);

        if ($this->input->get('issue_id') !== '')
            $this->db->where('n.id', $this->input->get('issue_id'));

        if ($this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];

        $pagination = [
            'total_record' => $total_record,
            'total_page' => $total_page,
            'page' => $this->page,
            'per_page' => $this->limit
        ];

        return [
            'status' => true,
            'pagination' => $pagination,
            'data' => (array) $this->repository
        ];
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
            ->join('staff s', 's.staff_id = o.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.type', 'pending')
            ->where('n.status_outlet', false)
            ->where('o.outlet_id', $this->input->get('outlet_id'));

        $this->repository = $this->db->get()->result();

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

    /**
     * @param $params
     * @return array
     */
    public function checkin()
    {

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = o.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.type', 'checkin')
            ->where('n.status_outlet', false)
            ->where('o.outlet_id', $this->input->get('outlet_id'));

        $this->repository = $this->db->get()->result();

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

    /**
     * @param $params
     * @return array
     */
    public function checkout()
    {

        $this->db
            ->select('n.*, i.subject, o.name  as outlet_name, s.name as staff_name')
            ->from('notification n')
            ->join('issue i', 'i.issue_id = n.id', 'left')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = o.staff_id', 'left')
//            ->where('i.staff_id IS NULL', null, false)
            ->where('n.type', 'checkout')
            ->where('n.status_outlet', false)
            ->where('o.outlet_id', $this->input->get('outlet_id'));

        $this->repository = $this->db->get()->result();

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