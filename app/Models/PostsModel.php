<?php namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model{
  protected $table = 'posts';
  protected $allowedFields = ['company_id','title','post_type','category','short_description','description','meta_keyword','meta_description','featured','file_type','alt','status','datetime','slug','cat_name','cat_slug','video_link','post_name','project_date','location','meta_keyword_slug'];
}