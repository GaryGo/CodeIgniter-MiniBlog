<?php

    class User_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this -> load -> database();
    
        }

        public function register($user) {
            $this->db->insert('user', $user);
        }

        /* 
        |***************************************************************
        | Select all uemail that is the same with $user.
        | ***************************************************************
        */
        public function retrive($user) {
            $this->db->where('uemail', $user['uemail']);
            $this->db->select("*");
            $query = $this->db->get('user');
            if ($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return FALSE;
            }
        }

        public function retrive_id($uid) {
            $this->db->where('uid', $uid);
            $this->db->select("*");
            $query = $this->db->get('user');
            if ($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return FALSE;
            }
        }

        public function select_all($user, $name_or_email) {
            $this->db->where($name_or_email, $user['$name_or_email']);
            $this->db->select('*');
            $query = $this->db->get('user');
            if($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return FALSE;
            }
        }


        public function delete($user) {
            if (isset($user) && isset($user['uname'])) {
                if ($this->db->delete('user',$user)) {
                    return TRUE;
                }
            }
            return FALSE;
        }



        public function check_email_exist($email) {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('uemail', $email);
            $query = $this->db->get('');
            if($query->num_rows() > 0)
                return TRUE;
            else
                return FALSE;
        }

        // public function check_pw($email) {
        //     $this->db->select('*');
        //     $this->db->from('user');
        //     $this->db->where('uemail', $email);
        //     $query = $this->db->get('');
        //     $user = $query->row_array();
        //     return $user['upw'];
        // }

        public function getUserNameById($uid) {
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where('uid', $uid);
            $query = $this->db->get('');
            if($query->num_rows() > 0) {
                $one_row = $query->row_array();
                return $one_row['uname'];
            } else {
                return FALSE;
            }
        }


        public function getPostNum($uid) {
            $this->db->where('uid', $uid);
            $this->db->select("post");
            $query = $this->db->get('user');
            if ($query->num_rows() > 0) {
                $one_row = $query->row_array();
                // print_r(strval($one_row['post']));
                // die();
                //log_message('debug', "the post number is " . $one_row['post']);
                return $one_row['post'];
            } else {
                //log_message('debug', "Nothing!!!!!!!!the post number is " . $one_row['post']);
                return FALSE;
            }
        }

        public function addPostNum($uid) {
            $init_num = $this->getPostNum($uid);
            $now_num = $init_num + 1;
            $new_data = array('post' => $now_num);
            $this->db->where('uid', $uid);
            $this->db->update('user', $new_data);
        }

        public function minusPostNum($uid) {
            $init_num = $this->getPostNum($uid);
            $now_num = $init_num - 1;
            $new_data = array('post' => $now_num);
            $this->db->where('uid', $uid);
            $this->db->update('user', $new_data);
        }

        public function getFriendNum($uid) {
            $this->db->where('uid', $uid);
            $this->db->select("friend");
            $query = $this->db->get('user');
            if ($query->num_rows() > 0) {
                $one_row = $query->row_array();
                return $one_row['friend'];
            } else {
                return FALSE;
            }
        }

        public function addFriendNum($uid) {
            $init_num = $this->getFriendNum($uid);
            $now_num = $init_num + 1;
            $new_data = array('friend' => $now_num);
            $this->db->where('uid', $uid);
            $this->db->update('user', $new_data);
        }

        public function minusFriendNum($uid) {
            $init_num = $this->getFriendNum($uid);
            $now_num = $init_num - 1;
            $new_data = array('friend' => $now_num);
            $this->db->where('uid', $uid);
            $this->db->update('user', $new_data);
        }

        public function setLastpostTime($uid) {
            date_default_timezone_set('America/New_York');
            $last_post_time = date('Y-m-d H:i:s', time());
            $new_data = array('lastposttime' => $last_post_time);
            $this->db->where('uid', $uid);
            $this->db->update('user', $new_data);
        }

    }
?>