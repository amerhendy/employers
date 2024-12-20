<?php

namespace Amerhendy\Employers\App\Models\Regulations;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Amerhendy\Amer\App\Models\Traits\AmerTrait;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Regulations_Topics extends Model
{
    use HasFactory,SoftDeletes,AmerTrait,HasRoles,HasApiTokens,HasUuids;
    protected $table ="regulations_topics";
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
    public function children()
{
    return $this->hasMany('\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics', 'father', 'id');
}
public function parent()
{
    return $this->belongsTo('\Amerhendy\Employers\App\Models\Regulations\Regulations_Topics', 'father');
}
function Regulation(){
    return $this->belongsToMany(Regulations::class,"regulations_regulations_topics",'topic_id','regulation_id')->withTrashed();
}
function Regulations(){
    return $this->belongsToMany(Regulations::class,"regulations_regulations_topics",'topic_id','regulation_id')->withTrashed();
}
function regulations_regulations_topics(){
    return $this->belongsToMany(Regulations::class,"regulations_topics",'id','id');
}
function Regulations_Articles(){
    return $this->belongsToMany(Regulations_Articles::class,"Regulations_topic_article",'topic_id','article_id')->withTrashed();
}
function Regulations_topic_article(){
    return $this->belongsToMany(Regulations_Articles::class,"regulations_topics",'id','id');
}
}
