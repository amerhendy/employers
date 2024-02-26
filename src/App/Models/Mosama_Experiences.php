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
class Mosama_Experiences extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,Sluggable, SluggableScopeHelpers;
    protected $table ="Mosama_Experiences";
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
    function Mosama_Degrees(){
        return $this->belongsToMany(Mosama_Degrees::class,"Mosama_Degrees_Experiences",'Experience_id','Degree_id')->withTrashed();
    }
    function Mosama_Degrees_Experiences(){
        return $this->belongsToMany(Mosama_Degrees::class,"Mosama_Experiences",'id','id');
    }
    function Mosama_Groups(){
        return $this->belongsToMany(Mosama_Groups::class,"Mosama_Groups_Experiences",'Experience_id','Group_id')->withTrashed();
    }
    function Mosama_Groups_Experiences(){
        return $this->belongsToMany(Mosama_Groups::class,"Mosama_Experiences",'id','id');
    }
    function Mosama_JobNames(){
        return $this->belongsToMany(Mosama_JobNames::class,"Mosama_JobName_Experiences",'Experience_id','JobName_id')->withTrashed();
    }
    function Mosama_JobName_Experiences(){
        return $this->belongsToMany(Mosama_JobNames::class,"Mosama_Experiences",'id','id');
    }
}
