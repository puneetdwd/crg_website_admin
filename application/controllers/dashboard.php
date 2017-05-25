<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);

        $page = '';
        if($this->router->fetch_method() == 'realtime') {
            $page = 'realtime';
        }
        //render template
        $this->template->write('title', 'SSI | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => $page));
        $this->template->write_view('footer', 'templates/footer');

    }
    
    public function dashboard_charts(){
        $data = array();
        $this->template->write_view('content', 'dashboard_charts', $data);
        $this->template->render();
    }
    
    public function dashboard_tabular(){
        $data = array();
        
        $this->load->model('Report_model');
        
        $self_data = $this->Report_model->get_zone_wise_self_top_five_count();
        $data['data'] = $self_data;
            
        $this->template->write_view('content', 'dashboard_tabular', $data);
        $this->template->render();
    }

    public function index() {
        /*if(!$this->session->userdata('dashboard_date')) {
            $this->session->set_userdata('dashboard_date', date('Y-m-d'));
        }*/

        if($this->user_type == 'Admin') {
            
            $data=array();
            $this->load->model('Report_model');
            
            //$self_data = $this->Report_model->get_zone_wise_self_top_five_count();
            $data['self_data'] = '';
            
            //$seq_data = $this->Report_model->get_zone_wise_sequencial_top_five_count();
            $data['seq_data'] = '';
            
            $this->template->write_view('content', 'dashboard', $data);
            $this->template->render();
        } 
    }
    
    public function dashboard_screen($page = 1, $type = 'self', $zone_index = 0) {
        
        //echo "<pre>"; print_r($this->session->userdata('all_zones')); exit;
        
        $data=array();
        $this->load->model('Report_model');
        
        $per_page = 10;
        $limit = ' LIMIT '.($page-1)*$per_page.', '.$per_page;
        
        $zone_id = $this->session->userdata('all_zones')[$zone_index]['id'];
        
        $data['data'] = array();
        
        if($type == 'self'){

                $type1 = "('A','A1','A2')";
                $data['data'] = $this->Report_model->get_zone_wise_count($type1, $limit, $zone_id);
                //$data['data'] = $data;
                $data['insp_type'] = 'Self Inspection';
        }else if($type == 'seq'){

                $type1 = "('B','B1','B2')";
                $data['data'] = $this->Report_model->get_zone_wise_count($type1, $limit, $zone_id);
                //$data['data'] = $data;
                $data['insp_type'] = 'Sequential Inspection';
        }

        $data['line_zone'] = $this->Report_model->get_line_zone_details($zone_id);
        
        if (!$this->input->is_ajax_request()) {
			
            $count_self = $this->Report_model->get_zone_wise_total_count($type1, $zone_id);
            $count_seq = $this->Report_model->get_zone_wise_total_count("('B','B1','B2')", $zone_id);// For Sequential Count
            
            $data['total_self'] = ceil($count_self/$per_page);
            $data['total_seq'] = ceil($count_seq/$per_page);
            //echo "Self - ".$data['total_self']."Seq - ".$data['total_seq']; exit;
            $this->template->write_view('content', 'dashboard_tabular', $data);
            $this->template->render();
        } else {
			
            $this->load->view('dashboard_tabular_ajax', $data);
        }
    }
	
    public function dashboard_screen_charts($type = 'self', $zone_index = 0) {
        
        $data=array();
        $this->load->model('Report_model');
        
        $zone_id = $this->session->userdata('all_zones')[$zone_index]['id'];
		
        $data['data'] = array();

        if($type == 'self'){

                $type1 = "('A','A1','A2')";
                $data = $this->Report_model->get_zone_wise_count($type1, '', $zone_id);
                $data['data'] = $data;
                $data['insp_type'] = 'Self Inspection';
        }else if($type == 'seq'){

                $type1 = "('B','B1','B2')";
                $data = $this->Report_model->get_zone_wise_count($type1, '', $zone_id);
                $data['data'] = $data;
                $data['insp_type'] = 'Sequential Inspection';
        }
        
        $data['line_zone'] = $this->Report_model->get_line_zone_details($zone_id);

        $this->load->view('dashboard_charts_ajax', $data);
    }
    
}