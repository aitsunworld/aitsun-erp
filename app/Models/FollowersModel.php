<?php namespace App\Models;

use CodeIgniter\Model;

class FollowersModel extends Model{
  protected $table = 'followers_table';
  protected $allowedFields = ['follower_id','lead_id'];
}