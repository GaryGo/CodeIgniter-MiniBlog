<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Article extends CI_Controller {

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
        $this -> load-> helper(array('url', 'form'));
        $this -> load-> library('session');
        $this -> load -> model('article_model');
        $this->load->model('category_model');
        $this->load->model('user_model');
    }

	public function index()
	{
		$this->load->view('templates/non-nav-header');
		$this->load->view('add_post');
		$this->load->view('templates/footer');
	}

	public function add() {
		// echo 'here';
		if (!$this->session->userdata('login')) {
			echo 'please login';
		} else {
			date_default_timezone_set('America/New_York');
			$category = $this->input->post('category');
        	$uid = $this->session->userdata('uid');
        	$title = $this->input->post('title');
        	$content = $this->input->post('content');
        	$addtime = date('Y-m-d H:i:s', time());
        	$views = 0;
        	$comments = 0;
        	$visible = $this->input->post('visible');
        	$like = 0;
        	$share = 0;

        	$post = array (
        			'category' => $category,
        			'uid' => $uid,
        			'title' => $title,
        			'content' => $content,
        			'addtime' => $addtime,
        			'views' => $views,
        			'comments'=> $comments,
        			'visible' => $visible,
        			'like' => $like,
        			'share' => $share,
        		);

        	
        	$this->article_model->insert($post);
        	$this->db->trans_begin();
        	$this->category_model->addCategoryArticleNum($category);
        	$this->user_model->addPostNum($uid);
        	$this->user_model->setLastpostTime($uid);
        	if ($this->db->trans_status() === FALSE) {
        		$this->db->trans_rollback();
        	} else {
        		$this->db->trans_commit();
        	}
        	// redirect('login_home');	
		}
	}

	public function likeArticle() {
		$this->load->model('userlike_model');
		$id = $this->input->post('id');
		$uid = $this->session->userdata('uid');
		if ($this->userlike_model->isUserLike($uid, $id)) {
			echo "notchange";
		} else {
			$this->db->trans_begin();
			$this->userlike_model->userLike($uid, $id);
			$new_num = $this->article_model->likePlusOne($id);
			if ($this->db->trans_status() === FALSE) {
				// generate an error;
        		$this->db->trans_rollback();
        	} else {
        		$this->db->trans_commit();
        	}
			echo $new_num;
		}
	}


	public function toEdit($aid) {
		$this->load->view('templates/non-nav-header');
		$this->load->view('edit_post');
		$this->load->view('templates/footer');
	}

	public function initEditPage() {
		$this->load->model('article_model');
		$aid = $this->input->post('aid');
		$post = $this->article_model->getPostById($aid);
		if ($post) {
			if ($post['uid'] == $this->session->userdata('uid')) {
				echo json_encode(array($post));
			} else {
				echo "hahah";
			}
		} else {
			echo "lalal";
		}
	}


	public function updateEditedPost() {

		// 'visible': $visible,
  //                   'category': $category,
  //                   'title': $title,
  //                   'content': $content
		date_default_timezone_set('America/New_York');
		$this->load->model('category_model');
		$this->load->model('article_model');
		$id = $this->input->post('id');
		$visible = $this->input->post('visible');
		$category = $this->input->post('category');
		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$edittime = date('Y-m-d H:i:s', time());

		//if category change. do sth;
		if ($this->input->post('init_category') != $category) {
			$this->db->trans_begin();
			$this->category_model->minusCategoryArticleNum($this->input->post('init_category'));
			$this->category_model->addCategoryArticleNum($category);
			if ($this->db->trans_status() === FALSE) {
        		$this->db->trans_rollback();
        		// generate an error;
        	} else {
        		$this->db->trans_commit();
        	}
		}

		$new_post = array(
				'visible' => $visible,
				'category' => $category,
				'title' => $title,
				'content' => $content,
				'edittime' => $edittime
			);

		$this->db->where('id', $id);
        $this->db->update('post', $new_post);
	}


	public function getPostGroupByWhat() {
		$uid = $this->input->post('uid');
		$unit = $this->input->post('unit');
		$post_get = $this->article_model->getPostGroupByWhat($uid, $unit);
		// echo $post_get;
		if ($post_get) {
			echo json_encode($post_get);
		} else {
			echo $post_get;
		}
	}

	public function addComment() {
		$this->load->model('comment_model');
		$aid = $this->input->post('aid');
		$uid = $this->session->userdata('uid');
		$touid = $this->input->post('touid');
		date_default_timezone_set('America/New_York');
		$addtime = date('Y-m-d H:i:s', time());
		$view = 0;
		$content = $this->input->post('content');
		$comment = array(
				'view' => $view,
				'aid' => $aid,
				'uid' => $uid,
				'addtime' => $addtime,
				'content' => $content,
				'touid' => $touid
			);

		$this->db->trans_start();
		$this->comment_model->add($comment);
		$this->article_model->commentPlusOne($aid);
		$this->db->trans_complete();
	}







}
