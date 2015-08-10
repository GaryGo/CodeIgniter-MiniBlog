<?php
    class Article_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this -> load -> database();
    
        }

        public function insert($post) {
            $this->db->trans_start();
        	$this->db->insert('post', $post);
            $this->db->trans_complete();
            if ($this->db->trans_status === FALSE) {
                // generate an error;
            }
        }

        public function get_article_by_uid($uid) {
        	$this->db->where('uid', $uid);
            $this->db->select("*");
            $this->db->order_by('addtime', 'desc');
            $query = $this->db->get('post');
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return FALSE;
            }
        }

        public function getPostById($id) {
            $this->db->select("*");
            $this->db->where('id', $id);
            $query = $this->db->get('post');
            if($query->num_rows() > 0) {
                return $query->row_array();
            } else {
                return FALSE;
            }
        }

        public function likePlusOne($id) {
            
            
            $this->db->select('like');
            $this->db->from('post');
            $this->db->where('id', $id);
            $query = $this->db->get('');
            $now_num = $query->row_array();
            $new_num = $now_num['like'] + 1;
            // $this->db->select('like');
            // $query = $this->db->get('post');
            // $now_num = $query + 1;
            // return $now_num;
            $new_data = array('like' => $new_num);
            $this->db->where('id', $id);
            $this->db->update('post', $new_data);
            return $new_num;
            // // return 1;
        }

        public function getPostGroupNum($uid) {
            $query0 = $this->db->query("select count(*) as 'cnt' from post where uid = " . $uid . " and datediff(addtime, now()) = 0;");
            $query1 = $this->db->query("select count(*) as 'cnt' from post where uid = " . $uid . " and datediff(addtime, now()) >= -7;");
            $query2 = $this->db->query("select count(*) as 'cnt' from post where uid = " . $uid . " and datediff(addtime, now()) >= -30;");
            $query3 = $this->db->query("select count(*) as 'cnt' from post where uid = " . $uid . " and datediff(addtime, now()) >= -365;");
            $query4 = $this->db->query("select count(*) as 'cnt' from post where uid = " . $uid . ";");
            
            $row0 = $query0->row_array();
            $row1 = $query1->row_array();
            $row2 = $query2->row_array();
            $row3 = $query3->row_array();
            $row4 = $query4->row_array();
            $res = array(
                    $row0['cnt'],
                    $row1['cnt'],
                    $row2['cnt'],
                    $row3['cnt'],
                    $row4['cnt']
                );
            return $res;
        }   

        public function getPostGroupByWhat($uid, $unit) {
            //today: 0 ------------------0
            //in a week: >= -7; ---------1
            //in a month: >= - 30; ------2
            //in a year: >= -365; -------3
            //other: < -365; ------------4

            if ($unit == 0) {
                $sql = "SELECT * FROM `post` WHERE uid = " . $uid . " and datediff(addtime, now()) = 0 order by addtime desc;";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }

            } else if ($unit == 1) {
                $sql = "SELECT * FROM `post` WHERE uid = " . $uid . " and datediff(addtime, now()) >= -7 order by addtime desc;";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
            } else if ($unit == 2) {
                $sql = "SELECT * FROM `post` WHERE uid = " . $uid . " and datediff(addtime, now()) >= -30 order by addtime desc;";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
            } else if ($unit == 3) {
                $sql = "SELECT * FROM `post` WHERE uid = " . $uid . " and datediff(addtime, now()) >= -365 order by addtime desc;";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
            } else  {
                $sql = "SELECT * FROM `post` WHERE uid = " . $uid . " order by addtime desc;";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
            }
        }

        public function commentPlusOne($aid) {
            
            $this->db->select('comments');
            $this->db->from('post');
            $this->db->where('id', $aid);
            $query = $this->db->get('');
            $now_num = $query->row_array();
            $new_num = $now_num['comments'] + 1;
            // $this->db->select('like');
            // $query = $this->db->get('post');
            // $now_num = $query + 1;
            // return $now_num;
            $new_data = array('comments' => $new_num);
            $this->db->where('id', $aid);
            $this->db->update('post', $new_data);
            return $new_num;
            // // return 1;
        }

        






    }
?>