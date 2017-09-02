<?php
namespace App\Transformers;

use App\User;


class UserTransformer extends BaseTransformer {

  public function transform(User $model)
  {
    return [
      'id'            => $model->id,
      'nick_name'     => $model->info->nick_name,
      // 'real_name'     => $model->info->real_name,
      'email'         => $model->email,
      'qq'            => $model->info->qq,
      'intro'         => $model->info->intro,
      'avatar_url'    => $model->info->avatar_url,
      // 'posts'      => 
    ];
  }
}