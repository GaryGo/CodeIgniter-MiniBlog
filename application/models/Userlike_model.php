<?php
    class Userlike_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this -> load -> database();
    
        }

        
        public function isUserLike($uid, $id) {
            $query = $this->db->query('SELECT * FROM alike WHERE aid = ' . $id . '&& uid = ' . $uid);
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        public function userLike($uid, $id) {
            $insert_data = array('uid' => $uid, 'aid' => $id);
            $this->db->insert('alike', $insert_data);
        }



        






    }
?>