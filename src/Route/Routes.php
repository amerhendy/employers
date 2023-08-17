<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::group([
    'namespace'  =>'Amerhendy\Employers\App\Http\Controllers',
], function () {
    Route::get('/Employers',"Auth\Employers@index")->middleware(['web'])->name('employerdashboard');
    Route::get('/RegulationsCollections',"api\RegulationsCollection@index")->middleware(['web'])->name('RegulationsCollection');
});
Route::group(
    [
        'prefix'     =>config('amer.route_prefix'),
        'namespace'  =>'Amerhendy\Employers\App\Http\Controllers',
        'middleware' =>array_merge((array) config('amer.web_middleware'),(array) config('amerSecurity.auth.middleware_key')),
        'name'=>'Employer.',
    ],
    function(){
        
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
});
Route::group(
    [
        'namespace' => 'Amerhendy\Employers\App\Http\Controllers',
        'middleware' => config('amer.web_middleware', 'web'),
        'prefix'     =>config('employers.route_prefix'),
    ],function(){
        Route::post('Employer/login', 'Auth\ApiAuthController@EmployerLogin')->name('Employer.login.api');
    }
);
Route::group(
    [
        'prefix'     =>config('employers.route_prefix'),
        'namespace'  =>'Amerhendy\Employers\App\Http\Controllers',
        'middleware' =>array_merge((array) config('amer.web_middleware'),(array) config('employers.employer_auth.middleware_key')),
        'name'=>'Employer.',
    ],
    function(){
        Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('employerlogin-form');
        Route::post('login', 'Auth\LoginController@adminLogin')->name('employerlogin-post');
        Route::post('logout', function(){
            Auth::guard(config('employers.employer_auth.middleware_key'))->logout();
            return redirect()->route('employerdashboard');
        })->name('employerlogout-post');        
        Route::GET('Mosama','MosamaAmerController')->name('Mosama.index');
        Route::POST('Mosama/Mosama_print','MosamaAmerController')->name('Mosama_print.index');
        Route::post('MosamaPrint','api\MosamaCollection@showprintjobname')->name('showprintjobname');
        Route::post('Regulations','RegulationsAmerController@showRegulations')->name('Regulations');
});
