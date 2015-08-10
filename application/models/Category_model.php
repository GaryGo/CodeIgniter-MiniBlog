<?php


    class Category_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this -> load -> database();
    
        }

        public function insert($category) {
        	$this->db->insert('category', $category);
        }

        public function getCategoryName($id) {
        	$this->db->where('id', $id);
            $this->db->select("name");
            $query = $this->db->get('category');
            if ($query->num_rows() > 0) {
                $one_row = $query->row_array();
                return $one_row['name'];
            } else {
                return FALSE;
            }
        }

        public function getCategoryArticleNum($id) {
            $this->db->where('id', $id);
            $this->db->select("articles");
            $query = $this->db->get('category');
            if ($query->num_rows() > 0) {
                $one_row = $query->row_array();
                return $one_row['articles'];
            } else {
                return FALSE;
            }
        }

        public function addCategoryArticleNum($id) {
            $init_num = $this->getCategoryArticleNum($id);
            $now_num = $init_num + 1;
            $new_data = array('articles' => $now_num);
            $this->db->where('id', $id);
            $this->db->update('category', $new_data);
        }


        public function minusCategoryArticleNum($id) {
            $init_num = $this->getCategoryArticleNum($id);
            $now_num = $init_num - 1;
            $new_data = array('articles' => $now_num);
            $this->db->where('id', $id);
            $this->db->update('category', $new_data);
        }



        






    }
?>