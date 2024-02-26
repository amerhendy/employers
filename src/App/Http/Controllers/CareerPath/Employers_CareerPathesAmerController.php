<?php
namespace Amerhendy\Employers\App\Http\Controllers\CareerPath;
use \Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathes as Employers_CareerPathes;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use \Amerhendy\Employers\App\Http\Requests\CareerPath\Employers_CareerPathesRequest as Employers_CareerPathesRequest;

class Employers_CareerPathesAmerController extends AmerController
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
        /*
        for($i=1001;$i<2002;$i++){
            \DB::table('Mosama_Groups_CareerPath')->insert([
                'Group_id' => rand(1,8),
                'CareerPath_id' => $i
            ]);
        }*/
        AMER::setModel(Employers_CareerPathes::class);
        AMER::setRoute(config('Amer.employers.route_prefix') . '/Employers_CareerPathes');
        AMER::setEntityNameStrings(trans('EMPLANG::Employers_CareerPathes.singular'), trans('EMPLANG::Employers_CareerPathes.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::Employers_CareerPathes.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Employers_CareerPathes.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Employers_CareerPathes.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Employers_CareerPathes.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Employers_CareerPathes.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Employers_CareerPathes.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Employers_CareerPathes-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Employers_CareerPathes-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Employers_CareerPathes-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Employers_CareerPathes-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Employers_CareerPathes-show') == 0){$this->Amer->denyAccess('show');}
        */
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupListOperation(){
        AMER::addColumns([
            [
                'name'=>'Text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers_CareerPathes.singular'),
            ],
            [
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
                'name'=>'Mosama_Groups',
                'type'=>'select_multiple',
                'entity'=>'Mosama_Groups',
                'attribute'=>'text',
                'model'=>'\Amerhendy\Employers\App\Models\Mosama_Groups'
            ]
        ]);
    }
    function fields(){
            $routes=$this->Amer->routelist;
        AMER::addFields([
            [
                'name'=>'Text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers_CareerPathes.Text'),
            ],[
                'type'=>'select2_multiple',
                'model'=>'Amerhendy\Employers\App\Models\Mosama_Groups',
                'name'=>'Mosama_Groups',
                'placeholder'=>trans('EMPLANG::Mosama_Groups.singular'),
                'label'=>trans('EMPLANG::Mosama_Groups.singular'),
                'minimum_input_length'=>0,
                'entity'=>'Mosama_Groups',
                'attribute'=>'text',
                'pivot'=>true,
                'select_all'=>true,
            ]
                ]); 
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Employers_CareerPathesRequest::class);
        $this->fields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Employers_CareerPathesRequest::class);
        $this->fields();
    }
    public function store(Employers_CareerPathesRequest $request)
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
}