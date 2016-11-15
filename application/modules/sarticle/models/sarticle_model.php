<?php

class Article_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    var $table = 'article';
    
    function count_all_num_rows()
    {
        //method untuk mengembalikan nilai jumlah baris dari database.
        return $this->db->count_all($this->table);
    }
    
    function get_last_article($limit, $offset)
    {
        $this->db->select('article.id, news_category.name as category, article.lang, article.permalink, article.user, article.publish, article.title, article.dates, article.time, article.comment');
        $this->db->from('article, news_category'); // from table dengan join nya
        $this->db->where('article.category_id = news_category.id');
        $this->db->order_by('article.dates', 'desc');
        $this->db->limit($limit, $offset);
        return $this->db->get(); // mengembalikan isi dari db
    }

    function search_article($val=null, $date=null, $lang=null)
    {
        $this->db->select('article.id, news_category.name as category, article.lang, article.permalink, article.user, article.title, article.publish, article.dates, article.time, article.comment');
        $this->db->from('article, news_category');
        $this->db->where('article.category_id = news_category.id');
        $this->cek_null($val,"article.category_id");
        $this->cek_null($date,"article.dates");
        $this->cek_null($lang,"article.lang");

        $this->db->order_by('article.dates', 'desc');
        return $this->db->get(); // mengembalikan isi dari db
    }

    function cek_null($val,$field)
    {
        if ($val == ""){return null;}
        else {return $this->db->where($field, $val);}
    }
    
    function delete($uid)
    {
        $this->db->where('id', $uid);
        $this->db->delete($this->table); // perintah untuk delete data dari db
    }

    function delete_based_category($uid)
    {
        $this->db->where('category_id', $uid);
        $this->db->delete($this->table); // perintah untuk delete data dari db
    }
    
    function add($users)
    {
        $this->db->insert($this->table, $users);
    }
    
    function get_article_by_id($uid)
    {
        $this->db->select('id, category_id, lang, permalink, user, comment, front, title, dates, time, image, text, publish');
        $this->db->where('id', $uid);
        return $this->db->get($this->table);
    }


    function get_article_name()
    {
        $this->db->where('publish', 1);
        $this->db->order_by('name', 'asc'); // query order
        return $this->db->get($this->table);
    }
    
    function counter()
    {
        $this->db->select_max('userid');
        return $this->db->get($this->table);
    }
    
    function update($uid, $users)
    {
        $this->db->where('id', $uid);
        $this->db->update($this->table, $users);
    }
    
    function valid_title($name)
    {
        $this->db->where('title', $name);
        $query = $this->db->get($this->table)->num_rows();
        if($query > 0) { return FALSE; } else { return TRUE; }
    }

    function validating_title($name,$id)
    {
        $this->db->where('title', $name);
        $this->db->where_not_in('id', $id);
        $query = $this->db->get($this->table)->num_rows();
        if($query > 0) { return FALSE; } else { return TRUE; }
    }

}

?>