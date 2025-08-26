<?php
namespace Amerhendy\Employers\App\Http\Controllers;
use \Amerhendy\Employers\App\Models\Regulations\Regulations as Regulations;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use Amerhendy\Employers\App\Http\Requests\RegulationsRequest as RegulationsRequest;
class RegulationsAmerController extends AmerController
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
        AMER::setModel(Regulations::class);
        AMER::setRoute(config('Amer.Amer.route_prefix') . '/Regulations');
        AMER::setEntityNameStrings(trans('EMPLANG::Regulations.singular'), trans('EMPLANG::Regulations.plural'));
        $this->Amer->setTitle(trans('EMPLANG::Regulations.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Regulations.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Regulations.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Regulations.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Regulations.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Regulations.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Regulations-Create') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Regulations-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Regulations-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Regulations-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Regulations-show') == 0){$this->Amer->denyAccess('show');}
    }

    protected function setupListOperation(){
        AMER::addColumns([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Regulations.singular'),
            ],
        ]);

    }
    function groupfields(){
        AMER::addFields([
            [
                'name'=>'text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Regulations.singular'),
            ]
        ]);
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(RegulationsRequest::class);
        $this->groupfields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(RegulationsRequest::class);
        $this->groupfields();
    }
    public function destroy($id)
    {
        $this->Amer->hasAccessOrFail('delete');
        $data=$this->Amer->model::remove_force($id);
        return $data;
    }
    public function showRegulations(\Request $request){
        if(!isset($_POST['Regulationid'])){
            return view('errors/layout',['error_number'=>405]);
        }
        $po=Regulations::where('id',$_POST['Regulationid'])->get()->toArray();
        if(count($po)){
            return view('Employers::Regulations.main',['data'=>$po,'load'=>'home']);
        }
        return view('errors/layout',['error_number'=>405]);
    }

}
