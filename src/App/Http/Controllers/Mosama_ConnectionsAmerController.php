<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use Amerhendy\Employers\App\Models\Mosama_Connections as Mosama_Connections;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use \Amerhendy\Employers\App\Http\Requests\Mosama_ConnectionsRequest as Mosama_ConnectionsRequest;

class Mosama_ConnectionsAmerController extends AmerController
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
        AMER::setModel(Mosama_Connections::class);
        AMER::setRoute(config('Amer.employers.route_prefix') . '/Mosama_Connections');
        AMER::setEntityNameStrings(trans('EMPLANG::Mosama_Connections.singular'), trans('EMPLANG::Mosama_Connections.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Connections.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Connections.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Connections.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Connections.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Connections.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Connections.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Mosama_Connections-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Mosama_Connections-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Mosama_Connections-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Mosama_Connections-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Mosama_Connections-show') == 0){$this->Amer->denyAccess('show');}
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
                'label'=>trans('EMPLANG::Mosama_Connections.singular'),
            ],
            [
                'name'=>'type',
                'type'=>'enum',
                'label'=>trans('EMPLANG::Mosama_Connections.type'),
                'options' => [
                    'in' => trans('EMPLANG::Mosama_Connections.in'),
                    'out' => trans('EMPLANG::Mosama_Connections.out'),
                ]
            ]
            ,[
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
                'name'=>'Mosama_Groups',
                'type'=>'select_multiple',
                'entity'=>'Mosama_Groups',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\ModelsMosama_Groups'
            ],[
                'label'=>trans('EMPLANG::Mosama_JobTitles.singular'),
                'name'=>'Mosama_JobTitles',
                'type'=>'select_multiple',
                'entity'=>'Mosama_JobTitles',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\ModelsMosama_JobTitles'
            ],[
                'label'=>trans('EMPLANG::Mosama_JobNames.singular'),
                'name'=>'Mosama_JobNames',
                'type'=>'select_multiple',
                'entity'=>'Mosama_JobNames',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\ModelsMosama_JobNames'
            ],
        ]);
    }
    function fields(){
        $routes=$this->Amer->routelist;
    AMER::addFields([
        [
            'name'=>'text',
            'type'=>'text',
            'label'=>trans('EMPLANG::Mosama_Goals.singular'),
        ],[
            'name'=>'type',
            'type'=>'enum',
            'label'=>trans('EMPLANG::Mosama_Connections.type'),
            'options' => [
                'in' => trans('EMPLANG::Mosama_Connections.in'),
                'out' => trans('EMPLANG::Mosama_Connections.out'),
            ]
            ],
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
                    'model'=>'Amerhendy\Employers\App\Models\Mosama_JobTitles',
                    'name'=>'Mosama_JobTitles',
                    'placeholder'=>trans('EMPLANG::Mosama_JobTitles.singular'),
                    'label'=>trans('EMPLANG::Mosama_JobTitles.singular'),
                    'minimum_input_length'=>0,
                    'data_source'=>$routes['fetchMosama_JobTitles']['as'],
                    'entity'=>'Mosama_JobTitles',
                    'attribute'=>'text',
                    'select_all'=>true,
                    'include_all_form_fields' => true,
                    'dependencies'            => ['Mosama_Groups'],
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
                ],
            ]); 
}
    protected function setupCreateOperation()
    {
        AMER::setValidation(Mosama_ConnectionsRequest::class);
        $this->fields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Mosama_ConnectionsRequest::class);
        $this->fields();
    }
    public function store(Mosama_ConnectionsRequest $request)
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
    public function fetchMosama_JobNames()
    {
        
        $model=\Amerhendy\Employers\App\Models\Mosama_JobNames::class;
        $text='Mosama_JobTitles';
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