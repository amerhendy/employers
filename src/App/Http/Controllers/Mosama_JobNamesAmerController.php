<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Mosama_JobNames as Mosama_JobNames;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use \Amerhendy\Employers\App\Http\Requests\Mosama_JobNamesRequest as Mosama_JobNamesRequest;

class Mosama_JobNamesAmerController extends AmerController
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
        AMER::setModel(Mosama_JobNames::class);
        AMER::setRoute(config('Amer.employers.route_prefix') . '/Mosama_JobNames');
        AMER::setEntityNameStrings(trans('EMPLANG::Mosama_JobNames.singular'), trans('EMPLANG::Mosama_JobNames.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Mosama_JobNames.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_JobNames.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_JobNames.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Mosama_JobNames.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_JobNames.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_JobNames.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Mosama_JobNames-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Mosama_JobNames-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Mosama_JobNames-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Mosama_JobNames-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Mosama_JobNames-show') == 0){$this->Amer->denyAccess('show');}
        */
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupListOperation(){
        AMER::addColumns([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Mosama_JobNames.singular'),
            ]
        ]);
        AMER::addColumns([
            [
                'label'=>trans('EMPLANG::Mosama_Experiences.singular'),
                'name'=>'Mosama_Experiences',
                'type'=>'select_multiple',
                'attribute'=>['type','time'],
                'select_all'=>true,
                'allows_null'=>false,
                'array_view'=>[
                    'divider'=>':::',
                    'enum'=>[
                        'type'=>[1=>trans('EMPLANG::Mosama_Experiences.enum_1'),0=>trans('EMPLANG::Mosama_Experiences.enum_0')]
                    ],
                    'translate'=>trans('EMPLANG::Mosama_Experiences.translate'),
                ]
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
    function createfields(){
        $routes=$this->Amer->routelist;
        //dd($routes);
        AMER::addFields([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Mosama_JobNames.singular'),
            ],
            [
                'name'=>'Group_id',
                'type'=>'select2',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Groups',
                'attribute'=>'text',
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
            ],[
                'label'=>trans('EMPLANG::Mosama_JobTitles.singular'),
                'type'=>'select2_from_ajax',
                'name'=>'JobTitle_id',
                'data_source'=>$routes['fetchMosama_JobTitles']['as'],
                'model'=>'Amerhendy\Employers\App\Models\Mosama_JobTitles',
                'entity'=>'Mosama_JobTitles',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_JobTitles.singular'),
                'include_all_form_fields' => true,
                'minimum_input_length'=>0,
                'dependencies'            => ['Group_id'],
            ],[
                'label'=>trans('EMPLANG::Mosama_Degrees.singular'),
                'type'=>'select2_from_ajax',
                'name'=>'Degree_id',
                'data_source'=>$routes['fetchMosama_Degrees']['as'],
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Degrees',
                'entity'=>'Mosama_Degrees',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_Degrees.singular'),
                'include_all_form_fields' => true,
                'minimum_input_length'=>0,
                'dependencies'            => ['JobTitle_id'],
            ],[
                'label'=>trans('EMPLANG::Mosama_Competencies.singular'),
                'type'=>'select2_from_ajax',
                'name'=>'Mosama_Competencies',
                'data_source'=>$routes['fetchMosama_Competencies']['as'],
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Competencies',
                'entity'=>'Mosama_Competencies',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_Competencies.singular'),
                'include_all_form_fields' => true,
                'minimum_input_length'=>0,
                'multiple'=>true,
                'select_all'=>true,
                'dependencies'            => ['JobTitle_id'],
            ],[
                'label'=>trans('EMPLANG::Mosama_Experiences.singular'),
                'type'=>'select2_from_ajax',
                'name'=>'Mosama_Experiences',
                'data_source'=>$routes['fetchMosama_Experiences']['as'],
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Experiences',
                'entity'=>'Mosama_Experiences',
                'attribute'=>['type','time'],
                'placeholder'=>trans('EMPLANG::Mosama_Experiences.singular'),
                'include_all_form_fields' => true,
                'minimum_input_length'=>0,
                'multiple'=>true,
                'select_all'=>true,
                'dependencies'            => ['JobTitle_id'],
                'array_view'=>[
                    'divider'=>':::',
                    'enum'=>[
                        'type'=>[1=>trans('EMPLANG::Mosama_Experiences.enum_1'),0=>trans('EMPLANG::Mosama_Experiences.enum_0')]
                    ],
                    'translate'=>trans('EMPLANG::Mosama_Experiences.translate'),
                ]
            ],[
                'label'=>trans('EMPLANG::Mosama_Connections.singular'),
                'type'=>'select2_from_ajax',
                'name'=>'Mosama_Connections',
                'data_source'=>$routes['fetchMosama_Connections']['as'],
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Connections',
                'entity'=>'Mosama_Connections',
                'attribute'=>['type','text'],
                'placeholder'=>trans('EMPLANG::Mosama_Connections.singular'),
                'include_all_form_fields' => true,
                'minimum_input_length'=>0,
                'multiple'=>true,
                'select_all'=>true,
                'dependencies'            => ['JobTitle_id'],
                'array_view'=>[
                    'divider'=>':::',
                    'enum'=>[
                        'type'=>['in'=>'اتصال داخلى','out'=>'اتصال خارجى']
                    ],
                    'translate'=>'? : ?',
                ]
            ],[
                'label'=>trans('EMPLANG::Mosama_Educations.singular'),
                'type'=>'select2_from_ajax',
                'name'=>'Mosama_Educations',
                'data_source'=>$routes['fetchMosama_Educations']['as'],
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Educations',
                'entity'=>'Mosama_Educations',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_Educations.singular'),
                'include_all_form_fields' => true,
                'minimum_input_length'=>0,
                'multiple'=>true,
                'select_all'=>true,
                'dependencies'            => ['JobTitle_id'],
            ],[
                'label'=>trans('EMPLANG::Mosama_Goals.singular'),
                'type'=>'select2_from_ajax',
                'name'=>'Mosama_Goals',
                'data_source'=>$routes['fetchMosama_Goals']['as'],
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Goals',
                'entity'=>'Mosama_Goals',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_Goals.singular'),
                'include_all_form_fields' => true,
                'minimum_input_length'=>0,
                'multiple'=>true,
                'select_all'=>true,
                'dependencies'            => ['JobTitle_id'],
            ],[
                'type'=>'select2_from_ajax',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Managers',
                'name'=>'Mosama_Managers',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_Managers.singular'),
                'label'=>trans('EMPLANG::Mosama_Managers.singular'),
                'minimum_input_length'=>0,
                'data_source'=>$routes['fetchMosama_Managers']['as'],
                'include_all_form_fields' => true,
                'allows_multiple' => true,
                'entity'=>'Mosama_Managers',
                'dependencies'            => ['JobTitle_id'],
            ],[
                'type'=>'select2_from_ajax',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_OrgStruses',
                'name'=>'Mosama_OrgStruses',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_OrgStruses.singular'),
                'label'=>trans('EMPLANG::Mosama_OrgStruses.singular'),
                'minimum_input_length'=>0,
                'data_source'=>$routes['fetchMosama_OrgStruses']['as'],
                'allows_multiple' => true,
                'entity'=>'Mosama_OrgStruses',
                'include_all_form_fields' => true,
                'dependencies'            => ['JobTitle_id'],
            ],[
                'type'=>'select2_from_ajax',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Skills',
                'name'=>'Mosama_Skills',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_Skills.singular'),
                'label'=>trans('EMPLANG::Mosama_Skills.singular'),
                'minimum_input_length'=>0,
                'data_source'=>$routes['fetchMosama_Skills']['as'],
                'allows_multiple' => true,
                'entity'=>'Mosama_Skills',
                'include_all_form_fields' => true,
                'dependencies'            => ['JobTitle_id'],
            ],[
                'type'=>'select2_from_ajax',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Tasks',
                'name'=>'Mosama_Tasks',
                'attribute'=>'text',
                'placeholder'=>trans('EMPLANG::Mosama_Tasks.singular'),
                'label'=>trans('EMPLANG::Mosama_Tasks.singular'),
                'minimum_input_length'=>0,
                'data_source'=>$routes['fetchMosama_Tasks']['as'],
                'allows_multiple' => true,
                'entity'=>'Mosama_Tasks',
                'include_all_form_fields' => true,
                'dependencies'            => ['JobTitle_id'],
            ],

        ]);
              
        
        
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Mosama_JobNamesRequest::class);
        $this->createfields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Mosama_JobNamesRequest::class);
        $this->createfields();
    }
    public function store(Mosama_JobNamesRequest $request)
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
    public function fetchMosama_JobTitles()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_JobTitles::class;
        $text='Group_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_Groups',function($q)use($result,$text){
                    return $q->whereIn('Mosama_Groups'.'.id',$result);
                });
            } 
        ]);   
    }
    public function fetchMosama_Degrees()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Degrees::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);   
    }
    public function fetchMosama_Competencies()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Competencies::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);   
    }
    public function fetchMosama_Experiences()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Experiences::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => ['time','type'],
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);   
    }
    public function fetchMosama_Connections()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Connections::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);   
    }
    public function fetchMosama_Educations()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Educations::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);   
    }
    public function fetchMosama_Goals()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Goals::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);   
    }
    public function fetchMosama_Managers()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Managers::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);
        
    }
    public function fetchMosama_OrgStruses()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_OrgStruses::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);
        
    }
    public function fetchMosama_Skills()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Skills::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);
        
    }
    public function fetchMosama_Tasks()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_Tasks::class;
        $text='JobTitle_id';
        $result=\AmerHelper::retunFetchValue($_GET,$text);
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_JobTitles',function($q)use($result,$text){
                    return $q->whereIn('Mosama_JobTitles'.'.id',$result);
                });
            } 
        ]);
        
    }
}