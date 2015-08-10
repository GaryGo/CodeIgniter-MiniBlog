<?php

    class Relation_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this -> load -> database();
    
        }

        public function becomeFriend($uid1, $uid2) {
            if($uid2< $uid1) {
                $new_data = array('uid1' => $uid2, 'uid2' => $uid1);
                $this->db->insert('relation', $new_data);
            }
        }

        public function countFriendNum($uid) {
            $query = $this->db->query("select count(*) as 'cnt' from relation where uid1 = ". $uid . " or uid2 = " . $uid);
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                return $row['cnt'];
            }
        }

    }
?>