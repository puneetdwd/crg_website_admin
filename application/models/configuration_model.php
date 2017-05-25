<?php

class Configuration_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }
    
    function get_all_configurations() {
        $sql = "SELECT * FROM configurations";

        $configurations = $this->db->query($sql);
        return $configurations->result_array();
    }

    function get_configuration($configuration_id) {
        $this->db->where('id', $configuration_id);

        return $this->db->get('configurations')->row_array();
    }

    function update_configuration($data, $configuration_id = '') {
        //filter unwanted fields while inserting in table.
        $needed_array = array('name', 'email', 'product', 'cc', 'bcc');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($configuration_id)) {
            $data['created'] = date("Y-m-d H:i:s");

            return (($this->db->insert('configurations', $data)) ? $this->db->insert_id() : false);
        } else {
            $this->db->where('id', $configuration_id);
            $data['modified'] = date("Y-m-d H:i:s");

            return (($this->db->update('configurations', $data)) ? $configuration_id : false);
        }
    }

    function delete_configuration($configuration_id) {
        if(!empty($configuration_id)) {
            $this->db->where('id', $configuration_id);
            $this->db->delete('configurations');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
}

?>