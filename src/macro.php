<?php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
if (! function_exists('Employer_url')) {
    function Employer_url($path = null, $parameters = [], $secure = null)
    {
        $path = ! $path || (substr($path, 0, 1) == '/') ? $path : '/'.$path;
        return url(config('Amer.employers.routeName_prefix', 'Employers').$path, $parameters, $secure);
    }
}
?>
