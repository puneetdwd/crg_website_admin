<?php

class Report_model extends CI_Model {
    
    function __construct() {
        parent::__construct();

        //require_once APPPATH .'libraries/pass_compat/password.php';
    }
    
    function get_all_defect_codes($product_id){
        
        $sql = "SELECT dc.*, s.stage_no, s.stage_name, s.device_no, z.zone_name, pl.name as line_name FROM defect_codes dc
                LEFT JOIN stages s ON s.id = dc.stage_id
                LEFT JOIN zones z ON z.id = s.zone_id
                LEFT JOIN product_lines pl ON pl.id = z.line_id
                WHERE dc.product_id = ".$product_id;
        
        $result = $this->db->query($sql);

        return $result->result_array();
        
    }
    
    function get_report_with_defect_codes($filters, $count = false, $limit = ''){
        
        //echo "<pre>"; print_r($filters); exit;
        
        $sql = "SELECT st.id, z.zone_name, s.stage_no, s.stage_name, st.DeviceNo, s.device_name, st.DeviceStatus, st.StatusDt, 
                pl.name as line_name, count(st.DeviceNo) as total_count
                FROM `statustable` st
                INNER JOIN defect_codes dc ON dc.device_id = st.DeviceNo ";
        
        if($this->product_id) {
            $sql .= " AND dc.product_id = ? ";
            $pass_array[] = $this->product_id;
        }
        
        if(!empty($filters['line_id'])) {
            $sql .= " AND dc.line_id = ? ";
            $pass_array[] = $filters['line_id'];
        }
        
        $sql .= " INNER JOIN stages s ON s.device_no = dc.device_id
                  INNER JOIN zones z ON z.id = s.zone_id
                  INNER JOIN product_lines pl ON pl.id = dc.line_id 
                  WHERE st.DeviceStatus IN ('A','A1','A2','B','B1','B2')
                  AND s.is_deleted = 0 ";
        
        if(!empty($filters['start_range']) && !empty($filters['end_range'])) {
            $sql .= " AND st.StatusDt BETWEEN ? AND ? ";
            $pass_array[] = $filters['start_range'];
            $pass_array[] = $filters['end_range'];
        }
        
        $sql .= " GROUP BY st.DeviceNo
                  ORDER BY st.StatusDt, st.DeviceNo ";
        
        if($count) {
            $sql = "SELECT count(id) as c FROM (".$sql.") as sub";
        } else {
            $sql .= " ".$limit;
        }
        
        //$result = $this->db->query($sql);

        //return $result->result_array();
        
        return $this->db->query($sql, $pass_array)->result_array();
        
    }
    
    function get_line_zone_details($zone_id){

        $sql = "SELECT z.zone_name, pl.name as line_name 
                        FROM zones z
                        LEFT JOIN product_lines pl ON pl.id = z.line_id
                        WHERE z.id = ".$zone_id." AND z.product_id = ".$this->product_id;

        $result = $this->db->query($sql);

        return $result->row_array();
    }
    
    function get_zone_wise_count($type, $limit='', $zone_id){
        
        $date = date('Y-m-d');
        //$date = '2017-04-27';
        
        $sql = "SELECT count(st.DeviceNo) as total_count, s.stage_no, s.stage_name 
                FROM statustable st 
                LEFT JOIN stages s ON s.device_no = st.DeviceNo
                LEFT JOIN zones z ON z.id = s.zone_id 
                LEFT JOIN product_lines pl ON (pl.name = st.Rline AND pl.product_id = ".$this->product_id.") 
                LEFT JOIN products p ON p.code = st.Product
                WHERE st.DeviceStatus IN ".$type."  ";
        
        $sql .= "AND st.StatusDt >= '".$date." 00:00:00' AND st.StatusDt <= '".$date." 23:59:59' ";
        
        if($this->product_id) {
            $sql .= " AND z.product_id = ".$this->product_id;
        }
        
        if($zone_id) {
            $sql .= " AND s.zone_id = ".$zone_id;
        }
        
        $sql .= " GROUP BY st.DeviceNo ";
        
        if($limit != ''){
            $sql .= $limit;
        }
        
        //echo $sql; exit;
        
        $result = $this->db->query($sql);
        
        return $result->result_array();
    }
    
