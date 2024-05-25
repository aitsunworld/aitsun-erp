<?php namespace App\Models;
use CodeIgniter\Model;

class HomesliderModel extends Model{
  protected $table = 'home_design';
  protected $allowedFields = ['company_id','title', 'homeimage', 'section', 'link','use_custom_contain','button_name','button_background_color','button_font_color','button_class','bg_gradient','mockup_shadow','position','mblimage','description'];
}