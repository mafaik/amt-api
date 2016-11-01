<?php

/**
 * Class StaffReportModel
 */
class StaffReportModel extends CI_Model
{
    /**
     * StaffReportModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $this->page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $this->offset = $this->input->get('page') == null ? 0 : ($this->page - 1) * $this->limit;
    }


    public function open()
    {
        $this->input->get('staff_id');

        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.staff_id', $this->input->get('staff_id'))
            ->where('i.status', 'open');

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

    public function progress()
    {
        $this->input->get('staff_id');

        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.staff_id', $this->input->get('staff_id'))
            ->where('i.status', 'progress');

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

    /**
     * @param $params
     * @return array
     */
    public function pending()
    {
        $this->input->get('staff_id');

        $this->db
            ->select('*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 'staff_id = i.staff_id', 'left')
            ->where('i.staff_id', $this->input->get('staff_id'))
            ->where('i.status', false);

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

    /**
     * @return array
     */
    public function history()
    {
        // $this->input->get('outlet_id');

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.staff_id', $this->input->get('staff_id'))
            ->where('i.status', 'done');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.staff_id', $this->input->get('staff_id'))
            ->where('i.status', 'done')
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'Data not found'
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
}