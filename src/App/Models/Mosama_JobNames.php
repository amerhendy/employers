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
class Mosama_JobNames extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,Sluggable, SluggableScopeHelpers;
    protected $table ="Mosama_JobNames";
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
        return $this->belongsToMany(Mosama_Competencies::class,"Mosama_JobName_Competencies",'JobName_id','Competence_id')->withTrashed();
    }
    function Mosama_JobName_Competencies(){
        return $this->belongsToMany(Mosama_Competencies::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"Mosama_JobName_Connections",'JobName_id','Connection_id')->withTrashed();
    }
    function Mosama_JobName_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"Mosama_JobName_Educations",'JobName_id','Education_id')->withTrashed();
    }
    function Mosama_JobName_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_Experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"Mosama_JobName_Experiences",'JobName_id','Experience_id')->withTrashed();
    }
    function Mosama_JobName_Experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"Mosama_JobName_Goals",'JobName_id','Goal_id')->withTrashed();
    }
    function Mosama_JobName_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"Mosama_JobName_Managers",'JobName_id','Manager_id')->withTrashed();
    }
    function Mosama_JobName_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_OrgStruses(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"Mosama_JobName_OrgStru",'JobName_id','OrgStru_id')->withTrashed();
    }
    function Mosama_JobName_OrgStru(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_Skills(){
        return $this->belongsToMany(Mosama_Skills::class,"Mosama_JobName_Skills",'JobName_id','Skill_id')->withTrashed();
    }
    function Mosama_JobName_Skills(){
        return $this->belongsToMany(Mosama_Skills::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"Mosama_JobName_Tasks",'JobName_id','Task_id')->withTrashed();
    }
    function Mosama_JobName_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"Mosama_JobNames",'id','id');
    }
    function Mosama_Groups(){
        return $this->hasOne(Mosama_Groups::class,'id','Group_id');
    }
    function Mosama_JobTitles(){
        return $this->hasOne(Mosama_JobTitles::class,'id','JobTitle_id');
    }
    
    function Mosama_Degrees(){
        return $this->hasOne(Mosama_Degrees::class,'id','Degree_id');
    }
}
