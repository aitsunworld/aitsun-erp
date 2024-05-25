<?php namespace App\Models;

use CodeIgniter\Model;

class NotificationsModel extends Model{
  protected $table = 'notifications';
  protected $allowedFields = ['company_id','title', 'message', 'url', 'icon', 'n_datetime', 'user_id', 'nread', 'notified','for_who','notid'];
}
