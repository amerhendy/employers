<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Illuminate\Support\Facades\Auth;
use \Amerhendy\Employers\App\Models\Mosama_Groups as Mosama_Groups;
use \Amerhendy\Employers\App\Models\Mosama_Degrees as Mosama_Degrees;
use \Amerhendy\Employers\App\Models\Mosama_Connections as Mosama_Connections;
use \Amerhendy\Employers\App\Models\Mosama_Educations as Mosama_Educations;
use \Amerhendy\Employers\App\Models\Mosama_Experiences as Mosama_Experiences;
use \Amerhendy\Employers\App\Models\Mosama_Managers as Mosama_Managers;
use \Amerhendy\Employers\App\Models\Mosama_JobTitles as Mosama_JobTitles;
use \Amerhendy\Employers\App\Models\Mosama_JobNames as Mosama_JobName;
use \Amerhendy\Employers\App\Models\Mosama_OrgStruses as Mosama_OrgStru;
use \Amerhendy\Employers\App\Models\Mosama_Tasks as Mosama_Tasks;
class MosamaAmerController extends AmerController
{
    function __invoke(){
        return $this->index();
    }
    function index(){
        $login=0;
        $guards=config('auth.guards');
        if(auth::guard(config('Amer.employers.auth.middleware_key'))->check()){
            $login=1;
        }elseif(auth::guard(config('Amer.Security.auth.middleware_key'))->check()){
            $login=1;
        }
        if($login==0){
            return view('errors.layout',['error_number'=>404,'error_message'=>__LINE__]);
        }
        $route = \Route::currentRouteName();
        if($route =='Mosama_print.index' || $route =='admin.Mosama_print.index'){
            return $this->showprintjobname();
        }
        if($route =='Mosama.index' || $route =='admin.Mosama.index'){
            $data=[
                'Mosama_Groups'=>Mosama_Groups::get(['id','text'])->toArray(),
                'Mosama_Degrees'=>Mosama_Degrees::get(['id','text'])->toArray(),
                'Mosama_Connections_in'=>Mosama_Connections::where('type','in')->get(['id','text'])->toArray(),
                'Mosama_Connections_out'=>Mosama_Connections::where('type','out')->get(['id','text'])->toArray(),
                'Mosama_Educations'=>Mosama_Educations::get(['id','text'])->toArray(),
                'Mosama_Experiences'=>Mosama_Experiences::all()->toArray(),
                'Mosama_Managers'=>Mosama_Managers::get(['id','text'])->toArray(),
                'Mosama_JobTitles'=>Mosama_JobTitles::get(['id','text','Group_id'])->toArray(),
                'Mosama_OrgStru'=>Mosama_OrgStru::get(['id','text'])->toArray(),
                'Mosama_Tasks'=>Mosama_Tasks::get(['id','text','type'])->toArray(),
            ];
            $Mosama_JobName=Mosama_JobName::with(['Mosama_Tasks'=>function($q){return $q->select('Mosama_JobName_Tasks.Task_id');}])->with(['Mosama_Skills'=>function($q){return $q->select('Mosama_JobName_Skills.Skill_id');}])->with(['Mosama_OrgStruses'=>function($q){return $q->select('Mosama_JobName_OrgStru.OrgStru_id');}])->with(['Mosama_Experiences'=>function($q){return $q->select('Mosama_JobName_Experiences.Experience_id');}])->with(['Mosama_Educations'=>function($q){return $q->select('Mosama_JobName_Educations.Education_id');}])->with(['Mosama_Connections'=>function($q){return $q->select('Mosama_JobName_Connections.Connection_id');}])->with(['Mosama_Managers'=>function($q){return $q->select('Mosama_JobName_Managers.Manager_id');}])->get(['id','text','JobTitle_id','Degree_id','Group_id'])->toArray();
            foreach($Mosama_JobName as $a=>$b){
                $Mosama_JobName[$a]['Mosama_JobTitles'][0]=$b['JobTitle_id'];unset($Mosama_JobName[$a]['JobTitle_id']);
                $Mosama_JobName[$a]['Mosama_Degrees'][0]=$b['Degree_id'];unset($Mosama_JobName[$a]['Degree_id']);
                $Mosama_JobName[$a]['Mosama_Groups'][0]=$b['Group_id'];unset($Mosama_JobName[$a]['Group_id']);
                $tasks=[];$skills=[];$managers=[];$orgstru=[];$exprer=[];$education=[];$connections=[];
                if(count($b['mosama__tasks'])){foreach($b['mosama__tasks'] as $c=>$d){$tasks[]=$d['Task_id'];}}
                unset($Mosama_JobName[$a]['mosama__tasks']);$Mosama_JobName[$a]['Mosama_Tasks']=$tasks;
                if(count($b['mosama__skills'])){foreach($b['mosama__skills'] as $c=>$d){$skills[]=$d['Skill_id'];}}
                unset($Mosama_JobName[$a]['mosama__skills']);$Mosama_JobName[$a]['Mosama_Skills']=$skills;
                if(count($b['mosama__org_struses'])){foreach($b['mosama__org_struses'] as $c=>$d){$orgstru[]=$d['OrgStru_id'];}}
                unset($Mosama_JobName[$a]['mosama__org_struses']);$Mosama_JobName[$a]['Mosama_OrgStru']=$orgstru;
                if(count($b['mosama__experiences'])){foreach($b['mosama__experiences'] as $c=>$d){$exprer[]=$d['Experience_id'];}}
                unset($Mosama_JobName[$a]['mosama__experiences']);$Mosama_JobName[$a]['Mosama_Experiences']=$exprer;
                if(count($b['mosama__educations'])){foreach($b['mosama__educations'] as $c=>$d){$education[]=$d['Education_id'];}}
                unset($Mosama_JobName[$a]['mosama__educations']);$Mosama_JobName[$a]['Mosama_Educations']=$education;
                if(count($b['mosama__connections'])){foreach($b['mosama__connections'] as $c=>$d){$connections[]=$d['Connection_id'];}}
                unset($Mosama_JobName[$a]['mosama__connections']);$Mosama_JobName[$a]['Mosama_Connections']=$connections;
                if(count($b['mosama__managers'])){foreach($b['mosama__managers'] as $c=>$d){$managers[]=$d['Manager_id'];}}
                unset($Mosama_JobName[$a]['mosama__managers']);$Mosama_JobName[$a]['Mosama_Managers']=$managers;
            }
            $data['Mosama_JobName']= $Mosama_JobName;
            return view('Employers::Mosama',['data'=>$data,'load'=>'home']);
        }
    }
    function showprintjobname($ids=null){
        if(!isset($_POST['jobnameselect'])){return view('errors.layout',['error_number'=>404,'error_message'=>'NOIDS']);}
            if($_POST['jobnameselect'] == ''){return view('errors.layout',['error_number'=>404,'error_message'=>'NOIDS']);}
            $ids=$_POST['jobnameselect'];
            sort($ids);
            $mor=array_chunk($ids,100,true);
            $aunset=['Mosama_Tasks','Mosama_Skills','Mosama_OrgStru','Mosama_Goals','Mosama_Experiences','Mosama_Educations','Mosama_Connections','Mosama_Competencies','Mosama_Managers','Mosama_Groups','Mosama_Degrees','Mosama_JobTitles','Mosama_JobName'];
            $permessions=[];
    if(!auth::guard('Employers')->user()) {
    foreach($aunset as $a=>$b) {
        $show=$b.'_show';
        $update=$b.'_update';
        $add=$b.'_add';
        if(amer_user()->canper($show)) {
            $permessions[]=$show;
        }
        if(amer_user()->canper($update)) {
            $permessions[]=$update;
        }
        if(amer_user()->canper($add)) {
            $permessions[]=$add;
        }
    }
}
            return view('Employers::print',['data'=>$mor,'permessions'=>$permessions]);
        if(isset($_POST['jobnameselect'])){
            if($_POST['jobnameselect'] !== '') {
                $ids=$_POST['jobnameselect'];
            }
        }
        
        $mor=Mosama_JobName::whereIn('id',$ids)->with('Mosama_Tasks','Mosama_Skills','Mosama_OrgStru','Mosama_Goals','Mosama_Experiences','Mosama_Educations','Mosama_Connections','Mosama_Competencies','Mosama_Managers','Mosama_Groups','Mosama_Degrees','Mosama_JobTitles')->paginate(15)->toArray();
        $aunset=['JobTitle_id','Group_id','Degree_id','created_at','updated_at','deleted_at'
            ,'mosama__tasks'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__skills'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__org_stru'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__goals'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__experiences'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__educations'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__connections'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__competencies'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__managers'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__groups'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__degrees'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__job_titles'=>['created_at','updated_at','deleted_at','pivot']
        ];
        foreach($mor['data'] as $a=>$b){  
            foreach($aunset as $c=>$d){
                if(!is_array($d)){unset($mor[$a][$d]);}
                else{
                    foreach($d as $e=>$f){
                        if(array_key_exists("id",$mor['data'][$a][$c])){
                            unset($mor['data'][$a][$c][$f]);
                        }else{
                        foreach($mor['data'][$a][$c] as $l=>$m){
                            unset($mor['data'][$a][$c][$l][$f]);
                        }}
                        
                    }
                }
            }
        }
        $aunset=['mosama__tasks'=>'Mosama_Tasks','mosama__skills'=>'Mosama_Skills','mosama__org_stru'=>'Mosama_OrgStru','mosama__goals'=>'Mosama_Goals','mosama__experiences'=>'Mosama_Experiences','mosama__educations'=>'Mosama_Educations','mosama__connections'=>'Mosama_Connections','mosama__competencies'=>'Mosama_Competencies','mosama__managers'=>'Mosama_Managers','mosama__groups'=>'Mosama_Groups','mosama__degrees'=>'Mosama_Degrees','mosama__job_titles'=>'Mosama_JobTitles'];
        $AllPermissions=amer_user()->getAllPermissions()->toArray();
        return ($AllPermissions);
        foreach($mor['data'] as $a=>$b){foreach($aunset as $c=>$d){$mor['data'][$a][$d]=$mor['data'][$a][$c];unset($mor['data'][$a][$c]);}}
        foreach($mor['data'] as $a=>$b){
            foreach($b['Mosama_Tasks'] as $c=>$d){
                if($d['type']=='wazifia'){$mor['data'][$a]['Mosama_Tasks_wazifia'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']=='eshraf'){$mor['data'][$a]['Mosama_Tasks_eshraf'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']=='tanfiz'){$mor['data'][$a]['Mosama_Tasks_tanfiz'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']=='fatherof'){$mor['data'][$a]['Mosama_Tasks_fatherof'][]=['id'=>$d['id'],'text'=>$d['text']];}
            }
            foreach($b['Mosama_OrgStru'] as $c=>$d){
                if($d['type']==1){$mor['data'][$a]['Mosama_OrgStru_1'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']==2){$mor['data'][$a]['Mosama_OrgStru_2'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']==3){$mor['data'][$a]['Mosama_OrgStru_3'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']==4){$mor['data'][$a]['Mosama_OrgStru_4'][]=['id'=>$d['id'],'text'=>$d['text']];}
            }
            foreach($b['Mosama_Connections'] as $c=>$d){
                if($d['type']=='in'){$mor['data'][$a]['Mosama_Connections_in'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']=='out'){$mor['data'][$a]['Mosama_Connections_out'][]=['id'=>$d['id'],'text'=>$d['text']];}
            }
            foreach($b['Mosama_Experiences'] as $c=>$d){
                //0=قضاء مدة بينية قدرها 10 سنوات فى الدرجة الادنى
                //1=خبره في مجال العمل 13 سنوات
                if($d['time'] == 0){
                    $mor['data'][$a]['Mosama_Experiences'][$c]['text']='لا يتطلب خبرة';
                }else{
                    if($d['type'] == 0){
                        $mor['data'][$a]['Mosama_Experiences'][$c]['text']='قضاء مدة بينية قدرها '.$d['time'].' سنوات فى الدرجة الادنى';
                    }elseif($d['type'] == 1){
                        $mor['data'][$a]['Mosama_Experiences'][$c]['text']='خبره في مجال العمل '.$d['time'].' سنوات';
                    }
                }
                unset($mor['data'][$a]['Mosama_Experiences'][$c]['time']);unset($mor['data'][$a]['Mosama_Experiences'][$c]['type']);
            }
            //print_r($b['Mosama_Managers']);
            $mor['data'][$a]['Mosama_Groups'][]=$mor['data'][$a]['Mosama_Groups'];unset($mor['data'][$a]['Mosama_Groups']['id']);unset($mor['data'][$a]['Mosama_Groups']['text']);
            $mor['data'][$a]['Mosama_Degrees'][]=$mor['data'][$a]['Mosama_Degrees'];unset($mor['data'][$a]['Mosama_Degrees']['id']);unset($mor['data'][$a]['Mosama_Degrees']['text']);
            $mor['data'][$a]['Mosama_JobTitles'][]=$mor['data'][$a]['Mosama_JobTitles'];unset($mor['data'][$a]['Mosama_JobTitles']['id']);unset($mor['data'][$a]['Mosama_JobTitles']['text']);unset($mor['data'][$a]['Mosama_JobTitles']['group_id']);
            unset($mor['data'][$a]['Mosama_Tasks']);unset($mor['data'][$a]['Mosama_OrgStru']);unset($mor['data'][$a]['Mosama_Connections']);
        }
        return view('layout.Mosama.print',['data'=>$mor]);
    }
}