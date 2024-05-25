<?php namespace App\Models;
use CodeIgniter\Model;

class TestModel extends Model{
  protected $table = 'test_table';
  protected $allowedFields = ['data'];
}