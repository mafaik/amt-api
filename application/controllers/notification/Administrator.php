<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Administrator
 */
class Administrator extends REST_Controller
{
    /**
     * Administrator constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('NotificationAdministratorModel', 'model');
    }

    public function all_get()
    {
        $handler = ( $this->input->get('pagination') ) ? $this->model->all_pagination() : $this->model->all();

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

    public function checkin_get()
    {
        $handler = $this->model->checkin();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

    public function checkout_get()
    {
        $handler = $this->model->checkout();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_NO_CONTENT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }
}
