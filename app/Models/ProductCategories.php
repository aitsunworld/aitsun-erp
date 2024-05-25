<?php namespace App\Models;
use CodeIgniter\Model;

class ProductCategories extends Model{
  protected $table = 'product_categories';
  protected $allowedFields = ['cat_name', 'company_id', 'deleted', 'cat_img', 'menu_cat_img', 'section_cat_img', 'description', 'keywords', 'menulink', 'sectionlink', 'title', 'slug','section_title','section_desc','section_cat_img2','sectionlink2','button_name','button_background_color','button_font_color','button_class','section_title2','section_desc2','button_name2','button_background_color2','button_font_color2','button_class2','cat_department'];
}