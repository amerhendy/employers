<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Mosama_Degrees as Mosama_Degrees;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\Mosama_DegreesRequest as Mosama_DegreesRequest;

class Mosama_DegreesAmerController extends AmerController
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
        AMER::setModel(Mosama_Degrees::class);
        AMER::setRoute(config('amer.route_prefix') . '/Mosama_Degrees');
        AMER::setEntityNameStrings(trans('EMPLANG::Mosama_Degrees.singular'), trans('EMPLANG::Mosama_Degrees.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Degrees.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Degrees.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Degrees.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Degrees.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Degrees.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Degrees.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Mosama_Degrees-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Mosama_Degrees-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Mosama_Degrees-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Mosama_Degrees-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Mosama_Degrees-show') == 0){$this->Amer->denyAccess('show');}
        */
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupListOperation(){
        //AMER::setFromDb();
        AMER::addColumns([
            [
                'type'=>'text',
                'name'=>'text',
                'label'=>trans('EMPLANG::Mosama_Degrees.singular'),
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
                'label'=>trans('EMPLANG::Mosama_Experiences.singular'),
                'name'=>'Mosama_Experiences',
                'type'=>'select_multiple',
                'entity'=>'Mosama_Experiences',
                'attribute'=>['type','time'],
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Experiences',
                'array_view'=>[
                    'divider'=>':::',
                    'enum'=>[
                        'type'=>[1=>'خبرة فى مجال العمل',0=>'مدة بينية']
                    ],
                    'translate'=>'يتطلب ? لمدة ( ? ) سنة',
                ]
            ]
        ]);
    }
    function fields(){
        AMER::addField([
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Mosama_Connections.singular'),
            ]);
            $routes=$this->Amer->routelist;
        AMER::addField([
                'label'             => '',
                'field_unique_name' => 'jobnames',
                'name'=>['Mosama_Groups','Mosama_Experiences'],
                'type'=>'Employers::Employers.Degrees',
                'subfields'=>[
                    'Mosama_Groups'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Groups',
                        'name'=>'Mosama_Groups',
                        'placeholder'=>trans('EMPLANG::Mosama_Groups.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Groups']['as'],
                        'entity'=>'Mosama_Groups',
                        'attribute'=>'text',
                        'pivot'=>true,
                        'entity_secondary' => ['Mosama_JobTitles','Mosama_JobNames'],
                    ],
                    'Mosama_Experiences'=>[
                        'type'=>'select2_from_ajax',
                        'model'=>'Amerhendy\Employers\App\Models\Mosama_Experiences',
                        'name'=>'Mosama_Experiences',
                        'placeholder'=>trans('EMPLANG::Mosama_Experiences.singular'),
                        'minimum_input_length'=>0,
                        'data_source'=>$routes['fetchMosama_Experiences']['as'],
                        'entity'=>'Mosama_Experiences',
                        'attribute'=>['type','time'],
                        'array_view'=>[
                            'divider'=>':::',
                            'enum'=>[
                                'type'=>[1=>'خبرة فى مجال العمل',0=>'مدة بينية']
                            ],
                            'translate'=>'يتطلب ? لمدة ( ? ) سنة',
                        ],
                        'pivot'=>true,
                        'entity_primary' => 'Mosama_Groups',
                    ],
                ]
                ]); 
    }
    protected function setupCreateOperation()
    {
        
        AMER::setValidation(Mosama_DegreesRequest::class);
        $this->fields();
        
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Mosama_DegreesRequest::class);
        $this->fields();
    }
    public function store(Mosama_DegreesRequest $request)
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
    public function fetchMosama_Experiences()
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
        if(!is_array($Mosama_Groups)){
            $Mosama_Groups=[$Mosama_Groups];
        }
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Mosama_Experiences::class,
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