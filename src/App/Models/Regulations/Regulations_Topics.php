<?php

namespace Amerhendy\Employers\App\Models\Regulations;
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
class Regulations_Topics extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,Sluggable, SluggableScopeHelpers;
    protected $table ="Regulations_Topics";
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
    public function children()
{
    return $this->hasMany('\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics', 'father', 'id');
}
public function parent()
{
    return $this->belongsTo('\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics', 'father');
}
function Regulation(){
    return $this->belongsToMany(Regulations::class,"Regulations_Regulation_Topic",'Topic_id','Regulation_id')->withTrashed();
}
function Regulations(){
    return $this->belongsToMany(Regulations::class,"Regulations_Regulation_Topic",'Topic_id','Regulation_id')->withTrashed();
}
function Regulations_Regulation_Topic(){
    return $this->belongsToMany(Regulations::class,"Regulations_Topics",'id','id');
}
function Regulations_Articles(){
    return $this->belongsToMany(Regulations_Articles::class,"Regulations_topic_article",'Topic_id','Article_id')->withTrashed();
}
function Regulations_topic_article(){
    return $this->belongsToMany(Regulations_Articles::class,"Regulations_Topics",'id','id');
}
}
