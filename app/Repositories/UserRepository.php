<?php namespace App\Repositories;

use App\Repositories\Interfaces\UserInterface;
use App\User;
use App\UserInfo;
use DB;

class UserRepository extends Repository implements UserInterface {

  public function findById($id)
  {
    $user = User::find($id);

    return $user;
  }

  public function model()
  {
    return '\App\User';
  }

  public function findOrCreateWithMobile($mobile)
  {
    $user = User::first(['mobile' => $mobile]);
    if ($user) {
      return $user;
    }

    $data = [
    'mobile' => $mobile,
    'nick_name' => substr_replace($mobile, 'XXXX', 3, 4),
    ];

    return $this->createWithInfo($data);
  }

  public function findByEmail($email)
  {
    return User::where('email', $email)->first();
  }

  public function createWithInfo($data)
  {
    $user = new User();
    $user->fill($data);
    // $user->id = 100;
    $user->password = \Hash::make($data['password']);

    $userInfo = new UserInfo();
    $userInfo->fill($data);
    $userInfo->avatar_url = \Storage::url('avatars/GCZaU1jL9Z2abqe5rbo3sodjNujJuYhEtXnw4E3l.jepg');

    DB::beginTransaction();

    $user->save();
    $userInfo->user_id = $user->id;
    $userInfo->save();

    if ($user->exists && $userInfo->exists) {
      DB::commit();
      $user->setRelation('info', $userInfo);

      return $user;
    } else {
      DB::rollback();
    }

    return false;
  }
}