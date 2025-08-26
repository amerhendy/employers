<?php
namespace Amerhendy\Employers\App\Http\Controllers\CareerPath;
use \Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathFiles as Employers_CareerPathFiles;
use Illuminate\Support\Facades\DB;
use \Amerhendy\Amer\App\Http\Controllers\Base\AmerController;
use \Amerhendy\Amer\App\Helpers\Library\AmerPanel\AmerPanelFacade as AMER;
use \Amerhendy\Employers\App\Http\Requests\CareerPath\Employers_CareerPathFilesRequest as Employers_CareerPathFilesRequest;

class Employers_CareerPathFilesAmerController extends AmerController
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
        /*
        for($i=0;$i<1000;$i++){
            Employers_CareerPathFiles::create(['Text'=>trans('EMPLANG::Employers_CareerPathFiles.singular').' :: '.$i,'Link'=>'http://www.link.com/'.$i]);
        }*/
        AMER::setModel(Employers_CareerPathFiles::class);
        AMER::setRoute(config('Amer.Employers.route_prefix') . '/Employers_CareerPathFiles');
        AMER::setEntityNameStrings(trans('EMPLANG::Employers_CareerPathFiles.singular'), trans('EMPLANG::Employers_CareerPathFiles.plural'));
        $this->Amer->setTitle(trans('EMPLANG::Employers_CareerPathFiles.create'), 'create');
        $this->Amer->setHeading(trans('EMPLANG::Employers_CareerPathFiles.create'), 'create');
        $this->Amer->setSubheading(trans('EMPLANG::Employers_CareerPathFiles.create'), 'create');
        $this->Amer->setTitle(trans('EMPLANG::Employers_CareerPathFiles.edit'), 'edit');
        $this->Amer->setHeading(trans('EMPLANG::Employers_CareerPathFiles.edit'), 'edit');
        $this->Amer->setSubheading(trans('EMPLANG::Employers_CareerPathFiles.edit'), 'edit');
        $this->Amer->addClause('where', 'deleted_at', '=', null);
        $this->Amer->enableDetailsRow ();
        $this->Amer->allowAccess ('details_row');
        if(amer_user()->can('Employers_CareerPathFiles-create') == 0){$this->Amer->denyAccess('create');}
        if(amer_user()->can('Employers_CareerPathFiles-trash') == 0){$this->Amer->denyAccess ('trash');}
        if(amer_user()->can('Employers_CareerPathFiles-update') == 0){$this->Amer->denyAccess('update');}
        if(amer_user()->can('Employers_CareerPathFiles-delete') == 0){$this->Amer->denyAccess('delete');}
        if(amer_user()->can('Employers_CareerPathFiles-show') == 0){$this->Amer->denyAccess('show');}
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
                'label'=>trans('EMPLANG::Employers_CareerPathFiles.singular'),
            ],[
                'name'=>'Link',
                'type'=>'url',
                'label'=>trans('EMPLANG::Employers_CareerPathFiles.Link'),
            ],
        ]);
    }
    function fields(){
            $routes=$this->Amer->routelist;
        AMER::addFields([
            [
                'name'=>'Text',
                'type'=>'text',
                'label'=>trans('EMPLANG::Employers_CareerPathFiles.Text'),
            ],[
                'name'=>'Link',
                'type'=>'url',
                'label'=>trans('EMPLANG::Employers_CareerPathFiles.Link'),
            ],
                ]);
    }
    protected function setupCreateOperation()
    {
        AMER::setValidation(Employers_CareerPathFilesRequest::class);
        $this->fields();
    }
    protected function setupUpdateOperation()
    {
        AMER::setValidation(Employers_CareerPathFilesRequest::class);
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
