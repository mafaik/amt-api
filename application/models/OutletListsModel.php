<?php

/**
 * Class OutletListsModel
 */
class OutletListsModel extends CI_Model
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
    public function index()
    {
        $limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $offset = $this->input->get('page') == null ? 0 : ($page) * $limit;

        $this->db
            ->select('s.staff_id as staff_id, s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.outlet_id as outlet_id, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note')
            ->from('outlet o')
            ->join('staff s', 's.staff_id = o.staff_id', 'left');

        if ($this->input->get('outlet') !== null)
            $this->db->like('o.name', $this->input->get('outlet'), 'both');

        if ($this->input->get('staff') !== null)
            $this->db->like('s.name', $this->input->get('staff'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $limit);

        $this->db->flush_cache();

        $this->db
            ->select('s.staff_id as staff_id, s.username as staff_username, s.date_registered as staff_date_registered, s.group as staff_group, s.name as staff_name, s.address as staff_address, s.city as staff_city, s.region as staff_region, s.note as staff_note, o.outlet_id as outlet_id, o.username as outlet_username, o.date_registered as outlet_date_registered, o.name as outlet_name, o.address as outlet_address, o.city as outlet_city, o.region as outlet_region, o.contact as outlet_contact, o.note as outlet_note')
            ->from('outlet o')
            ->join('staff s', 's.staff_id = o.staff_id', 'left');

        if ($this->input->get('outlet') !== '')
            $this->db->like('o.name', $this->input->get('outlet'), 'both');

        if ($this->input->get('staff') !== '')
            $this->db->like('s.name', $this->input->get('staff'), 'both');

        $this->db->limit($limit, $offset);

        $this->repository = $this->db->get()->result();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'Data not found'
            ];

        $pagination = [
            'total_record' => $total_record,
            'total_page' => $total_page,
            'page' => $page,
            'per_page' => $limit
        ];

        return [
            'status' => true,
            'pagination' => $pagination,
            'data' => (array) $this->repository
        ];

    }
}