<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Staff
 */
class Staff extends REST_Controller
{
    /**
     * Administrator constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('NotificationStaffModel', 'model');
    }

    public function pending_get()
    {
        if(!$this->input->get('staff_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_NO_CONTENT);
        $handler = $this->model->pending();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }
}
