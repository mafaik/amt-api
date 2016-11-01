<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class AdministratorReport
 */
class AdministratorReport extends REST_Controller
{
    /**
     * AdministratorReport constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AdministratorReportModel', 'model');
    }

    public function all_get()
    {
        $handler = $this->model->all();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function queue_get()
    {
        $handler = $this->model->queue();

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

    public function progress_get()
    {
        $handler = $this->model->progress();

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
