<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Outlet
 */
class Outlet extends REST_Controller
{
    /**
     * Outlet constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('NotificationOutletModel', 'model');
    }

    public function all_get()
    {
        if(!$this->input->get('outlet_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_NO_CONTENT);

        $handler = ( $this->input->get('pagination') ) ? $this->model->all_pagination() : $this->model->all();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function pending_get()
    {
        if(!$this->input->get('outlet_id'))
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

    public function checkin_get()
    {
        if(!$this->input->get('outlet_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_NO_CONTENT);
        $handler = $this->model->checkin();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function checkout_get()
    {
        if(!$this->input->get('outlet_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "data tidak ditemukan."
                ],
                REST_Controller::HTTP_NO_CONTENT);

        $handler = $this->model->checkout();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }
}
