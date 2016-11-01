<?php

/**
 * Class IssueDoneModel
 */
class IssueDoneModel extends CI_Model
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
                'message' => 'data tidak ditemukan'
            ];

        if($this->repository->status != 'progress')
            return [
                'status' => false,
                'message' => 'data tidak dapat diubah'
            ];

        
        /*
        $filename = null;

        if (isset($_FILES['filename']['size']) && ($_FILES['filename']['size'] > 0)) {
            $upload_path = './uploads/issue';

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            //$config['max_width'] = '1024';
            //$config['max_height'] = '768';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('filename') === false)
                return [
                    'status' => false,
                    'message' => $this->upload->display_errors()
                ];

            $filename = $this->upload->data()['file_name'];
        }
        */
        

        //$filename = null;
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

                    list($imgWidth, $imgHeight) = getimagesize($fileData['full_path']);

                    if( $imgWidth > 1024 || $imgHeight > 1024 ) {

                        $config['source_image'] = FCPATH.$uploadPath.'/'.$fileData['file_name'];
                        //$config['new_image'] = FCPATH.$uploadPath.'/'.$fileData['file_name'];
                        $config['maintain_ratio'] = TRUE;
                        $config['width']     = 1024;
                        $config['height']   = 768;

                        $this->load->library('image_lib', $config); 

                        $this->image_lib->resize();

                    }

                    
                }
            }
        }
        

        $signature_name = null;

        
        if (isset($_FILES['signature']['size']) && ($_FILES['signature']['size'] > 0)) {
            $upload_path = './uploads/signature';

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            //$config['max_width'] = '1024';
            //$config['max_height'] = '768';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('signature') === false)
                return [
                    'status' => false,
                    'message' => $this->upload->display_errors()
                ];

            $signature_name = $this->upload->data()['file_name'];
        }
        
        /*
        $signature_name = null;

        if( !empty($this->input->post('signature')) )
        {
            $upload_path = FCPATH.'uploads/signature';
            $signature_decoded = base64_decode($this->input->post('signature'));
            $signature_name = 'signature-'.$this->input->post('issue_id').'.png';
            file_put_contents($upload_path.'/'.$signature_name,$signature_decoded);
        }
        */

        $data = [
            'date_checkout' => date('Y-m-d h:i:s'),
            'note' => $this->input->post('note'),
            'status' => 'done',
            'attachment_checkout' => implode(";", $uploadData),
            'signature' => $signature_name
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