<?php

/**
 * Class IssueInsertModel
 */
class IssueInsertModel extends CI_Model
{

    /**
     * IssueInsertModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function send_gcm( $message, $staff_id )
    {
        //GCM
        $this->load->library('gcm');

        $this->gcm->setMessage($message);

        $this->staff_repository = $this->db->get_where(
            'staff', array('staff_id' => $staff_id))->row();

        $gcm_token = $this->staff_repository->gcm_token;

        $this->gcm->addRecepient($gcm_token);

        $this->gcm->setTtl(false);

        $this->gcm->send();

        return $this->gcm->status;
    }

    public function save()
    {
        $this->outlet_repository = $this->db->get_where(
            'outlet', array('outlet_id' => $this->input->post('outlet_id')))->row();

        if($this->outlet_repository === null)
            return [
                'status' => false,
                'message' => 'Outlet data not found'
            ];

        $this->is_available_staff_repository = $this->db->get_where(
            'issue',
            array(
                'staff_id' => $this->outlet_repository->staff_id,
                'status' => 'open'
            ));

        $staff_id = $this->is_available_staff_repository->num_rows() > 0 ? null : $this->outlet_repository->staff_id;

        $filename = null;
        $uploadData = array();

        if(!empty($_FILES['filename']['name'])) {
            $filesCount = count($_FILES['filename']['name']);
            $files = $_FILES['filename'];
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['filename']['name'] = $files['name'][$i];
                $_FILES['filename']['type'] = $files['type'][$i];
                $_FILES['filename']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['filename']['error'] = $files['error'][$i];
                $_FILES['filename']['size'] = $files['size'][$i];

                if (isset($_FILES['filename']['size']) && ($_FILES['filename']['size'] > 0)) {
                    $uploadPath = './uploads/issue';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('filename') === false )
                        return [
                            'status' => false,
                            'message' => $this->upload->display_errors()
                        ];

                    $fileData = $this->upload->data();
                    $uploadData[$i] = $fileData['file_name'];
                }
            }
        }


        $status = $staff_id === null ? "pending" : "open";
        $data = [
            'staff_id' => $staff_id,
            'subject' => $this->input->post('subject'),
            'issue' => $this->input->post('issue'),
            'outlet_id' => $this->input->post('outlet_id'),
            'attachment' => implode(";", $uploadData),
            'status' => $status,
        ];

        $this->db->insert('issue', $data);

        if ($staff_id === null) {
            $notif = [
                'type' => 'pending',
                'id' => $this->db->insert_id(),
                'status_outlet' => false,
                'status_staff' => false,
                'status_administrator' => false
            ];

            $this->db->insert('notification', $notif);
        }

        if( $status === 'open' )
        {
            //GCM

            $message = 'Open Issue : '.$this->input->post('subject');

            $this->send_gcm($message, $staff_id);

        }

//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }

    public function recurrence_weekly()
    {
        $this->outlet_repository = $this->db->get_where(
            'outlet', array('outlet_id' => $this->input->post('outlet_id')))->row();

        if($this->outlet_repository === null)
            return [
                'status' => false,
                'message' => 'Outlet data not found'
            ];

        $this->is_available_staff_repository = $this->db->get_where(
            'issue',
            array(
                'staff_id' => $this->outlet_repository->staff_id,
                'status' => 'open'
            ));

        $staff_id = $this->is_available_staff_repository->num_rows() > 0 ? null : $this->outlet_repository->staff_id;

        $filename = null;

        if(!empty($_FILES['filename']['name'])) {
            $filesCount = count($_FILES['filename']['name']);
            $files = $_FILES['filename'];
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['filename']['name'] = $files['name'][$i];
                $_FILES['filename']['type'] = $files['type'][$i];
                $_FILES['filename']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['filename']['error'] = $files['error'][$i];
                $_FILES['filename']['size'] = $files['size'][$i];

                if (isset($_FILES['filename']['size']) && ($_FILES['filename']['size'] > 0)) {
                    $uploadPath = './uploads/issue';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('filename') === false )
                        return [
                            'status' => false,
                            'message' => $this->upload->display_errors()
                        ];

                    $fileData = $this->upload->data();
                    $uploadData[$i] = $fileData['file_name'];
                }
            }
        }

        $status = $staff_id === null ? "pending" : "open";
        $endDate = date('Y-m-d', strtotime("+".$this->input->post('interval')."month"));

        $rrule = new \RRule\RRule([
            'FREQ' => 'WEEKLY',
            'BYDAY' => $this->input->post('day'),
            'DTSTART' => date('Y-m-d'),
            'UNTIL' => $endDate
        ]);

        foreach ( $rrule as $occurrence ) {
            $data = [
                'staff_id' => $staff_id,
                'date_request' => $occurrence->format('Y-m-d h:i:s'),
                'subject' => $this->input->post('subject'),
                'issue' => $this->input->post('issue'),
                'outlet_id' => $this->input->post('outlet_id'),
                'attachment' => implode(";", $uploadData),
                'status' => $status,
            ];

            $this->db->insert('issue', $data);

            if ($staff_id === null) {
                $notif = [
                    'type' => 'pending',
                    'id' => $this->db->insert_id(),
                    'status_outlet' => false,
                    'status_staff' => false,
                    'status_administrator' => false
                ];

                $this->db->insert('notification', $notif);
            }
        }


//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }

    public function recurrence_monthly()
    {
        $this->outlet_repository = $this->db->get_where(
            'outlet', array('outlet_id' => $this->input->post('outlet_id')))->row();

        if($this->outlet_repository === null)
            return [
                'status' => false,
                'message' => 'Outlet data not found'
            ];

        $this->is_available_staff_repository = $this->db->get_where(
            'issue',
            array(
                'staff_id' => $this->outlet_repository->staff_id,
                'status' => 'open'
            ));

        $staff_id = $this->is_available_staff_repository->num_rows() > 0 ? null : $this->outlet_repository->staff_id;

        $filename = null;

        if(!empty($_FILES['filename']['name'])) {
            $filesCount = count($_FILES['filename']['name']);
            $files = $_FILES['filename'];
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['filename']['name'] = $files['name'][$i];
                $_FILES['filename']['type'] = $files['type'][$i];
                $_FILES['filename']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['filename']['error'] = $files['error'][$i];
                $_FILES['filename']['size'] = $files['size'][$i];

                if (isset($_FILES['filename']['size']) && ($_FILES['filename']['size'] > 0)) {
                    $uploadPath = './uploads/issue';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2048';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('filename') === false )
                        return [
                            'status' => false,
                            'message' => $this->upload->display_errors()
                        ];

                    $fileData = $this->upload->data();
                    $uploadData[$i] = $fileData['file_name'];
                }
            }
        }

        $status = $staff_id === null ? "pending" : "open";
        $endDate = date('Y-m-d', strtotime("+".$this->input->post('interval')."month"));

        $rrule = new \RRule\RRule([
            'FREQ' => 'MONTHLY',
            'BYMONTHDAY' => $this->input->post('day'),
            'DTSTART' => date('Y-m-d'),
            'UNTIL' => $endDate
        ]);

        foreach ( $rrule as $occurrence ) {
            $data = [
                'staff_id' => $staff_id,
                'date_request' => $occurrence->format('Y-m-d h:i:s'),
                'subject' => $this->input->post('subject'),
                'issue' => $this->input->post('issue'),
                'outlet_id' => $this->input->post('outlet_id'),
                'attachment' => implode(";", $uploadData),
                'status' => $status,
            ];

            $this->db->insert('issue', $data);

            if ($staff_id === null) {
                $notif = [
                    'type' => 'pending',
                    'id' => $this->db->insert_id(),
                    'status_outlet' => false,
                    'status_staff' => false,
                    'status_administrator' => false
                ];

                $this->db->insert('notification', $notif);
            }
        }


//        if ($this->db->affected_rows() > 0)
        return [
            'status' => true
        ];
    }
}