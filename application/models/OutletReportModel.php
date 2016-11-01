<?php

/**
 * Class OutletReportModel
 */
class OutletReportModel extends CI_Model
{
    /**
     * OutletReportModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $this->page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $this->offset = $this->input->get('page') == null ? 0 : ($this->page) * $this->limit;

        $this->outlet_id = $this->input->get('outlet_id');
    }

    /**
     * @param $params
     * @return array
     */
    public function all()
    {
        $this->input->get('outlet_id');

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->outlet_id);

        if ($this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->input->get('outlet_id'))
            ->limit($this->limit, $this->offset);

        if ($this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

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

    public function open()
    {
        $this->input->get('outlet_id');

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->outlet_id)
            ->where('i.status', "open");

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->input->get('outlet_id'))
            ->where('i.status', "open")
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if ($this->repository === null)
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
            'data' => (array)$this->repository
        ];

    }

    public function pending()
    {
        $this->input->get('outlet_id');

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->outlet_id)
            ->where('i.status', "pending");

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->input->get('outlet_id'))
            ->where('i.status', "pending")
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if ($this->repository === null)
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
            'data' => (array)$this->repository
        ];

    }

    public function progress()
    {
        $this->input->get('outlet_id');

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->outlet_id)
            ->where('i.status', "progress");

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->input->get('outlet_id'))
            ->where('i.status', "progress")
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if ($this->repository === null)
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
            'data' => (array)$this->repository
        ];

    }

    public function done()
    {
        $this->input->get('outlet_id');

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->outlet_id)
            ->where('i.status', "done");

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note, i.*')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
//            ->join('building b', 'b.building_id = o.building_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.outlet_id', $this->input->get('outlet_id'))
            ->where('i.status', "done")
            ->limit($this->limit, $this->offset);

        $this->repository = $this->db->get()->result();

        if ($this->repository === null)
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
            'data' => (array)$this->repository
        ];

    }
}