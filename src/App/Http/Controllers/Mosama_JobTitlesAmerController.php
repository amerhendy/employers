<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Mosama_JobTitles as Mosama_JobTitles;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\Mosama_JobTitlesRequest as Mosama_JobTitlesRequest;

class Mosama_JobTitlesAmerController extends AmerController
{
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\ListOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\CreateOperation  {store as traitStore;}
    //use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\CreateOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\UpdateOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\DeleteOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\ShowOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\TrashOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\CloneOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\BulkCloneOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\BulkDeleteOperation;
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\FetchOperation;
    public function setup()
    {
        AMER::setModel(Mosama_JobTitles::class);
        AMER::setRoute(config('Amer.employers.route_prefix') . '/Mosama_JobTitles');
        AMER::setEntityNameStrings(trans('EMPLANG::Mosama_JobTitles.singular'), trans('EMPLANG::Mosama_JobTitles.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Mosama_JobTitles.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_JobTitles.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_JobTitles.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Mosama_JobTitles.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_JobTitles.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_JobTitles.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Mosama_JobTitles-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Mosama_JobTitles-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Mosama_JobTitles-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Mosama_JobTitles-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Mosama_JobTitles-show') == 0){$this->Amer->denyAccess('show');}
        */
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupListOperation(){
        AMER::addColumns([
            [
                'label'=>trans('EMPLANG::Mosama_JobTitles.singular'),
                'name'=>'text',
                'type'=>'text',
            ]
        ]);
        $rels=['Mosama_Competencies','Mosama_Connections','Mosama_Educations','Mosama_Goals','Mosama_Managers','Mosama_OrgStruses','Mosama_Skills','Mosama_Tasks'];
        foreach ($rels as $key => $value) {
            AMER::addColumn([
                'label'=>trans('EMPLANG::'.$value.'.singular'),
                'name'=>$value,
                'type'=>'select_multiple',
                'entity'=>$value,
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\Models\\'.$value
            ]);
        }   
    }
    function fields(){
        AMER::addField([
            'name'=>'text',
            'type'=>'text',
            'label'=>trans('EMPLANG::Mosama_JobTitles.singular'),
        ]);
        $routes=$this->Amer->routelist;
        AMER::addFields([
            [
                                        'type'=>'select2_from_ajax',
                                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Competencies',
                                        'name'=>'Mosama_Competencies',
                                        'placeholder'=>trans('EMPLANG::Mosama_Competencies.singular'),
                                        'label'=>trans('EMPLANG::Mosama_Competencies.singular'),
                                        'minimum_input_length'=>0,
                                        'data_source'=>$routes['fetchMosama_Competencies']['as'],
                                        'entity'=>'Mosama_Competencies',
                                        'attribute'=>'text',
                                        'select_all'=>true,
                                    ],
                                    [
                                            'type'=>'select2_from_ajax',
                                            'model'=>'Amerhendy\Employers\App\Models\Mosama_Connections',
                                            'name'=>'Mosama_Connections',
                                            'placeholder'=>trans('EMPLANG::Mosama_Connections.singular'),
                                            'label'=>trans('EMPLANG::Mosama_Connections.singular'),
                                            'minimum_input_length'=>0,
                                            'data_source'=>$routes['fetchMosama_Connections']['as'],
                                            'entity'=>'Mosama_Connections',
                                            'attribute'=>['type','text'],
                                            'select_all'=>true,
                                            'array_view'=>[
                                                'divider'=>':::',
                                                'enum'=>[
                                                    'type'=>['in'=>'اتصال داخلى','out'=>'اتصال خارجى']
                                                ],
                                                'translate'=>'? : ?',
                                            ]
                                        ],
                                        [
                                        'type'=>'select2_from_ajax',
                                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Educations',
                                        'name'=>'Mosama_Educations',
                                        'placeholder'=>trans('EMPLANG::Mosama_Educations.singular'),
                                        'label'=>trans('EMPLANG::Mosama_Educations.singular'),
                                        'minimum_input_length'=>0,
                                        'data_source'=>$routes['fetchMosama_Educations']['as'],
                                        'entity'=>'Mosama_Educations',
                                        'attribute'=>'text',
                                        'select_all'=>true,
                                    ],
                                    [
                                    'type'=>'select2_from_ajax',
                                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Goals',
                                    'name'=>'Mosama_Goals',
                                    'placeholder'=>trans('EMPLANG::Mosama_Goals.singular'),
                                    'label'=>trans('EMPLANG::Mosama_Goals.singular'),
                                    'minimum_input_length'=>0,
                                    'data_source'=>$routes['fetchMosama_Goals']['as'],
                                    'entity'=>'Mosama_Goals',
                                    'attribute'=>'text',
                                    'select_all'=>true,
                                ],
                                [
                                        'type'=>'select2_from_ajax',
                                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Managers',
                                        'name'=>'Mosama_Managers',
                                        'placeholder'=>trans('EMPLANG::Mosama_Managers.singular'),
                                        'label'=>trans('EMPLANG::Mosama_Managers.singular'),
                                        'minimum_input_length'=>0,
                                        'data_source'=>$routes['fetchMosama_Managers']['as'],
                                        'entity'=>'Mosama_Managers',
                                        'attribute'=>'text',
                                        'select_all'=>true,
                                    ],
                                    [
                                        'type'=>'select2_from_ajax',
                                        'model'=>'Amerhendy\Employers\App\Models\Mosama_OrgStruses',
                                        'name'=>'Mosama_OrgStruses',
                                        'placeholder'=>trans('EMPLANG::Mosama_OrgStruses.singular'),
                                        'label'=>trans('EMPLANG::Mosama_OrgStruses.singular'),
                                        'minimum_input_length'=>0,
                                        'data_source'=>$routes['fetchMosama_OrgStruses']['as'],
                                        'entity'=>'Mosama_OrgStruses',
                                        'attribute'=>'text',
                                        'select_all'=>true,
                                    ],
                                    [
                                    'type'=>'select2_from_ajax',
                                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Skills',
                                    'name'=>'Mosama_Skills',
                                    'placeholder'=>trans('EMPLANG::Mosama_Skills.singular'),
                                    'label'=>trans('EMPLANG::Mosama_Skills.singular'),
                                    'minimum_input_length'=>0,
                                    'data_source'=>$routes['fetchMosama_Skills']['as'],
                                    'entity'=>'Mosama_Skills',
                                    'attribute'=>'text',
                                    'select_all'=>true,
                                ],
                                [
                                'type'=>'select2_from_ajax',
                                'model'=>'Amerhendy\Employers\App\Models\Mosama_Tasks',
                                'name'=>'Mosama_Tasks',
                                'placeholder'=>trans('EMPLANG::Mosama_Tasks.singular'),
                                'label'=>trans('EMPLANG::Mosama_Tasks.singular'),
                                'minimum_input_length'=>0,
                                'data_source'=>$routes['fetchMosama_Tasks']['as'],
                                'entity'=>'Mosama_Tasks',
                                'attribute'=>'text',
                                'select_all'=>true,
                            ],
            ]); 
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Mosama_JobTitlesRequest::class);
        $this->fields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Mosama_JobTitlesRequest::class);
        $this->fields();
    }
    public function store(Mosama_JobTitlesRequest $request)
    {
        $table=$this->Amer->model->getTable();
        $lsid=DB::table($table)->get()->max('id');
        $id=$lsid+1;
        $this->Amer->addField(['type' => 'hidden', 'name' => 'id', 'value'=>$id]);
        $this->Amer->getRequest()->request->add(['id'=> $id]);
        $this->Amer->setRequest($this->Amer->validateRequest());
        $this->Amer->unsetValidation();
        return $this->traitStore();
    }
    public function destroy($id)
    {
        $this->Amer->hasAccessOrFail('delete');
        $data=$this->Amer->model::remove_force($id);
        return $data;
    }
    public function fetchMosama_Groups()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Groups::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Competencies()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Competencies::class;
        $text='Mosama_Groups';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn($text.'.id',$result);
                });
            } 
        ]);
    }
    public function fetchMosama_Connections()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Connections::class;
        $text='Mosama_Groups';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn($text.'.id',$result);
                });
            } 
        ]);
    }
    public function fetchMosama_Educations()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Educations::class;
        $text='Mosama_Groups';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn($text.'.id',$result);
                });
            } 
        ]);
    }
    public function fetchMosama_Goals()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Goals::class;
        $text='Mosama_Groups';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn($text.'.id',$result);
                });
            } 
        ]);
    }
    public function fetchMosama_Managers()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Managers::class;
        $text='Mosama_Groups';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn($text.'.id',$result);
                });
            } 
        ]);
    }
    public function fetchMosama_OrgStruses()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_OrgStruses::class;
        $text='Mosama_Groups';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn($text.'.id',$result);
                });
            } 
        ]);
    }
    public function fetchMosama_Skills()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Skills::class;
        $text='Mosama_Groups';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn($text.'.id',$result);
                });
            } 
        ]);
        
    }
    public function fetchMosama_Tasks()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Tasks::class;
        $text='Mosama_Groups';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn($text.'.id',$result);
                });
            } 
        ]);
        
    }   
}