    function get_zone_wise_total_count($type, $zone_id){
		
	$date = date('Y-m-d');
        //$date = '2017-04-27';
        
        $sql = "SELECT count(st.DeviceNo) as total_count, s.stage_no, s.stage_name 
                FROM statustable st
                LEFT JOIN stages s ON s.device_no = st.DeviceNo
                LEFT JOIN zones z ON z.id = s.zone_id 
                LEFT JOIN product_lines pl ON (pl.name = st.Rline AND pl.product_id = ".$this->product_id.") 
                LEFT JOIN products p ON p.code = st.Product
                WHERE st.DeviceStatus IN ".$type."  ";
        
        $sql .= "AND st.StatusDt >= '".$date." 00:00:00' AND st.StatusDt <= '".$date." 23:59:59' ";
        
        if($this->product_id) {
            $sql .= " AND z.product_id = ".$this->product_id;
        }
        
        if($zone_id) {
            $sql .= " AND s.zone_id = ".$zone_id;
        }
        
        $sql .= " GROUP BY st.DeviceNo ";
        
        //echo $sql; exit;
        
        $result = $this->db->query($sql);
        
        return count($result->result_array());
    }
	
    function get_zone_wise_self_top_five_count($zone_id = 1){
        
        $date = date('Y-m-d');
        //$date = '2017-04-28';
        
        $sql = "SELECT count(st.DeviceNo) as total_self_count, s.stage_no, s.stage_name 
                FROM statustable st 
                LEFT JOIN stages s ON s.device_no = st.DeviceNo
                LEFT JOIN zones z ON z.id = s.zone_id 
                LEFT JOIN product_lines pl ON (pl.name = st.Rline AND pl.product_id = ".$this->product_id.") 
                LEFT JOIN products p ON p.code = st.Product
                WHERE st.DeviceStatus = 'A'  ";
        
        $sql .= "AND st.StatusDt >= '".$date." 00:00:00' AND st.StatusDt <= '".$date." 23:59:59' ";
        
        if($this->product_id) {
            $sql .= " AND z.product_id = ".$this->product_id;
        }
        
        if($zone_id) {
            $sql .= " AND s.zone_id = ".$zone_id;
        }
        
        $sql .= " GROUP BY st.DeviceNo ORDER BY total_self_count DESC LIMIT 0,5";
        
        //echo $sql; exit;
        
        $result = $this->db->query($sql);
        
        return $result->result_array();
    }
    
    function get_zone_wise_sequencial_top_five_count($zone_id = 1){
        
        $date = date('Y-m-d');
        //$date = '2017-04-28';
        
        $sql = "SELECT count(st.DeviceNo) as total_seq_count, s.stage_no, s.stage_name 
                FROM statustable st 
                LEFT JOIN stages s ON s.device_no = st.DeviceNo
                LEFT JOIN zones z ON z.id = s.zone_id 
                LEFT JOIN product_lines pl ON (pl.name = st.Rline AND pl.product_id = ".$this->product_id.") 
                LEFT JOIN products p ON p.code = st.Product
                WHERE st.DeviceStatus = 'B'  ";
        
        $sql .= "AND st.StatusDt >= '".$date." 00:00:00' AND st.StatusDt <= '".$date." 23:59:59' ";
        
        if($this->product_id) {
            $sql .= " AND z.product_id = ".$this->product_id;
        }
        
        if($zone_id) {
            $sql .= " AND s.zone_id = ".$zone_id;
        }
        
        $sql .= " GROUP BY st.DeviceNo ORDER BY total_seq_count DESC LIMIT 0,5";
        
        //echo $sql; exit;
        
        $result = $this->db->query($sql);
        
        return $result->result_array();
    }
    
