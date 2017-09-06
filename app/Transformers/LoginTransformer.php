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
      'avatar_url'=> $user->info->avatar_url,
      'token'     => JWTAuth::fromUser($user),
    ];
  }
}