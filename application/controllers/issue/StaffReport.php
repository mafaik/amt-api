<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class StaffReport
 */
class StaffReport extends REST_Controller
{
    /**
     * StaffReport constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StaffReportModel', 'model');

        if(!$this->input->get('staff_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_NO_CONTENT);
    }

    public function open_get()
    {
        $handler = $this->model->open();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function progress_get()
    {
        $handler = $this->model->progress();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function pending_get()
    {
        $handler = $this->model->pending();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function history_get()
    {
        $handler = $this->model->history();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }
}
