<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configurations extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        
        $this->template->write('title', 'CRG | '.$this->user_type.' Configurations');
        $this->template->write_view('header', 'templates/header', array('page' => 'configurations'));
        $this->template->write_view('footer', 'templates/footer');
    }
    
    public function index() {
        $this->load->model('Configuration_model');

        $data['configurations'] = $this->Configuration_model->get_all_configurations();

        $this->template->write_view('content', 'configurations/index', $data);
        $this->template->render();
    }

    public function add($configuration_id = '') {
        $this->load->model('Configuration_model');

        $data = array();
        if(!empty($configuration_id)) {
          //  $this->is_admin();
            $configuration = $this->Configuration_model->get_configuration($configuration_id);
            if(!$configuration)
                redirect(base_url().'configurations');

            $data['configuration'] = $configuration;
        }

        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('name', 'Name', 'trim|required|xss_clean');
            //$validate->set_rules('email', 'Email', 'trim|required|xss_clean');
            $validate->set_rules('product', 'Product', 'trim|required|xss_clean');

            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
                $post_data ['email'] = $this->input->post('mail');
                $configuration_id = $this->Configuration_model->update_configuration($post_data, $this->input->post('id'));
                if($configuration_id) {
                    $msg = isset($configuration['id']) ? 'updated' : 'added';
                    $this->session->set_flashdata('success', 'Configuration successfully '.$msg.'.');

                    redirect(base_url().'configurations');
                } else {
                    $data['error'] = 'Something went wrong, Please try again.';
                }

            } else {
                $data['error'] = validation_errors();
            }
        }

        $this->template->write_view('content', 'configurations/add_configuration', $data);
        $this->template->render();
    }

    public function delete($id) {
        $this->load->model('Configuration_model');
        $configuration = $this->Configuration_model->get_configuration($id);

        if(!$configuration) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if($this->Configuration_model->delete_configuration($configuration['id'])) {
                $this->session->set_flashdata('success', 'Configuration deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }

        }

        redirect(base_url().'configurations');
    }
}