<?php

/**
 * Class StaffListsModel
 */
class StaffListsModel extends CI_Model
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

        $query_where = '';
        $query_name = '';
        $query_status = '';
        $staff_group = 'engineer';
        if (($this->input->get('group') !== '' && $this->input->get('group') !== null) && $this->input->get('group') == 'administrator') {
            $staff_group = 'administrator';
        }

        $query_where = "where q.group = '$staff_group'";

        if (($this->input->get('name') !== '' || $this->input->get('status') !== '') && ($this->input->get('name') !== null || $this->input->get('status') !== null)) {
            
            if ($this->input->get('name') !== '' && $this->input->get('name') !== null)
                $query_name = " q.name like '%". $this->input->get('name') ."%'";

            if ($this->input->get('status') !== '' && $this->input->get('status') !== null)
                $query_status = " q.status_available = '". $this->input->get('status') ."'";

            if ($query_name !== '')
                $query_where .= ' and '.$query_name;

            if ($query_status !== '')
                $query_where .= ' and '.$query_status;

            if ($query_name !== '' && $query_status !== '')
                $query_where .= ' and '.$query_name . ' and ' . $query_status;
        }

        $all_query = $this->db->query("select q.* from ( select s.*, (select o.outlet_id from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_id, (select o.name from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_name, if(( select count(*) from issue i where  i.staff_id = s.staff_id and i.status = 'open') > 0, 'on', 'off' ) as status_available from staff s ) as q $query_where");

        $total_record = $all_query->num_rows();
        $total_page = ceil($total_record / $limit);

        $query = $this->db->query("select q.* from ( select s.*, (select o.outlet_id from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_id, (select o.name from issue i join outlet o on o.outlet_id = i.outlet_id where i.staff_id = s.staff_id and i.status = 'open') as outlet_name, if(( select count(*) from issue i where  i.staff_id = s.staff_id and i.status = 'open') > 0, 'on', 'off' ) as status_available from staff s ) as q $query_where limit $offset, $limit");


        $this->repository = $query->result();

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

    /**
     * @param $params
     * @return array
     */
    public function available()
    {

        $this->db
            ->select('s.*')
            ->from('staff s')
            ->join('issue i', 'i.staff_id = s.staff_id', 'left')
            ->where('i.status', "open")
            ->where('i.staff_is IS NULL', null, false)
            ->

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
