<?php namespace App\Repositories;

use App\Repositories\Interfaces\UserInterface;
use App\User;
use App\UserInfo;

class UserRepository implements UserInterface {

  public function findById($id)
  {
    $user = User::find($id);

    return $user;
  }

  public function findOrCreateWithMobile($mobile)
  {
    $user = User::firstOrCreate([
      'mobile' => $mobile,
    ]);

    $userInfo = UserInfo::where('user_id', $user->id);

    if ($userInfo->exists()) {
      return $user;
    } else {
      $userInfo = new UserInfo();
      $userInfo->user_id = $user->id;
      $userInfo->avatar_url = '';
      $userInfo->nick_name = substr_replace($mobile, 'XXXX', 3, 4);
      $userInfo->save();
    }
    return $user;
  }

  public function findByEmail($email)
  {
    return User::where('email', $email)->first();
  }

  public function CreateWithEmail($email, $password)
  {
    
    $user = User::firstOrNew([
      'email' => $email
      ]);
    $user = new User();
    $user->email = $email;
    $user->password = $password;
    $user->save();

    $userInfo = new UserInfo();
    $userInfo->user_id = $user->id;
    $userInfo->avatar_url = '';
    $userInfo->nick_name = explode('@', $email)[0];
    $userInfo->save();
    
    return $user;
  }
}