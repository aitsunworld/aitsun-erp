<?php namespace App\Models;
use CodeIgniter\Model;

class NotificationsettingModel extends Model{
  protected $table = 'notification_setting';
  protected $allowedFields = ['company_id', 'InvoiceSent', 'InvoiceViewed', 'InvoicePaid', 'EstimateSent', 'EstimateViewed', 'EstimateAccepted_Rejected'];
}