<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\OrgStru\OrgStru_Sections as OrgStru_Sections;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\OrgStru_SectionsRequest as OrgStru_SectionsRequest;
class OrgStru_SectionsAmerController extends AmerController
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
        AMER::setModel(OrgStru_Sections::class);
        AMER::setRoute(config('amer.route_prefix') . '/OrgStru_Sections');
        AMER::setEntityNameStrings(trans('EMPLANG::OrgStru_Sections.singular'), trans('EMPLANG::OrgStru_Sections.plural'));
        /*
        $this->Amer->setTitle(trans('EMPLANG::OrgStru_Sections.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::OrgStru_Sections.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::OrgStru_Sections.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::OrgStru_Sections.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::OrgStru_Sections.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::OrgStru_Sections.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('OrgStru_Sections-add') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('OrgStru_Sections-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('OrgStru_Sections-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('OrgStru_Sections-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('OrgStru_Sections-show') == 0){$this->Amer->denyAccess('show');}
        */
    }

    protected function setupListOperation(){
        AMER::addColumns([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::OrgStru_Sections.singular'),
            ],
            [
                'label'=>trans('EMPLANG::OrgStru_Areas.singular'),
                'name'=>'OrgStru_Areas',
                'type'=>'select_multiple',
                'entity'=>'OrgStru_Areas',
                'attribute'=>'text',
                'model'=>'Amerhendy\Employers\App\Models\OrgStru\OrgStru_Areas'
            ],
        ]);
        
    }
    function groupfields(){
        AMER::addFields([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::OrgStru_Sections.singular'),
            ],[
                'type'=>'select2_multiple',
                'model'=>'Amerhendy\Employers\App\Models\OrgStru\OrgStru_Areas',
                'name'=>'OrgStru_Areas',
                'attribute'=>'text',
                'label'=>trans('EMPLANG::OrgStru_Areas.singular'),
                'entity'=>'OrgStru_Areas',
            ],
        ]);
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(OrgStru_SectionsRequest::class);
        $this->groupfields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(OrgStru_SectionsRequest::class);
        $this->groupfields();
    }
    public function store(OrgStru_SectionsRequest $request)
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
    
}