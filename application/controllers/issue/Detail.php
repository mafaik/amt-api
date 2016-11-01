<?php

require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Detail
 */
class Detail extends REST_Controller
{
    /**
     * Detail constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('IssueDetailModel', 'model');
    }

    public function index_get()
    {
        if(!$this->input->get('issue_id'))
            $this->set_response(
                [
                    'status' => false,
                    'message' => "Data not found"
                ],
                REST_Controller::HTTP_NO_CONTENT);

        $handler = $this->model->detail();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_OK);
    }

}