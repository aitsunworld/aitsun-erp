<?php namespace App\Models;
use CodeIgniter\Model;

class AppointmentsBookings extends Model{
  protected $table = 'appointments_bookings';
  protected $allowedFields = ['booking_name', 'company_id', 'booking_type', 'resource_id', 'person_id', 'customer', 'book_from', 'book_to', 'appointment_id', 'duration', 'booked_by', 'datetime', 'note', 'deleted'];
}