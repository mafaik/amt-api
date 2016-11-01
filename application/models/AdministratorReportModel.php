<?php

/**
 * Class AdministratorReportModel
 */
class AdministratorReportModel extends CI_Model
{
    /**
     * AdministratorReportModel constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->limit = $this->input->get('per_page') == null ? 10 : $this->input->get('per_page') ;

        $this->page = $this->input->get('page') == null ? 0 : $this->input->get('page') ;

        $this->offset = $this->input->get('page') == null ? 0 : ($this->page) * $this->limit;
    }

    /**
     * @param $params
     * @return array
     */
    public function all()
    {
        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left');

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        if ($this->input->get('staff_name') !== null && $this->input->get('staff_name') !== '')
            $this->db->like('s.name', $this->input->get('staff_name'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->limit($this->limit, $this->offset);

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        if ($this->input->get('staff_name') !== null && $this->input->get('staff_name') !== '')
            $this->db->like('s.name', $this->input->get('staff_name'), 'both');

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

    /**
     * @param $params
     * @return array
     */
    public function queue()
    {
        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.status', "open");

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        if ($this->input->get('staff_name') !== null && $this->input->get('staff_name') !== '')
            $this->db->like('s.name', $this->input->get('staff_name'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.status', "open")
            ->limit($this->limit, $this->offset);

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        if ($this->input->get('staff_name') !== null && $this->input->get('staff_name') !== '')
            $this->db->like('s.name', $this->input->get('staff_name'), 'both');

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

    /**
     * @param $params
     * @return array
     */
    public function pending()
    {
        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->where('i.status', "pending");

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->where('i.status', "pending")
            ->limit($this->limit, $this->offset);

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
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

    /**
     * @param $params
     * @return array
     */
    public function progress()
    {
        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
           ->join('staff s', 's.staff_id = i.staff_id', 'left')
           ->where('i.staff_id IS NOT NULL', null, false)
            ->where('i.status', "progress");

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        if ($this->input->get('staff_name') !== null && $this->input->get('staff_name') !== '')
            $this->db->like('s.name', $this->input->get('staff_name'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
           ->join('staff s', 's.staff_id = i.staff_id', 'left')
           ->where('i.staff_id IS NOT NULL', null, false)
            ->where('i.status', "progress")
            ->limit($this->limit, $this->offset);

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        if ($this->input->get('staff_name') !== null && $this->input->get('staff_name') !== '')
            $this->db->like('s.name', $this->input->get('staff_name'), 'both');

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

    /**
     * @return array
     */
    public function history()
    {

        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.status', "done");

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        if ($this->input->get('staff_name') !== null && $this->input->get('staff_name') !== '')
            $this->db->like('s.name', $this->input->get('staff_name'), 'both');

        $total_record = $this->db->get()->num_rows();
        $total_page = ceil($total_record / $this->limit);

        $this->db->flush_cache();

        $this->db
            ->select('*, o.name as outlet_name')
            ->from('issue i')
            ->join('outlet o', 'o.outlet_id = i.outlet_id', 'left')
            ->join('staff s', 's.staff_id = i.staff_id', 'left')
            ->where('i.status', "done")
            ->limit($this->limit, $this->offset);

        if ($this->input->get('issue_id') !== null && $this->input->get('issue_id') !== '')
            $this->db->where('i.issue_id', $this->input->get('issue_id'));

        if ($this->input->get('outlet_name') !== null && $this->input->get('outlet_name') !== '')
            $this->db->like('o.name', $this->input->get('outlet_name'), 'both');

        if ($this->input->get('subject') !== null && $this->input->get('subject') !== '')
            $this->db->like('i.subject', $this->input->get('subject'), 'both');

        if ($this->input->get('issue') !== null && $this->input->get('issue') !== '')
            $this->db->like('i.issue', $this->input->get('issue'), 'both');

        if ($this->input->get('staff_name') !== null && $this->input->get('staff_name') !== '')
            $this->db->like('s.name', $this->input->get('staff_name'), 'both');

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