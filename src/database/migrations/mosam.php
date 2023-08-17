<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $colp;
    public function up(): void
    {
        $this->setupPlain();
        $this->setupComplecated();
        $this->setupnewreferedtables();
    }
    function setupnewreferedtables(){
        $colp=[
            'Mosama_Degrees_Experiences'=>['Degree_id'=>'Mosama_Degrees','Experience_id'=>'Mosama_Experiences'],//
            'Mosama_Groups_Competencies'=>['Group_id'=>'Mosama_Groups','Competence_id'=>'Mosama_Competencies'],//
            'Mosama_Groups_Connections'=>['Group_id'=>'Mosama_Groups','Connection_id'=>'Mosama_Connections'],//
            'Mosama_Groups_Degrees'=>['Group_id'=>'Mosama_Groups','Degree_id'=>'Mosama_Degrees'],//
            'Mosama_Groups_Direct_Managers'=>['Group_id'=>'Mosama_Groups','Manager_id'=>'Mosama_Managers'],//
            'Mosama_Groups_Educations'=>['Group_id'=>'Mosama_Groups','Education_id'=>'Mosama_Educations'],//
            'Mosama_Groups_Experiences'=>['Group_id'=>'Mosama_Groups','Experience_id'=>'Mosama_Experiences'],
            'Mosama_Groups_Goals'=>['Group_id'=>'Mosama_Groups','Goal_id'=>'Mosama_Goals'],//
            'Mosama_Groups_JobTitles'=>['Group_id'=>'Mosama_Groups','JobTitle_id'=>'Mosama_JobTitles'],//
            'Mosama_Groups_Managers'=>['Group_id'=>'Mosama_Groups','Manager_id'=>'Mosama_Managers'],//
            'Mosama_Groups_OrgStru'=>['Group_id'=>'Mosama_Groups','OrgStru_id'=>'Mosama_OrgStruses'],//
            'Mosama_Groups_Skills'=>['Group_id'=>'Mosama_Groups','Skill_id'=>'Mosama_Skills'],//
            'Mosama_Groups_Tasks'=>['Group_id'=>'Mosama_Groups','Task_id'=>'Mosama_Tasks'],//
            'Mosama_JobName_Competencies'=>['JobName_id'=>'Mosama_JobNames','Competence_id'=>'Mosama_Competencies'],//
            'Mosama_JobName_Connections'=>['JobName_id'=>'Mosama_JobNames','Connection_id'=>'Mosama_Connections'],//
            'Mosama_JobName_Educations'=>['JobName_id'=>'Mosama_JobNames','Education_id'=>'Mosama_Educations'],//
            'Mosama_JobName_Experiences'=>['JobName_id'=>'Mosama_JobNames','Experience_id'=>'Mosama_Experiences'],//
            'Mosama_JobName_Goals'=>['JobName_id'=>'Mosama_JobNames','Goal_id'=>'Mosama_Goals'],//
            'Mosama_JobName_Managers'=>['JobName_id'=>'Mosama_JobNames','Manager_id'=>'Mosama_Managers'],//
            'Mosama_JobName_OrgStru'=>['JobName_id'=>'Mosama_JobNames','OrgStru_id'=>'Mosama_OrgStruses'],//
            'Mosama_JobName_Skills'=>['JobName_id'=>'Mosama_JobNames','Skill_id'=>'Mosama_Skills'],//
            'Mosama_JobName_Tasks'=>['JobName_id'=>'Mosama_JobNames','Task_id'=>'Mosama_Tasks'],//
            'Mosama_JobTitles_Competencies'=>['JobTitle_id'=>'Mosama_JobTitles','Competence_id'=>'Mosama_Competencies'], //
            'Mosama_JobTitles_Connections'=>['JobTitle_id'=>'Mosama_JobTitles','Connection_id'=>'Mosama_Connections'], //
            'Mosama_JobTitles_Educations'=>['JobTitle_id'=>'Mosama_JobTitles','Education_id'=>'Mosama_Educations'], //
            'Mosama_JobTitles_Goals'=>['JobTitle_id'=>'Mosama_JobTitles','Goal_id'=>'Mosama_Goals'],// 
            'Mosama_JobTitles_Managers'=>['JobTitle_id'=>'Mosama_JobTitles','Manager_id'=>'Mosama_Managers'], //
            'Mosama_JobTitles_OrgStru'=>['JobTitle_id'=>'Mosama_JobTitles','OrgStru_id'=>'Mosama_OrgStruses'], //
            'Mosama_JobTitles_Skill'=>['JobTitle_id'=>'Mosama_JobTitles','Skill_id'=>'Mosama_Skills'], //
            'Mosama_JobTitles_Tasks'=>['JobTitle_id'=>'Mosama_JobTitles','Task_id'=>'Mosama_Tasks'],//
            'OrgStru_Areas_Types'=>['Area_id'=>'OrgStru_Areas','Type_id'=>'OrgStru_Types'],
            'Regulations_topic_article'=>['Topic_id'=>'Regulations_Topics','Article_id'=>'Regulations_Articles'],
            'Regulations_Regulation_Topic'=>['Regulation_id'=>'Regulations','Topic_id'=>'Regulations_Topics'],
        ];
        $this->colp=$colp;
        foreach($colp as $a=>$b){
            Schema::create($a, function (Blueprint $table) use($b) {
                $table->id();
                foreach($b as $c=>$d){
                    $table->foreignId($c)->constrained(table: $d)->onUpdate('cascade')->onDelete('cascade');
                }
                $table->timestamps();
                $table->softDeletes();
            });    
        }
    }
    public function setupComplecated(){
        Schema::create('Mosama_JobTitles', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignId('Group_id')->constrained(table: 'Mosama_Groups')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_JobNames', function (Blueprint $table) {
            $table->id();
            $table->text('text')->unique();
            $table->foreignId('JobTitle_id')->constrained(table: 'Mosama_JobTitles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('Degree_id')->constrained(table: 'Mosama_Degrees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('Group_id')->constrained(table: 'Mosama_Groups')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('OrgStru_Areas', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignId('Section_id')->constrained(table: 'OrgStru_Sections')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('OrgStru_Mahatas', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignId('Section_id')->constrained(table: 'OrgStru_Sections')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('Area_id')->constrained(table: 'OrgStru_Areas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('Types_id')->constrained(table: 'OrgStru_Types')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Employers', function (Blueprint $table) {
            $table->id();
            $table->text('uid')->unique();
            $table->text('nid')->unique();
            $table->text('fullname')->unique();
            $table->foreignId('Mosama_JobTitles')->constrained(table: 'Mosama_JobTitles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('Mosama_Groups')->constrained(table: 'Mosama_Groups')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('Mosama_Degrees')->constrained(table: 'Mosama_Degrees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('mahata')->constrained(table: 'OrgStru_Mahatas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('section')->constrained(table: 'OrgStru_Sections')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('area')->constrained(table: 'OrgStru_Areas')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function setupPlain(){
        Schema::create('Mosama_Competencies', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Connections', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->enum('type',['in','out'])->nullable()->default('in');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Degrees', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Educations', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Experiences', function (Blueprint $table) {
            $table->id();
            $table->enum('type',[0,1])->default(0);
            $table->integer('time');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Goals', function (Blueprint $table) {
            $table->id();
            $table->longText('text');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Groups', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Managers', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_OrgStruses', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->integer('type');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Skills', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Mosama_Tasks', function (Blueprint $table) {
            $table->id();
            $table->mediumText('text');
            $table->enum('type',['fatherof','wazifia','tanfiz','eshraf'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('OrgStru_Types', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('OrgStru_Sections', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Regulations_Topics', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->unsignedInteger('father')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Regulations', function (Blueprint $table) {
            $table->id();
            $table->string('text')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Regulations_Articles', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->longText('text');
            $table->text('mp3')->nullable();
            $table->foreignId('Regulation_id')->constrained(table: 'Regulations')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

    }
    public function down(): void
    {
        Schema::dropIfExists('Mosama_Competencies');
        Schema::dropIfExists('Mosama_Connections');
        Schema::dropIfExists('Mosama_Degrees');
        Schema::dropIfExists('Mosama_Experiences');
        Schema::dropIfExists('Mosama_Goals');
        Schema::dropIfExists('Mosama_Groups');
        Schema::dropIfExists('Mosama_JobNames');
        Schema::dropIfExists('Mosama_Jobs');
        Schema::dropIfExists('Mosama_JobTitles');
        Schema::dropIfExists('Mosama_Managers');
        Schema::dropIfExists('Mosama_OrgStruses');
        Schema::dropIfExists('Mosama_Skills');
        Schema::dropIfExists('Mosama_Tasks');
        foreach($this->colp as $a=>$b){
            Schema::dropIfExists($a);
        }
    }
};