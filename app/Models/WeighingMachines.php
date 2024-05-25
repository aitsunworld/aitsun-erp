<?php namespace App\Models;
use CodeIgniter\Model;

class WeighingMachines extends Model{
  protected $table = 'weighing_machines';
  protected $allowedFields = ['device_name','slice_unit'];
}