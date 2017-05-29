<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        //render template
        $this->template->write('title', 'CRG | '.$this->user_type.' Products');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $this->is_super_admin();
        
        $data = array();
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();

        $this->template->write_view('content', 'products/index', $data);
        $this->template->render();
    }
    
    public function add_product($product_id = '') {
        $this->is_super_admin();
        
        $data = array();
        $this->load->model('Product_model');
        
        if(!empty($product_id)) {
            $product = $this->Product_model->get_product($product_id);
            if(empty($product))
                redirect(base_url().'products');

            $data['product'] = $product;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Product_model->add_product($post_data, $product_id); 
            
            if($response) {
                $this->session->set_flashdata('success', 'Product successfully '.(($product_id) ? 'updated' : 'added').'.');
                redirect(base_url().'products');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
            
        }
        //$response = $this->Product_model->generate_product_code();
        $this->template->write_view('content', 'products/add_product', $data);
        $this->template->render();
    }
    
    /*Line Module Code Start*/
    
    public function lines($product_id = '') {
        if($this->product_id != '') {
            $product_id = $this->product_id;
        }
        
        $data = array();
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        
        $data['lines'] = $this->Product_model->get_all_product_lines($product_id);

        $this->template->write_view('content', 'products/lines', $data);
        $this->template->render();
    }
    
    public function add_product_line($product_id, $line_id = '') {
        if($this->product_id) {
            $product_id = $this->product_id;
        }
        
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        
        if(!empty($line_id)) {
            $line = $this->Product_model->get_product_line($product_id, $line_id);
            if(empty($line))
                redirect(base_url().'products/lines/'.$product['id']);

            $data['line'] = $line;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            $post_data['product_id'] = $product['id'];
            
            $response = $this->Product_model->update_product_line($post_data, $line_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Product line successfully '.(($line_id) ? 'updated' : 'added').'.');
                redirect(base_url().'products/lines/'.$product_id);
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'products/add_product_line', $data);
        $this->template->render();
    }

    public function delete_product_line($product_id, $line_id) {
        if($this->product_id) {
            $product_id = $this->product_id;
        }
        
        $this->load->model('Product_model');

        $line = $this->Product_model->get_product_line($product_id, $line_id);
        if(empty($line))
            redirect(base_url().'products/lines/'.$product['id']);
            
        $deleted = $this->Product_model->update_product_line(array('is_deleted' => 1), $line_id); 
        if($deleted) {
            $this->session->set_flashdata('success', 'Product Line deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'products/lines/'.$product_id);
    }
    
    /*Line Module Code End*/
    
    
    /*Zone Module Code Start*/
    
    public function line_zones() {
        if($this->product_id != '') {
            $product_id = $this->product_id;
        }
        
        $data = array();
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        
        $data['lines'] = $this->Product_model->get_all_product_lines($product_id);
        
        $data['zones'] = $this->Product_model->get_all_zones($product_id);
        
        //echo $this->db->last_query(); exit;

        $this->template->write_view('content', 'products/line_zones', $data);
        $this->template->render();
    }
    
    public function add_line_zone($zone_id = '') {
        if($this->product_id) {
            $product_id = $this->product_id;
        }
        
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        
        $data['lines'] = $this->Product_model->get_all_product_lines($product_id);
        
        if(!empty($zone_id)) {
            $zone = $this->Product_model->get_line_zone($product_id, $zone_id);
            if(empty($zone))
                redirect(base_url().'products/lines');

            $data['zone'] = $zone;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            $post_data['product_id'] = $product['id'];
            
            $response = $this->Product_model->update_line_zone($post_data, $zone_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Line Zone Successfully '.(($zone_id) ? 'Updated' : 'Added').'.');
                redirect(base_url().'products/lines');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'products/add_line_zone', $data);
        $this->template->render();
    }

    public function delete_line_zone($zone_id) {
        if($this->product_id) {
            $product_id = $this->product_id;
        }
        
        $this->load->model('Product_model');

        $zone_id = $this->Product_model->get_line_zone($zone_id);
        if(empty($zone_id))
            redirect(base_url().'products/line_zones');
            
        $deleted = $this->Product_model->update_line_zone(array('is_deleted' => 1), $zone_id['id']); 
        if($deleted) {
            $this->session->set_flashdata('success', 'Line zone deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'products/line_zones');
    }
    
    /*Zone Module Code End*/
    
    
    /*Stage Module Code Start*/
    
    public function line_stages() {
        if($this->product_id != '') {
            $product_id = $this->product_id;
        }
        
        $data = array();
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        
        //$data['lines'] = $this->Product_model->get_all_product_lines($product_id);
        
        //$data['zones'] = $this->Product_model->get_all_zones($product_id);
        
        $data['stages'] = $this->Product_model->get_all_stages($product_id);
        
        //echo $this->db->last_query(); exit;

        $this->template->write_view('content', 'products/line_stages', $data);
        $this->template->render();
    }
    
    public function add_line_stage($stage_id = '') {
        if($this->product_id) {
            $product_id = $this->product_id;
        }
        
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        
        $data['lines'] = $this->Product_model->get_all_product_lines($product_id);
        
        $data['zones'] = $this->Product_model->get_all_zones($product_id);
        
        if(!empty($zone_id)) {
            $stage = $this->Product_model->get_all_stages($product_id);
            //$zone = $this->Product_model->get_line_zone($product_id, $zone_id);
            if(empty($stage))
                redirect(base_url().'products/line_stages');

            $data['stage'] = $stage;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            $post_data['product_id'] = $product['id'];
            
            $response = $this->Product_model->update_line_stage($post_data, $stage_id); 
            //echo $this->db->last_query(); exit;
            if($response) {
                $this->session->set_flashdata('success', 'Stage Successfully '.(($stage_id) ? 'Updated' : 'Added').'.');
                redirect(base_url().'products/line_stages');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'products/add_line_stage', $data);
        $this->template->render();
    }

    public function delete_line_stage($stage_id) {
        if($this->product_id) {
            $product_id = $this->product_id;
        }
        
        $this->load->model('Product_model');

        $stage_id = $this->Product_model->get_line_zone($stage_id);
        if(empty($stage_id))
            redirect(base_url().'products/line_zones');
            
        $deleted = $this->Product_model->update_line_zone(array('is_deleted' => 1), $stage_id['id']); 
        if($deleted) {
            $this->session->set_flashdata('success', 'Stage deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'products/line_stages');
    }
    
    /*Stage Module Code End*/
    
    
    /*Defect Code Module Start*/
    
    public function defect_codes(){
        $data=array();
        $this->load->model('Report_model');
        
        $data['defect_codes'] = $this->Report_model->get_all_defect_codes($this->product_id);
        
        //echo "<pre>"; print_r($data['defect_codes']); exit;
        
        $this->template->write_view('content', 'products/defect_codes', $data);
        $this->template->render();
    }
    
    public function upload_defect_codes() {
        $this->is_super_admin();
        
        $data = array();
        $this->load->model('Product_model');
        
        if($this->input->post()) {
             
            if(!empty($_FILES['defect_code_excel']['name'])) {
                $output = $this->upload_file('defect_code_excel', 'defect_codes', "assets/uploads/");

                if($output['status'] == 'success') {
                    $res = $this->parse_defect_codes($output['file']);
                    
                    if($res) {
                        $this->session->set_flashdata('success', 'Defect codes successfully uploaded.');
                        redirect(base_url().'products/defect_codes');
                    } else {
                        $data['error'] = 'Error while uploading excel';
                    }
                } else {
                    $data['error'] = $output['error'];
                }

            }
        }
        
        $this->template->write_view('content', 'products/upload_defect_codes', $data);
        $this->template->render();
    }
    
    private function parse_defect_codes($file_name) {
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[1])) {
            return FALSE;
        }
        
        $this->load->model('Product_model');
        $suppliers = array();
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;
            
            if(!trim($row['A']))
                continue;
            
            $temp = array();
            $temp['supplier_no']    = trim($row['A']);
            $temp['full_name']      = trim($row['B']);
            $temp['name']           = trim($row['C']);
            $temp['email']          = trim($row['D']);
            
            $cost = $this->config->item('hash_cost');
            $temp['password'] = password_hash(SALT .'lge@123', PASSWORD_BCRYPT, array('cost' => $cost));
            
            $temp['created']        = date("Y-m-d H:i:s");
            
            $exists = $this->Supplier_model->get_supplier_by_code($temp['supplier_no']);
            if($exists) {
                $this->Supplier_model->add_supplier($temp, $exists['id']);
            } else {
                $suppliers[]        = $temp;
            }
        }

        if($suppliers) {
            $this->Supplier_model->insert_suppliers($suppliers);
        }
        
        return TRUE;
    }
    
    /*Defect Code Module End*/
    
    
    public function get_parts_by_product() {
        $data = array('parts' => array());
        
        if($this->input->post('product')) {
            $this->load->model('Product_model');
            $data['parts'] = $this->Product_model->get_all_product_parts($this->input->post('product'));
        }
        
        echo json_encode($data);
    }
    
    public function get_all_product_parts_by_supplier() {
        $data = array('parts' => array());
        
        if($this->input->post('product') && $this->input->post('supplier_id')) {
            $this->load->model('Product_model');
            $data['parts'] = $this->Product_model->get_all_product_parts_by_supplier($this->input->post('product'), $this->input->post('supplier_id'));
        }
        
        echo json_encode($data);
    }
    
    public function get_distinct_parts_by_product() {
        $data = array('parts' => array());
        
        if($this->input->post('product')) {
            $this->load->model('Product_model');
            $data['parts'] = $this->Product_model->get_all_distinct_product_parts($this->input->post('product'));
        }
        
        echo json_encode($data);
    }
    
    public function get_part_numbers_by_part_name() {
        $data = array('parts' => array());
        
        if($this->input->post('part_name')) {
            $this->load->model('Product_model');
            $data['part_nums'] = $this->Product_model->get_all_part_numbers_by_part_name($this->input->post('part_name'));
        }
        
        echo json_encode($data);
    }
}