<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\OrgStru\OrgStru_Areas as OrgStru_Areas;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\OrgStru_AreasRequest as OrgStru_AreasRequest;
class OrgStru_AreasAmerController extends AmerController
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

        AMER::setModel(OrgStru_Areas::class);
        AMER::setRoute(config('Amer.Amer.route_prefix') . '/OrgStru_Areas');
        AMER::setEntityNameStrings(trans('EMPLANG::OrgStru_Areas.singular'), trans('EMPLANG::OrgStru_Areas.plural'));
        $this->Amer->setTitle(trans('EMPLANG::OrgStru_Areas.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::OrgStru_Areas.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::OrgStru_Areas.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::OrgStru_Areas.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::OrgStru_Areas.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::OrgStru_Areas.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('OrgStru_Areas-Create') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('OrgStru_Areas-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('OrgStru_Areas-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('OrgStru_Areas-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('OrgStru_Areas-show') == 0){$this->Amer->denyAccess('show');}
    }

    protected function setupListOperation(){
        AMER::addColumns([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::OrgStru_Areas.singular'),
            ],
            [
                'name'=>'Section_id',
                'type'=>'select',
                'model'=>'\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Sections',
                'entity'=>'OrgStru_Sections',
                'label'=>trans('EMPLANG::OrgStru_Sections.singular'),
            ],
            [
                'name'=>'OrgStru_Types',
                'type'=>'select_multiple',
                'model'=>'\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Types',
                'entity'=>'OrgStru_Types',
                'label'=>trans('EMPLANG::OrgStru_Types.singular'),
            ],
        ]);

    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    function groupfields(){
        AMER::addFields([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::OrgStru_Areas.singular'),
            ],[
                'name'=>'Section_id',
                'type'=>'select2',
                'model'=>'\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Sections',
                'entity'=>'OrgStru_Sections',
                'label'=>trans('EMPLANG::OrgStru_Sections.singular'),
            ],
            [
                'name'=>'OrgStru_Types',
                'type'=>'select2',
                'model'=>'\Amerhendy\Employers\App\Models\OrgStru\OrgStru_Types',
                'entity'=>'OrgStru_Types',
                'label'=>trans('EMPLANG::OrgStru_Types.singular'),
            ],
        ]);
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(OrgStru_AreasRequest::class);
        $this->groupfields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(OrgStru_AreasRequest::class);
        $this->groupfields();
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
