<?php
require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class UpdateGcmToken
 */
class UpdateGcmToken extends REST_Controller
{

    /**
     * UpdateGcmToken constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('StaffUpdateGcmTokenModel', 'model');
    }

    public function index_post()
    {
        $this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required|integer');
        $this->form_validation->set_rules('gcm_token', 'GCM Token', 'trim|required');
        

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->update();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }
}