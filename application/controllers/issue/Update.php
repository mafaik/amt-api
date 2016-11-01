<?php
require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Update
 */
class Update extends REST_Controller
{

    /**
     * Update constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('IssueUpdateModel', 'model');
    }

    public function index_post()
    {
        $this->form_validation->set_rules('issue_id', 'Issue ID', 'trim|required|integer');
        $this->form_validation->set_rules('outlet_id', 'Outlet ID', 'trim|required|integer');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('issue', 'Issue', 'trim|required');

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
    public function staff_post()
    {

        $this->form_validation->set_rules('issue_id', 'Issue ID', 'trim|required|integer');
        $this->form_validation->set_rules('staff_id', 'Staff ID', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->updateStaff();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }


}