@extends(Baseview('app'))
<?php
$viewways=[
    ['id'=>'','text'=>'',],
    ['id'=>'Mosama_JobName','text'=>'البطاقات',],
    ['id'=>'Mosama_JobTitles','text'=>'المسمى الوظيفى',],
    ['id'=>'Mosama_Groups','text'=>'المجموعة النوعية',],
    ['id'=>'Mosama_Degrees','text'=>'الدرجة',],
    ['id'=>'Mosama_Managers','text'=>'المسئول المباشر',],
    ['id'=>'Mosama_OrgStru','text'=>'القطاع/المكتب/الادارة العامة/الادارة',],
    ['id'=>'Mosama_Connections_in','text'=>'الاتصالات الداخلية',],
    ['id'=>'Mosama_Connections_out','text'=>'الاتصالات الخارجية',],
    ['id'=>'Mosama_Tasks','text'=>'المهام والمسئوليات',],
    ['id'=>'Mosama_Educations','text'=>'المؤهل الدراسى',],
    ['id'=>'Mosama_Experiences','text'=>'سنوات الخبرة',],
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
    <div class="row">
    <div class="col-sm-12">
    <label for="selectshow" style="width:100%">
        <select 
        name="selectshow" 
        id='selectshow' 
        style="width:100%" 
        data-init-function="set_select2_Views" data-placeholder="اختر طريقة العرض" data-array='@json($viewways)'></select>
        </label>
    </div>
    <div class="col-sm-12" id='allselectdiv'>
    <label for="allselect" style="width:100%">
    
        من فضلك اختر <span id="allselectlabel"></span>
        <select name='allselect[]' class="form-control select2" id='allselect' multiple="multiple" data-init-function="set_select2_element" style="width:100%"></select>
        <input type="checkbox" id="selectall" onclick="select2all(this); allselect2();" for="allselect">Select All
        </label>
    </div>
    <div class="col-sm-12" id='jobnameselectdiv'>
    <label for="jobnameselect" style="width:100%">
        من فضلك اختر البطاقات
        <select name='jobnameselect[]' class="form-control select2" id='jobnameselect' multiple="multiple" style="width:100%"></select>
        <input type="checkbox" id="selectall" onclick="selectall2(this);" for="jobnameselect">Select All
        </label>
    </div>
    </div>
    <div class="row">
        <button  class="col-sm-1 btn btn-primary" id="showmenubtn"><span>عرض</span></button>
    <!--<div onclick="showmenubtn()">
        
    </div>-->
    </div>
    <div class="alldata" data='@json($data)'></div>
    </form>
    </div>
@endsection
@push('after_scripts')
@loadScriptOnce('js/packages/select2/dist/js/select2.full.min.js')

@if (app()->getLocale() !== 'en')
    @loadScriptOnce('js/packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js')
    @endif
<script>
    $('#showmenubtn').hide();
    $('#jobnameselectdiv').hide();
    $('#allselectdiv').hide();
    //on load
    

$('#selectshow').on('select2:select', function (e) {
    selectshow2();
        $('#showmenubtn').hide();
});
//allselect
$('#allselect').on('select2:select', function (e) {
        allselect2();
        //$('#jobnameselectdiv').hide();
});
$('#jobnameselect').on('select2:select', function (e) {
    $('#showmenubtn').show();
});
function selectall2(e){
    $('#showmenubtn').show();
    select2all(e); 
}
    function maindatatoarray(wanted){
        alldata=$('.alldata').attr('data');
        if(!IsValidJSONString(alldata)){alert('error1');}
        jsin=JSON.parse(alldata);
        return (jsin[wanted]);
    }
    function jobnameselect(e){
        data=maindatatoarray('Mosama_JobName');
        arr=new Array();
        data.forEach(logs=>{
            arr.push({'id':logs['id'],'text':logs['text']});
            var newOption = new Option(logs['text'], logs['id'], false, false);
            $('#jobnameselect').append(newOption).trigger('change');
            });
            
            $("#jobnameselect").select2({
                dir:'rtl',
                theme: 'bootstrap-5',
                allowClear: true,
            });
    }
    function selectshow2(){
        selectval=$('#selectshow').val();
        if(selectval == ''){$('#showmenubtn').hide();
    $('#jobnameselectdiv').hide();
    $('#allselectdiv').hide();return;}
        data=maindatatoarray(selectval);
        arr=new Array();
        if(selectval=='Mosama_JobName'){
            $('#jobnameselectdiv').show();
            $('#allselectdiv').hide();
            //if($('#jobnameselectdiv').is(":hidden")){$('#jobnameselectdiv').show();}
        }else{
            $('#jobnameselectdiv').hide();
            $('#allselectdiv').show();
            $('#allselectlabel').html($('#selectshow').find(':selected')[0]['text']);
            //set label
        }
        if(selectval=='Mosama_JobName'){targetselect='jobnameselect';}else{targetselect='allselect';}
        removeAllOptions(document.getElementById(targetselect));
        fstopt=['Mosama_JobName','Mosama_JobTitles','Mosama_Groups','Mosama_Degrees','Mosama_Managers','Mosama_OrgStru','Mosama_Connections_in','Mosama_Connections_out','Mosama_Educations']
        if(fstopt.includes(selectval)){
            data.forEach(logs=>{
                arr.push({'key':logs['id'],'text':logs['text']});
            });
        }else{
            if(selectval=='Mosama_Tasks'){
                data.forEach(logs=>{
                    if(logs['type']=='tanfiz'){starttext='تنفيذية : ';}else if(logs['type']=='wazifia'){starttext='وظيفية : ';}else if(logs['type']=='eshraf'){starttext='اشرافية : ';}else{starttext="";}
                arr.push({'key':logs['id'],'text':starttext+logs['text']});
            }); 
            }else if(selectval=='Mosama_Experiences'){
                
                data.forEach(logs=>{
                    if(logs['time']== 0){
                        text="لا يتطلب خبره";
                    }else{
                        if(logs['type']== 1){
                            text="خبره في مجال العمل "+ logs ['time']+" سنوات ";
                        }else{
                            
                            text='قضاء مدة بينية قدرها '+logs['time']+' سنوات فى الدرجة الادنى';}
                        
                    }
                    arr.push({'key':logs['id'],'text':text});
                });
            }
        }
        dataToSelect(arr,$('#'+targetselect));
    }
    
    function allselect2(){
        selectval=$('#allselect').val();
        selectshowval=$('#selectshow').val();
        selectshowdata=maindatatoarray('Mosama_JobName');
        amo=new Array();
        if(selectshowval == 'Mosama_Connections_in'){ selectshowval="Mosama_Connections";}
        else if(selectshowval == 'Mosama_Connections_out'){selectshowval="Mosama_Connections";}
        selectval.forEach(element => {
            amo.push(selectshowdata.map(function (person)  {
            if (person[selectshowval].includes(parseInt(element))) {
                return {'key':person['id'],text:person['text']}
            }else{
                return 'empty';
            }
            }));
        });
        arr=new Array();
        amo[0].forEach(element => {
            if(element !== 'empty'){
                arr.push(element);
            }
        });
        $('#jobnameselectdiv').show();
        removeAllOptions(document.getElementById('jobnameselect'));
        dataToSelect(arr,$('#jobnameselect'));
    }
    function dataToSelect(arr,select){
        html='';
        arr.forEach(element => {
            var o = new Option(element['text'], element['key']);
            /// jquerify the DOM object 'o' so we can use the html method
            $(o).html(element['text']);
            select.append(o);
            html+='<option value="'+element['key']+'">'+element['text']+'</option>';
        });
        return html;
    }/*
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
    function set_select2_Views(element){
        var form = element.closest('form');
        var data=$(element).data('array');
        var placeHolder=$(element).data('placeHolder');
        
        $(element).select2({
            data:data,
            placeholder:placeHolder,
        });
        jobnameselect();
        selectshow2();
        
    }
    function set_select2_element(element){
        var form = element.closest('form');
        var data=$(element).data('array');
        var placeHolder=$(element).data('placeHolder');
        
        $(element).select2();
    }
</script>
@endpush