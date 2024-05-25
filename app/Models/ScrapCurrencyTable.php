<?php namespace App\Models;
use CodeIgniter\Model;

class ScrapCurrencyTable extends Model{
  protected $table = 'scrap_currency_table';
  protected $allowedFields = ['currency', 'rate', 'profit'];
}