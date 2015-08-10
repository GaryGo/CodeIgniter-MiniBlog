<?php
    

    class Comment_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this -> load -> database();
    
        }

        public function getCommentByPostId($aid) {

        	//select uname as cname, id,  aid, addtime, content, touid from comment left join user ON comment.uid = user.uid;
        	$query = $this->db->query("select * from comment where aid = " . $aid . ";");
        	if ($query->num_rows() > 0) {
        		$res = $query->result_array();
        		for ($i = 0; $i < count($res); $i++) {
                    $query1 = $this->db->query("select uname from user where uid = " . $res[$i]['uid'] . ";");
                    $uname1 = $query1->row_array();
                    if ($res[$i]['touid'] == 0 or !$res[$i]['touid']) {
                        $names = array('uname' => $uname1['uname'], 'touname' => '');
                    } else {
                        $query2 = $this->db->query("select uname from user where uid = " . $res[$i]['touid'] . ";");
                        $uname2 = $query2->row_array();
                        $names = array('uname' => $uname1['uname'], 'touname' => $uname2['uname']);
                    }
                    
        			$res[$i]['uname'] = $names['uname'];
        			$res[$i]['touname'] = $names['touname'];
        		}
        		return $res;

        	} else {
        		return FALSE;
        	}
        }

        public function add($comment) {
        	$this->db->insert('comment', $comment);
        }


       

        






    }
?>