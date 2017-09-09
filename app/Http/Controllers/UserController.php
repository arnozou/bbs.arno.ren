<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserInterface;
use App\Transformers\UserTransformer;
use App\Transformers\UserEditTransformer;
use App\Transformers\TopicTransformer;
use App\Transformers\ReplyTransformer;
use Mail;
use Auth;

class UserController extends ApiController
{
  use Traits\DingoValidateTrait;

  public function __construct(UserInterface $userRepository)
  {
    $this->userR = $userRepository;
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request->all(), [
      'mobile'            => 'required_without:email|integer',
      'email'             => 'required_without:mobile|email',
      'nick_name'         => 'required',
      'password'          => 'required|string|min:6|confirmed',
      // 'password_confirmation'  => 'same:password',
      'real_name'         => 'nullable|string|realname|unique:user_infos',
      'gender'            => 'nullable|between:0,1',
      'age'               => 'nullable|between:0,150',
      'qq'                => 'nullable|digits_between:8,11',
      'intro'             => 'nullable|string',
      ]);
    $datas = collect($request->all())->reject(function ($value) {
        return empty($value);
      });
    $user = $this->userR->createWithInfo($datas->toArray());

    if ($user) {
      return $this->response->item($user, new UserTransformer());
    } else {
      return $this->response->errorInternal();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show2($id)
  {
      $user = $this->user;
      if (Auth::check()) {
          echo 'checked';
      } else {
          echo 'unchecked';
      }
      return response($user);
  }

  public function show($id)
  {
    $user = $this->userR->with('info')->find($id);
      return $this->response->item($user, new UserTransformer());

    if ($user) {
      return $this->response->item($user, new UserTransformer());
    } else {
      return $this->response->errorInternal();
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit()
  {
    $this->user()->load('info');

    return $this->response->item($this->user(), new UserEditTransformer());
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->validate($request->all(), [
      'mobile'            => 'required_without:email|integer',
      'email'             => 'required_without:mobile|email',
      'nick_name'         => 'required|unique:user_infos',
      'real_name'         => 'present',
      'gender'            => 'required|between:0,1',
      'birthday'          => 'present|date',
      'age'               => 'present|between:0,150',
      'qq'                => 'present|digits_between:6,11',
      'intro'             => 'present|string',
      ]);

    
    $this->user()->fill($request->all());
    $this->user()->info->fill($request->all());

    if ($this->user()->save()) {
      return $this->response->accepted(null, '更改已生效');
    } else {
      return $this->response->errorInternal();
    }

  }

  public function updatePassword(Request $request)
  {
    $this->validate($request->all(), [
      'password'   => 'required|confirmed'
      ]);
    $this->user()->password = \Hash::make($request->input('password'));
    if ($this->user()->save()) {
      return $this->response->accepted();
    } else {
      return $this->response->errorInternal();
    }
  }
  public function updateAvatar(Request $request)
  {

    if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
      $path = $request->file('avatar')->store('avatars');
      $path = \Storage::url($path);
      $this->user()->info->avatar_url = $path;
      $this->user()->push();

      return $this->response->accepted(null, ['url' => $path]);
    }
    return $this->response->errorInternal(); 
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      //
  }

  public function topics($userId)
  {
    $user = $this->userR->find($userId);
    if ($user) {
      $user->load('topics');
      $user->topics->load('user.info');
      $user->topics->load('lastReply');
      /*foreach ($user->topics as $topic) {
        $topic->setRelation('user', $user);
      }*/
      // dump($user->topics);
      return $this->response->collection($user->topics, new TopicTransformer());
    } else {
      return $this->response->noContent();
    }
  }

  public function replies($userId)
  {
    $user = $this->userR->find($userId);
    if ($user) {
      $user->load('replies');
      $user->replies->load('user.info');
      return $this->response->collection($user->replies, new ReplyTransformer());
    } else {
      return $this->response->noContent();
    }
  }
}
