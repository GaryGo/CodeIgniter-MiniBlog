<?php 



if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {

        parent :: __construct();

        $this -> load-> helper(array('url', 'form'));
        $this -> load-> library('form_validation');
        $this -> load-> library('session');
        $this -> load -> model('user_model');


        // $session = array('login' => False);
        // $this->session->set_userdata($session);
    }

    /* 
    |***************************************************************
    | Registration
    | ***************************************************************
    */
    public function reg() {
        date_default_timezone_set('America/New_York');
        $this->load->model('visitor_model');
        $now = date('Y-m-d H:i:s', time());

        $user = array(
                    'uemail' => $this->input->post('uemail'),
                    'uname' => $this->input->post('uname'),
                    'upw' => md5($this->input->post('upw')),
                    'flag' => 1,
                    'regtime' => $now
                );
        $this->user_model->register($user);
        // $session = array(
        //             'login' => TRUE,
        //             'uname' => $user['uname'],
        //             'upw'  => $user['upw'],
        //             'uemail' => $user['uemail']
        //         );
        // $this->session->set_userdata($session);

        $config =  array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_user' => 'sysugjf@gmail.com',
                'smtp_pass' => '!Gjf0916lullaby',
                'smtp_port' => '465',
                'charset' => 'utf-8',  
                'wordwrap' => TRUE, 
                'mailtype' => 'html' 
  
            );

        $new_user_email = array('uemail' => $user['uemail']);
        $new_user = $this->user_model->retrive($new_user_email);
        $new_user_id = $new_user['uid'];
        $message = 'http://localhost/~maydaygjf/Hunter_Hunter/index.php/user/activate/' . $new_user_id;
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('sysugjf@gmail.com', 'sysugjf');  
        $this->email->to($user['uemail']);  
        $this->email->subject('Email activate');  
        $this->email->message($message);  
        $this->visitor_model->initUserVisitor($new_user_id);
            if ($this->email->send() ) {
                redirect('signup_alert');
            } else {

                echo $this->email->print_debugger();
            }

        

        
        

        // send activation email
        
        // $this->email->attach('application\controllers\1.jpeg');
        
    }

    /* 
    |***************************************************************
    | Index
    | ***************************************************************
    */
    public function index() {
        redirect('home');
    }

    public function user_index() {
        redirect('Login_home');
    }

    /* 
    |***************************************************************
    | Login
    | ***************************************************************
    */
    function login() {

        $user = array(
            'uemail' => $this->input->post('uemail'),
            'upw' => md5($this->input->post('upw')),
            );

        $the_user = $this->user_model->retrive($user);
        if ($the_user) {
            if ($the_user['upw'] === $user['upw']) {
                $session = array(
                    'login' => TRUE,
                    'uname' => $the_user['uname'],
                    'upw'  => $the_user['upw'],
                    'uemail' => $the_user['uemail'],
                    'uid' => $the_user['uid']
                );
                $this->session->set_userdata($session);
                // echo 'good';
                redirect('Login_home');
            } 
                
            
        } 

    }

    /* 
    |***************************************************************
    | Logout
    | ***************************************************************
    */
    function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }


     /* 
    |***************************************************************
    | Check whether the email is available
    | ***************************************************************
    */


    function check_email_exist() {
        //echo '<h1 style="color:red;">' . $email . '</h1>';
        // echo '<h1 style="color:red;">hello1</h1>';
        $email = $this->input->post('uemail');
        $get_result = $this->user_model->check_email_exist($email);
        // echo $get_result;
        if($get_result) {
            echo "exist";
        } else {
            echo "notexist";
        }
    }

    function check_pw() {
        $user = array(
            'uemail' => $this->input->post('uemail'),
            'upw' => md5($this->input->post('upw')),
            );

        $the_user = $this->user_model->retrive($user);
        if ($the_user) {
            if ($the_user['upw'] === $user['upw']) {
                echo true; //password right
            } else {
                echo false;
            }

        }

    }

    function activate($uid) {
        $result = $this->user_model->retrive_id($uid);
        if ($result) {
            $session = array(
                    'login' => TRUE,
                    'uname' => $result['uname'],
                    'upw'  => $result['upw'],
                    'uemail' => $result['uemail'],
                    'uid' => $result['uid']
                    );
            $this->session->set_userdata($session);
            redirect('Login_home');
        } else {
            echo "error happened!";
        }
    }

    function userPublic($uid) {
        if ($uid == $this->session->userdata('uid')) {
            redirect('login_home');
        }
        $this->load->model('article_model');
        $this->load->helper('timestamp_helper');
        $this->load->model('visitor_model');
        $this->load->model('lastvisit_model');
        $this->load->model('relation_model');
        $posts = $this->article_model->get_article_by_uid($uid);
        $uname = $this->user_model->getUserNameById($uid);
        
        date_default_timezone_set('America/New_York');
        $now = date('Y-m-d H:i:s', time());
        $last_visit_time = $this->lastvisit_model->getVisitTime($uid, $this->session->userdata('uid'));
        if (!$last_visit_time) {
            if ($uid != $this->session->userdata('uid')) {
                $new_data = array(
                        'uid' => $uid,
                        'visitorid' => $this->session->userdata('uid'),
                        'visittime' => $now
                    );
                $this->lastvisit_model->firstTimeVisit($new_data);
                

                // $visitor_string = $this->visitor_model->getVisitorString($uid);
                $this->db->trans_begin();
                $this->visitor_model->plusVisitorNum($uid);
                $this->visitor_model->AddVisitorToString($uid);
                $this->visitor_model->plusPanelNum($uid);
                if ($this->db->trans_status() === FALSE) {
                    //generate an error;
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }


        } else if (longEnoughToVisitAgain($now, $last_visit_time)) {
            //update lastvisit table
            if ($uid != $this->session->userdata('uid')) {
                $new_data = array(
                        'uid' => $uid,
                        'visitorid' => $this->session->userdata('uid'),
                        'visittime' => $now
                    );
                $this->lastvisit_model->setVisitTime($new_data);

                $visitor_string = $this->visitor_model->getVisitorString($uid);
                $this->visitor_model->plusVisitorNum($uid);

                if ($visitor_string[0] == $this->session->userdata('uid')) {
                    //do nothing
                } else {
                    $this->visitor_model->moveVisitToTop($uid, $this->session->userdata('uid'));
                }
                    
            }
        } else {
            // do nothing
        }

        $data['posts'] = $posts;
        $data['user'] = $this->user_model->retrive_id($uid);
        $data['visit_num'] = $this->visitor_model->getVisitorNum($uid);
        $data['relation'] = $this->relation_model->countFriendNum($uid);
        $visitors = $this->visitor_model->getVisitorString($uid);
        $visitors = explode('#', $visitors);
        $data['visitors'] = $visitors;
        $data['post_cnt'] = $this->article_model->getPostGroupNum($uid);

        //render
        $this->load->view('templates/header');
        $this->load->view('user_public', $data);
        $this->load->view('templates/footer');
    }



}







