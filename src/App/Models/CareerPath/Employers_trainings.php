<?php

namespace Amerhendy\Employers\App\Models\CareerPath;
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
class Employers_trainings extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="Employers_trainings";
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $casts=['Files'];
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [];
    protected $dates = ['deleted_at','TrainningTimeEnd','TrainningTimeStart','TestDate'];
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
    function Employers_CareerPathes(){
        return $this->belongsTo(\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathes::class,'CareerPath_id','id');
    }
    function Mosama_JobNames(){
        return $this->belongsTo(\Amerhendy\Employers\App\Models\Mosama_JobNames::class,'JobNames_id','id');
    }
    function Mosama_Groups_CareerPath(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\Mosama_Groups::class,"Employers_trainings",'id','id');
    }
    function Mosama_Groups(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\Mosama_Groups::class,"Mosama_Groups_CareerPath",'CareerPath_id','group_id')->withTrashed();
    }
    function Employers_training(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\Employers::class,"Employers_trainings",'id','id');
    }
    function Employers(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\Employers::class,"Employers_training",'training_id','Employer_id')->withTrashed();
    }
}
