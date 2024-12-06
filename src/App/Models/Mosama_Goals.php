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
class Mosama_Goals extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="mosama_goals";
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = ['id','text'];
    protected $dates = ['deleted_at'];
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
    function Mosama_Groups(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_groups_goals",'goal_id','group_id')->withTrashed();
    }
    function mosama_groups_goals(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_goals",'id','id');
    }
    function Mosama_JobTitles(){
        return $this->belongsToMany(Mosama_JobTitles::class,"mosama_jobtitles_goals",'goal_id','jobtitle_id')->withTrashed();
    }
    function mosama_jobtitles_goals(){
        return $this->belongsToMany(Mosama_JobTitles::class,"mosama_goals",'id','id');
    }
    function Mosama_JobNames(){
        return $this->belongsToMany(Mosama_JobNames::class,"mosama_jobnames_goals",'goal_id','jobname_id')->withTrashed();
    }
    function mosama_jobnames_goals(){
        return $this->belongsToMany(Mosama_JobNames::class,"mosama_goals",'id','id');
    }
}
