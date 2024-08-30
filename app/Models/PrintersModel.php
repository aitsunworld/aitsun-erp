<?php namespace App\Models;
use CodeIgniter\Model;

class PrintersModel extends Model{
  protected $table = 'printers';
  protected $allowedFields = ['company_id', 'user_id', 'printer_name', 'options', 'status','silent','top','right','bottom','left','scale','default'];
}