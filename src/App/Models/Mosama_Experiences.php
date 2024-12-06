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
class Mosama_Experiences extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="mosama_experiences";
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
    function Mosama_Degrees(){
        return $this->belongsToMany(Mosama_Degrees::class,"mosama_degrees_experiences",'experience_id','degree_id')->withTrashed();
    }
    function mosama_degrees_experiences(){
        return $this->belongsToMany(Mosama_Degrees::class,"mosama_experiences",'id','id');
    }
    function Mosama_Groups(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_groups_experiences",'experience_id','group_id')->withTrashed();
    }
    function mosama_groups_experiences(){
        return $this->belongsToMany(Mosama_Groups::class,"mosama_experiences",'id','id');
    }
    function Mosama_JobNames(){
        return $this->belongsToMany(Mosama_JobNames::class,"mosama_jobnames_experiences",'experience_id','jobname_id')->withTrashed();
    }
    function mosama_jobnames_experiences(){
        return $this->belongsToMany(Mosama_JobNames::class,"mosama_experiences",'id','id');
    }
    public function text(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes){
                if($attributes['time'] === 0 || $attributes['time'] === '0'){
                    return __('EMPLANG::Mosama_Experiences.year0');
                }else{
                    return __('EMPLANG::Mosama_Experiences.LaravelTranslate',
                    [
                        'type'=>__('EMPLANG::Mosama_Experiences.enum_'.$attributes['type']),
                        'year'=>$attributes['time']
                    ]
                );
                }
            }
        );
    }
}
