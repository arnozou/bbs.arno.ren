<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Auth;

class UserController extends ApiController
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user;
        if (Auth::check()) {
            echo 'checked';
        } else {
            echo 'unchecked';
        }
        return response($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $email ='970815705@qq.com';
        $name = 'arnozou';
        $uid = '1';
        // config(['mail.password' => 'aa']);
        // config(['app.debug' => false]);
        $code = '1876536';
        print_r(config('mail'));
        // print_r($_ENV);
        // exit;
        $data = ['email'=>$email, 'name'=>$name, 'uid'=>$uid, 'activationcode'=>$code];
        $flag = Mail::send('activemail', $data, function($message) use($data)
        {
            $message->to($data['email'])->subject('欢迎注册我们的网站，请激活您的账号！');
        });

        if ($flag) {
            echo '发送成功';
        } else {
            echo '发送失败';
        }

        var_dump($flag);
        // exit;
        return response($flag);
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
        //
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
}
