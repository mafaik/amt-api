<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Login
 */
class Login extends REST_Controller
{

    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StaffLoginModel', 'model');
    }

    public function index_post()
    {
        $this->form_validation->set_rules('username', 'Useraname', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        //$this->form_validation->set_rules('ip', 'valid_ip', 'trim|required');

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->login();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

}