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
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
class Employers_CareerPathes extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,Sluggable, SluggableScopeHelpers;
    protected $table ="Employers_CareerPathes";
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
    function Mosama_Groups_CareerPath(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\Mosama_Groups::class,"Employers_CareerPathes",'id','id');
    }
    function Mosama_Groups(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\Mosama_Groups::class,"Mosama_Groups_CareerPath",'CareerPath_id','Group_id')->withTrashed();
    }
    function Employers_CareerPathes_Files(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathFiles::class,"Employers_CareerPathes",'id','id');
    }
    function Employers_CareerPathFiles(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathFiles::class,"Employers_CareerPathes_Files",'CareerPath_id','File_id')->withTrashed();
    }
}
