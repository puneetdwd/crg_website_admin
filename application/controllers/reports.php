<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        
        $this->template->write('title', 'CRG | '.$this->user_type.' Reports');
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
    
    public function excel_export($type){
        
        if($type == 'defect_report'){
            
            $filters = @$_SESSION['defect_filters'] ;
            
            //echo "<pre>"; print_r($filters); exit;
            
            $this->load->model('Report_model');
            $data['defects'] = $this->Report_model->get_report_with_defect_codes($filters, false);
            
            //echo "<pre>"; print_r($data['defects']); exit;
            
            $str = $this->load->view('reports/defect_report_download', $data, true);
            
            //echo $str; exit;

            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=Defect_Report.xls');

        }
            
        header("Pragma: ");
        header("Cache-Control: ");
        echo $str;
        
    }
    
    public function lot_wise_report() {
        $data = array();
        $this->load->model('Audit_model');

        if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector'){
            $sup_id = $this->supplier_id;
        }else{
            $sup_id = '';
        }
        
        $data['parts'] = $this->Audit_model->get_all_audit_parts('', $sup_id);
        
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $filters = $this->input->post() ? $this->input->post() : array();
        $filters = array_filter($filters);
        $data['page_no'] = 1;
        if(count($filters) > 1) {
            if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector'){
                $filters['supplier_id'] = $this->supplier_id;
            }
            
            if(@$filters['product_all']) {
                $filters['product_id'] = "all";
            } else {
                $filters['product_id'] = $this->product_id;
            }
            
            $per_page = 25;
            $page_no = $this->input->post('page_no');
            
            $limit = 'LIMIT '.($page_no-1)*$per_page.' ,'.$per_page;
            
            $data['page_no'] = $page_no;
            
            $count = $this->Audit_model->get_consolidated_audit_report($filters, true);
            $count = $count[0]['c'];
            $data['total_page'] = ceil($count/50);
            
            $data['audits'] = $this->Audit_model->get_consolidated_audit_report($filters, false, $limit);
            //echo $this->db->last_query();exit;
        }
        
        $this->template->write('title', 'SQIM | Inspections Report');
        $this->template->write_view('content', 'reports/lot_wise_report', $data);
        $this->template->render();
    }

    public function part_inspection_report($audit_id) {
        $data = array();
        $this->load->model('Audit_model');
        $filters = array('id' => $audit_id);
        $audit = $this->Audit_model->get_completed_audits($filters, false, 'LIMIT 1');
        if(empty($audit)) {
            $this->session->set_flashdata('error', 'Invalid request');
            redirect(base_url().'reports');
        }
        
        $audit = $audit[0];
        $checkpoints = $this->Audit_model->get_all_audit_checkpoints($audit['id']);
        
        $max_qty = 0;
        foreach($checkpoints as $checkpoint) {
            if($checkpoint['sampling_qty'] > $max_qty) {
                $max_qty = $checkpoint['sampling_qty'];
            }
        }
        
        foreach($checkpoints as $chk){
            if($chk['result'] == 'NG'){
                $final_result = $chk['result'];
                break;
            }else{
                $final_result = $chk['result'];
            }
        }
        
        $data['final_result'] = $final_result;
        $data['audit'] = $audit;
        $data['checkpoints'] = $checkpoints;
        $data['max_qty'] = $max_qty;
        $data['total_col'] = $max_qty+13;
        
        //echo "<pre>";print_r($checkpoints); exit;
        
        if($this->input->get('download')) {
            $data['download'] = true;
            $str = $this->load->view('reports/part_inspection_report', $data, true);
        
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=Part_Inspection_'.$audit['part_no'].'.xls');
            // Fix for crappy IE bug in download.
            header("Pragma: ");
            header("Cache-Control: ");
            echo $str;
        } else {
            $this->template->write('title', 'SQIM | Part Inspection Report');
            $this->template->write_view('content', 'reports/part_inspection_report', $data);
            $this->template->render();
        }
    }
    
    public function check_judgement() {
        $response = array('status' => 'error');
        if($this->input->post('audit_id')) {
            $audit_id = $this->input->post('audit_id');
            
            $this->load->model('Audit_model');
            $res = $this->Audit_model->get_audit_judgement($audit_id);
            
            $response = array('status' => 'success', 'judgement' => ($res['ng_count'] > 0 ? 'NG' : 'OK'));
        }
        
        echo json_encode($response);
    }

    public function timecheck() {
        if($this->user_type == 'Supplier Inspector') {
            //redirect($_SERVER['HTTP_REFERER']);
        }
        
        $data = array();
        $this->load->model('Audit_model');
        $this->load->model('Timecheck_model');

        if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector') {
            $sup_id = $this->supplier_id;
        }else{
            $sup_id = '';
            
            $this->load->model('Supplier_model');
            $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        }

        $data['parts'] = $this->Audit_model->get_all_audit_parts('', $sup_id);

        $filters = $this->input->post() ? $this->input->post() : array();
        $filters = array_filter($filters);
        $data['page_no'] = 1;
        if(count($filters) > 1) {
            if($this->user_type == 'Supplier' || $this->user_type == 'Supplier Inspector') {
                $filters['supplier_id'] = $this->supplier_id;
            }
            
            $per_page = 25;
            $page_no = $this->input->post('page_no');
            
            $limit = 'LIMIT '.($page_no-1)*$per_page.' ,'.$per_page;
            
            $data['page_no'] = $page_no;
            
            $count = $this->Timecheck_model->get_timecheck_plan_report($filters, true);
            $count = $count[0]['c'];
            $data['total_page'] = ceil($count/50);
            
            $data['plans'] = $this->Timecheck_model->get_timecheck_plan_report($filters, false);
            //echo $this->db->last_query();exit;
        }
        
        $this->template->write('title', 'SQIM | Timecheck Report');
        $this->template->write_view('content', 'reports/timecheck', $data);
        $this->template->render();
    }
    
    function foolproof(){
        
        if($this->user_type == 'Supplier Inspector') {
            //redirect($_SERVER['HTTP_REFERER']);
        }
        
        $data = array();

        if($this->user_type == 'Supplier') {
            $sup_id = $this->supplier_id;
        }else{
            $sup_id = '';
            
            $this->load->model('Supplier_model');
            $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        }
        
        $filters = $this->input->post() ? $this->input->post() : array();
        $filters = array_filter($filters);
        if(count($filters) > 1) {
            if($this->user_type == 'Supplier') {
                $filters['supplier_id'] = $this->supplier_id;
            }
            
            $this->load->model('foolproof_model');
            $data['foolproofs'] = $this->foolproof_model->get_foolproof_report($filters);
            //echo $this->db->last_query();exit;
        }
        
        $this->template->write('title', 'SQIM | Fool-Proof Report');
        $this->template->write_view('content', 'reports/foolproof', $data);
        $this->template->render();
    }
    
    function download_foolproof_report($date, $supplier_id = ''){
        
        $filter = array();
        $data = array();
        
        $filter['date'] = $date;
        
        if(!empty($supplier_id)){
            $filter['supplier_id'] = $supplier_id;
        }
        
        $this->load->model('foolproof_model');
        $data['foolproofs'] = $this->foolproof_model->get_foolproof_report($filter);
        
        $str = $this->load->view('fool_proof/view', $data, true);
        
        header('Content-Type: application/force-download');
        header('Content-disposition: attachment; filename=FoolProof_Report.xls');
        // Fix for crappy IE bug in download.
        header("Pragma: ");
        header("Cache-Control: ");
        echo $str;
        
        //header("location:".base_url()."reports/foolproof");
        
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
            $type = $this->input->get('type');

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
            $type = $this->input->get('type');

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

        if($date_type == 'Q4') {
            $start_range = ($y+1).'-01-01';
            $end_range = ($y+1).'-03-31';
        } else if($date_type == 'Q1') {
            $start_range = $y.'-04-01';
            $end_range = $y.'-06-30';
        } else if($date_type == 'Q2') {
            $start_range = $y.'-07-01';
            $end_range = $y.'-09-30';
        } else if($date_type == 'Q3') {
            $start_range = $y.'-10-01';
            $end_range = $y.'-12-31';
        } else if($date_type == 'H1') {
            $start_range = $y.'-04-01';
            $end_range = $y.'-09-30';
        } else if($date_type == 'H2') {
            $start_range = $y.'-10-01';
            $end_range = ($y+1).'-03-31';
        } else if($date_type == 'Y') {
            $start_range = $y.'-04-01';
            $end_range = ($y+1).'-03-31';
        } else {
            $start_range = '';
            $end_range = '';
        }
        
        return array('sr' => $start_range, 'er' => $end_range);
    }
}