    function get_all_users() {
        $sql = "SELECT u.*, 
        GROUP_CONCAT(p.name ORDER BY p.name) as product_name 
        FROM users u
        LEFT JOIN products p
        ON FIND_IN_SET(p.id, u.product_id)";
        
        if($this->product_id) {
            $sql .= " WHERE FIND_IN_SET(".$this->product_id.", u.product_id) ";
        }
        
        $sql .= " GROUP BY u.id";
        //echo $this->product_id." ".$sql; exit;
        $users = $this->db->query($sql);
        //echo "<pre>"; print_r($users->result_array()); exit;
        return $users->result_array();
    }

    function get_user($username) {
        $sql = "SELECT u.*, 
        GROUP_CONCAT(p.name ORDER BY p.name) as product_name 
        FROM users u
        LEFT JOIN products p
        ON FIND_IN_SET(p.id, u.product_id)
        WHERE u.username = ?";
        
        $pass_array = array($username);
        if($this->product_id) {
            $sql .= ' AND p.id = ?';
            $pass_array[] = $this->product_id;
        }

        $sql .= " GROUP BY u.id";
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_user_by_id($id) {
        $sql = "SELECT u.*, 
        GROUP_CONCAT(p.name ORDER BY p.name) as product_name 
        FROM users u
        LEFT JOIN products p
        ON FIND_IN_SET(p.id, u.product_id)
        WHERE u.id = ?";
        
        $pass_array = array($id);
        if($this->product_id) {
            $sql .= ' AND p.id = ?';
            $pass_array[] = $this->product_id;
        }

        $sql .= " GROUP BY u.id";
        
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_supplier_user($id) {
        $sql = "SELECT * FROM suppliers WHERE id = ?";
        
        $pass_array = array($id);
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_supplier_inspector_user($id) {
        $sql = "SELECT * FROM supplier_inspector WHERE id = ?";
        
        $pass_array = array($id);
        return $this->db->query($sql, $pass_array)->row_array();
    }
    
    function get_user_by_type($user_type) {
        $this->db->where('user_type', $user_type);
        
        if($this->product_id) {
            $this->db->where('product_id', $this->product_id);
        }
        
        return $this->db->get('users')->result_array();
    }

    function is_username_exists($username, $id = '') {
        if(!empty($id)) {
            $this->db->where('id !=', $id);
        }

        $this->db->where('username', $username);

        return $this->db->count_all_results('users');
    }

    function update_user($data, $user_id = '') {
        //filter unwanted fields while inserting in table.
        $needed_array = array('product_id', 'first_name', 'last_name', 'username', 'password', 'email', 'user_type', 'is_active', 'checklist_checked');
        
        
        $data = array_intersect_key($data, array_flip($needed_array));

        if(!empty($data['password'])) {
            $cost = $this->config->item('hash_cost');
            $data['password'] = password_hash(SALT .$data['password'], PASSWORD_BCRYPT, array('cost' => $cost));
        } else {
            unset($data['password']);
        }

        if(empty($user_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('users', $data)) ? $this->db->insert_id() : False);
            
        } else {
            $this->db->where('id', $user_id);
            $data['modified'] = date("Y-m-d H:i:s");
            return (($this->db->update('users', $data)) ? $user_id : False);
            
        }
    }
    
    function update_supplier_user($data, $user_id = '') {
        //filter unwanted fields while inserting in table.
        $needed_array = array('name', 'password', 'email', 'user_type', 'is_active', 'checklist_checked');
        
        
        $data = array_intersect_key($data, array_flip($needed_array));

        if(!empty($data['password'])) {
            $cost = $this->config->item('hash_cost');
            $data['password'] = password_hash(SALT .$data['password'], PASSWORD_BCRYPT, array('cost' => $cost));
        } else {
            unset($data['password']);
        }

        if(empty($user_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('suppliers', $data)) ? $this->db->insert_id() : False);
            
        } else {
            $this->db->where('id', $user_id);
            $data['modified'] = date("Y-m-d H:i:s");
            return (($this->db->update('suppliers', $data)) ? $user_id : False);
            
        }
    }
    
    function update_supplier_inspector_user($data, $user_id = '') {
        //filter unwanted fields while inserting in table.
        $needed_array = array('name', 'password', 'email', 'user_type', 'is_active', 'checklist_checked');
        
        
        $data = array_intersect_key($data, array_flip($needed_array));

        if(!empty($data['password'])) {
            $cost = $this->config->item('hash_cost');
            $data['password'] = password_hash(SALT .$data['password'], PASSWORD_BCRYPT, array('cost' => $cost));
        } else {
            unset($data['password']);
        }

        if(empty($user_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('users', $data)) ? $this->db->insert_id() : False);
            
        } else {
            $this->db->where('id', $user_id);
            $data['modified'] = date("Y-m-d H:i:s");
            return (($this->db->update('supplier_inspector', $data)) ? $user_id : False);
            
        }
    }

