<?php 
namespace App\Models;
use CodeIgniter\Model;

class ContactType extends Model{
  protected $table = 'contact_types';
  protected $allowedFields = ['company_id', 'contact_type', 'deleted'];
}