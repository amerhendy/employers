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
class Employers extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,Sluggable, SluggableScopeHelpers;
    protected $table ="Employers";
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [];
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
        return $this->belongsTo(\Amerhendy\Employers\App\Models\Mosama_Groups::class,'Group_id','id')->withTrashed();
    }
    function Mosama_JobTitles(){
        return $this->belongsTo(\Amerhendy\Employers\App\Models\Mosama_JobTitles::class,'JobTitle_id','id')->withTrashed();
    }
    function Mosama_Degrees(){
        return $this->belongsTo(\Amerhendy\Employers\App\Models\Mosama_Degrees::class,'Degree_id','id')->withTrashed();
    }
    function Employers_trainings(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\CareerPath\Employers_trainings::class,"Employers_training",'Employer_id','training_id')->withTrashed();
    }
    function Employers_training(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\CareerPath\Employers_trainings::class,"Employers",'id','id');
    }
}
