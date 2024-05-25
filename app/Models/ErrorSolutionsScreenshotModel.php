<?php namespace App\Models;
use CodeIgniter\Model;

class ErrorSolutionsScreenshotModel extends Model{
  protected $table = 'error_screenshots';
  protected $allowedFields = ['error_id', 'screenshot'];
}