    function login_check($username, $password, $only_check = false) {
        if (empty($username) || empty($password)) {
            return False;
        }

        $response['status'] = 'ERROR';
        $response['message'] = 'Invalid Credentials';

        $sql = "SELECT u.*, 
            GROUP_CONCAT(p.id ORDER BY p.name) as product_ids,
            GROUP_CONCAT(p.org_id ORDER BY p.name) as org_ids,
            GROUP_CONCAT(p.org_name ORDER BY p.name) as org_names,
            GROUP_CONCAT(p.name ORDER BY p.name) as product_names
            FROM users u 
            LEFT JOIN products p 
            ON FIND_IN_SET(p.id, u.product_id)
            WHERE u.username = ?
            GROUP BY u.id";
        
        $query = $this->db->query($sql, array($username));

        if ($query->num_rows() == 1) {
            $user = $query->row_array();
            //echo "<pre>";print_r($user);exit;
            if (password_verify(SALT .$password, $user['password'])) {
                if(!$user['is_active']) {
                    $response['message'] = 'Your acount has been deactivated.';
                } else {

                    $response['status'] = 'SUCCESS';
                    
                    if(!$only_check) {
                        $this->create_session($user);
                    }
                    return $response;
                }
            }
        }

        return $response;
    }
    
    function supplier_login_check($username, $password, $type, $only_check = false) {
        if (empty($username) || empty($password)) {
            return False;
        }

        $response['status'] = 'ERROR';
        $response['message'] = 'Invalid Credentials';

        
        if($type == 'Supplier'){
            $sql = "SELECT * FROM suppliers WHERE email = ? GROUP BY id";
        }else{
            $sql = "SELECT * FROM supplier_inspector WHERE email = ? GROUP BY id";
        }
        
        $query = $this->db->query($sql, array($username));

        if ($query->num_rows() == 1) {
            $user = $query->row_array();
            //echo "<pre>";print_r($user);exit;
            if (password_verify(SALT .$password, $user['password'])) {
                if(!$user['is_active']) {
                    $response['message'] = 'Your acount has been deactivated.';
                } else {

                    $response['status'] = 'SUCCESS';
                    if($type == 'Supplier'){
                        $user['user_type'] = 'Supplier';
                    }else{
                        $user['user_type'] = 'Supplier Inspector';
                        
                        $this->load->model('Supplier_model');
                        $supplier = $this->Supplier_model->get_supplier($user['supplier_id']);
                        
                        $user['supplier_no'] = $supplier['supplier_no'];
                    }
                    
                    if(!$only_check) {
                        $this->create_supplier_session($user);
                    }
                    return $response;
                }
            }
        }

        return $response;
    }
    
