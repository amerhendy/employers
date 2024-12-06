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
class Mosama_JobTitles extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="mosama_jobtitles";
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
        return $this->belongsToMany(Mosama_Competencies::class,"mosama_jobtitles_competencies",'jobtitle_id','competence_id')->withTrashed();
    }
    function mosama_jobtitles_competencies(){
        return $this->belongsToMany(Mosama_Competencies::class,"mosama_jobtitles",'id','id');
    }
    function Mosama_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"mosama_jobtitles_connections",'jobtitle_id','connection_id')->withTrashed();
    }
    function mosama_jobtitles_connections(){
        return $this->belongsToMany(Mosama_Connections::class,"mosama_jobtitles",'id','id');
    }
    function Mosama_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"mosama_jobtitles_educations",'jobtitle_id','education_id')->withTrashed();
    }
    function mosama_jobtitles_educations(){
        return $this->belongsToMany(Mosama_Educations::class,"mosama_jobtitles",'id','id');
    }
    function Mosama_Groups(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_groups_jobtitles",'jobtitle_id','group_id')->withTrashed();
    }
    function mosama_groups_jobtitles(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_jobtitles",'id','id');
    }
    function Mosama_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"mosama_jobtitles_goals",'jobtitle_id','goal_id')->withTrashed();
    }
    function mosama_jobtitles_goals(){
        return $this->belongsToMany(Mosama_Goals::class,"mosama_jobtitles",'id','id');
    }
    function Mosama_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"mosama_jobtitles_managers",'jobtitle_id','manager_id')->withTrashed();
    }
    function mosama_jobtitles_managers(){
        return $this->belongsToMany(Mosama_Managers::class,"mosama_jobtitles",'id','id');
    }
    function Mosama_OrgStruses(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"mosama_jobtitles_orgstrus",'jobtitle_id','orgstru_id')->withTrashed();
    }
    function mosama_jobtitles_orgstrus(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"mosama_jobtitles",'id','id');
    }
    function Mosama_Skills(){
        return $this->belongsToMany(Mosama_Skills::class,"mosama_jobtitles_skills",'jobtitle_id','skill_id')->withTrashed();
    }
    function mosama_jobtitles_skills(){
        return $this->belongsToMany(Mosama_Skills::class,"mosama_jobtitles",'id','id');
    }
    function Mosama_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"mosama_jobtitles_tasks",'jobtitle_id','task_id')->withTrashed();
    }
    function mosama_jobtitles_tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"mosama_jobtitles",'id','id');
    }
}
