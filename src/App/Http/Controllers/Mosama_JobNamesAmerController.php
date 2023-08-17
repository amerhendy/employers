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
        AMER::setRoute(config('amer.route_prefix') . '/Mosama_JobNames');
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
                // two interconnected entities
                'label'             => trans('AMER::permissionmanager.user_role_permission'),
                'field_unique_name' => 'jobnames',
                'type'              => 'Employers::Employers.jobnames',
                'name'              => ['Group_id','JobTitle_id', 'Degree_id','Mosama_Experiences','Mosama_Competencies','Mosama_Connections','Mosama_Educations','Mosama_Goals','Mosama_Managers','Mosama_OrgStruses','Mosama_Skills','Mosama_Tasks'],
                'subfields'=>[
                    'Group_id'=>[
                        'type'=>'select2',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Groups',
                        'name'=>'Mosama_Groups',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_Groups.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Groups']['as'],
                        'entity_secondary' => 'JobTitle_id',
                        'entity'=>'Mosama_Groups',
                    ],
                    'JobTitle_id'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_JobTitles',
                        'name'=>'Mosama_JobTitles',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_JobTitles.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_JobTitles']['as'],
                        'entity'=>'Mosama_JobTitles',
                    ],
                    'Degree_id'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Degrees',
                        'name'=>'Mosama_Degrees',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_Degrees.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Degrees']['as'],
                        'entity'=>'Mosama_Degrees',
                    ],
                    'Mosama_Competencies'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Competencies',
                        'name'=>'Mosama_Competencies',
                        'attribute'=>'text',
                           'placeholder'=>trans('EMPLANG::Mosama_Competencies.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Competencies']['as'],
                        'allows_multiple' => true,
                        'entity'=>'Mosama_Competencies',
                    ],
                    'Mosama_Experiences'=>[
                        'type'=>'select2_from_ajax',
                        'entity'=>'Mosama_Experiences',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Experiences',
                        'name'=>'Mosama_Experiences',
                        'attribute'=>['type','time'],
                        'placeholder'=>trans('EMPLANG::Mosama_Experiences.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Experiences']['as'],
                        'allows_multiple' => true,
                        'select_all'=>true,
                        'allows_null'=>false,
                        'array_view'=>[
                            'divider'=>':::',
                            'enum'=>[
                                'type'=>[1=>trans('EMPLANG::Mosama_Experiences.enum_1'),0=>trans('EMPLANG::Mosama_Experiences.enum_0')]
                            ],
                            'translate'=>trans('EMPLANG::Mosama_Experiences.translate'),
                        ]
                    ],
                    'Mosama_Connections'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Connections',
                        'name'=>'Mosama_Connections',
                        'attribute'=>['type','text'],
                        'placeholder'=>trans('EMPLANG::Mosama_Connections.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Connections']['as'],
                        'allows_multiple' => true,
                        'entity'=>'Mosama_Connections',
                        'array_view'=>[
                            'divider'=>':::',
                            'enum'=>[
                                'type'=>['in'=>'اتصال داخلى','out'=>'اتصال خارجى']
                            ],
                            'translate'=>'? : ?',
                        ]
                    ],
                    'Mosama_Educations'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Educations',
                        'name'=>'Mosama_Educations',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_Educations.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Educations']['as'],
                        'allows_multiple' => true,
                        'entity'=>'Mosama_Educations',
                    ],
                    'Mosama_Goals'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Goals',
                        'name'=>'Mosama_Goals',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_Goals.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Goals']['as'],
                        'allows_multiple' => true,
                        'entity'=>'Mosama_Goals',
                    ],
                    'Mosama_Managers'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Managers',
                        'name'=>'Mosama_Managers',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_Managers.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Managers']['as'],
                        'allows_multiple' => true,
                        'entity'=>'Mosama_Managers',
                    ],
                    'Mosama_OrgStruses'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_OrgStruses',
                        'name'=>'Mosama_OrgStruses',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_OrgStruses.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_OrgStruses']['as'],
                        'allows_multiple' => true,
                        'entity'=>'Mosama_OrgStruses',
                    ],
                    'Mosama_Skills'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Skills',
                        'name'=>'Mosama_Skills',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_Skills.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Skills']['as'],
                        'allows_multiple' => true,
                        'entity'=>'Mosama_Skills',
                    ],
                    'Mosama_Tasks'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Tasks',
                        'name'=>'Mosama_Tasks',
                        'attribute'=>'text',
                        'placeholder'=>trans('EMPLANG::Mosama_Tasks.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Tasks']['as'],
                        'allows_multiple' => true,
                        'entity'=>'Mosama_Tasks',
                    ],
                ]

            ],
        ]
        );
        
        
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
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Group_id'])){
                $Group_id=$parents['Group_id'];
            }
        }else{
            $Group_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_JobTitles::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Group_id) {
                return $model->whereHas('Mosama_Groups',function($query)use($Group_id){
                    return $query->where('Mosama_Groups.id',$Group_id);
                });
            } 
        ]);
    }
    public function fetchMosama_Degrees()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Degrees::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
    }
    public function fetchMosama_Competencies()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Competencies::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Competencies::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Experiences()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Experiences::class,
            'searchable_attributes' => ['time','type'],
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Experiences::class,'searchable_attributes'=>['time','type']]);
    }
    
    public function fetchMosama_Connections()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Connections::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
    }
    public function fetchMosama_Educations()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Educations::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Educations::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Goals()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Goals::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Goals::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Managers()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Managers::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Managers::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_OrgStruses()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_OrgStruses::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_OrgStruses::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Skills()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Skills::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Skills::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Tasks()
    {
        $op=$_GET;
        if(isset($op['parents']['JobTitle_id'])){
                $JobTitle_id=$op['parents']['JobTitle_id'];
        }else{
            $JobTitle_id=null;
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Tasks::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($JobTitle_id) {
                return $model->whereHas('Mosama_Groups',function($q)use($JobTitle_id){
                    return $q->whereHas('Mosama_JobTitles',function($query)use($JobTitle_id){
                        return $query->where('Mosama_JobTitles.id',$JobTitle_id);
                    });
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Tasks::class,'searchable_attributes'=>'text']);
    }
}