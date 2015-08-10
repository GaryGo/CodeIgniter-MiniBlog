<?php

    class Visitor_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this -> load -> database();
    
        }

        public function initUserVisitor($uid) {
            $new_row = array('uid' => $uid, 'visitornum' => 0, 'onpanel' => 0);
            $this->db->insert('visitors', $new_row);
        }

        public function getPanelNum($uid) {
            $this->db->select('onpanel');
            $this->db->from('visitors');
            $this->db->where('uid', $uid);
            $query = $this->db->get('');
            if ($query->num_rows() > 0) {
                $the_row = $query->row_array();
                return $the_row['onpanel'];
            }
        }

        public function plusPanelNum($uid) {
            $this->db->select('onpanel');
            $this->db->from('visitors');
            $this->db->where('uid', $uid);
            $query = $this->db->get('');
            $the_row = $query->row_array();
            if ($the_row['onpanel'] == 9) {
                $on_panel_num = 9;
            } else {
                $on_panel_num = $the_row['onpanel'] + 1;
                $new_row = array('onpanel' => $on_panel_num);
                $this->db->where('uid', $uid);
                $this->db->update('visitors', $new_row);
            }
        }

        public function getVisitorNum($uid) {
            $this->db->select('visitornum');
            $this->db->from('visitors');
            $this->db->where('uid', $uid);
            $query = $this->db->get('');
            if ($query->num_rows() > 0) {
                $the_row = $query->row_array();
                return $the_row['visitornum'];
            }
        }


        public function plusVisitorNum($uid) {
            $this->db->select('visitornum');
            $this->db->from('visitors');
            $this->db->where('uid', $uid);
            $query = $this->db->get('');
            $the_row = $query->row_array();
            $new_visitor_num = $the_row['visitornum'] + 1;
            $new_row = array('visitornum' => $new_visitor_num);
            $this->db->where('uid', $uid);
            $this->db->update('visitors', $new_row);
        }

        public function getVisitorString($uid) {
            $this->db->select('visitorstr');
            $this->db->from('visitors');
            $this->db->where('uid', $uid);
            $query = $this->db->get('');
            if ($query->num_rows() > 0) {
                $the_row = $query->row_array();
                return $the_row['visitorstr'];
            }
        }

        public function AddVisitorToString($uid) {
            $this -> load-> library('session');
            $this->db->select('visitorstr');
            $this->db->from('visitors');
            $this->db->where('uid', $uid);
            $query = $this->db->get('');
            $init_str = $query->row_array();
            $visitor_id_array = explode('#', $init_str['visitorstr']);
            $visitor_id = $this->session->userdata('uid');
            
            if (!$init_str['visitorstr']) {
                $after_str = $visitor_id . '#';
            } else if (count($visitor_id_array) < 10) {
                $after_str = $visitor_id . '#' . $init_str['visitorstr'];
            } else {
                $str = '';
                for($i = 7; $i >=0; $i--) {
                    $str = $visitor_id_array[$i] . '#' . $str;
                }
                $after_str = $visitor_id . '#' . $str;
            }

            $new_row = array('visitorstr' => $after_str);
            $this->db->where('uid', $uid);
            $this->db->update('visitors', $new_row);
        }


        public function moveVisitToTop($uid, $visitorid) {
            $this->db->from('visitors');
            $this->db->where('uid', $uid);
            $query = $this->db->get('');
            $init_str = $query->row_array();
            $visitor_id_array = explode('#', $init_str['visitorstr']);

            $str = '';
            for ($i = count($visitor_id_array) - 2; $i >= 0 ; $i--) {
                if ($visitor_id_array[$i] == $visitorid) {
                    continue;
                } else {
                    $str = $visitor_id_array[$i] . "#" . $str;
                }
            }
            $str = $visitorid . "#" . $str;
            $new_row = array('visitorstr' => $str);
            $this->db->where('uid', $uid);
            $this->db->update('visitors', $new_row);

        }
        

        






    }
?>