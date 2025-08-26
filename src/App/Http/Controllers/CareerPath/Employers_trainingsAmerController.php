<?php
namespace Amerhendy\Employers\App\Http\Controllers\CareerPath;
use \Amerhendy\Employers\App\Models\CareerPath\Employers_trainings as Employers_trainings;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use \Amerhendy\Employers\App\Http\Requests\CareerPath\Employers_trainingsRequest as Employers_trainingsRequest;

class Employers_trainingsAmerController extends AmerController
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
        AMER::setModel(Employers_trainings::class);
        AMER::setRoute(config('Amer.Employers.route_prefix') . '/Employers_trainings');
        AMER::setEntityNameStrings(trans('EMPLANG::Employers_trainings.singular'), trans('EMPLANG::Employers_trainings.plural'));
        $this->Amer->setTitle(trans('EMPLANG::Employers_trainings.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Employers_trainings.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Employers_trainings.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Employers_trainings.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Employers_trainings.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Employers_trainings.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Employers_trainings-create') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Employers_trainings-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Employers_trainings-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Employers_trainings-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Employers_trainings-show') == 0){$this->Amer->denyAccess('show');}
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupListOperation(){
        AMER::addColumns([

                [
                    'name'=>'Year',
                    'type'=>'year',
                    'label'=>trans('EMPLANG::Employers_trainings.Year'),
                ],[
                    'type'=>'select',
                    'name'=>'JobNames_id',
                    'placeholder'=>trans('EMPLANG::Mosama_JobNames.singular'),
                    'label'=>trans('EMPLANG::Mosama_JobNames.singular'),
                    'minimum_input_length'=>0,
                    'entity'=>'Mosama_JobNames',
                    'attribute'=>'text',
                    'pivot'=>true,
                    'select_all'=>true,
                ],[
                    'type'=>'select',
                    'model'=>'Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathes',
                    'name'=>'CareerPath_id',
                    'placeholder'=>trans('EMPLANG::Employers_CareerPathes.singular'),
                    'label'=>trans('EMPLANG::Employers_CareerPathes.singular'),
                    'minimum_input_length'=>0,
                    'entity'=>'Employers_CareerPathes',
                    'attribute'=>'Text',
                    'pivot'=>true,
                    'select_all'=>true,
                    'include_all_form_fields' => true,
                ],[
                    'type'=>'select_multiplejson',
                    'model'=>\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathFiles::class,
                    'attribute'=>'Text',
                    'name'=>'Files',
                    'placeholder'=>trans('EMPLANG::Employers_CareerPathFiles.singular'),
                    'label'=>trans('EMPLANG::Employers_CareerPathFiles.singular'),

                ],[
                    'type'=>'select_from_array',
                    'name'=>'Stage',
                    'placeholder'=>trans('EMPLANG::Employers_trainings.Stage'),
                    'label'=>trans('EMPLANG::Employers_trainings.Stage'),
                    'options'=>["A"=>'A',"B"=>'B',]
                ],[
                    'type'=>'date_range',
                    'name'=>"TrainningTimeStart,TrainningTimeEnd",
                    'placeholder'=>trans('EMPLANG::Employers_trainings.TrainningTime'),
                    'label'=>trans('EMPLANG::Employers_trainings.TrainningTime'),
                    'time'=>true,
                ],
                [
                    'type'=>'url',
                    'name'=>'TrainningLink',
                    'label'=>trans('EMPLANG::Employers_trainings.TrainningLink'),
                ],
                [
                    'type'=>'datalist',
                    'name'=>'Trainer',
                    'label'=>trans('EMPLANG::Employers_trainings.Trainer'),
                    'options'=>$this->gettrainers()
                ],
        ]);
    }
    function fields(){
            $routes=$this->Amer->routelist;
        AMER::addFields([
            [
                'name'=>'Year',
                'type'=>'year',
                'label'=>trans('EMPLANG::Employers_trainings.Year'),
            ],[
                'type'=>'select2',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_JobNames',
                'name'=>'JobNames_id',
                'placeholder'=>trans('EMPLANG::Mosama_JobNames.singular'),
                'label'=>trans('EMPLANG::Mosama_JobNames.singular'),
                'minimum_input_length'=>0,
                'entity'=>'Mosama_JobNames',
                'attribute'=>'text',
                'pivot'=>true,
                'select_all'=>true,
            ],[
                'type'=>'select2_from_ajax',
                'model'=>'Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathes',
                'name'=>'CareerPath_id',
                'placeholder'=>trans('EMPLANG::Employers_CareerPathes.singular'),
                'label'=>trans('EMPLANG::Employers_CareerPathes.singular'),
                'minimum_input_length'=>0,
                'entity'=>'Employers_CareerPathes',
                'attribute'=>'Text',
                'data_source'=>$routes['fetchMosama_JobNames']['as'],
                'pivot'=>true,
                'select_all'=>true,
                'include_all_form_fields' => true,
            ],[
                'type'=>'select2_from_ajax_multipleJSON',
                'model'=>\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathFiles::class,
                'data_source'=>$routes['fetchEmployers_CareerPathFiles']['as'],
                'attribute'=>'Text',
                'minimum_input_length'=>0,
                'name'=>'Files',
                'placeholder'=>trans('EMPLANG::Employers_CareerPathFiles.singular'),
                'label'=>trans('EMPLANG::Employers_CareerPathFiles.singular'),
                'pivot'=>true,
                'select_all'=>true,
                'include_all_form_fields' => true,
                'store_as_json' => true

            ],[
                'type'=>'select2_from_ajax',
                'model'=>\Amerhendy\Employers\App\Models\Employers::class,
                'data_source'=>$routes['fetchEmployers']['as'],
                'attribute'=>'fullname',
                'minimum_input_length'=>0,
                'name'=>'Employers',
                'entity'=>'Employers',
                'placeholder'=>trans('EMPLANG::Employers.singular'),
                'label'=>trans('EMPLANG::Employers.singular'),
                'pivot'=>true,
                'select_all'=>true,
                'include_all_form_fields' => true,
                'multiple' => true,

            ],[
                'type'=>'select_from_array',
                'name'=>'Stage',
                'placeholder'=>trans('EMPLANG::Employers_trainings.Stage'),
                'label'=>trans('EMPLANG::Employers_trainings.Stage'),
                'options'=>["A"=>'A',"B"=>'B',]
            ],[
                'type'=>'date_range',
                'name'=>'TrainningTimeStart,TrainningTimeEnd',
                'placeholder'=>trans('EMPLANG::Employers_trainings.TrainningTime'),
                'label'=>trans('EMPLANG::Employers_trainings.TrainningTime'),
                'time'=>true,
            ],
            [
                'type'=>'url',
                'name'=>'TrainningLink',
                'label'=>trans('EMPLANG::Employers_trainings.TrainningLink'),
            ],
            [
                'type'=>'datalist',
                'name'=>'Trainer',
                'label'=>trans('EMPLANG::Employers_trainings.Trainer'),
                'options'=>$this->gettrainers()
            ],
            [
                'type'=>'datetime_picker',
                'name'=>'TestDate',
                'label'=>trans('EMPLANG::Employers_trainings.TestDate'),
            ],

                ]);
    }
    protected function gettrainers(){
        $db=Employers_trainings::distinct()->get('Trainer');
        if($db){
           return $db->pluck('Trainer')->toArray();
        }
        return[];
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Employers_trainingsRequest::class);
        $this->fields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Employers_trainingsRequest::class);
        $this->fields();
    }
    function update(Employers_trainingsRequest $request){
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
        $Employers_CareerPathes=Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathes::class;
        $model=\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathes::class;
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
        $model=\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathFiles::class;
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
