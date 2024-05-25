<?php namespace App\Models;
use CodeIgniter\Model;

class OffersModel extends Model{
  protected $table = 'offers';
  protected $allowedFields = ['company_id','title', 'offerimage', 'section', 'link'];
}