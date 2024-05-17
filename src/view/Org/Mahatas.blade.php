<!-- dependencyJson -->
<?php
$language=Str::replace('_', '-', app()->getLocale());
foreach ($field['subfields'] as $key => $value) {
    $field['subfields'][$key]['label']=$value['placeholder'];
}

if(isset($field['value'])){
    $field['subfields']['Section_id']['value']=$field['value'][0];
    $field['subfields']['Area_id']['value']=$field['value'][1];
    $field['subfields']['Types_id']['value']=$field['value'][2];
}

$model = $Amer->getModel();
$Section_id = ['field'=>$field['subfields']['Section_id']];
$Area_id= ['field'=>$field['subfields']['Area_id']];
$Types_id= ['field'=>$field['subfields']['Types_id']];
?>
<div "class"="form-group col-sm-12" "data-entity"="jobnames" "data-init-function"="bpFieldInitChecklistDependencyElement">
        <div class="row">
            <div class="col-sm-12" id="fullDiv_{{$Section_id['field']['name']}}">
            <label for="{{$Section_id['field']['name']}}" class="form-label">{{$Section_id['field']['label']}}</label>
            @include(fieldview($Section_id['field']['type']),['field'=>$Section_id['field']])
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" id="fullDiv_{{$Area_id['field']['name']}}">
            <label for="{{$Area_id['field']['name']}}" class="form-label">{{$Area_id['field']['label']}}</label>
            @include(fieldview($Area_id['field']['type']),['field'=>$Area_id['field']])
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" id="fullDiv_{{$Types_id['field']['name']}}">
            <label for="{{$Types_id['field']['name']}}" class="form-label">{{$Types_id['field']['label']}}</label>
            @include(fieldview($Types_id['field']['type']),['field'=>$Types_id['field']])
            </div>
        </div>
</div>
@push('after_styles')
<style>
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 0;
  margin-left: 0;
  margin-bottom: 0;
  font-size: unset;
  color: #212529;
  cursor: auto;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
}
.select2-container--bootstrap-5 .select2-selection--multiple .select2-search .select2-search__field {
    color:#000 !important;
    width:100% !important;
}
</style>
@endpush
@push('after_scripts')
@loadOnce('jobnames')
<script>
    @if(!isset($field['value']))
    disableselect2('Types_id');
    disableselect2('Area_id');
    @endif
    @if(isset($field['value']))
    setold();
    @endif
    function setold(){
        attatchlink('Area_id',{'Section_id':$('select[name^=Section_id]').val()});
        attatchlink('Types_id',{'Area_id':$('select[name^=Area_id]').val()});
    }
    $('select[name^=Section_id]').on("select2:select", function() {
        var value =$(this).val();
        reopenoptions('Area_id');
        attatchlink('Area_id',{'Section_id':value});
    });
    $('select[name^=Area_id]').on("select2:select", function() {
        var value =$(this).val();
        reopenoptions('Types_id');
        attatchlink('Types_id',{'Area_id':value});
    });

    function disableselect2(name,action=true){
        $('select[name^='+name+']').prop('disabled', action);
    }
    function reopenoptions(name){
        disableselect2(name,false);
        removeAllOptions($('select[name^='+name+']')[0]);
    }
    function attatchlink(name,keys){
        var element=$('select[name^='+name+']');
        var link=$(element).attr('data-data-source');
        if(link.includes('?') === false){

            link+='?'+$.param({parents:keys});
        }else{
            link=link.split('?');
            var link=link[0];
            link+='?'+$.param({parents:keys});  
        }
        $(element).attr('data-data-source',link);
        if ($(element).hasClass("select2-hidden-accessible"))
        {
            $(element).select2('destroy')
        }
        bpFieldInitSelect2FromAjax($(element));

    }
</script>
@endLoadOnce
@endpush