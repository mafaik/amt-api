<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Delete
 */
class Delete extends REST_Controller
{
    /**
     * Delete constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StaffDeleteModel', 'model');
    }

    public function index_get()
    {
        if(!$this->input->get('staff_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_NO_CONTENT);

        $handler = $this->model->delete();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

}