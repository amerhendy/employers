<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Regulations\Regulations_Articles as Regulations_Articles;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\Regulations_ArticlesRequest as Regulations_ArticlesRequest;
class Regulations_ArticlesAmerController extends AmerController
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
        AMER::setModel(Regulations_Articles::class);
        AMER::setRoute(config('Amer.employers.route_prefix') . '/Regulations_Articles');
        AMER::setEntityNameStrings(trans('EMPLANG::Regulations_Articles.singular'), trans('EMPLANG::Regulations_Articles.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Regulations_Articles.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Regulations_Articles.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Regulations_Articles.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Regulations_Articles.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Regulations_Articles.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Regulations_Articles.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Regulations_Articles-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Regulations_Articles-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Regulations_Articles-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Regulations_Articles-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Regulations_Articles-show') == 0){$this->Amer->denyAccess('show');}
        */
    }

    protected function setupListOperation(){
        AMER::addColumns([
            [
                'name'=>'number',
                'type'=>'text',
                'label'=>trans('EMPLANG::Regulations_Articles.number'),
            ],[
                'name'=>'Regulation_id',
                'type'=>'select',
                'label'=>trans('EMPLANG::Regulations.singular'),
                'model'=>'Amerhendy\Employers\App\Models\Regulations\Regulations',
                'entity'=>'Regulations'
            ],[
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Regulations_Articles.singular'),
            ],
            [
                'name'=>'mp3',
                'type'=>'mp3',
                'label'=>trans('EMPLANG::Regulations_Articles.mp3'),
            ],
            [
                'name'=>'Regulations_Topics',
                'type'=>'select_multiple',
                'label'=>trans('EMPLANG::Regulations_Topics.singular'),
                'model'=>'Amerhendy\Employers\App\Models\Regulations\Regulations_Topics',
                'entity'=>'Regulations_Topics'
            ]
        ]);
        
    }
    function groupfields(){
        AMER::addFields([
            [
                'name'=>'number',
                'type'=>'number',
                'label'=>trans('EMPLANG::Regulations_Articles.number'),
            ],
            [
                'name'=>'text',
                'type'=>'wysiwyg',
                'label'=>trans('EMPLANG::Regulations_Articles.singular'),
            ]
        ]);
        $routes=$this->Amer->routelist;
        AMER::addFields([
            [
                'type'=>'select2',
                'model'=>'Amerhendy\Employers\App\Models\Regulations\Regulations',
                'name'=>'Regulation_id',
                'placeholder'=>trans('EMPLANG::Regulations.singular'),
                'minimum_input_length'=>0,
                'entity'=>'Regulations',
                'attribute'=>'text',
                'pivot'=>true,
            ]
            ,[
                'type'=>'select2_from_ajax',
                'model'=>'Amerhendy\Employers\App\Models\Regulations\Regulations_Topics',
                'name'=>'Regulations_Topics',
                'placeholder'=>trans('EMPLANG::Regulations_Topics.singular'),
                'label'=>trans('EMPLANG::Regulations_Topics.singular'),
                'minimum_input_length'=>0,
                'data_source'=>$routes['fetchRegulations_Topics']['as'],
                'entity'=>'Regulations_Topics',
                'attribute'=>'text',
                'select_all'=>true,
            ],
        ]);
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Regulations_ArticlesRequest::class);
        $this->groupfields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Regulations_ArticlesRequest::class);
        $this->groupfields();
    }
    public function store(Regulations_ArticlesRequest $request)
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
    public function fetchRegulations_Topics(){
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
}