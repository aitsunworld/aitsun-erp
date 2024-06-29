<?php namespace App\Models;
use CodeIgniter\Model;

class RentalHoursModel extends Model{
  protected $table = 'rental_hours';
  protected $allowedFields = ['company_id', 'period_name', 'period_duration', 'unit'];
}