<?php namespace App\Models;
use CodeIgniter\Model;

class SocialMediaModel extends Model{
  protected $table = 'social_medias';
  protected $allowedFields = ['company_id','name','link','class','userid','token'];
}