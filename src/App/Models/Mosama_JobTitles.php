<?php
namespace Amerhendy\Employers\App\Models;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Amerhendy\Amer\App\Models\Traits\AmerTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
class Mosama_JobTitles extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,Sluggable, SluggableScopeHelpers;
    protected $table ="Mosama_JobTitles";
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [];
    protected $dates = ['deleted_at'];
    public static $list=[];
    public static $fileds=[];
public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => [],
            ],
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function remove_force($id){
        $data=self::withTrashed()->find($id);
            if(!$data){return 0;}
        return $data::forceDelete();
        return 1;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    function Mosama_Competencies(){
        return $this->belongsToMany(Mosama_Competencies::class,"Mosama_JobTitles_Competencies",'JobTitle_id','Competence_id')->withTrashed();
    }
    function Mosama_JobTitles_Competencies(){
        return $this->belongsToMany(Mosama_Competencies::class,"Mosama_JobTitles",'id','id');
    }
    function Mosama_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"Mosama_JobTitles_Connections",'JobTitle_id','Connection_id')->withTrashed();
    }
    function Mosama_JobTitles_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"Mosama_JobTitles",'id','id');
    }
    function Mosama_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"Mosama_JobTitles_Educations",'JobTitle_id','Education_id')->withTrashed();
    }
    function Mosama_JobTitles_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"Mosama_JobTitles",'id','id');
    }
    function Mosama_Groups(){
        return $this->belongsToMany(Mosama_Groups::class,"Mosama_Groups_JobTitles",'JobTitle_id','Group_id')->withTrashed();
    }
    function Mosama_Groups_JobTitles(){
        return $this->belongsToMany(Mosama_Groups::class,"Mosama_JobTitles",'id','id');
    }
    function Mosama_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"Mosama_JobTitles_Goals",'JobTitle_id','Goal_id')->withTrashed();
    }
    function Mosama_JobTitles_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"Mosama_JobTitles",'id','id');
    }
    function Mosama_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"Mosama_JobTitles_Managers",'JobTitle_id','Manager_id')->withTrashed();
    }
    function Mosama_JobTitles_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"Mosama_JobTitles",'id','id');
    }
    function Mosama_OrgStruses(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"Mosama_JobTitles_OrgStru",'JobTitle_id','OrgStru_id')->withTrashed();
    }
    function Mosama_JobTitles_OrgStru(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"Mosama_JobTitles",'id','id');
    }
    function Mosama_Skills(){
        return $this->belongsToMany(Mosama_Skills::class,"Mosama_JobTitles_Skill",'JobTitle_id','Skill_id')->withTrashed();
    }
    function Mosama_JobTitles_Skill(){
        return $this->belongsToMany(Mosama_Skills::class,"Mosama_JobTitles",'id','id');
    }
    function Mosama_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"Mosama_JobTitles_Tasks",'JobTitle_id','Task_id')->withTrashed();
    }
    function Mosama_JobTitles_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"Mosama_JobTitles",'id','id');
    }
}
