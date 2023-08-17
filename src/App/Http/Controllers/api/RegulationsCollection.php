<?php
namespace Amerhendy\Employers\App\Http\Controllers\api;
use \Amerhendy\Employers\App\Models\Regulations\Regulations as Regulations;
use \Amerhendy\Employers\App\Models\Regulations\Regulations_Articles as Regulations_Articles;
use \Amerhendy\Employers\App\Models\Regulations\Regulations_Topics as Regulations_Topics;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
class RegulationsCollection extends Controller
{
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\FetchOperation;
    public function index(\Request $request){
        $search_string = request()->input('q') ?? false;
        if(!isset($_GET['fetch']) || !isset($_GET['Regulations'])){return $this->error(505);}
        //check regulations
        $Regulations=Regulations::where('id',$_GET['Regulations'])->get()->toArray();
        if(!count($Regulations)){return $this->error(505);}
        return $this->fetchRegulations_Topics();
    }
    private function error($code=404,$status='error',$message='An error occurred!'){
        $returnData = array(
            'status' => $status,
            'message' => $message,
        );
        return \Response::json($returnData, $code);
    }
    public function fetchRegulations_Topics(){
        $op=$_GET;
            if(isset($op['Regulations'])){
                $Regulations=$op['Regulations'];
            }else{
            $Regulations=null;
        }
        if(isset($_GET['parents'][0])){
            if(is_numeric($_GET['parents'][0])){$parent=$_GET['parents'][0];}else{$parent=(int)$_GET['parents'][0];}
        }
        if(!is_array($Regulations)){$Regulations=[$Regulations];}
        $Regulations_Topics=\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics::class;
        $data_A= ($Regulations_Topics::whereHas('Regulation',function($q)use($Regulations){
            return $q->whereIn('Regulations.id',$Regulations);
        })->get(['id','text','father'])->toArray());
        $Regulations_Articles=Regulations_Articles::with('Regulations_Topics')->get()->toArray();
        $articles=[];
        $rel=[];
        //return $Regulations_Articles;
        foreach($Regulations_Articles as $a=>$b){
            $articles[]=['id'=>$b['id'],'number'=>$b['number'],'text'=>$b['text'],'mp3'=>$b['mp3']];
            foreach($b['regulations__topics'] as $c=>$d){
                $rel[]=['Topic_id'=>$d['pivot']['Topic_id'],'Article_id'=>$d['pivot']['Article_id']];
            }
        }
        $articles = array_values(Arr::sort($articles, function (array $value) {
            return $value['number'];
        }));
        $data=['Regulations_Topics'=>$data_A,'Regulations_Articles'=>$articles,'Regulations_topic_article'=>$rel];
        return $data;
    }
    
}