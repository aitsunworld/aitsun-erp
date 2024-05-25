<?php namespace App\Models;
use CodeIgniter\Model;

class ExgroupheadsModel extends Model{
  protected $table = 'ex_groupheads';
  protected $allowedFields = ['company_id','academic_year','grouphead_name', 'account_catid', 'slug', 'effect_to', 'pos_default', 'deleted','side'];
}