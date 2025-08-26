<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::post('MosamaPrint','api\MosamaCollection@showprintjobname')->name('showprintjobname');

