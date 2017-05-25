<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        
        $this->template->write_view('header', 'templates/header', array('page' => 'reports'));
        $this->template->write_view('footer', 'templates/footer');
    }

    public function index() {
        $data = array();
        $this->load->model('Product_model');
        $this->load->model('Report_model');
        
        //$data['lines'] = $this->Product_model->get_all_product_lines($this->product_id);
        $data['lines'] = '';
        
        $filters = $this->input->post() ? $this->input->post() : array();
        $filters = array_filter($filters);
        $data['page_no'] = 1;
        if(count($filters) > 1) {
                
            $filters['product_id'] = $this->product_id;
            
            $_SESSION['defect_filters'] = $filters;
            
            $per_page = 25;
            $page_no = $this->input->post('page_no');
            
            $limit = ' LIMIT '.($page_no-1)*$per_page.' ,'.$per_page;
            
            $data['page_no'] = $page_no;
            
            $count = $this->Report_model->get_report_with_defect_codes($filters, true, $limit);
            $count = $count[0]['c'];
            $data['total_page'] = ceil($count/50);
            
            $data['defects'] = $this->Report_model->get_report_with_defect_codes($filters, false);
            
            //echo $this->db->last_query();exit;
        }
        
        $this->template->write('title', 'SSI | Defect Report');
        $this->template->write_view('content', 'reports/index', $data);
        $this->template->render();
    }

    function contact_us_report() {
        $data = array();
        $this->load->model('Report_model');
        
        if($this->input->get()) {
            $start_range = $this->input->get('start_range');
            $end_range = $this->input->get('end_range');            
            $type = $this->input->get('type');

            $date_type = $this->input->get('date_type');
            if(!empty($date_type)) {
                $year = $this->input->get('year');
                $range = $this->get_date_range($date_type, $year);
                $start_range = $range['sr'];
                $end_range = $range['er'];
            }

            $data['reports'] = $this->Report_model->get_career_contact_us_data($start_range, $end_range, $type);
        }

        $this->template->write('title', 'Career & Contact Us Report');
        $this->template->write_view('content', 'reports/contact_us_report', $data);
        $this->template->render();
    }
    
    function excel_export_contact_us_report(){
        $data = array();
        $this->load->model('Report_model');

        $str = '';
        if($this->input->get()) {
            $start_range = $this->input->get('start_range');
            $end_range = $this->input->get('end_range');            
            $type = $this->input->get('type');

            $date_type = $this->input->get('date_type');
            if(!empty($date_type)) {
                $year = $this->input->get('year');
                $range = $this->get_date_range($date_type, $year);
                $start_range = $range['sr'];
                $end_range = $range['er'];
            }

            $data['reports'] = $this->Report_model->get_career_contact_us_data($start_range, $end_range, $type);
            
            $str = $this->load->view('reports/contact_us_report_download', $data, true);
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=Contact&Career_Report.xls');
        }
        
        header("Pragma: ");
        header("Cache-Control: ");
        echo $str;
    }
    
    function delete_contact_us($id) {
        $this->load->model('Report_model');
        $contact_us = $this->Report_model->get_contact_us_data($id);

        if(!$contact_us) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if($this->Report_model->delete_contact_us($contact_us['id'])) {
                $this->session->set_flashdata('success', 'Contact Us details deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }

        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    function delete_career($id) {
        $this->load->model('Report_model');
        $career = $this->Report_model->get_career_data($id);

        if(!$career) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if($this->Report_model->delete_career($career['id'])) {
                $this->session->set_flashdata('success', 'Career enquiry details deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }

        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    function delete_subscription($id) {
        $this->load->model('Report_model');
        $subscription = $this->Report_model->get_subscription_data($id);

        if(!$subscription) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if($this->Report_model->delete_subscription($subscription['id'])) {
                $this->session->set_flashdata('success', 'Subscription deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }

        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    function leads_report(){
        $data = array();
        $this->load->model('Report_model');

        if($this->input->get()) {
            $start_range = $this->input->get('start_range');
            $end_range = $this->input->get('end_range');
            $type = $this->session->userdata('product_name');
            
            //echo $type; exit;

            $date_type = $this->input->get('date_type');
            if(!empty($date_type)) {
                $year = $this->input->get('year');
                $range = $this->get_date_range($date_type, $year);
                $start_range = $range['sr'];
                $end_range = $range['er'];
            }

            $data['reports'] = $this->Report_model->get_leads_data($start_range, $end_range, $type);
        }

        $this->template->write('title', 'Leads Report');
        $this->template->write_view('content', 'reports/leads_report', $data);
        $this->template->render();
    }
    
    function excel_export_leads_report(){
        $data = array();
        $this->load->model('Report_model');

        $str = '';
        if($this->input->get()) {
            $start_range = $this->input->get('start_range');
            $end_range = $this->input->get('end_range');
            $type = $this->session->userdata('product_name');

            $date_type = $this->input->get('date_type');
            if(!empty($date_type)) {
                $year = $this->input->get('year');
                $range = $this->get_date_range($date_type, $year);
                $start_range = $range['sr'];
                $end_range = $range['er'];
            }

            $data['reports'] = $this->Report_model->get_leads_data($start_range, $end_range, $type);
            
            $str = $this->load->view('reports/leads_report_download', $data, true);
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=Leads_Report.xls');
        }
        
        header("Pragma: ");
        header("Cache-Control: ");
        echo $str;
    }
    
    function delete_lead($id) {
        $this->load->model('Report_model');
        $lead = $this->Report_model->get_lead_data($id);

        if(!$lead) {
            $this->session->set_flashdata('error', 'Invalid record');
        } else {

            if($this->Report_model->delete_lead($lead['id'])) {
                $this->session->set_flashdata('success', 'Lead details deleted successfully');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
            }

        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    function mails_report(){
        $data = array();
        $this->load->model('Report_model');
        
        if($this->input->get()) {
            $start_range = $this->input->get('start_range');
            $end_range = $this->input->get('end_range');
            $status = $this->input->get('status');

            $date_type = $this->input->get('date_type');
            if(!empty($date_type)) {
                $year = $this->input->get('year');
                $range = $this->get_date_range($date_type, $year);
                $start_range = $range['sr'];
                $end_range = $range['er'];
            }

            $data['reports'] = $this->Report_model->get_mail_data($start_range, $end_range, $status);
        }

        $this->template->write('title', 'Mails Report');
        $this->template->write_view('content', 'reports/mails_report', $data);
        $this->template->render();
    }
    
    function excel_export_mails_report(){
        $data = array();
        $this->load->model('Report_model');

        $str = '';
        if($this->input->get()) {
            $start_range = $this->input->get('start_range');
            $end_range = $this->input->get('end_range');
            $status = $this->input->get('status');

            $date_type = $this->input->get('date_type');
            if(!empty($date_type)) {
                $year = $this->input->get('year');
                $range = $this->get_date_range($date_type, $year);
                $start_range = $range['sr'];
                $end_range = $range['er'];
            }

            $data['reports'] = $this->Report_model->get_mail_data($start_range, $end_range, $status);
            
            $str = $this->load->view('reports/mails_report_download', $data, true);
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=Mails_Report.xls');
        }
        
        header("Pragma: ");
        header("Cache-Control: ");
        echo $str;
    }
    
    function show_message($id) {
        $data = array();
        $this->load->model('Report_model');
        
        $data['mail'] = $this->Report_model->get_mail($id);
        
        $this->template->write('title', 'Mails Report');
        $this->template->write_view('content', 'reports/show_message', $data);
        $this->template->render();
    }

    function get_date_range($date_type, $y) {
        $return = array('sr' => '', 'er' => '');

        if($date_type == 'Q1') {
            $start_range = $y.'-01-01';
            $end_range = $y.'-03-31';
        } else if($date_type == 'Q2') {
            $start_range = $y.'-04-01';
            $end_range = $y.'-06-30';
        } else if($date_type == 'Q3') {
            $start_range = $y.'-07-01';
            $end_range = $y.'-09-30';
        } else if($date_type == 'Q4') {
            $start_range = $y.'-10-01';
            $end_range = $y.'-12-31';
        } else if($date_type == 'H1') {
            $start_range = $y.'-01-01';
            $end_range = $y.'-06-30';
        } else if($date_type == 'H2') {
            $start_range = $y.'-07-01';
            $end_range = $y.'-12-31';
        } else if($date_type == 'Y') {
            $start_range = $y.'-01-01';
            $end_range = $y.'-12-31';
        } else {
            $start_range = '';
            $end_range = '';
        }
        
        return array('sr' => $start_range, 'er' => $end_range);
    }
}