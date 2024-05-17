<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->training();
    }
    public function training(){
        Schema::create('Employers_CareerPathFiles', function (Blueprint $table) {
            $table->id();
            $table->string('Text');
            $table->Text('Link');
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('Employers_CareerPathes', function (Blueprint $table) {
            $table->id();
            $table->string('Text');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('Employers_CareerPathes_Files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CareerPath_id')->constrained(table: 'Employers_CareerPathes');
            $table->foreignId('File_id')->constrained(table: 'Employers_CareerPathFiles');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('Mosama_Groups_CareerPath', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Group_id')->constrained(table: 'Mosama_Groups');
            $table->foreignId('CareerPath_id')->constrained(table: 'Employers_CareerPathes');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('Employers_trainings', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->foreignId('JobNames_id')->constrained(table: 'Mosama_JobNames');
            $table->foreignId('CareerPath_id')->constrained(table: 'Employers_CareerPathes');
            $table->char('Stage',2);
            $table->dateTime('TrainningTimeStart', $precision = 0)->nullable();
            $table->dateTime('TrainningTimeEnd', $precision = 0)->nullable();
            $table->string('TrainningLink')->nullable();
            $table->string('Trainer')->nullable();
            $table->dateTime('TestDate', $precision = 0)->nullable();
            $table->jsonb('Files');
            $table->timestamps();
            $table->softDeletes();
        });
        ///relation with Employers
        Schema::create('Employers_training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Employer_id')->constrained(table: 'Employers');
            $table->foreignId('training_id')->constrained(table: 'Employers_trainings');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        $tables=[];
        Schema::dropIfExists('Employers_CareerPathFiles');
        Schema::dropIfExists('Mosama_Groups_CareerPath');
        Schema::dropIfExists('Employers_CareerPathes');
        Schema::dropIfExists('Employers_trainings');
        Schema::dropIfExists('Employers_training');
    }
};