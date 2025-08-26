<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use Illuminate\Support\Collection;
use \Amerhendy\Employers\App\Models\{Mosama_Groups,Mosama_JobNames,Mosama_Degrees,Mosama_Connections,Mosama_Educations,Mosama_Experiences,Mosama_Managers,Mosama_JobTitles,Mosama_OrgStruses,Mosama_Tasks};
use stdClass;

trait EmployerTrait
{
    public static function get($wanted){
        //setids
        if($wanted == 'Mosama_JobNames'){
            self::getMosama_JobNamesById();
        }
        if($wanted == 'listAll'){
            self::listEmployers();
        }
    }
    public static function getMosama_JobNamesById(){
        if(empty(self::$ids)){
            self::$clearData=Mosama_JobNames::get();
        }else{
            if(!is_array(self::$ids)){
                self::$ids=[self::$ids];
            }
            self::$clearData=Mosama_JobNames::whereIn('id',self::$ids);
        }
    }
    public static function attachRelsToMosama_JobNames(){
        $collect=new collection();
        foreach (self::$clearData->get() as $key => $value) {
            $dod=new \stdClass;
            $dod->id=$value->id;
            $dod->text=$value->text;
            $dod->jobtitle_id=self::toStd($value->Mosama_JobTitles,['id','text']);
            $dod->degree_id=self::toStd($value->Mosama_Degrees,['id','text']);
            $dod->group_id=self::toStd($value->Mosama_Groups,['id','text']);
            $dod->Mosama_Skills=self::toStd($value->Mosama_Skills,['id','text']);
            $dod->Mosama_OrgStruses=self::toStd($value->Mosama_OrgStruses,['id','text','type']);
            $dod->Mosama_Goals=self::toStd($value->Mosama_Goals,['id','text']);
            $dod->Mosama_Competencies=self::toStd($value->Mosama_Competencies,['id','text']);
            $dod->Mosama_Managers=self::toStd($value->Mosama_Managers,['id','text']);
            $dod->Mosama_Connections=self::toStd($value->Mosama_Connections,['id','text','type']);
            $dod->Mosama_Educations=self::toStd($value->Mosama_Educations,['id','text']);
            $dod->Mosama_Experiences=self::toStd($value->Mosama_Experiences,['id','type','time','text']);
            $dod->Mosama_Tasks=self::toStd($value->Mosama_Tasks,['id','text','type']);
            $collect->push($dod);
        }
        self::$dataWithRels=$collect;
    }
    public static function toStd($cl,$row){
        if(is_a($cl,'Illuminate\Database\Eloquent\Collection')){
            return $cl->map(function($v,$k)use($row){
                $ers=new \stdClass;
                foreach ($row as $key => $value) {
                    $ers->{$value}=$v[$value];
                }
                return $ers;
            });
        }else{
            $ers=new \stdClass;
            foreach ($row as $key => $value) {
                $ers->{$value}=$cl->{$value};
            }
            return $ers;
        }

    }
    public static function listEmployers(){
        $data=new \stdClass;
        $data->Mosama_Groups=Mosama_Groups::get(['id','text'])->toArray();
        $data->Mosama_Degrees=Mosama_Degrees::get(['id','text'])->toArray();
        $data->Mosama_Connections_in=Mosama_Connections::where('type','in')->get(['id','text'])->toArray();
        $data->Mosama_Connections_out=Mosama_Connections::where('type','out')->get(['id','text'])->toArray();
        $data->Mosama_Educations=Mosama_Educations::get(['id','text'])->toArray();
        $data->Mosama_Experiences=Mosama_Experiences::get();
        foreach ($data->Mosama_Experiences as $key => $value) {$data->Mosama_Experiences[$key]->text=$value->text;}
        $data->Mosama_Managers=Mosama_Managers::get(['id','text'])->toArray();
        $data->Mosama_JobTitles=Mosama_JobTitles::get(['id','text','group_id'])->toArray();
        $data->Mosama_OrgStru=Mosama_OrgStruses::get();
        foreach ($data->Mosama_OrgStru as $key => $value) {$data->Mosama_OrgStru[$key]->text=$value->fulltext;}
        $data->Mosama_Tasks=Mosama_Tasks::get(['id','text','type']);
        foreach ($data->Mosama_Tasks as $key => $value) {
            $data->Mosama_Tasks[$key]->text=$value->fulltext;
        }
        $Mosama_JobName=Mosama_JobNames::with(['Mosama_Tasks'=>function($q){return $q->select('mosama_jobnames_tasks.task_id');}])
                                        ->with(['Mosama_Skills'=>function($q){return $q->select('mosama_jobnames_skills.skill_id');}])
                                        ->with(['Mosama_OrgStruses'=>function($q){return $q->select('mosama_jobnames_orgstrus.orgstru_id');}])
                                        ->with(['Mosama_Experiences'=>function($q){return $q->select('mosama_jobnames_experiences.experience_id');}])
                                        ->with(['Mosama_Educations'=>function($q){return $q->select('mosama_jobnames_educations.education_id');}])
                                        ->with(['Mosama_Connections'=>function($q){return $q->select('mosama_jobnames_connections.connection_id');}])
                                        ->with(['Mosama_Managers'=>function($q){return $q->select('mosama_jobnames_managers.manager_id');}])
                                        ->get(['id','text','jobtitle_id','degree_id','group_id']);
        //dd($Mosama_JobName);
        $new=[];
        foreach($Mosama_JobName as $a=>$b){
            $dod=new \stdClass;
            $dod->id=$b['id'];
            $dod->text=$b['text'];
            $dod->Mosama_JobTitles=[$b['jobtitle_id']];
            $dod->Mosama_Degrees=[$b['degree_id']];
            $dod->Mosama_Groups=[$b['group_id']];
            $dod->Mosama_Tasks=$b->Mosama_Tasks->map(function($v,$k){return $v['task_id'];});
            $dod->Mosama_Skills=$b->Mosama_Skills->map(function($v,$k){return $v['skill_id'];});
            $dod->Mosama_OrgStruses=$b->Mosama_OrgStruses->map(function($v,$k){return $v['orgstru_id'];});
            $dod->Mosama_Experiences=$b->Mosama_Experiences->map(function($v,$k){return $v['experience_id'];});
            $dod->Mosama_Educations=$b->Mosama_Educations->map(function($v,$k){return $v['education_id'];});
            $dod->Mosama_Connections=$b->Mosama_Connections->map(function($v,$k){return $v['connection_id'];});
            $dod->Mosama_Managers=$b->Mosama_Managers->map(function($v,$k){return $v['manager_id'];});
            $new[]=$dod;
        }
        $data->Mosama_JobName= $new;
        self::$listEmployers=$data;
    }
}
