<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
///////////////////////////////////////////////////////////////user area ////////////////////////////////////////////
/////////////////////////////ui///////////////////////////
Route::group(
    [
        'prefix'     =>config('Amer.Employers.route_prefix','Employers'),
        'namespace'  =>config('Amer.Employers.Controllers'),
        'middleware' => config('Amer.Amer.web_middleware', 'web'),
        'name'=>config('Amer.Employers.routeName_prefix','Employers.'),
    ],function(){
        Route::post('Employer/login', 'Auth\LoginController@login')->name('Employer.login.api');
        Route::POST('Mosama/Mosama_print','MosamaAmerController')->name('Mosama_print.index');

    }
);
Route::group(
    [
        'prefix'     =>config('Amer.Employers.route_prefix'),
        'namespace'  =>config('Amer.Employers.Controllers'),
        'middleware' =>array_merge((array) config('Amer.Amer.web_middleware'),(array) config('Amer.Employers.auth.middleware_key')),
        'name'=>'Employer.',
    ],
    function(){
        Route::post('logout', 'Auth\LoginController@logout')->name('employerlogout-post');
        Route::post('showRegulations','RegulationsAmerController@showRegulations')->name('Regulations');
});
////////////////////////////////////////////////////////////// admin area ////////////////////////////////////////////////
Route::group([
    'namespace'  =>config('Amer.Employers.Controllers'),
], function () {
    //Route::get('/',"Auth\Employers@index")->middleware(['web'])->name('home');
    Route::get('/Employers',"Auth\Employers@index")->middleware(['web'])->name('employerdashboard');
    Route::get('/RegulationsCollections',"api\RegulationsCollection@index")->middleware(['web'])->name('RegulationsCollections');
});
Route::group(
    [
        'prefix'     =>config('Amer.Employers.route_prefix','Employers'),
        'namespace'  =>config('Amer.Employers.Controllers'),
        'middleware' =>array_merge((array) config('Amer.Amer.web_middleware'),(array) config('Amer.Security.auth.middleware_key')),
        'name'=>config('Amer.Employers.routeName_prefix','Employers.'),
    ],
    function(){
        Route::GET('Mosama','MosamaAmerController')->name('Mosama.index');
        Route::Amer('Mosama_Competencies','Mosama_CompetenciesAmerController');
        Route::Amer('Mosama_Connections','Mosama_ConnectionsAmerController');
        Route::Amer('Mosama_JobTitles','Mosama_JobTitlesAmerController');
        Route::Amer('Mosama_Managers','Mosama_ManagersAmerController');
        Route::Amer('Mosama_OrgStruses','Mosama_OrgStrusesAmerController');
        Route::Amer('Mosama_Skills','Mosama_SkillsAmerController');
        Route::Amer('Mosama_Tasks','Mosama_TasksAmerController');
        Route::Amer('Mosama_Goals','Mosama_GoalsAmerController');
        Route::Amer('Mosama_Degrees','Mosama_DegreesAmerController');
        Route::Amer('Mosama_Educations','Mosama_EducationsAmerController');
        Route::Amer('Mosama_Experiences','Mosama_ExperiencesAmerController');
        Route::Amer('Mosama_Groups','Mosama_GroupsAmerController');
        Route::Amer('Mosama_JobNames','Mosama_JobNamesAmerController');
        Route::Amer('OrgStru_Types','OrgStru_TypesAmerController');
        Route::Amer('OrgStru_Sections','OrgStru_SectionsAmerController');
        Route::Amer('OrgStru_Areas','OrgStru_AreasAmerController');
        Route::Amer('OrgStru_Mahatas','OrgStru_MahatasAmerController');
        Route::Amer('Regulations','RegulationsAmerController');
        Route::Amer('Regulations_Topics','Regulations_TopicsAmerController');
        Route::Amer('Regulations_Articles','Regulations_ArticlesAmerController');
        Route::Amer('Employers_CareerPathFiles','CareerPath\Employers_CareerPathFilesAmerController');
        Route::Amer('Employers_CareerPathes','CareerPath\Employers_CareerPathesAmerController');
        Route::Amer('Employers_trainings','CareerPath\Employers_trainingsAmerController');
        Route::Amer('Employers','EmployersAmerController');
});
//Route::get('/','Employers@index');
