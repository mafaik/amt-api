<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Lists
 */
class Lists extends REST_Controller
{
    /**
     * Lists constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StaffListsModel', 'model');
    }

    public function index_get()
    {
        $handler = $this->model->index();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function available_get()
    {
        $handler = $this->model->available();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

}