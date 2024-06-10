<?php namespace App\Models;
use CodeIgniter\Model;

class PosTables extends Model{
  protected $table = 'pos_tables';
  protected $allowedFields = ['floor_id', 'table_name', 'seats', 'shape', 'deleted'];
}