<?php namespace App\Models;
use CodeIgniter\Model;

class SubscribersModel extends Model{
  protected $table = 'subscribers';
  protected $allowedFields = ['company_id', 'email', 'datetime'];
}