    function create_session($user) {
        $data = array(
            'is_logged_in' => True,
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'name' => $user['first_name'].' '.$user['last_name'],
            'username' => $user['username'],
            'email' => $user['email'],
            'user_type' => $user['user_type'],
            'product_ids' => $user['product_ids'],
        );
        
        /* echo "<pre>";
        print_r($user);
        print_r($data);
        exit; */
        
        if($user['user_type'] == 'Admin' && empty($user['product_id'])) {
            $all_products = $this->db->get('products')->result_array();
            
            $products = array();
            $product_ids = array();
            foreach($all_products as $k => $pid) {
                if($k === 0) {
                    $data['product_id']         = $pid['id'];
                    $data['product_name']       = $pid['name'];
                    $data['org_id']             = $pid['org_id'];
                    $data['org_name']           = $pid['org_name'];
                }
                
                $temp = array();
                $temp['id']             = $pid['id'];
                $temp['name']           = $pid['name'];
                $temp['org_id']         = $pid['org_id'];
                $temp['org_name']       = $pid['org_name'];
                $product_ids[]          = $pid['id'];
                $products[]             = $temp;
            }

            $data['product_ids']        = implode(',', $product_ids);
            $data['is_super_admin']     = true;
        } else {
            $data['is_super_admin'] = false;
            $product_ids = explode(',', $user['product_ids']);
            $org_ids = explode(',', $user['org_ids']);
            $org_names = explode(',', $user['org_names']);
            $product_names = explode(',', $user['product_names']);
            $products = array();
            
            if(count($product_ids)) {
                foreach($product_ids as $k => $pid) {
                    if($k === 0) {
                        $data['product_id']     = $pid;
                        $data['product_name']   = $product_names[$k];
                        $data['org_id']   = $org_ids[$k];
                        $data['org_name']   = $org_names[$k];
                    }
                    
                    $temp = array();
                    $temp['id'] = $pid;
                    $temp['name'] = $product_names[$k];
                    $temp['org_id'] = $org_ids[$k];
                    $temp['org_name'] = $org_names[$k];
                    
                    $products[] = $temp;
                }

            }
        }
        
        $data['products'] = $products;
        
        //echo "<pre>";print_r($data);exit;
        $this->session->set_userdata($data);
        
        return true;
    }
    
    function create_supplier_session($user) {
        $data = array(
            'is_logged_in'              => True,
            'id'                        => $user['id'],
            'first_name'                => $user['name'],
            'last_name'                 => '',
            'name'                      => $user['name'],
            'username'                  => $user['email'],
            'email'                     => $user['email'],
            'user_type'                 => $user['user_type'],
            
            'supplier_no'               => $user['supplier_no'],
            'supplier_name'             => $user['name'],
            'is_active'                 => $user['is_active'],
        );
        
        if($user['user_type'] == 'Supplier Inspector'){
            $data['supplier_id'] = $user['supplier_id'];
        }else{
            $data['supplier_id'] = $user['id'];
        }
        
        $query = "SELECT DISTINCT p.id, p.name, p.org_id , p.org_name
        FROM `sp_mappings` sp 
        INNER JOIN products p 
        ON sp.product_id = p.id 
        WHERE sp.supplier_id = ?";
        
        $all_products = $this->db->query($query, array($data['supplier_id']))->result_array();
        
        $products = array();
        $product_ids = array();
        
        foreach($all_products as $k => $pid) {
            if($k === 0) {
                $data['product_id']     = $pid['id'];
                $data['product_name']   = $pid['name'];
                $data['org_id']         = $pid['org_id'];
                $data['org_name']       = $pid['org_name'];
            }
            
            $temp               = array();
            $temp['id']         = $pid['id'];
            $temp['name']       = $pid['name'];
            $temp['org_id']     = $pid['org_id'];
            $temp['org_name']   = $pid['org_name'];
            $product_ids[]      = $pid['id'];
            $products[]         = $temp;
        }
        
        $data['product_ids']    = implode(',', $product_ids);
        $data['products']       = $products;

        $this->session->set_userdata($data);
        
        return true;
    }

    function login_by_email($email) {
        $sql = "SELECT u.*, 
            GROUP_CONCAT(p.id ORDER BY p.name) as product_ids,
            GROUP_CONCAT(p.name ORDER BY p.name) as product_names
            FROM users u 
            LEFT JOIN products p 
            ON FIND_IN_SET(p.id, u.product_id)
            WHERE u.email = ?
            GROUP BY u.id";
        
        $query = $this->db->query($sql, array($email));
        if ($query->num_rows() == 1) {
            $user = $query->row_array();            
            $this->create_session($user);

            return true;
        }
        
        return false;
    }
    
