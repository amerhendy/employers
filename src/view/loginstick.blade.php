<?php
$guards=config('auth.guards');
?>
@if(array_key_exists('Employers',$guards))
<li><a class="dropdown-item" href="{{route('employerdashboard') }}"><i class="fa fa-users"></i>خدمات العاملين</a></li>
@endif
@error('uid') is-invalid @enderror
<div id='employermenu' style="display:none">
    <li><a class="dropdown-item">{{ amer_auth()->user()->fullname ?? '' }}</a></li>
    <li><a class="dropdown-item" href="{{route('employerlogout-post') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ trans('SECLANG::auth.logout') }}</a></li>
    <form id="logout-form" action="{{ route('employerlogout-post') }}" method="POST" style="display: none;">
            @csrf
    </form>
</div>
<template id="login-template-Employer">
@if(array_key_exists('Employers',$guards))
    @if(!auth::guard('Employers')->check())
        <div class="col-sm-5 btn btn-primary" data-bs-target="loginemployers">دخول العاملين</div>
    @endif
    @endif
    </div>
    <div id="loginemployers" style="display:none">
            @csrf
            <input id="nid" type="number" class="swal2-input" name="nid" value="{{ old('nid') }}" required autocomplete="nid" placeholder="{{ __('EMPLANG::Auth.nid') }}" autofocus>
            <input id="uid" type="text" class="swal2-input @error('uid') is-invalid @enderror" name="uid" required autocomplete="current-uid" placeholder="{{ __('EMPLANG::Auth.uid') }}">
            <div class="form-check">
            <input type="checkbox" class="btn-check" id="btn-check" autocomplete="off" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
            <label class="btn btn-primary" for="btn-check">{{ __('Remember Me') }}</label>
            </div>
            <button type="button" class="swal2-confirm swal2-styled loginbtn" data-bs-link='{{route("Employer.login.api")}}' style="display: inline-block;" aria-label="" >{{__('SECLANG::auth.login')}}</button>
            <!--onclick="preConfirm()"-->
    </div>
</template>
@push('after_scripts')
<script>
    @if(auth::guard('Employers')->check())
        $('#employermenu').css('display','block');
    @endif
</script>
@endpush
