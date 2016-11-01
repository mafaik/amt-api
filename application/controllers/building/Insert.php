<?php
require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * Class Insert
 */
class Insert extends REST_Controller
{
    /**
     * Insert constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('BuildingInsertModel', 'model');
    }

    public function index_post()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('region', 'Region', 'trim|required');

        if ($this->form_validation->run() == FALSE)
            $this->set_response(
                [
                    'status' => false,
                    'message' => validation_errors()
                ],
                REST_Controller::HTTP_BAD_REQUEST);

        $handler = $this->model->save();

        if($handler['status'] !== true)
            $this->set_response($handler, REST_Controller::HTTP_CONFLICT);
        $this->set_response($handler, REST_Controller::HTTP_CREATED);
    }
}