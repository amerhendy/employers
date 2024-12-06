<?php

namespace Amerhendy\Employers\App\Http\Controllers\api;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use \Amerhendy\Employers\App\Models\Mosama_Groups;
use \Amerhendy\Employers\App\Models\Mosama_Competencies;
use \Amerhendy\Employers\App\Models\Mosama_Connections;
use \Amerhendy\Employers\App\Models\Mosama_Educations;
use \Amerhendy\Employers\App\Models\Mosama_Experiences;
use \Amerhendy\Employers\App\Models\Mosama_Goals;
use \Amerhendy\Employers\App\Models\Mosama_Degrees;
use \Amerhendy\Employers\App\Models\Mosama_JobNames as Mosama_JobName;
use \Amerhendy\Employers\App\Models\Mosama_Jobs;
use \Amerhendy\Employers\App\Models\Mosama_Tasks;
use \Amerhendy\Employers\App\Models\Mosama_Skills;
use \Amerhendy\Employers\App\Models\Mosama_Managers;
use \Amerhendy\Employers\App\Models\Mosama_JobTitles;
use \Amerhendy\Employers\App\Models\Mosama_OrgStrues as Mosama_OrgStrues;
use Illuminate\Pagination\LengthAwarePaginator;
class MosamaCollection extends Controller
{
    public function index()
    {
        //return Mosama_Goals::with('Mosama_JobTitles')->get();
        //return Mosama_Degrees::with('Mosama_Experiences')->get();
        //return Mosama_Degrees::with('Mosama_Groups')->get();
        //return Mosama_Educations::with('Mosama_Groups')->get();
        //return Mosama_Connections::with('Mosama_Groups')->get();
        //return Mosama_Connections::with('Mosama_OrgStrues')->get();
        //return Mosama_Competencies::get();
        //return Mosama_Experiences::with('Mosama_Degrees')->get();
        //return Mosama_Tasks::with('Mosama_Groups')->get();
        //return Mosama_Managers::with('Mosama_Groups')->get();
        //return Mosama_JobTitles::with('Mosama_Goals')->get();
        //return Mosama_JobTitles::with('Mosama_Groups')->get();
        //return Mosama_Goals::with('Mosama_Degrees')->get();
        //return Mosama_Groups::with('Mosama_JobTitles')->get();

       //return '';


        //return Mosama_Groups::with('Mosama_Degrees')->get();
        //return Mosama_Groups::with('Mosama_Educations')->get();
        //return Mosama_Groups::with('Mosama_Connections')->get();
        //return Mosama_Groups::with('Mosama_Tasks')->get();
        //return Mosama_Groups::with('Mosama_Managers')->get();
        if(!isset($_GET['type'])){return '';}
        if(isset($_REQUEST['q'])){
            if($_REQUEST['q'] !== ''){
                //degrees
                if(isset($_GET['Mosama_Degrees'])){
                    if(is_int($_GET['Mosama_Degrees'])){
                        $type=self::getclass($_GET['type'])->where('time', 'LIKE', '%'.$_REQUEST['q'].'%');
                    }else{
                        $a='بينية';$b='كلية';
                        if (str_contains($a, $_GET['q'])) {$type=self::getclass($_GET['type'])->where('type', 0);}
                        elseif (str_contains($b, $_GET['q'])) {$type=self::getclass($_GET['type'])->where('type', 1);}
                        else{$type=self::getclass($_GET['type']);}
                    }
                    //degrees
                }else{
                        $type=self::getclass($_GET['type'])->where('text', 'LIKE', '%'.$_REQUEST['q'].'%');
                    }
            }else{$type=self::getclass($_GET['type']);}
        }else{$type=self::getclass($_GET['type']);}
        if(isset($_GET['Mosama_Groups'])){
            $group_id=$_GET['Mosama_Groups'];
            return ['data'=>$type->whereHas('Mosama_Groups',function($query)use($group_id){
                return $query->where('Mosama_Groups.id', '=', $group_id);
            })->get()->toArray()];
        }elseif(isset($_GET['Mosama_JobTitles'])){
            $mosamiat_id=$_GET['Mosama_JobTitles'];
            return ['data'=>$type->whereHas('Mosama_JobTitles',function($query)use($mosamiat_id){
                return $query->where('Mosama_JobTitles.id', '=', $mosamiat_id);
            })->get()->toArray()];
        }elseif(isset($_GET['Mosama_Degrees'])){
            $degrees_id=$_GET['Mosama_Degrees'];
            $Data=[];
            $data=$type->whereHas('Mosama_Degrees',function($query)use($degrees_id){
                return $query->where('Mosama_Degrees.id', '=', $degrees_id);
            })->get()->toArray();
            foreach($data as $a=>$b){
                if($b['type'] == '0'){
                    $text="·مدة بينية- لا تقل عن ".$b['time']." سنوات ";
                }else{
                    $text=" مدة كلية قدرها ".$b['time']." سنة في نفس مجال العمل .";
                }

                $Data[$a]=['id'=>$b['id'],'type'=>$b['type'],'time'=>$b['time'],'text'=>$text];
            }
            return ['data'=>$Data];
        }
        else{
            return ['data'=>$type->get(['id','text'])->toArray()];
        }

    }
    private static function getclass($target){
        if($target == "Mosama_Goals"){$class=new Mosama_Goals();}
        elseif($target == "Mosama_Degrees"){$class=new Mosama_Degrees();}
        elseif($target == "Mosama_Educations"){$class=new Mosama_Educations();}
        elseif($target == "Mosama_Connections"){$class=new Mosama_Connections();}
        elseif($target == "Mosama_Connections_IN"){$class=Mosama_Connections::where('type','in');}
        elseif($target == "Mosama_Connections_OUT"){$class=Mosama_Connections::where('type','out');}
        elseif($target == "Mosama_Groups"){$class=new Mosama_Groups();}
        elseif($target == "Mosama_JobName"){$class=new Mosama_JobName();}
        elseif($target == "Mosama_Jobs"){$class=new Mosama_Jobs();}
        elseif($target == "Mosama_Competencies"){$class=new Mosama_Competencies();}
        elseif($target == "Mosama_Experiences"){$class=new Mosama_Experiences();}
        elseif($target == "Mosama_Tasks_wazifia"){$class=Mosama_Tasks::where('type','wazifia');}
        elseif($target == "Mosama_Tasks_tanfiz"){$class=Mosama_Tasks::where('type','tanfiz');}
        elseif($target == "Mosama_Tasks_eshraf"){$class=Mosama_Tasks::where('type','eshraf');}
        elseif($target == "Mosama_Tasks"){$class=new Mosama_Tasks();}
        elseif($target == "Mosama_Skills"){$class=new Mosama_Skills();}
        elseif($target == "Mosama_Managers"){$class=new Mosama_Managers();}
        elseif($target == "Mosama_JobTitles"){$class=new Mosama_JobTitles();}
        elseif($target == "Mosama_OrgStrues"){$class=new Mosama_OrgStrues();}
        return $class;
    }
    public function DataTableFormat($target){
        $request=$_REQUEST;
        $draw=$request['draw'];
        $start=$request['start'];
        $rowperpage =$request['length'];
        $columnIndex_arr=$request['order'];
        $columnName_arr=$request['columns'];
        $order_arr=$request['order'];
        $search_arr =$request['search'];
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['name']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
        $searchCol=$columnName_arr[0]['name'];
        $class=self::getclass($target);
        $classTable=$class->getTable();
        $classTableSearchCols=[];

        foreach(DB::getSchemaBuilder()->getColumnListing($classTable) as $a=>$b){
            if(!in_array($b,['id','created_at','updated_at','deleted_at'])){$classTableSearchCols[]=$b;}
        }
        $cols=[];
        foreach ($request['columns'] as $item) {
            if(!is_array($item['name'])){
                if($item['name'] !== ''){$cols[]= $item['name'];}
            }
        }
        //////////
        $with=[];
        for ($x = 0; $x <= count($columnName_arr)-1; $x++) {
            if(is_array($columnName_arr[$x]['name'])){
                $newclass=$columnName_arr[$x]['name'];
                $with[]=['targetClass'=>$newclass['targetClass'],'Targetcols'=>$newclass['Targetcols']];
            }
        }
        $records = $class::orderBy($columnName,$columnSortOrder);
        if($searchValue !== ''){
            for($x=0;$x<=count($classTableSearchCols)-1; $x++){
                if($x == 0){
                    $records->where($classTableSearchCols[$x],'like','%'.$searchValue.'%');
                }else{
                    $records->orWhere($classTableSearchCols[$x],'like','%'.$searchValue.'%');
                }
            }
        }

        $recordsFiltered=$records->count();
        if(count($with)!==0){
            foreach($with as $a=>$b){
                $records->with([$b['targetClass']=>function($query) use($b){
                    //$query->select($b['Targetcols']);
                }]);
            }
        }

       // $start=67;
        $records
        //->select()
       ->skip($start)
       ->take($rowperpage)
       ->get();
       //return $records->get();
       if(count($with)){
        foreach($with as $b){
            $cols[]=$b;
        }
       }
       $data_arr = array();
       foreach($records->get() as $a=>$b){
        foreach($cols as $c=>$d){
            if(!is_array($d)){
                $data_arr[$a][]=$b->$d;
            }else{
                $newTargetColsArray=[];
                if(isset($b[$d['targetClass']][$d['Targetcols']])){
                    $newTargetColsArray[]=$b[$d['targetClass']][$d['Targetcols']];
                }else{
                    foreach($b[$d['targetClass']] as $e=>$f){
                        $newTargetColsArray[]=$f[$d['Targetcols']];
                }
                }

        //$newTargetColsArray[]= $b[$d['targetClass']][$d['Targetcols']];

                $data_arr[$a][]= $newTargetColsArray;
            }
        }
     }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $class::count(),
            "recordsFiltered" => $recordsFiltered,
           "data" => $data_arr
         );
         return json_encode($response);

