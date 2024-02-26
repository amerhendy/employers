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
class Mosama_Goals extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,Sluggable, SluggableScopeHelpers;
    protected $table ="Mosama_Goals";
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = ['id','text'];
    protected $dates = ['deleted_at'];
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
    function Mosama_Groups(){
        return $this->belongsToMany(Mosama_Groups::class,"Mosama_Groups_Goals",'Goal_id','Group_id')->withTrashed();
    }
    function Mosama_Groups_Goals(){
        return $this->belongsToMany(Mosama_Groups::class,"Mosama_Goals",'id','id');
    }
    function Mosama_JobTitles(){
        return $this->belongsToMany(Mosama_JobTitles::class,"Mosama_JobTitles_Goals",'Goal_id','JobTitle_id')->withTrashed();
    }
    function Mosama_JobTitles_Goals(){
        return $this->belongsToMany(Mosama_JobTitles::class,"Mosama_Goals",'id','id');
    }
    function Mosama_JobNames(){
        return $this->belongsToMany(Mosama_JobNames::class,"Mosama_JobName_Goals",'Goal_id','JobName_id')->withTrashed();
    }
    function Mosama_JobName_Goals(){
        return $this->belongsToMany(Mosama_JobNames::class,"Mosama_Goals",'id','id');
    }
}
