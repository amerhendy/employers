<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Regulations\Regulations_Topics as Regulations_Topics;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\Regulations_TopicsRequest as Regulations_TopicsRequest;
class Regulations_TopicsAmerController extends AmerController
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
        AMER::setModel(Regulations_Topics::class);
        AMER::setRoute(config('amer.route_prefix') . '/Regulations_Topics');
        AMER::setEntityNameStrings(trans('EMPLANG::Regulations_Topics.singular'), trans('EMPLANG::Regulations_Topics.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Regulations_Topics.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Regulations_Topics.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Regulations_Topics.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Regulations_Topics.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Regulations_Topics.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Regulations_Topics.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Regulations_Topics-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Regulations_Topics-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Regulations_Topics-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Regulations_Topics-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Regulations_Topics-show') == 0){$this->Amer->denyAccess('show');}
        */
    }
    public function cols(){
        AMER::addColumns([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Regulations_Topics.singular'),
            ],[
                'name'=>'Regulations',
                'type'=>'select',
                'model'=>'\Amerhendy\Employers\App\Models\Regulations\Regulations',
                'entity'=>'Regulations',
                'label'=>trans('EMPLANG::Regulations.singular'),
            ],[
                'name'=>'father',
                'type'=>'select',
                'model'=>'\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics',
                'entity'=>'parent',
                'label'=>trans('EMPLANG::Regulations_Topics.father'),
            ],[
                'name'=>'children',
                'type'=>'select_multiple',
                'model'=>'\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics',
                'entity'=>'children',
                'label'=>trans('EMPLANG::Regulations_Topics.son'),
            ],[
                'name'=>'Regulations_Articles',
                'type'=>'select_multiple',
                'model'=>'\Amerhendy\Employers\App\Models\Regulations\Regulations_Articles',
                'entity'=>'Regulations_Articles',
                'label'=>trans('EMPLANG::Regulations_Articles.Regulations_Articles'),
                'attribute'=>'text',
            ],
        ]);
    }
    
    function groupfields(){
        AMER::addFields([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Regulations_Topics.singular'),
            ]
        ]);
        $routes=$this->Amer->routelist;
        AMER::addFields([
            [
                    'type'=>'select2_multiple',
                    'model'=>'Amerhendy\Employers\App\Models\Regulations\Regulations',
                    'name'=>'Regulations',
                    'placeholder'=>trans('EMPLANG::Regulations.singular'),
                    'minimum_input_length'=>0,
                    'data_source'=>$routes['fetchRegulations']['as'],
                    'entity'=>'Regulations',
                    'attribute'=>'text',
                    'pivot'=>true,
                ],
                [
                    'type'=>'select2_from_ajax',
                    'model'=>'Amerhendy\Employers\App\Models\Regulations\Regulations_Topics',
                    'name'=>'father',
                    'placeholder'=>trans('EMPLANG::Regulations_Topics.father'),
                    'label'=>trans('EMPLANG::Regulations_Topics.father'),
                    'minimum_input_length'=>0,
                    'data_source'=>$routes['fetchfather']['as'],
                    'entity'=>'parent',
                    'attribute'=>'text',
                    'pivot'=>true,
                ]
            ]);
    }
    protected function setupListOperation(){
        if (! $this->Amer->getRequest()->has('order')){
            $this->Amer->orderBy('father');
        }
        
        $this->cols();
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Regulations_TopicsRequest::class);
        $this->groupfields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Regulations_TopicsRequest::class);
        $this->groupfields();
    }
    public function store(Regulations_TopicsRequest $request)
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
    public function fetchRegulations()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Regulations\Regulations::class,'searchable_attributes'=>'text']);
    }
    public function fetchfather()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Regulations'])){
                $Regulations=$parents['Regulations'];
            }
        }else{
            $Regulations=null;
        }
        if(!is_array($Regulations)){$Regulations=[$Regulations];}
        //$model=\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics::class;
        //dd($model::get()->toArray(),$model::whereHas('Regulation')->get()->toArray());
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Regulations) {
                return $model->whereHas('Regulation',function($q)use($Regulations){
                    return $q->whereIn('Regulations.id',$Regulations);
                });
            } 
        ]);
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics::class,'searchable_attributes'=>'text']);
    }
    public function fetchchildren()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics::class,'searchable_attributes'=>'text']);
    }
}