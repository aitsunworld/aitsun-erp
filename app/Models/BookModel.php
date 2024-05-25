<?php namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model{
  protected $table = 'library_books';
  protected $allowedFields = ['company_id', 'book_img', 'book_number', 'book_title', 'author', 'category', 'no_of_books', 'datetime', 'deleted'];
}


