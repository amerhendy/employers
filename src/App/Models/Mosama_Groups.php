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
class Mosama_Groups extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="mosama_groups";
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
        return $this->belongsToMany(Mosama_Competencies::class,"mosama_groups_competencies",'group_id','competence_id')->withTrashed();
    }
    function mosama_groups_competencies(){
        return $this->belongsToMany(Mosama_Competencies::class,"mosama_groups",'id','id');
    }
    function Mosama_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"mosama_groups_connections",'group_id','connection_id')->withTrashed();
    }
    function mosama_groups_connections(){
        return $this->belongsToMany(Mosama_Connections::class,"mosama_groups",'id','id');
    }
    function Mosama_Degrees(){
        return $this->belongsToMany(Mosama_Degrees::class,"mosama_groups_degrees",'group_id','degree_id')->withTrashed();
    }
    function mosama_groups_degrees(){
        return $this->belongsToMany(Mosama_Degrees::class,"mosama_groups",'id','id');
    }
    function Mosama_DirectManagers(){
        return $this->belongsToMany(Mosama_Managers::class,"mosama_groups_directmanagers",'group_id','manager_id')->withTrashed();
    }
    function mosama_groups_directmanagers(){
        return $this->belongsToMany(Mosama_Managers::class,"mosama_groups",'id','id');
    }
    function Mosama_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"mosama_groups_educations",'group_id','education_id')->withTrashed();
    }
    function mosama_groups_educations(){
        return $this->belongsToMany(Mosama_Educations::class,"mosama_groups",'id','id');
    }
    function Mosama_Experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"mosama_groups_experiences",'group_id','experience_id')->withTrashed();
    }
    function mosama_groups_experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"mosama_groups",'id','id');
    }
    function Mosama_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"mosama_groups_goals",'group_id','goal_id')->withTrashed();
    }
    function mosama_groups_goals(){
        return $this->belongsToMany(Mosama_Goals::class,"mosama_groups",'id','id');
    }
    function Mosama_JobTitles(){
        return $this->belongsToMany(Mosama_JobTitles::class,"mosama_groups_jobtitles",'group_id','jobtitle_id')->withTrashed();
    }
    function mosama_groups_jobtitles(){
        return $this->belongsToMany(Mosama_JobTitles::class,"mosama_groups",'id','id');
    }
    function Mosama_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"mosama_groups_managers",'group_id','manager_id')->withTrashed();
    }
    function mosama_groups_managers(){
        return $this->belongsToMany(Mosama_Managers::class,"mosama_groups",'id','id');
    }
    function Mosama_OrgStruses(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"mosama_groups_orgstrus",'group_id','orgstru_id')->withTrashed();
    }
    function mosama_groups_orgstrus(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"mosama_groups",'id','id');
    }
    function Mosama_Skills(){
        return $this->belongsToMany(Mosama_Skills::class,"mosama_groups_skills",'group_id','skill_id')->withTrashed();
    }
    function mosama_groups_skills(){
        return $this->belongsToMany(Mosama_Skills::class,"mosama_groups",'id','id');
    }
    function Mosama_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"mosama_groups_tasks",'group_id','task_id')->withTrashed();
    }
    function mosama_groups_tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"mosama_groups",'id','id');
    }
    function Employers(){
        return $this->hasOne(\Amerhendy\Employers\App\Models\Employers::class,'id','group_id')->withTrashed();
    }
}
