<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Mosama_Experiences as Mosama_Experiences;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\Mosama_ExperiencesRequest as Mosama_ExperiencesRequest;

class Mosama_ExperiencesAmerController extends AmerController
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
        AMER::setModel(Mosama_Experiences::class);
        AMER::setRoute(config('Amer.employers.employers.route_prefix') . '/Mosama_Experiences');
        AMER::setEntityNameStrings(trans('EMPLANG::Mosama_Experiences.singular'), trans('EMPLANG::Mosama_Experiences.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Experiences.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Experiences.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Experiences.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Experiences.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Experiences.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Experiences.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Mosama_Experiences-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Mosama_Experiences-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Mosama_Experiences-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Mosama_Experiences-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Mosama_Experiences-show') == 0){$this->Amer->denyAccess('show');}
        */
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupListOperation(){
        AMER::addColumns([
            [
                'name'=>'type',
                'type'=>'enum',
                'label'=>trans('EMPLANG::Mosama_Experiences.type'),
                'options' => [
                    0 =>trans('EMPLANG::Mosama_Experiences.enum_0'),
                    1 => trans('EMPLANG::Mosama_Experiences.enum_1'),
                ]
            ],
            [
                'name'=>'time',
                'type'=>'number',
                'label'=>trans('EMPLANG::Mosama_Experiences.years'),
                'prefix'=>'عدد(',
                'suffix'=>') سنة',
                'wrapper'=>[]
                
            ],
            [
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
                'name'=>'Mosama_Groups',
                'type'=>'select_multiple',
                'entity'=>'Mosama_Groups',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Groups'
            ],
            [
                'label'=>trans('EMPLANG::Mosama_JobNames.singular'),
                'name'=>'Mosama_JobNames',
                'type'=>'select_multiple',
                'entity'=>'Mosama_JobNames',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_JobNames'
            ],
        ]);
    }
    function fields(){
            AMER::addFields([
                [
                    'name'=>'type',
                    'type'=>'enum',
                    'label'=>trans('EMPLANG::Mosama_Experiences.type'),
                    'options' => [
                        0 =>trans('EMPLANG::Mosama_Experiences.enum_0'),
                        1 => trans('EMPLANG::Mosama_Experiences.enum_1'),
                    ]
                ],
                [
                    'name'=>'time',
                    'type'=>'number',
                    'label'=>trans('EMPLANG::Mosama_Experiences.years'),
                    'prefix'=>'عدد(',
                    'suffix'=>') سنة',
                    'wrapper'=>[]
                    
                ]
            ]);
            $routes=$this->Amer->routelist;
        AMER::addFields([
                [
                    'type'=>'select2_from_ajax',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_Groups',
                    'name'=>'Mosama_Groups',
                    'placeholder'=>trans('EMPLANG::Mosama_Groups.singular'),
                    'label'=>trans('EMPLANG::Mosama_Groups.singular'),
                    'minimum_input_length'=>0,
                    'data_source'=>$routes['fetchMosama_Groups']['as'],
                    'entity'=>'Mosama_Groups',
                    'attribute'=>'text',
                    'pivot'=>true,
                    'select_all'=>true,
                    'include_all_form_fields' => true,
                ],
                [
                    'type'=>'select2_from_ajax',
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_JobNames',
                    'name'=>'Mosama_JobNames',
                    'placeholder'=>trans('EMPLANG::Mosama_JobNames.singular'),
                    'label'=>trans('EMPLANG::Mosama_JobNames.singular'),
                    'minimum_input_length'=>0,
                    'data_source'=>$routes['fetchMosama_JobNames']['as'],
                    'entity'=>'Mosama_JobNames',
                    'attribute'=>'text',
                    'select_all'=>true,
                    'include_all_form_fields' => true,
                    'dependencies'            => ['Mosama_Groups'],
                ], 
                ]); 
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Mosama_ExperiencesRequest::class);
        $this->fields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Mosama_ExperiencesRequest::class);
        $this->fields();
    }
    public function store(Mosama_ExperiencesRequest $request)
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
    public function fetchMosama_JobNames()
    {
        $model=\Amerhendy\Employers\App\Models\Mosama_JobNames::class;
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