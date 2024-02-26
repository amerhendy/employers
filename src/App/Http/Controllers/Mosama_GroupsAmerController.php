<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Mosama_Groups as Mosama_Groups;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\Mosama_GroupsRequest as Mosama_GroupsRequest;

class Mosama_GroupsAmerController extends AmerController
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
        AMER::setModel(Mosama_Groups::class);
        AMER::setRoute(config('Amer.employers.route_prefix') . '/Mosama_Groups');
        AMER::setEntityNameStrings(trans('EMPLANG::Mosama_Groups.singular'), trans('EMPLANG::Mosama_Groups.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Groups.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Groups.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Groups.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Groups.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Groups.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Groups.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Mosama_Groups-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Mosama_Groups-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Mosama_Groups-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Mosama_Groups-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Mosama_Groups-show') == 0){$this->Amer->denyAccess('show');}
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
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
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
        $rels=['Mosama_Competencies','Mosama_Connections','Mosama_Degrees','Mosama_Educations','Mosama_Goals','Mosama_JobTitles','Mosama_Managers','Mosama_OrgStruses','Mosama_Skills','Mosama_Tasks'];
        AMER::addColumn([
            'label'=>trans('EMPLANG::Mosama_Managers.Mosama_DirectManagers'),
            'name'=>'Mosama_DirectManagers',
            'type'=>'select_multiple',
            'entity'=>'Mosama_DirectManagers',
            'attribute'=>'text',
            'model'=>'Amerhendy\Employers\App\Models\Mosama_Managers'
        ]);
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
    function groupfields(){
        AMER::addFields([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
            ]
        ]);
        $routes=$this->Amer->routelist;
        AMER::addField([
            'name'=>'Mosama_Competencies',
            'type'=>'select2_from_ajax','placeholder'=>trans('EMPLANG::Mosama_Competencies.singular'),'entity'=>'Mosama_Competencies',
            'model'=>'Amerhendy\Employers\App\Models\Mosama_Competencies','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_Competencies']['as'],
        ]);
        AMER::addField([
            'type'=>'select2_from_ajax','name'=>'Mosama_Connections','placeholder'=>trans('EMPLANG::Mosama_Connections.singular'),'entity'=>'Mosama_Connections',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Connections','minimum_input_length'=>0,'attribute'=>['type','text'],'select_all'=>true,'data_source'=>$routes['fetchMosama_Connections']['as'],
                    'array_view'=>[
                        'divider'=>':::',
                        'enum'=>[
                            'type'=>['in'=>'اتصال داخلى','out'=>'اتصال خارجى']
                        ],
                        'translate'=>'? : ?',
                    ]
        ]);
        AMER::addFields([
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_Degrees','placeholder'=>trans('EMPLANG::Mosama_Degrees.singular'),'entity'=>'Mosama_Degrees',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Degrees','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_Degrees']['as'],
                ],
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_DirectManagers','placeholder'=>trans('EMPLANG::Mosama_Managers.Mosama_DirectManagers'),'entity'=>'Mosama_DirectManagers',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Managers','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_DirectManagers']['as'],
                ],
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_Educations','placeholder'=>trans('EMPLANG::Mosama_Educations.singular'),'entity'=>'Mosama_Educations',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Educations','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_Educations']['as'],
                ],
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_Experiences','placeholder'=>trans('EMPLANG::Mosama_Experiences.singular'),'entity'=>'Mosama_Experiences',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Experiences','minimum_input_length'=>0,'attribute'=>['type','time'],'select_all'=>true,'data_source'=>$routes['fetchMosama_Experiences']['as'],'array_view'=>[
                        'divider'=>':::',
                        'enum'=>[
                            'type'=>[1=>'خبرة فى مجال العمل',0=>'مدة بينية']
                        ],
                        'translate'=>'يتطلب ? لمدة ( ? ) سنة',
                    ]
                ],
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_Goals','placeholder'=>trans('EMPLANG::Mosama_Goals.singular'),'entity'=>'Mosama_Goals',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Goals','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_Goals']['as'],
                ],
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_Managers','placeholder'=>trans('EMPLANG::Mosama_Managers.singular'),'entity'=>'Mosama_Managers',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Managers','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_Managers']['as'],
                ],
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_OrgStruses','placeholder'=>trans('EMPLANG::Mosama_OrgStruses.singular'),'entity'=>'Mosama_OrgStruses',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_OrgStruses','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_OrgStruses']['as'],
                ],
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_Skills','placeholder'=>trans('EMPLANG::Mosama_Skills.singular'),'entity'=>'Mosama_Skills',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Skills','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_Skills']['as'],
                ],
                [
                    'type'=>'select2_from_ajax','name'=>'Mosama_Tasks','placeholder'=>trans('EMPLANG::Mosama_Tasks.singular'),'entity'=>'Mosama_Tasks',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Tasks','minimum_input_length'=>0,'attribute'=>'text','select_all'=>true,'data_source'=>$routes['fetchMosama_Tasks']['as'],
                ]
            ]
        );
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Mosama_GroupsRequest::class);
        $this->groupfields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Mosama_GroupsRequest::class);
        $this->groupfields();
    }
    public function store(Mosama_GroupsRequest $request)
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
    public function fetchMosama_Competencies()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Competencies::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Connections()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Connections::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Degrees()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Degrees::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_DirectManagers()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Managers::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Educations()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Educations::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Experiences()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Experiences::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Goals()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Goals::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Managers()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Managers::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_OrgStruses()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_OrgStruses::class,'searchable_attributes'=>'text']);
    }
    public function fetchMosama_Skills()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Skills::class,'searchable_attributes'=>'text']);
    }
    
    public function fetchMosama_Tasks()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Mosama_Tasks::class,'searchable_attributes'=>'text']);
    }
    
}