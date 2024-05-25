<?php
namespace App\Validation;
use App\Models\Main_item_party_table;

class UserRules
{

  public function validateUser(string $str, string $fields, array $data){
    $model = new Main_item_party_table();
    $user = $model->where('email', $data['email'])->where('deleted',0)->where('main_type','user')->first();

    if(!$user)
      return false;

    return password_verify($data['password'], $user['password']);
  }
}