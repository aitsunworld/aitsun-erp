<?php namespace App\Models;

use CodeIgniter\Model;

class PostThumbnail extends Model{
  protected $table = 'post_thumbnails';
  protected $allowedFields = ['post_id','thumbnail'];
}