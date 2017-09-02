<?php
namespace App\Transformers;

use App\User;
use JWTAuth;

class LoginTransformer extends BaseTransformer {

  public function transform(User $user)
  {
    return [
      'id'        => $user->id,
      'mobile'    => $user->mobile,
      'email'     => $user->email,
      'nick_name' => $user->info->nick_name,
      'avator_url'=> $user->info->avator_url,
      'token'     => JWTAuth::fromUser($user),
    ];
  }
}