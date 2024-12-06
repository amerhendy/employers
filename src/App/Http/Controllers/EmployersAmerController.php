<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Employers as Employers;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use \Amerhendy\Employers\App\Http\Requests\EmployersRequest as EmployersRequest;

class EmployersAmerController extends AmerController
{
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\ListOperation;
    //use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\CreateOperation  {store as traitStore;}
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\CreateOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\UpdateOperation{ update as traitUpdate; }
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\DeleteOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\ShowOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\TrashOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\CloneOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\BulkCloneOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\BulkDeleteOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\FetchOperation;
    public function setup()
    {
        /*
        for($i=1;$i<5000;$i++){
            DB::table('Employers_CareerPathes_Files')->insert([
                'CareerPath_id' => rand(1,2000),
                'File_id' => rand(1,2000)
            ]);
        }*/
        AMER::setModel(Employers::class);
        AMER::setRoute(config('Amer.Employers.route_prefix') . '/Employers');
        AMER::setEntityNameStrings(trans('EMPLANG::Employers.singular'), trans('EMPLANG::Employers.plural'));
        $this->Amer->setTitle(trans('EMPLANG::Employers.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Employers.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Employers.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Employers.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Employers.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Employers.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Employers-Create') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Employers-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Employers-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Employers-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Employers-show') == 0){$this->Amer->denyAccess('show');}
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupListOperation(){
        //$emp=Employers::with('Mosama_Groups')->where('id',1)->get();
        //dd($emp->toArray());
        AMER::addColumns([
            [
                'name'=>'uid',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers.Uid'),
            ],[
                'name'=>'fullname',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers.fullname'),
            ],
            [
                'name'=>'nid',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers.nid'),
            ],
            [
                'name'=>'Group_id',
                'type'=>'select',
                'entity'=>'Mosama_Groups',
                'attribute'=>'text',
                'model'=>\Amerhendy\Employers\App\Models\Mosama_Groups::class,
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
            ],
            [
                'name'=>'JobTitle_id',
                'type'=>'select',
                'entity'=>'Mosama_Jobtitles',
                'attribute'=>'text',
                'model'=>\Amerhendy\Employers\App\Models\Mosama_JobTitles::class,
                'label'=>trans('EMPLANG::Mosama_Jobtitles.singular'),
            ],
            [
                'name'=>'Degree_id',
                'type'=>'select',
                'entity'=>'Mosama_Degrees',
                'attribute'=>'text',
                'model'=>\Amerhendy\Employers\App\Models\Mosama_Degrees::class,
                'label'=>trans('EMPLANG::Mosama_Degrees.singular'),
            ],
        ]);
    }
    function fields(){
            $routes=$this->Amer->routelist;
        AMER::addFields([

            [
                'name'=>'uid',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers.Uid'),
            ],[
                'name'=>'fullname',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers.fullname'),
            ],
            [
                'name'=>'nid',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers.nid'),
            ],
            [
                'name'=>'Group_id',
                'type'=>'select',
                'entity'=>'Mosama_Groups',
                'attribute'=>'text',
                'model'=>\Amerhendy\Employers\App\Models\Mosama_Groups::class,
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
            ],
            [
                'name'=>'JobTitle_id',
                'type'=>'select',
                'entity'=>'Mosama_Jobtitles',
                'attribute'=>'text',
                'model'=>\Amerhendy\Employers\App\Models\Mosama_JobTitles::class,
                'label'=>trans('EMPLANG::Mosama_Jobtitles.singular'),
            ],
            [
                'name'=>'Degree_id',
                'type'=>'select',
                'entity'=>'Mosama_Degrees',
                'attribute'=>'text',
                'model'=>\Amerhendy\Employers\App\Models\Mosama_Degrees::class,
                'label'=>trans('EMPLANG::Mosama_Degrees.singular'),
            ],

                ]);
    }
    protected function gettrainers(){
        $db=Employers::distinct()->get('Trainer');
        if($db){
           return $db->pluck('Trainer')->toArray();
        }
        return[];
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(EmployersRequest::class);
        $this->fields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(EmployersRequest::class);
        $this->fields();
    }
    function update(EmployersRequest $request){
        $response = $this->traitUpdate();
        // do something after save
        return $response;
    }
    public function destroy($id)
    {
        $this->Amer->hasAccessOrFail('delete');
        $data=$this->Amer->model::remove_force($id);
        return $data;
    }
    public function fetchMosama_JobNames()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_JobNames::class;
        $text='JobNames_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        $model=$model::where('id',$result)->get('Group_id')->first();
        $result=$model->Group_id;
        $Employers_CareerPathes=Amerhendy\Employers\App\Models\Employers_CareerPathes::class;
        $model=\Amerhendy\Employers\App\Models\Employers_CareerPathes::class;
        $text='Mosama_Groups';
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->where($text.'.id',$result);
                });
            }
        ]);
    }
    public function fetchEmployers_CareerPathFiles(){
        $model=\Amerhendy\Employers\App\Models\Employers_CareerPathFiles::class;
        $text='CareerPath_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        $text='Employers_CareerPathFiles';
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            //'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->where($text.'.id',$result);
                });
            }
        ]);
    }
    public function fetchEmployers(){

        $text='JobNames_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        $model=\Amerhendy\Employers\App\Models\Mosama_JobNames::class;
        $jobname=$model::where('id',$result)->get()->first();
        if(!$jobname){return[];}
        $model=\Amerhendy\Employers\App\Models\Employers::class;
        $Mosama_JobTitles=$jobname->JobTitle_id;
        $Mosama_Degrees=$jobname->Degree_id;
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            //'paginate' => 10,
            'query' => function($model)use($Mosama_JobTitles,$Mosama_Degrees,$text) {
                return $model->where('Mosama_JobTitles',$Mosama_JobTitles);
            }
        ]);
    }
}
