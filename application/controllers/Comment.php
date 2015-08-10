<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct() {
        parent :: __construct();
        $this -> load-> library('session');
        $this -> load -> model('article_model');
        $this->load->model('category_model');
        $this->load->model('user_model');
        $this->load->model('comment_model');
    }

    public function addToAll() {
    	$uid = $this->session->userdata('uid');
    	$content = $this->input->post('content');
    	$aid = $this->input->post('aid');
    	$view = 0;
    	date_default_timezone_set('America/New_York');
    	$addtime = date('Y-m-d H:i:s', time());
    	$touid = 0;
    	$comment = array(
    			'view' => $view,
    			'aid' => $aid,
    			'uid' => $uid,
    			'addtime' => $addtime,
    			'content' => $content,
    			'touid' => $touid
    		);
    	$this->db->trans_begin();
    	$this->article_model->commentPlusOne($aid);
    	$this->comment_model->add($comment);
    	if ($this->db->trans_status() === FALSE) {
        		$this->db->trans_rollback();
        		// generate an error;
        	} else {
        		$this->db->trans_commit();
        	}
    	echo "success";

    }

    public function addToUser() {
        $uid = $this->session->userdata('uid');
        $content = $this->input->post('content');
        $aid = $this->input->post('aid');
        $view = 0;
        date_default_timezone_set('America/New_York');
        $addtime = date('Y-m-d H:i:s', time());
        $touid = $this->input->post('touid');
        $comment = array(
                'view' => $view,
                'aid' => $aid,
                'uid' => $uid,
                'addtime' => $addtime,
                'content' => $content,
                'touid' => $touid
            );
        $this->db->trans_begin();
        $this->article_model->commentPlusOne($aid);
        $this->comment_model->add($comment);
        if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                // generate an error;
            } else {
                $this->db->trans_commit();
            }
        echo "success";

    }

	public function getAllCommentById() {
		$aid = $this->input->post('aid');
        // echo $aid;
		$all_comment = $this->comment_model->getCommentByPostId($aid);
		// echo count($all_comment);
		if ($all_comment) {
			echo json_encode($all_comment);
		} else {
			echo "nocomment";
		}
	}





}
