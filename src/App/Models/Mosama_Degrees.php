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

use Illuminate\Database\Eloquent\Relations\HasOneThrough;
class Mosama_Degrees extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="mosama_degrees";
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
        return $this->belongsToMany(Mosama_Groups::class,"mosama_groups_degrees",'degree_id','group_id')->withTrashed();
    }
    function mosama_groups_degrees(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_degrees",'id','id');
    }
    function Mosama_Experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"mosama_degrees_experiences",'degree_id','experience_id')->withTrashed();
    }
    function mosama_degrees_experiences(){
        return $this->belongsToMany(Mosama_Experiences::class,"mosama_degrees",'id','id');
    }
}