    function change_password($id, $password) {
        if(!empty($password)) {
            $cost = $this->config->item('hash_cost');
            $password = password_hash(SALT .$password, PASSWORD_BCRYPT, array('cost' => $cost));

            $this->db->where('id', $id);
            $this->db->set('password', $password);

            $this->db->update('users');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }

        }

        return False;
    }

    function change_status($id, $status) {
        if(!empty($id) && !empty($status)) {
            $user_active = ($status == 'active') ? 1 : 0;
            
            $this->db->where('id', $id);
            if($this->product_id) {
                $this->db->where('product_id', $this->product_id);
            }
            $this->db->set('is_active', $user_active);
            $this->db->update('users');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function reset_token($user_id, $email) {
        $token = md5($email);
        
        $this->db->where('id', $user_id);        
        $this->db->set('reset_token', $token);
        $this->db->set('reset_request_time', date('Y-m-d H:i:s'));
        
        return (($this->db->update('users')) ? $token : False);
    }
    
    public function find_user_by_token($token){
        $sql = "SELECT * FROM users WHERE reset_token = ? AND reset_request_time >  DATE_SUB( NOW(), INTERVAL 24 HOUR)" ;
        $result = $this->db->query($sql, array($token));
        return $result->row_array();
    }
    
    function get_contact_us_data($id) {
        $this->db->where('id', $id);
        $this->db->where('type', '');

        return $this->db->get('contact_us')->row_array();
    }
    
    function delete_contact_us($id) {
        if(!empty($id)) {
            $this->db->where('id', $id);
            $this->db->set('is_deleted', 1);

            return (($this->db->update('contact_us', $data)) ? $id : false);
        }

        return FALSE;
    }

    function get_career_data($id) {
        $this->db->where('id', $id);

        return $this->db->get('careers')->row_array();
    }
    
    function delete_career($id) {
        if(!empty($id)) {
            $this->db->where('id', $id);
            $this->db->set('is_deleted', 1);

            return (($this->db->update('careers', $data)) ? $id : false);
        }

        return FALSE;
    }

    function get_subscription_data($id) {
        $this->db->where('id', $id);

        return $this->db->get('crg_subscribe')->row_array();
    }
    
    function delete_subscription($id) {
        if(!empty($id)) {
            $this->db->where('id', $id);
            $this->db->set('is_deleted', 1);

            return (($this->db->update('crg_subscribe', $data)) ? $id : false);
        }

        return FALSE;
    }
    
    public function get_career_contact_us_data($start_range, $end_range, $type) {
        $pass_array = array();
        if($type == 'all') {
            $sql = "SELECT id, 'Contact Us' as type, name, email, subject, mobile, comment, 'NA' as cv_name, datetime 
                FROM contact_us WHERE type = '' AND is_deleted = 0 ";
            
            if(!empty($start_range) && !empty($end_range)) {
                $sql .= " AND DATE_FORMAT(datetime, '%Y-%m-%d') BETWEEN ? AND ?";
                $pass_array[] = $start_range;
                $pass_array[] = $end_range;
            }
            
            $sql .= "UNION 
                SELECT id, CONCAT('Career ',type) as type, name, email, 'NA',  mobile, 'NA', cv_name, datetime
                FROM careers WHERE is_deleted = 0 ";

            if(!empty($start_range) && !empty($end_range)) {
                $sql .= " AND DATE_FORMAT(datetime, '%Y-%m-%d') BETWEEN ? AND ?";
                $pass_array[] = $start_range;
                $pass_array[] = $end_range;
            }
            
            $sql .= "UNION 
                SELECT id, 'Subscription' as type, 'NA' as name, email, 'NA',  'NA', 'NA', 'NA', datetime
                FROM crg_subscribe WHERE is_deleted = 0 ";

            if(!empty($start_range) && !empty($end_range)) {
                $sql .= " AND DATE_FORMAT(datetime, '%Y-%m-%d') BETWEEN ? AND ?";
                $pass_array[] = $start_range;
                $pass_array[] = $end_range;
            }
        } else if($type == 'Contact Us') {
            $sql = "SELECT id, 'Contact Us' as type, name, email, subject, mobile, comment, 'NA' as cv_name, datetime 
                FROM contact_us WHERE type = '' AND is_deleted = 0 ";

            if(!empty($start_range) && !empty($end_range)) {
                $sql .= " AND DATE_FORMAT(datetime, '%Y-%m-%d') BETWEEN ? AND ?";
                $pass_array[] = $start_range;
                $pass_array[] = $end_range;
            }
        } else if($type == 'Career') {
            $sql = "SELECT id, CONCAT('Career ',type) as type, name, email, 'NA' as subject,  mobile, comment, cv_name, datetime 
                FROM careers WHERE is_deleted = 0 ";

            if(!empty($start_range) && !empty($end_range)) {
                $sql .= " AND DATE_FORMAT(datetime, '%Y-%m-%d') BETWEEN ? AND ?";
                $pass_array[] = $start_range;
                $pass_array[] = $end_range;
            }
        } else if($type == 'Subscription') {
            $sql = "SELECT id, 'Subscription' as type, 'NA' as name, email, 'NA' as subject,  'NA' as mobile, 'NA' as comment, 'NA' as cv_name, datetime FROM crg_subscribe WHERE is_deleted = 0";

            if(!empty($start_range) && !empty($end_range)) {
                $sql .= " AND DATE_FORMAT(datetime, '%Y-%m-%d') BETWEEN ? AND ?";
                $pass_array[] = $start_range;
                $pass_array[] = $end_range;
            }
        }

        $result = $this->db->query($sql, $pass_array);
        return $result->result_array();
    }
    
    function get_lead_data($id) {
        $this->db->where('id', $id);
        $this->db->where('type !=', '');

        return $this->db->get('contact_us')->row_array();
    }
    
    function delete_lead($id) {
        if(!empty($id)) {
            $this->db->where('id', $id);
            $this->db->set('is_deleted', 1);

            return (($this->db->update('contact_us', $data)) ? $id : false);
        }

        return FALSE;
    }
    
    public function get_leads_data($start_range, $end_range, $type){
       $pass_array = array();
       $sql = "SELECT * FROM contact_us WHERE type != '' AND is_deleted = 0 ";
       if(!empty($start_range) && !empty($end_range)) {
           $sql .= " AND DATE_FORMAT(datetime, '%Y-%m-%d') BETWEEN ? AND ?";
           $pass_array[] = $start_range;
           $pass_array[] = $end_range;
       }
       
       if(!empty($type) && $type != 'all') {
           $sql .= " AND type = ?";
           $pass_array[] = $type;
       }
       
       if($type == 'atlassian'){
           $sql .= " AND type IN('download free trial','Jira Services','Jira health check','confluence service','atlassian training','Get In Touch', 'Book Assigment')";
       }

       $result = $this->db->query($sql, $pass_array);
       return $result->result_array();
   }
   
    public function get_mail_data($start_range, $end_range, $status){
       $pass_array = array();
       $sql = "SELECT * FROM send_mail WHERE status != ''";
       if(!empty($start_range) && !empty($end_range)) {
           $sql .= " AND DATE_FORMAT(created_datetime, '%Y-%m-%d') BETWEEN ? AND ?";
           $pass_array[] = $start_range;
           $pass_array[] = $end_range;
       }
       
       if(!empty($status) && $status != 'all') {
           $sql .= " AND status = ?";
           $pass_array[] = $status;
       }

       $result = $this->db->query($sql, $pass_array);
       return $result->result_array();
    }
    
    public function get_mail($id) {
        $pass_array = array($id);
        $sql = "SELECT * FROM send_mail WHERE id = ?";
        
        $result = $this->db->query($sql, $pass_array);
        return $result->row_array();

    }
}