<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\OrgStru\OrgStru_Mahatas as OrgStru_Mahatas;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\OrgStru_MahatasRequest as OrgStru_MahatasRequest;
class OrgStru_MahatasAmerController extends AmerController
{
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\ListOperation;
    //use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\CreateOperation  {store as traitStore;}
    use \Amerhendy\Amer\App\Http\Controllers\Base\Operations\CreateOperation;
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
        AMER::setModel(OrgStru_Mahatas::class);
        AMER::setRoute(config('Amer.Amer.route_prefix') . '/OrgStru_Mahatas');
        AMER::setEntityNameStrings(trans('EMPLANG::OrgStru_Mahatas.singular'), trans('EMPLANG::OrgStru_Mahatas.plural'));
        $this->Amer->setTitle(trans('EMPLANG::OrgStru_Mahatas.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::OrgStru_Mahatas.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::OrgStru_Mahatas.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::OrgStru_Mahatas.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::OrgStru_Mahatas.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::OrgStru_Mahatas.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('OrgStru_Mahatas-create') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('OrgStru_Mahatas-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('OrgStru_Mahatas-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('OrgStru_Mahatas-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('OrgStru_Mahatas-show') == 0){$this->Amer->denyAccess('show');}
    }

    protected function setupListOperation(){
        AMER::addColumns([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::OrgStru_Mahatas.singular'),
            ],
            [
                'name'=>'Types_id',
                'type'=>'select',
                'model'=>'\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Types',
                'entity'=>'OrgStru_Types',
                'label'=>trans('EMPLANG::OrgStru_Types.singular'),
            ],
            [
                'name'=>'Section_id',
                'type'=>'select',
                'model'=>'\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Sections',
                'entity'=>'OrgStru_Sections',
                'label'=>trans('EMPLANG::OrgStru_Sections.singular'),
            ],
            [
                'name'=>'Area_id',
                'type'=>'select',
                'model'=>'\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Areas',
                'entity'=>'OrgStru_Areas',
                'label'=>trans('EMPLANG::OrgStru_Areas.singular'),
            ],
        ]);

    }
    function groupfields(){
        AMER::addFields([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::OrgStru_Mahatas.singular'),
            ]
        ]);
        $routes=$this->Amer->routelist;
        AMER::addField([
            'label'             => '',
            'field_unique_name' => 'jobnames',
            'name'=>['Section_id','Area_id','Types_id'],
            'type'=>'Employers::Org.Mahatas',
            'subfields'=>[
                'Section_id'=>[
                    'type'=>'select2_from_ajax',
                    'model'=>'Amerhendy\Employers\App\Models\OrgStru\OrgStru_Sections',
                    'name'=>'Section_id',
                    'placeholder'=>trans('EMPLANG::OrgStru_Sections.singular'),
                    'minimum_input_length'=>0,
                    'data_source'=>$routes['fetchOrgStru_Sections']['as'],
                    'entity'=>'OrgStru_Sections',
                    'attribute'=>'text',
                    'pivot'=>true,
                ],
                'Area_id'=>[
                    'type'=>'select2_from_ajax',
                    'model'=>'Amerhendy\Employers\App\Models\OrgStru\OrgStru_Areas',
                    'name'=>'Area_id',
                    'placeholder'=>trans('EMPLANG::OrgStru_Areas.singular'),
                    'minimum_input_length'=>0,
                    'data_source'=>$routes['fetchOrgStru_Areas']['as'],
                    'entity'=>'OrgStru_Areas',
                    'attribute'=>'text',
                    'pivot'=>true,
                ],
                'Types_id'=>[
                    'type'=>'select2_from_ajax',
                    'model'=>'Amerhendy\Employers\App\Models\OrgStru\OrgStru_Types',
                    'name'=>'Types_id',
                    'placeholder'=>trans('EMPLANG::OrgStru_Types.singular'),
                    'minimum_input_length'=>0,
                    'data_source'=>$routes['fetchOrgStru_Types']['as'],
                    'entity'=>'OrgStru_Types',
                    'attribute'=>'text',
                    'pivot'=>true,
                ],
            ]
            ]);
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(OrgStru_MahatasRequest::class);
        $this->groupfields();
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(OrgStru_MahatasRequest::class);
        $this->groupfields();
    }
    public function destroy($id)
    {
        $this->Amer->hasAccessOrFail('delete');
        $data=$this->Amer->model::remove_force($id);
        return $data;
    }
    public function fetchOrgStru_Sections()
    {
        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Sections::class,'searchable_attributes'=>'text']);
    }
    public function fetchOrgStru_Areas()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Section_id'])){
                $Section_id=$parents['Section_id'];
            }
        }else{
            $Section_id=null;
        }
        if(is_numeric($Section_id)){$Section_id=[$Section_id];}
        $model=\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Areas::class;
        //dd($model::get()->toArray(),$model::whereHas('OrgStru_Sections')->get()->toArray());
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Areas::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Section_id) {
                return $model->whereHas('OrgStru_Sections',function($query)use($Section_id){
                    return $query->whereIn('OrgStru_Sections.id',$Section_id);
                });
            }
        ]);
    }
    public function fetchOrgStru_Types()
    {
        $op=$_GET;
        if(isset($op['parents'])){
            $parents=$op['parents'];
            if(isset($parents['Area_id'])){
                $Area_id=$parents['Area_id'];
            }
        }else{
            $Area_id=null;
        }
        if(is_numeric($Area_id)){$Area_id=[$Area_id];}
        return $this->fetch([
            'model' =>\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Types::class,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($Area_id) {
                return $model->whereHas('OrgStru_Areas',function($query)use($Area_id){
                    return $query->whereIn('OrgStru_Areas.id',$Area_id);
                });
            }
        ]);

        return $this->fetch(['model'=>\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Types::class,'searchable_attributes'=>'text']);
    }
}
