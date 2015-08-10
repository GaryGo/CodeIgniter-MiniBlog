<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_home extends CI_Controller {


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

        $this -> load-> helper(array('url', 'form', 'timestamp'));
        $this -> load-> library('form_validation');
        $this -> load-> library('session');
        $this -> load -> model('user_model');
        $this->load->model('article_model');


        // $session = array('login' => False);
        // $this->session->set_userdata($session);
    }

	public function index()
	{

		date_default_timezone_set('America/New_York');
		$this->load->model('user_model');
		$this->load->model('visitor_model');
		$this->load->model('relation_model');
		$uid = $this->session->userdata('uid');
		$uname = $this->user_model->getUserNameById($uid);
		$posts = $this->article_model->get_article_by_uid($uid);
		$user = $this->user_model->retrive_id($uid);

		$data['posts'] = $posts;
		$data['user'] = $user;//需要改成整个user存入。
		$data['visit_num'] = $this->visitor_model->getVisitorNum($uid);
		$data['relation'] = $this->relation_model->countFriendNum($uid);
		// $data['post_cnt'] = $this->article_model->getPostGroupNum($uid);
		$data['post_cnt'] = $this->article_model->getPostGroupNum($uid);
		$visitors = $this->visitor_model->getVisitorString($uid);
		$visitors = explode('#', $visitors);
		$data['visitors'] = $visitors;
		$this->load->view('templates/header');
		$this->load->view('user-page', $data);
		$this->load->view('templates/footer');


	}
}
