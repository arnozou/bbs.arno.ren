<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use Dingo\Api\Exception\ValidationHttpException;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\AuthcodeInterface;
use App\Transformers\LoginTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\EmailLogin;
use App\User;
use Auth;
use App\Http\Controllers\Traits\DingoValidateTrait;
// use Validator;

class LoginController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use DingoValidateTrait;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserInterface $userInterface)
    {
        // $this->middleware('guest')->except('logout');
        $this->userInterface = $userInterface;
    }

    public function wechat(Request $request)
    {
        // validate

        $wechatId = $request->input('wechat_id');
        $wechatInfo = $request->input('wechat_info');

        $user = $this->userInterface->findOrCreateWithWechat($wechatId, $wechatInfo);

        return $this->response->item($user);
    }

    public function mobile(Request $request, AuthcodeInterface $authcodeRepository)
    {
        $this->validate($request->all(), [
            'mobile'    => 'required|integer',
            'code'      => 'required|integer'
            ]);

        $mobile = $request->input('mobile');
        $code = $request->input('code');
        if ($authcodeRepository->checkCode($mobile, $code)) {
            $user = $this->userInterface->findOrCreateWithMobile($mobile);

            return $this->response->item($user, new LoginTransformer());
        } else {
            return $this->response->errorForbidden('验证码错误');
        }

        
        
    }

    public function login(Request $request)
    {
        $this->validate($request->all(), [
            'email'     => 'sometimes|email',
            'mobile'    => 'required_without:email|integer',
            'password'  => 'required'
            ]);
        
        $data = $request->intersect(['email', 'mobile', 'password']);
        if (Auth::once($data)) {
            return $this->response->item(Auth::getLastAttempted(), new \App\Transformers\LoginTransformer());
        } else {
            return $this->response->errorForbidden('用户名和密码不匹配');
        }
    }
    public function email(EmailLogin $request)
    {
        $datas = $request->all();

        if (Auth::once(['email' => $datas['email'], 'password' => $datas['password']])) { 
            return $this->response->item(Auth::user(), new LoginTransformer());
        } else {
            return $this->response->errorForbidden('用户名和密码不匹配');
        }
    }

}
