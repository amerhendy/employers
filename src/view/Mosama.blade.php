@extends(Baseview('app'))
<?php
$viewways=[
    ['id'=>'','text'=>'',],
    ['id'=>'Mosama_JobName','text'=>trans('EMPLANG::Mosama.Mosama_JobName.plural')],
    ['id'=>'Mosama_JobTitles','text'=>trans('EMPLANG::Mosama.Mosama_JobTitles.plural')],
    ['id'=>'Mosama_Groups','text'=>trans('EMPLANG::Mosama.Mosama_Groups.plural')],
    ['id'=>'Mosama_Degrees','text'=>trans('EMPLANG::Mosama.Mosama_Degrees.plural')],
    ['id'=>'Mosama_Managers','text'=>trans('EMPLANG::Mosama.Mosama_Managers.directMosama_Managers')],
    ['id'=>'Mosama_OrgStru','text'=>trans('EMPLANG::Mosama.Mosama_OrgStruI')],
    ['id'=>'Mosama_Connections_in','text'=>trans('EMPLANG::Mosama.Mosama_Connections.Mosama_Connections_in')],
    ['id'=>'Mosama_Connections_out','text'=>trans('EMPLANG::Mosama.Mosama_Connections.Mosama_Connections_out')],
    ['id'=>'Mosama_Tasks','text'=>trans('EMPLANG::Mosama.Mosama_Tasks.Mosama_Tasksandresp')],
    ['id'=>'Mosama_Educations','text'=>trans('EMPLANG::Mosama.Mosama_Educations.plural')],
    ['id'=>'Mosama_Experiences','text'=>trans('EMPLANG::Mosama.Mosama_Experiences.Experiences_years')],
];
?>
@push('header')
@endpush
@push('after_styles')
    <style>
        .requireinput{
            border-color: #0B90C4;
        }
        .select2-results__group{
        background-color:gray;
        }
        .has-error{
            border-color: rgb(185, 74, 72) !important;
        }
    </style>
@loadStyleOnce('js/packages/select2/dist/css/select2.min.css')
@loadStyleOnce('js/packages/select2-bootstrap-theme/dist/select2-bootstrap-5-theme.min.css')
@endpush

@section('content')
<div class="container">
    <?php
    $route = \Route::currentRouteName();
    if($route =='Mosama.index'){
        $acroute=route('Mosama_print.index');
    }
    if($route =='admin.Mosama.index'){
        $acroute=route('admin.Mosama_print.index');
    }
    ?>
<form method="POST" action="{{$acroute}}" target="_blank">
    <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />
    <div class="row mb-3">
        <label for="selectshow" class="col-sm-2 col-form-label">{{trans('EMPLANG::Mosama.SelectShowType')}}</label>
        <div class="col-sm-10">
            <select
            class="form-control form-control-sm form-select form-select-sm"
            name="selectshow"
            id='selectshow'
            style="width:100%"
            data-init-function="set_select_element"
            data-placeholder="{{trans('EMPLANG::Mosama.SelectShowType')}}" data-array='@json($viewways)'></select>
        </div>
    </div>
    <div class="row mb-3" id='allselectdiv'>
        <label for="allselect" class="col-sm-2 col-form-label">{{trans('EMPLANG::Mosama.pleaseSelect')}}<span id="allselectlabel"></span></label>
        <div class="col-sm-10">
            <select name='allselect[]'
                class="form-control form-control-sm form-select form-select-sm"
                id='allselect'
                multiple="multiple"
                data-init-function="set_select_element"
                style="width:100%">
            </select>
        </div>
    </div>
    <div class="row mb-3" id='jobnameselectdiv'>
        <label for="jobnameselect" class="col-sm-2 col-form-label">{{trans('EMPLANG::Mosama.pleaseSelect')}} {{trans('EMPLANG::Mosama.Mosama_JobName.plural')}}</label>
        <div class="col-sm-10">
            <select
                    name='jobnameselect[]'
                    class="form-control form-control-sm form-select form-select-sm"
                    id='jobnameselect'
                    multiple="multiple"
                    data-init-function="set_select_element"
                    style="width:100%">
            </select>
        </div>
        <div class="controlgroup">
        <label for="selectall">selectall</label>
        <input type="checkbox" name="selectall" id="selectall">
        </div>
    </div>
    <div class="row">
        <button  class="col-sm-1 btn btn-primary" id="showmenubtn"><span>عرض</span></button>
    <!--<div onclick="showmenubtn()">

    </div>-->
    </div>
    </form>
    </div>
@endsection
@push('after_scripts')
@loadScriptOnce('js/packages/select2/dist/js/select2.full.min.js')
@loadScriptOnce('js/Amer/forms/select2.js')
@loadScriptOnce('js/employment/admin/mosama/mosamaView.js')
@if (app()->getLocale() !== 'en')
    @loadScriptOnce('js/packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js')
    @endif
<script>
    window.Amer.alldata={{ Illuminate\Support\Js::from($data) }};
    jstrans.mosama={{ Illuminate\Support\Js::from(trans('EMPLANG::Mosama')) }};
    jstrans.Mosama_Experiences={{ Illuminate\Support\Js::from(trans('EMPLANG::Mosama_Experiences')) }};
/*
    function showmenubtn(){
        selectval=$('#jobnameselect').val();
        if(selectval.length == 0){
            alert("من فضلك اختر بطاقات لعؤضها");
            return;
        }
        setcookie('printids',selectval.toString(),1);
        //localStorage.setItem("printids",selectval.toString());
        link="{{route('Mosama_print.index')}}";
        //link+="?ids="+selectval.toString();
        window.open(link);
    }*/

</script>
@endpush
