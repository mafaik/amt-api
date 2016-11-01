<?php
require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class UpdatePassword
 */
class UpdatePassword extends REST_Controller
{

    /**
     * UpdatePassword constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('StaffUpdatePasswordModel', 'model');
    }

    public function index_post()
    {
        $this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required|integer');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules(
            'password_confirmation',
            'New Password Confirmation',
            'trim|required|matches[new_password]'
        );

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