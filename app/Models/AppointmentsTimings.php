<?php namespace App\Models;
use CodeIgniter\Model;

class AppointmentsTimings extends Model{
  protected $table = 'appointments_timings';
  protected $allowedFields = ['appointment_id', 'week', 'from', 'to'];
}