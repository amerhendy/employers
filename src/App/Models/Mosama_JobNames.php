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

use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Mosama_JobNames extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="mosama_jobnames";
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [];
    protected $dates = ['deleted_at'];
    public static $list=[];
    public static $fileds=[];
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
        return $this->belongsToMany(Mosama_Competencies::class,"mosama_jobnames_competencies",'jobname_id','competence_id')->withTrashed();
    }
    function mosama_jobnames_competencies(){
        return $this->belongsToMany(Mosama_Competencies::class,"mosama_jobnames",'id','id');
    }
    function Mosama_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"mosama_jobnames_connections",'jobname_id','connection_id')->withTrashed();
    }
    function mosama_jobnames_connections(){
        return $this->belongsToMany(Mosama_Connections::class,"mosama_jobnames",'id','id');
    }
    function Mosama_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"mosama_jobnames_educations",'jobname_id','education_id')->withTrashed();
    }
    function mosama_jobnames_educations(){
        return $this->belongsToMany(Mosama_Educations::class,"mosama_jobnames",'id','id');
    }
    function Mosama_Experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"mosama_jobnames_experiences",'jobname_id','experience_id')->withTrashed();
    }
    function mosama_jobnames_experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"mosama_jobnames",'id','id');
    }
    function Mosama_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"mosama_jobnames_goals",'jobname_id','goal_id')->withTrashed();
    }
    function mosama_jobnames_goals(){
        return $this->belongsToMany(Mosama_Goals::class,"mosama_jobnames",'id','id');
    }
    function Mosama_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"mosama_jobnames_managers",'jobname_id','manager_id')->withTrashed();
    }
    function mosama_jobnames_managers(){
        return $this->belongsToMany(Mosama_Managers::class,"mosama_jobnames",'id','id');
    }
    function Mosama_OrgStruses(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"mosama_jobnames_orgstrus",'jobname_id','orgstru_id')->withTrashed();
    }
    function mosama_jobnames_orgstrus(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"mosama_jobnames",'id','id');
    }
    function Mosama_Skills(){
        return $this->belongsToMany(Mosama_Skills::class,"mosama_jobnames_skills",'jobname_id','skill_id')->withTrashed();
    }
    function mosama_jobnames_skills(){
        return $this->belongsToMany(Mosama_Skills::class,"mosama_jobnames",'id','id');
    }
    function Mosama_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"mosama_jobnames_tasks",'jobname_id','task_id')->withTrashed();
    }
    function mosama_jobnames_tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"mosama_jobnames",'id','id');
    }
    function Mosama_Groups(){
        return $this->hasOne(Mosama_Groups::class,'id','group_id');
    }
    function Mosama_JobTitles(){
        return $this->hasOne(Mosama_JobTitles::class,'id','jobtitle_id');
    }
    function Mosama_Degrees(){
        return $this->hasOne(Mosama_Degrees::class,'id','degree_id');
    }
}
