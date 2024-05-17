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
class Mosama_Groups extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,Sluggable, SluggableScopeHelpers;
    protected $table ="Mosama_Groups";
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
        return $this->belongsToMany(Mosama_Competencies::class,"Mosama_Groups_Competencies",'Group_id','Competence_id')->withTrashed();
    }
    function Mosama_Groups_Competencies(){
        return $this->belongsToMany(Mosama_Competencies::class,"Mosama_Groups",'id','id');
    }
    function Mosama_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"Mosama_Groups_Connections",'Group_id','Connection_id')->withTrashed();
    }
    function Mosama_Groups_Connections(){
        return $this->belongsToMany(Mosama_Connections::class,"Mosama_Groups",'id','id');
    }
    function Mosama_Degrees(){
        return $this->belongsToMany(Mosama_Degrees::class,"Mosama_Groups_Degrees",'Group_id','Degree_id')->withTrashed();
    }
    function Mosama_Groups_Degrees(){
        return $this->belongsToMany(Mosama_Degrees::class,"Mosama_Groups",'id','id');
    }
    function Mosama_DirectManagers(){
        return $this->belongsToMany(Mosama_Managers::class,"Mosama_Groups_Direct_Managers",'Group_id','Manager_id')->withTrashed();
    }
    function Mosama_Groups_Direct_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"Mosama_Groups",'id','id');
    }
    function Mosama_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"Mosama_Groups_Educations",'Group_id','Education_id')->withTrashed();
    }
    function Mosama_Groups_Educations(){
        return $this->belongsToMany(Mosama_Educations::class,"Mosama_Groups",'id','id');
    }
    function Mosama_Experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"Mosama_Groups_Experiences",'Group_id','Experience_id')->withTrashed();
    }
    function Mosama_Groups_Experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"Mosama_Groups",'id','id');
    }
    function Mosama_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"Mosama_Groups_Goals",'Group_id','Goal_id')->withTrashed();
    }
    function Mosama_Groups_Goals(){
        return $this->belongsToMany(Mosama_Goals::class,"Mosama_Groups",'id','id');
    }
    function Mosama_JobTitles(){
        return $this->belongsToMany(Mosama_JobTitles::class,"Mosama_Groups_JobTitles",'Group_id','JobTitle_id')->withTrashed();
    }
    function Mosama_Groups_JobTitles(){
        return $this->belongsToMany(Mosama_JobTitles::class,"Mosama_Groups",'id','id');
    }
    function Mosama_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"Mosama_Groups_Managers",'Group_id','Manager_id')->withTrashed();
    }
    function Mosama_Groups_Managers(){
        return $this->belongsToMany(Mosama_Managers::class,"Mosama_Groups",'id','id');
    }
    function Mosama_OrgStruses(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"Mosama_Groups_OrgStru",'Group_id','OrgStru_id')->withTrashed();
    }
    function Mosama_Groups_OrgStru(){
        return $this->belongsToMany(Mosama_OrgStruses::class,"Mosama_Groups",'id','id');
    }
    function Mosama_Skills(){
        return $this->belongsToMany(Mosama_Skills::class,"Mosama_Groups_Skills",'Group_id','Skill_id')->withTrashed();
    }
    function Mosama_Groups_Skills(){
        return $this->belongsToMany(Mosama_Skills::class,"Mosama_Groups",'id','id');
    }
    function Mosama_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"Mosama_Groups_Tasks",'Group_id','Task_id')->withTrashed();
    }
    function Mosama_Groups_Tasks(){
        return $this->belongsToMany(Mosama_Tasks::class,"Mosama_Groups",'id','id');
    }
    function Employers(){
        return $this->hasOne(\Amerhendy\Employers\App\Models\Employers::class,'id','Group_id')->withTrashed();
    }
}
