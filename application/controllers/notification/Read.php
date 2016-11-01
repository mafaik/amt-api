<?php
require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Read
 */
class Read extends REST_Controller
{

    /**
     * Done constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('NotificationReadModel', 'model');
    }

    public function staff_post()
    {
        $this->form_validation->set_rules('notif_id', 'Notification ID', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->staff();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }

    public function outlet_post()
    {
        $this->form_validation->set_rules('notification_id', 'Notification ID', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->outlet();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }

    public function outlet_all_post()
    {
        $this->form_validation->set_rules('outlet_id', 'OUTLET ID ID', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->outlet_all();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }

    public function administrator_post()
    {
        $this->form_validation->set_rules('notif_id', 'Notification ID', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->administrator();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }

    public function administrator_all_post()
    {

        $handler = $this->model->administrator_all();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }

}
