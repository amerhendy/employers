<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Mosama_Goals as Mosama_Goals;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use \App\Http\Requests\Admin\Mosama_GoalsRequest as Mosama_GoalsRequest;

class Mosama_GoalsAmerController extends AmerController
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
        AMER::setModel(Mosama_Goals::class);
        AMER::setRoute(config('Amer.Employers.route_prefix') . '/Mosama_Goals');
        AMER::setEntityNameStrings(trans('EMPLANG::Mosama_Goals.singular'), trans('EMPLANG::Mosama_Goals.plural'));
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Goals.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Goals.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Goals.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Mosama_Goals.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Mosama_Goals.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Mosama_Goals.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        $this->setPermisssions('Mosama_Goals');
    }
    public function setPermisssions($n){
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        $this->Amer->enableBulkActions();
        $accesslist=['update','list', 'show','trash','reorder','delete','create','clone','BulkDelete'];
        foreach ($accesslist as $l) {
            if(amer_user()->canper($n.'-'.$l) === false){$this->Amer->denyAccess($l);}
        }
    }

    protected function setupListOperation(){
        //AMER::setFromDb();
        AMER::addColumns([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Mosama_Goals.singular'),
            ]
            ,[
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
                'name'=>'Mosama_Groups',
                'type'=>'select_multiple',
                'entity'=>'Mosama_Groups',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Groups'
            ],[
                'label'=>trans('EMPLANG::Mosama_JobTitles.singular'),
                'name'=>'Mosama_JobTitles',
                'type'=>'select_multiple',
                'entity'=>'Mosama_JobTitles',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_JobTitles'
            ],[
                'label'=>trans('EMPLANG::Mosama_JobNames.singular'),
                'name'=>'Mosama_JobNames',
                'type'=>'select_multiple',
                'entity'=>'Mosama_JobNames',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_JobNames'
            ],
        ]);
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    function fields(){
        $routes=$this->Amer->routelist;
        //dd($routes);
        AMER::addField([
            'name'=>'text',
            'type'=>'text',
            'label'=>trans('EMPLANG::Mosama_Goals.singular'),
        ]);
        AMER::addFields([
            [
                'type'                  =>'select2_from_ajax',
                'name'                  =>'Mosama_Groups',
                'placeholder'           =>trans('EMPLANG::Mosama_Groups.singular'),
                'label'                 =>trans('EMPLANG::Mosama_Groups.singular'),
                'entity'                =>'Mosama_Groups',
                'model'                 =>'Amerhendy\Employers\App\Models\Mosama_Groups',
                'data_source'           =>$routes['fetchMosama_Groups']['as'],
                //'dependencies'=>false,
                'minimum_input_length'  =>0,
                'attribute'             =>'text',
                'select_all'            =>true,
            ],
            [
                'type'                  =>'select2_from_ajax',
                'name'                  =>'Mosama_JobTitles',
                'placeholder'           =>trans('EMPLANG::Mosama_JobTitles.singular'),
                'label'                 =>trans('EMPLANG::Mosama_JobTitles.singular'),
                'entity'                =>'Mosama_JobTitles',
                'model'                 =>'Amerhendy\Employers\App\Models\Mosama_JobTitles',
                'data_source'           =>$routes['fetchMosama_JobTitles']['as'],
                'dependencies'          => ['Mosama_Groups'],
                'minimum_input_length'  =>0,
                'attribute'             =>'text',
                'select_all'            =>true,
            ],
            [
                'type'                  =>'select2_from_ajax',
                'name'                  =>'Mosama_JobNames',
                'placeholder'           =>trans('EMPLANG::Mosama_JobNames.singular'),
                'label'                 =>trans('EMPLANG::Mosama_JobNames.singular'),
                'entity'                =>'Mosama_JobNames',
                'model'                 =>'Amerhendy\Employers\App\Models\Mosama_JobNames',
                'data_source'           =>$routes['fetchMosama_JobNames']['as'],
                'dependencies'          => ['Mosama_JobTitles'],
                'minimum_input_length'  =>0,
                'attribute'             =>'text',
                'select_all'            =>true,
            ],
        ]);
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Mosama_GoalsRequest::class);
        $this->fields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Mosama_GoalsRequest::class);
        $this->fields();
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
        $result=\AmerHelper::retunFetchValue($text);
        if($result === null){return json_encode([]);}
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas('Mosama_Groups',function($q)use($result,$text){
                    return $q->whereIn(\Str::lower($text).'.id',$result[$text]);
                });
            }
        ]);

    }
    public function fetchMosama_JobNames()
    {

        $model=\Amerhendy\Employers\App\Models\Mosama_JobNames::class;
        $text='Mosama_JobTitles';
        $result=\AmerHelper::retunFetchValue($text);
        if($result === null){return json_encode([]);}
        return $this->fetch([
            'model' =>$model,
            'searchable_attributes' => 'text',
            'paginate' => 10,
            'query' => function($model)use($result,$text) {
                return $model->whereHas($text,function($q)use($result,$text){
                    return $q->whereIn(\Str::lower($text).'.id',$result[$text]);
                });
            }
        ]);
    }
}
