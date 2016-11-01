<?php

/**
 * Class IssueProgressModel
 */
class IssueProgressModel extends CI_Model
{

    /**
     * IssueDoneModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function update()
    {

        $this->repository = $this->db->get_where(
            'issue', array('issue_id' => $this->input->post('issue_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'Data not found'
            ];

        if($this->repository->status != 'open')
            return [
                'status' => false,
                'message' => 'Data cannot be changed'
            ];


        $data = [
            'date_checkin' => date('Y-m-d h:i:s'),
            'status' => 'progress'
        ];

        $this->db
            ->where('issue_id', $this->input->post('issue_id'))
            ->update('issue', $data);

        $notif = [
            'type' => 'checkin',
            'id' => $this->input->post('issue_id'),
            'status_outlet' => false,
            'status_staff' => true,
            'status_administrator' => false
        ];

        $this->db->insert('notification', $notif);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}