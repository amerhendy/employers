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
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Mosama_OrgStruses extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="mosama_org_structures";
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
    function Mosama_Groups(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_groups_org_stru",'org_stru_id','group_id')->withTrashed();
    }
    function mosama_groups_org_stru(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_org_structures",'id','id');
    }
    function Mosama_JobNames(){
        return $this->belongsToMany(Mosama_JobNames::class,"mosama_job_name_org_stru",'org_stru_id','job_name_id')->withTrashed();
    }
    function mosama_job_name_org_stru(){
        return $this->belongsToMany(Mosama_JobNames::class,"mosama_org_structures",'id','id');
    }
    function Mosama_JobTitles(){
        return $this->belongsToMany(Mosama_JobTitles::class,"mosama_job_titles_org_stru",'org_stru_id','job_title_id')->withTrashed();
    }
    function mosama_job_titles_org_stru(){
        return $this->belongsToMany(Mosama_JobTitles::class,"mosama_org_structures",'id','id');
    }
    public function fulltext(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                return __('EMPLANG::mosama.Mosama_OrgStru.'.$attributes['type']).": ".$attributes['text'];
            }
        );
    }
}
