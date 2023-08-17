<?php
namespace Amerhendy\Employers\App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Requests\Mosama\Mosama_CompetenciesRequest;
use App\Http\Requests\Mosama\Mosama_ConnectionsRequest;
use App\Http\Requests\Mosama\Mosama_DegreesRequest;
use App\Http\Requests\Mosama\Mosama_EducationsRequest;
use App\Http\Requests\Mosama\Mosama_ExperiencesRequest;
use App\Http\Requests\Mosama\Mosama_GoalsRequest;
use App\Http\Requests\Mosama\Mosama_GroupsRequest;
use App\Http\Requests\Mosama\Mosama_JobsRequest;
use App\Http\Requests\Mosama\Mosama_JobTitlesRequest;
use App\Http\Requests\Mosama\Mosama_ManagersRequest;
use App\Http\Requests\Mosama\Mosama_OrgStruRequest;
use App\Http\Requests\Mosama\Mosama_SkillsRequest;
use App\Http\Requests\Mosama\Mosama_TasksRequest;
use App\Http\Requests\Mosama\Mosama_JobNameRequest;
use \Amerhendy\Employers\App\Models\Regulations\Regulations as Regulations;
use Amerhendy\Employers\App\Models\Mosama_Groups;
use Amerhendy\Employers\App\Models\Mosama_Degrees;
use Amerhendy\Employers\App\Models\Mosama_Educations;
use Amerhendy\Employers\App\Models\Mosama_Connections;
use Amerhendy\Employers\App\Models\Mosama_Competencies;
use Amerhendy\Employers\App\Models\Mosama_Experiences;
use Amerhendy\Employers\App\Models\Mosama_Goals;
use Amerhendy\Employers\App\Models\Mosama_JobNames;
use Amerhendy\Employers\App\Models\Mosama_Skills;
use Amerhendy\Employers\App\Models\Mosama_Managers;
use Amerhendy\Employers\App\Models\Mosama_JobTitles;
use Amerhendy\Employers\App\Models\Mosama_OrgStrues;
use Amerhendy\Employers\App\Models\Mosama_Tasks;
//class Mosama extends Controller
class Employers extends Controller
{
    protected $currentClass;
    
    protected $settings = [];
    protected $currentOperation;
    protected $routeMethod;
    protected $id;
    public function __construct() {
    }
    public function __invoke(Request $request)
    {
        //
    }
    public function index()
    {
        if(auth::guard('Employers')->check())
        {
            $route = Route::currentRouteName();
            $user=auth::guard(config('employers.auth.middleware_key'))->user();
            $userinfo='';
            $user['JobName']=Mosama_JobNames::where('JobTitle_id',$user->Mosama_JobTitles)->where('Degree_id',$user->Mosama_Degrees)->where('Group_id',$user->Mosama_Groups)->get(['text','id']);
            return view('Employers::dashboard',['user'=>$user,'Regulations'=>Regulations::all()]);
        }else{
            return view(Amerview('content.Employers.home'));
        }
        
    }
}