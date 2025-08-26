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
            $user=auth::guard(config('Amer.employers.auth.middleware_key'))->user();
            //get trainings
            $employers=\Amerhendy\Employers\App\Models\Employers::class;
            $userid=$user->id;
            $training=\Amerhendy\Employers\App\Models\CareerPath\Employers_trainings::class;
            $trainings=$training::with(['Employers_CareerPathes','Mosama_JobNames','Mosama_JobNames.Mosama_Groups','Mosama_JobNames.Mosama_JobTitles','Mosama_JobNames.Mosama_Degrees'])->whereHas('Employers',function($q)use($userid){
                return $q->where('Employers.id',$userid);
            })->orderBy('TrainningTimeStart','asc')->get();
            if(count($trainings)){
                $training_data=[];
                foreach ($trainings as $key => $value) {
                    $training_data[$key]['id']=$value->id;
                    $training_data[$key]['Year']=$value->Year;
                    $jobnames=$value->Mosama_JobNames;
                    $mosama_jobnames=[
                                        'text'=>$jobnames->text,
                                        'Mosama_Groups'=>$jobnames->Mosama_Groups->text
                                        ,'Mosama_JobTitles'=>$jobnames->Mosama_JobTitles->text
                                        ,'Mosama_Degrees'=>$jobnames->Mosama_Degrees->text
                    ];
                    $trainings[$key]->JobNames_id=$mosama_jobnames;
                    $trainings[$key]->CareerPath_id=$value->Employers_CareerPathes->Text;
                    $trainings[$key]->Files=json_decode($value->Files);
                    $FilesModel=\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathFiles::class;
                    $trainings[$key]->Files=$FilesModel::whereIn('id',$value->Files)->get(['Text','Link'])->toArray();
                    if($value->TrainningTimeStart !== null){
                        $start=\Carbon\Carbon::create($value->TrainningTimeStart);
                        //dd(\AmerHelper::ArabicDate($start->format('Y'),$start->format('m'),$start->format('d'),$start->format('h'),$start->format('i'),$start->format('A')));
                        $trainings[$key]->TrainningTimeStart=[
                            $value->TrainningTimeStart,
                            \AmerHelper::ArabicDate($start->format('Y'),$start->format('m'),$start->format('d'),$start->format('h'),$start->format('i'),$start->format('A'))
                        ];
                    }
                    if($value->TrainningTimeEnd !== null){
                        $end=\Carbon\Carbon::create($value->TrainningTimeEnd);
                        $trainings[$key]->TrainningTimeEnd=[
                            $value->TrainningTimeEnd,
                            \AmerHelper::ArabicDate($end->format('Y'),$end->format('m'),$end->format('d'),$end->format('h'),$end->format('i'),$end->format('A'))
                        ];
                    }
                    if($value->TestDate !== null)
                    {
                        $TestDate=\Carbon\Carbon::create($value->TestDate);
                        $trainings[$key]->TestDate=[
                            $value->TestDate,
                            \AmerHelper::ArabicDate($TestDate->format('Y'),$TestDate->format('m'),$TestDate->format('d'),$TestDate->format('h'),$TestDate->format('i'),$TestDate->format('A')),
                            $this->checkTestTimeStatus($value->TestDate)
                        ];
                    }
                    /////////create status
                    if(($value->TrainningTimeStart !== null) || ($value->TrainningTimeEnd !== null)){
                        $trainings[$key]->TrainningStatus=$this->checkdatesStatus($value->TrainningTimeStart[0],$value->TrainningTimeEnd[0]);
                    }
                    //dd($value->toArray());
                }
                $user['trainings']=$trainings;
            }
            $user['JobName']=Mosama_JobNames::where('JobTitle_id',$user->JobTitle_id)->where('Degree_id',$user->Degree_id)->where('Group_id',$user->Group_id)->get(['text','id']);
            return view('Employers::dashboard',['user'=>$user,'Regulations'=>Regulations::all()]);
        }else{
            return view(Amerview('content.Employers.home'));
        }
    }
    function checkdatesStatus($start,$end){
        $start=\Carbon\Carbon::create($start);
        $end=\Carbon\Carbon::create($end);
        $st=\Carbon\Carbon::now()->between($start, $end);
        if($st == true){
            $status='now';
        }elseif($start->isFuture()){
                $status='future';
            }else{
                $status='past';
            }
        return $status;
    }
    function checkTestTimeStatus($time){
        $time=\Carbon\Carbon::create($time);
        $now=\Carbon\Carbon::now();
        if($time->isSameDay($now)){
            $status='today';
        }else{
            if($time->isFuture()){
                $status="future";
            }else{
                $status='past';
            }
        }
        return $status;
    }
}