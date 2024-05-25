<?php namespace App\Models;

use CodeIgniter\Model;

class ShortLinkModel extends Model{

  protected $table = 'short_links';

  protected $allowedFields = ['url', 'short_link', 'date'];

}