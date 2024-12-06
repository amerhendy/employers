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
class Employers_CareerPathFiles extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="employers_careerpathfiles";
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
    function Employers_CareerPathes_Files(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathes::class,"Employers_CareerPathFiles",'File_id','CareerPath_id')->withTrashed();
    }
    function Employers_CareerPathFiles(){
        return $this->belongsToMany(\Amerhendy\Employers\App\Models\CareerPath\Employers_CareerPathes::class,"Employers_CareerPathFiles",'id','id');
    }
}
