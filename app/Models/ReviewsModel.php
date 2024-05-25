<?php namespace App\Models;

use CodeIgniter\Model;

class ReviewsModel extends Model{
  protected $table = 'reviews';
  protected $allowedFields = [ 'company_id', 'profile_pic', 'user_name', 'designation', 'ratings', 'review'];
}