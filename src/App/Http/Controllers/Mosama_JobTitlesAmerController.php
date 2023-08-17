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
        AMER::setRoute(config('amer.route_prefix') . '/Mosama_JobTitles');
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
        AMER::addField([
            'label'             => '',
            'field_unique_name' => 'jobnames',
            'name'=>['Mosama_Groups','Mosama_Competencies','Mosama_Connections','Mosama_Educations','Mosama_Goals','Mosama_Managers','Mosama_OrgStruses','Mosama_Skills','Mosama_Tasks'],
            'type'=>'Employers::Employers.jobtitles',
            'subfields'=>[
                'Mosama_Groups'=>[
                    'type'=>'select2',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Groups',
                    'name'=>'Mosama_Groups',
                    'placeholder'=>trans('EMPLANG::Mosama_Groups.singular'),
                    'minimum_input_length'=>0,
                    'entity'=>'Mosama_Groups',
                    'attribute'=>'text',
                    'entity_secondary' => ['Mosama_JobTitles','Mosama_JobNames'],
                ],
                'Mosama_Competencies'=>[
                                        'type'=>'select2_from_ajax',
                                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Competencies',
                                        'name'=>'Mosama_Competencies',
                                        'placeholder'=>trans('EMPLANG::Mosama_Competencies.singular'),
                                        'minimum_input_length'=>0,
                                        'data_source'=>$routes['fetchMosama_Competencies']['as'],
                                        'entity'=>'Mosama_Competencies',
                                        'attribute'=>'text',
                                        'entity_primary'=>'Mosama_Groups',
                                        'select_all'=>true,
                                    ],
                'Mosama_Connections'=>[
                                            'type'=>'select2_from_ajax',
                                            'model'=>'Amerhendy\Employers\App\Models\Mosama_Connections',
                                            'name'=>'Mosama_Connections',
                                            'placeholder'=>trans('EMPLANG::Mosama_Connections.singular'),
                                            'minimum_input_length'=>0,
                                            'data_source'=>$routes['fetchMosama_Connections']['as'],
                                            'entity'=>'Mosama_Connections',
                                            'attribute'=>['type','text'],
                                            'entity_primary'=>'Mosama_Groups',
                                            'select_all'=>true,
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
                                        'placeholder'=>trans('EMPLANG::Mosama_Educations.singular'),
                                        'minimum_input_length'=>0,
                                        'data_source'=>$routes['fetchMosama_Educations']['as'],
                                        'entity'=>'Mosama_Educations',
                                        'attribute'=>'text',
                                        'entity_primary'=>'Mosama_Groups',
                                        'select_all'=>true,
                                    ],
                'Mosama_Goals'=>[
                                    'type'=>'select2_from_ajax',
                                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Goals',
                                    'name'=>'Mosama_Goals',
                                    'placeholder'=>trans('EMPLANG::Mosama_Goals.singular'),
                                    'minimum_input_length'=>0,
                                    'data_source'=>$routes['fetchMosama_Goals']['as'],
                                    'entity'=>'Mosama_Goals',
                                    'attribute'=>'text',
                                    'entity_primary'=>'Mosama_Groups',
                                    'select_all'=>true,
                                ],
                'Mosama_Managers'=>[
                                        'type'=>'select2_from_ajax',
                                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Managers',
                                        'name'=>'Mosama_Managers',
                                        'placeholder'=>trans('EMPLANG::Mosama_Managers.singular'),
                                        'minimum_input_length'=>0,
                                        'data_source'=>$routes['fetchMosama_Managers']['as'],
                                        'entity'=>'Mosama_Managers',
                                        'attribute'=>'text',
                                        'entity_primary'=>'Mosama_Groups',
                                        'select_all'=>true,
                                    ],
                'Mosama_OrgStruses'=>[
                                        'type'=>'select2_from_ajax',
                                        'model'=>'Amerhendy\Employers\App\Models\Mosama_OrgStruses',
                                        'name'=>'Mosama_OrgStruses',
                                        'placeholder'=>trans('EMPLANG::Mosama_OrgStruses.singular'),
                                        'minimum_input_length'=>0,
                                        'data_source'=>$routes['fetchMosama_OrgStruses']['as'],
                                        'entity'=>'Mosama_OrgStruses',
                                        'attribute'=>'text',
                                        'entity_primary'=>'Mosama_Groups',
                                        'select_all'=>true,
                                    ],
                'Mosama_Skills'=>[
                                    'type'=>'select2_from_ajax',
                                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Skills',
                                    'name'=>'Mosama_Skills',
                                    'placeholder'=>trans('EMPLANG::Mosama_Skills.singular'),
                                    'minimum_input_length'=>0,
                                    'data_source'=>$routes['fetchMosama_Skills']['as'],
                                    'entity'=>'Mosama_Skills',
                                    'attribute'=>'text',
                                    'entity_primary'=>'Mosama_Groups',
                                    'select_all'=>true,
                                ],
                'Mosama_Tasks'=>[
                                'type'=>'select2_from_ajax',
                                'model'=>'Amerhendy\Employers\App\Models\Mosama_Tasks',
                                'name'=>'Mosama_Tasks',
                                'placeholder'=>trans('EMPLANG::Mosama_Tasks.singular'),
                                'minimum_input_length'=>0,
                                'data_source'=>$routes['fetchMosama_Tasks']['as'],
                                'entity'=>'Mosama_Tasks',
                                'attribute'=>'text',
                                'entity_primary'=>'Mosama_Groups',
                                'select_all'=>true,
                            ],
            ]
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
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Mosama_Groups'])){
                $Mosama_Groups=$parents['Mosama_Groups'];
            }
        }else{
            $Mosama_Groups=null;
        }
        if(is_numeric($Mosama_Groups)){$Mosama_Groups=[$Mosama_Groups];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Competencies::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Mosama_Groups) {
                return $model->whereHas('Mosama_Groups',function($q)use($Mosama_Groups){
                    return $q->whereIn('Mosama_Groups.id',$Mosama_Groups);
                });
            } 
        ]);
    }
    public function fetchMosama_Connections()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Mosama_Groups'])){
                $Mosama_Groups=$parents['Mosama_Groups'];
            }
        }else{
            $Mosama_Groups=null;
        }
        if(is_numeric($Mosama_Groups)){$Mosama_Groups=[$Mosama_Groups];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Connections::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Mosama_Groups) {
                return $model->whereHas('Mosama_Groups',function($q)use($Mosama_Groups){
                    return $q->whereIn('Mosama_Groups.id',$Mosama_Groups);
                });
            } 
        ]);
    }
    public function fetchMosama_Educations()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Mosama_Groups'])){
                $Mosama_Groups=$parents['Mosama_Groups'];
            }
        }else{
            $Mosama_Groups=null;
        }
        if(is_numeric($Mosama_Groups)){$Mosama_Groups=[$Mosama_Groups];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Educations::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Mosama_Groups) {
                return $model->whereHas('Mosama_Groups',function($q)use($Mosama_Groups){
                    return $q->whereIn('Mosama_Groups.id',$Mosama_Groups);
                });
            } 
        ]);
    }
    public function fetchMosama_Goals()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Mosama_Groups'])){
                $Mosama_Groups=$parents['Mosama_Groups'];
            }
        }else{
            $Mosama_Groups=null;
        }
        if(is_numeric($Mosama_Groups)){$Mosama_Groups=[$Mosama_Groups];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Goals::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Mosama_Groups) {
                return $model->whereHas('Mosama_Groups',function($q)use($Mosama_Groups){
                    return $q->whereIn('Mosama_Groups.id',$Mosama_Groups);
                });
            } 
        ]);
    }
    public function fetchMosama_Managers()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Mosama_Groups'])){
                $Mosama_Groups=$parents['Mosama_Groups'];
            }
        }else{
            $Mosama_Groups=null;
        }
        if(is_numeric($Mosama_Groups)){$Mosama_Groups=[$Mosama_Groups];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Managers::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Mosama_Groups) {
                return $model->whereHas('Mosama_Groups',function($q)use($Mosama_Groups){
                    return $q->whereIn('Mosama_Groups.id',$Mosama_Groups);
                });
            } 
        ]);
    }
    public function fetchMosama_OrgStruses()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Mosama_Groups'])){
                $Mosama_Groups=$parents['Mosama_Groups'];
            }
        }else{
            $Mosama_Groups=null;
        }
        if(is_numeric($Mosama_Groups)){$Mosama_Groups=[$Mosama_Groups];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_OrgStruses::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Mosama_Groups) {
                return $model->whereHas('Mosama_Groups',function($q)use($Mosama_Groups){
                    return $q->whereIn('Mosama_Groups.id',$Mosama_Groups);
                });
            } 
        ]);
    }
    public function fetchMosama_Skills()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Mosama_Groups'])){
                $Mosama_Groups=$parents['Mosama_Groups'];
            }
        }else{
            $Mosama_Groups=null;
        }
        if(is_numeric($Mosama_Groups)){$Mosama_Groups=[$Mosama_Groups];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Skills::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Mosama_Groups) {
                return $model->whereHas('Mosama_Groups',function($q)use($Mosama_Groups){
                    return $q->whereIn('Mosama_Groups.id',$Mosama_Groups);
                });
            } 
        ]);
    }
    public function fetchMosama_Tasks()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Mosama_Groups'])){
                $Mosama_Groups=$parents['Mosama_Groups'];
            }
        }else{
            $Mosama_Groups=null;
        }
        if(is_numeric($Mosama_Groups)){$Mosama_Groups=[$Mosama_Groups];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Tasks::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Mosama_Groups) {
                return $model->whereHas('Mosama_Groups',function($q)use($Mosama_Groups){
                    return $q->whereIn('Mosama_Groups.id',$Mosama_Groups);
                });
            } 
        ]);
    }
    
}