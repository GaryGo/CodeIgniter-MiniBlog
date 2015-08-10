<?php

    class Lastvisit_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this -> load -> database();
    
        }

        public function firstTimeVisit($new_data) {
            $this->db->insert('lastvisit', $new_data);
        }

        public function setVisitTime($new_data) {
            date_default_timezone_set('America/New_York');
            $now = date('Y-m-d H:i:s', time());
            $this->db->where('uid', $new_data['uid']);
            $this->db->where('visitorid', $new_data['visitorid']);
            $this->db->update('lastvisit', $new_data);
        }

        public function getVisitTime($uid, $visitorid) {
            $query = $this->db->query("select visittime from lastvisit where uid = " . $uid . " and visitorid = " . $visitorid);
            if ($query->num_rows() > 0) {
                $get_data = $query->row_array();
                return $get_data['visittime'];
            } else {
                return FALSE;
            }
        }






    }
?>