<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
use \Amerhendy\Employers\App\Http\Controllers\api\MosamaCollection;
class MosamaAmerController extends AmerController
{
    use EmployerPrintTrait,EmployerTrait;
    public static $returnType,$error,$request,$ids,$clearData,$dataWithRels,$pdfString,$listEmployers;
    function __invoke(){
        self::$error=new \stdClass();
        self::$error->number=401;
        self::$error->page=\Str::between(\Str::after(__FILE__,__DIR__),'\\','.php');
        if(request()->ajax()){$returnType='json';}else{$returnType='html';}
        if(self::checklogin() !== true){
            if(self::$returnType === 'json'){}else{
                return view('Amer::Errors.layout',['error_number'=>401]);
            }
        }
        $route = \Route::currentRouteName();
        if($route =='Mosama_print.index' || $route =='admin.Mosama_print.index'){
            return $this->showprintjobname();
        }elseif($route =='Mosama.index' || $route =='admin.Mosama.index'){
            return $this->index();
        }

        if(self::$returnType === 'json'){}else{
            return view('Amer::Errors.layout',['error_number'=>401]);
        }
    }
    public static function checklogin()
    {
        $login=0;
        $guards=config('auth.guards');
        if(auth::guard(config('Amer.Employers.auth.middleware_key'))->check()){
            $login=1;
        }elseif(auth::guard(config('Amer.Security.auth.middleware_key'))->check()){
            $login=1;
        }
        if($login==0){
            return 405;
        }
        return true;
    }
    function index()
    {
        self::get('listAll');
        $data=self::$listEmployers;
        return view('Employers::Mosama',['data'=>$data,'load'=>'home']);
    }
    function showprintjobname($ids=null){
        self::$request=request();
        $validator=Validator::make(self::$request->all(),[
            'selectshow'=>'required',
            'jobnameselect'=>'required|array',
        ]);
        if($validator->fails()){

            self::$error->message=$validator->messages();self::$error->line=__LINE__;
            if(self::$returnType === 'json'){
                return \AmerHelper::responseError(self::$error,self::$error->number);
            }else{
                return view('Amer::errors.layout',['error_number'=>504,'error_message'=>self::$error]);
                }
        }
        self::$ids=self::$request->input('jobnameselect');
        self::get($wanted='Mosama_JobNames');
        self::attachRelsToMosama_JobNames();
        self::PdfMosama_JobNames();
        return view('Employers::Employers.ViewPdf',['pdf'=>self::$pdfString]);
        dd(self::$pdfString);
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
        showprintjobname($ids);
        return view('Employers::Employers.PDFprint',['data'=>$mor,'permessions'=>$permessions]);
        if(isset($_POST['jobnameselect'])){
            if($_POST['jobnameselect'] !== '') {
                $ids=$_POST['jobnameselect'];
            }
        }

        $mor=Mosama_JobName::whereIn('id',$ids)->with('Mosama_Tasks','Mosama_Skills','Mosama_OrgStru','Mosama_Goals','Mosama_Experiences','Mosama_Educations','Mosama_Connections','Mosama_Competencies','Mosama_Managers','Mosama_Groups','Mosama_Degrees','Mosama_JobTitles')->paginate(15)->toArray();
        $aunset=['jobtitle_id','group_id','degree_id','created_at','updated_at','deleted_at'
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
