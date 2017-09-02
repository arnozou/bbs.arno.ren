<?php
namespace App\Transformers;

use App\User;


class UserEditTransformer extends BaseTransformer {

  public function transform(User $model)
  {
    return [
      'id'            => $model->id,
      'mobile'        => $model->mobile,
      'email'         => $model->email,
      'nick_name'     => $model->info->nick_name,
      'real_name'     => $model->info->real_name,
      'birthday'      => $model->info->birthday,
      'gender'        => $model->info->gender,
      'age'           => $model->info->age,
      'qq'            => $model->info->qq,
      'intro'         => $model->info->intro,
      'avatar_url'    => $model->info->avatar_url,
      // 'posts'      => 
    ];
  }
}