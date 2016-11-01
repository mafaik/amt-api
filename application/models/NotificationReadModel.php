<?php

/**
 * Class NotificationReadModel
 */
class NotificationReadModel extends CI_Model
{

    /**
     * NotificationReadModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function staff()
    {

        $this->repository = $this->db->get_where(
            'notification', array('notification_id' => $this->input->post('notification_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];


        $data = [
            'staff_status' => true
        ];

        $this->db
            ->where('notification_id', $this->input->post('notification_id'))
            ->update('notification', $data);

//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }

    public function outlet()
    {

        $this->repository = $this->db->get_where(
            'notification', array('notification_id' => $this->input->post('notification_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];


        $data = [
            'status_outlet' => true
        ];

        $this->db
            ->where('notification_id', $this->input->post('notification_id'))
            ->update('notification', $data);

//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }

    public function outlet_all()
    {

        $now = date('Y-m-d H:i:s');

        $outlet_id = $this->input->post('outlet_id');

        $query = "UPDATE notification n
                    LEFT JOIN issue i ON i.issue_id = n.id
                    LEFT JOIN outlet o ON o.outlet_id = i.outlet_id
                    SET n.status_outlet = true
                    WHERE n.timestamp <= '$now' AND o.outlet_id = $outlet_id AND n.status_outlet = false";

        $this->db->query($query);

        return [
            'status' => true
        ];
    }

    public function administrator()
    {

        $this->repository = $this->db->get_where(
            'notification', array('notification_id' => $this->input->post('notification_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'data tidak ditemukan'
            ];


        $data = [
            'administrator_status' => true
        ];

        $this->db
            ->where('notification_id', $this->input->post('notification_id'))
            ->update('notification', $data);

//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }

    public function administrator_all()
    {

        $now = date('Y-m-d H:i:s');

        $outlet_id = $this->input->post('outlet_id');

        $query = "UPDATE notification n
                    LEFT JOIN issue i ON i.issue_id = n.id
                    LEFT JOIN outlet o ON o.outlet_id = i.outlet_id
                    SET n.status_administrator = true
                    WHERE n.timestamp <= '$now' AND n.status_administrator = false";

        $this->db->query($query);

        return [
            'status' => true
        ];
    }
}