        return $records->get();

    }
    function showprintjobname($ids=null){
        if(!isset($_POST['jobnameselect'])){return 'error1';}
        if($_POST['jobnameselect'] == '') {return 'error2';}
        if(isset($_POST['jobnameselect'])){
            if($_POST['jobnameselect'] !== '') {
                $ids=$_POST['jobnameselect'];
            }
        }
        $mor=Mosama_JobName::whereIn('id',$ids)->with('Mosama_Tasks','Mosama_Skills','Mosama_OrgStruses','Mosama_Goals','Mosama_Experiences','Mosama_Educations','Mosama_Connections','Mosama_Competencies','Mosama_Managers','Mosama_Groups','Mosama_Degrees','Mosama_JobTitles')->get()->toArray();
        //dd($mor);
        $aunset=['JobTitle_id','Group_id','Degree_id','created_at','updated_at','deleted_at'
            ,'mosama__tasks'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__skills'=>['created_at','updated_at','deleted_at','pivot']
            ,'mosama__org_struses'=>['created_at','updated_at','deleted_at','pivot']
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
        foreach($mor as $a=>$b){
            foreach($aunset as $c=>$d){
                if(!is_array($d)){unset($mor[$a][$d]);}
                else{
                    foreach($d as $e=>$f){
                        if(array_key_exists("id",$mor[$a][$c])){
                            unset($mor[$a][$c][$f]);
                        }else{
                        foreach($mor[$a][$c] as $l=>$m){
                            unset($mor[$a][$c][$l][$f]);
                        }}

                    }
                }
            }
        }
        $aunset=['mosama__tasks'=>'Mosama_Tasks','mosama__skills'=>'Mosama_Skills','mosama__org_struses'=>'Mosama_OrgStrues','mosama__goals'=>'Mosama_Goals','mosama__experiences'=>'Mosama_Experiences','mosama__educations'=>'Mosama_Educations','mosama__connections'=>'Mosama_Connections','mosama__competencies'=>'Mosama_Competencies','mosama__managers'=>'Mosama_Managers','mosama__groups'=>'Mosama_Groups','mosama__degrees'=>'Mosama_Degrees','mosama__job_titles'=>'Mosama_JobTitles'];
        foreach($mor as $a=>$b){foreach($aunset as $c=>$d){$mor[$a][$d]=$mor[$a][$c];unset($mor[$a][$c]);}}
        foreach($mor as $a=>$b){
            foreach($b['Mosama_Tasks'] as $c=>$d){
                if($d['type']=='wazifia'){$mor[$a]['Mosama_Tasks_wazifia'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']=='eshraf'){$mor[$a]['Mosama_Tasks_eshraf'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']=='tanfiz'){$mor[$a]['Mosama_Tasks_tanfiz'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']=='fatherof'){$mor[$a]['Mosama_Tasks_fatherof'][]=['id'=>$d['id'],'text'=>$d['text']];}
            }
            foreach($b['Mosama_OrgStrues'] as $c=>$d){
                if($d['type']==1){$mor[$a]['Mosama_OrgStrues_1'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']==2){$mor[$a]['Mosama_OrgStrues_2'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']==3){$mor[$a]['Mosama_OrgStrues_3'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']==4){$mor[$a]['Mosama_OrgStrues_4'][]=['id'=>$d['id'],'text'=>$d['text']];}
            }
            foreach($b['Mosama_Connections'] as $c=>$d){
                if($d['type']=='in'){$mor[$a]['Mosama_Connections_in'][]=['id'=>$d['id'],'text'=>$d['text']];}
                elseif($d['type']=='out'){$mor[$a]['Mosama_Connections_out'][]=['id'=>$d['id'],'text'=>$d['text']];}
            }
            foreach($b['Mosama_Experiences'] as $c=>$d){
                //0=قضاء مدة بينية قدرها 10 سنوات فى الدرجة الادنى
                //1=خبره في مجال العمل 13 سنوات
                if($d['time'] == 0){
                    $mor[$a]['Mosama_Experiences'][$c]['text']='لا يتطلب خبرة';
                }else{
                    if($d['type'] == 0){
                        $mor[$a]['Mosama_Experiences'][$c]['text']='قضاء مدة بينية قدرها '.$d['time'].' سنوات فى الدرجة الادنى';
                    }elseif($d['type'] == 1){
                        $mor[$a]['Mosama_Experiences'][$c]['text']='خبره في مجال العمل '.$d['time'].' سنوات';
                    }
                }
                unset($mor[$a]['Mosama_Experiences'][$c]['time']);unset($mor[$a]['Mosama_Experiences'][$c]['type']);
            }
            //print_r($b['Mosama_Managers']);
            $mor[$a]['Mosama_Groups'][]=$mor[$a]['Mosama_Groups'];unset($mor[$a]['Mosama_Groups']['id']);unset($mor[$a]['Mosama_Groups']['text']);
            $mor[$a]['Mosama_Degrees'][]=$mor[$a]['Mosama_Degrees'];unset($mor[$a]['Mosama_Degrees']['id']);unset($mor[$a]['Mosama_Degrees']['text']);
            $mor[$a]['Mosama_JobTitles'][]=$mor[$a]['Mosama_JobTitles'];unset($mor[$a]['Mosama_JobTitles']['id']);unset($mor[$a]['Mosama_JobTitles']['text']);unset($mor[$a]['Mosama_JobTitles']['group_id']);
            unset($mor[$a]['Mosama_Tasks']);unset($mor[$a]['Mosama_OrgStrues']);unset($mor[$a]['Mosama_Connections']);
        }
        return $mor;
    }
}
