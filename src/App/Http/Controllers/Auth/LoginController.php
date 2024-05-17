<?php
namespace Amerhendy\Employers\App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Amerhendy\Employers\App\Models\Base\Employers;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Alert;
class LoginController extends Controller
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
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
    protected $redirectTo = '/Employers';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:Employers')->except('logout');
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'uid'   => 'required|numeric',
            'nid' => 'required'
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()]);
        }
        $error=[];
        if($request->remember == 'on'){$remembers=true;}else{$remembers=false;}
        $user=Employers::where('nid',$request->nid)->first();
        if($user){
            if($request->uid !== $user->uid){
                $error['uid']=trans('EMPLANG::auth.error_uid');
            }else{
                Auth::guard(config('Amer.employers.auth.middleware_key'))->loginUsingId($user->id);
                //$token = $user->createToken('Employer')->accessToken;
                $request->session()->regenerate();
                Alert::add('success', trans('EMPLANG::auth.loginsuccessed'))->flash();
                $response = ['request'=>$request->toArray()];
                return response($response, 200);
            }
        }else{
            $error['nid']=trans('EMPLANG::auth.error_nid');
        }
        return response(['errors'=>$error]);
    }
    public function logout(Request $request){
        if(Auth::guard(config('Amer.employers.auth.middleware_key'))->check()){
            Auth::guard(config('Amer.employers.auth.middleware_key'))->logout();
            $request->session()->flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Alert::add('success', trans('EMPLANG::auth.logoutsuccessed'))->flash();
            return $this->loggedOut($request) ?: redirect('/');
        }
    }
}