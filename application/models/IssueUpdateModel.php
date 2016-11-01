<?php

/**
 * Class IssueUpdateModel
 */
class IssueUpdateModel extends CI_Model
{

    /**
     * IssueUpdateModel constructor.
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

        if($this->repository->status === true)
            return [
                'status' => false,
                'message' => 'Data cannot be changed'
            ];

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

        $data = [
            'subject' => $this->input->post('subject'),
            'issue' => $this->input->post('issue'),
            'attachment' => implode(";", $uploadData)
        ];

        $this->db
            ->where('issue_id', $this->input->post('issue_id'))
            ->update('issue', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }

    public function updateStaff()
    {
        
        $this->repository = $this->db->get_where(
            'issue', array('issue_id' => $this->input->post('issue_id')))->row();

        if($this->repository === null)
            return [
                'status' => false,
                'message' => 'Data not found'
            ];

        if($this->repository->status != "pending")
            return [
                'status' => false,
                'message' => 'Data cannot be changed'
            ];

        $this->staff_repository = $this->db->get_where(
            'staff', array('staff_id' => $this->input->post('staff_id')))->row();

        if($this->staff_repository === null)
            return [
                'status' => false,
                'message' => 'Data not found'
            ];

        $this->db->where("(status='open' OR status='progress') AND staff_id=".$this->staff_repository->staff_id);
        $this->is_available_staff_repository = $this->db->get('issue')->result();
        /*$this->is_available_staff_repository = $this->db->get_where(
            'issue',
            array(
                'staff_id' => $this->staff_repository->staff_id,
                'status' => 'open'
            ))->result();*/
        
        if ($this->is_available_staff_repository && count($this->is_available_staff_repository) > 0)
            return [
                'status' => false,
                'message' => 'Technician not available'
            ];

        $data = [
            'staff_id' => $this->input->post('staff_id'),
            'status'    => 'open'
        ];

        $this->db
            ->where('issue_id', $this->input->post('issue_id'))
            ->update('issue', $data);

//        if ($this->db->affected_rows() > 0)
            return [
                'status' => true
            ];
    }
}