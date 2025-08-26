<!-- dependencyJson -->
<?php
$language=Str::replace('_', '-', app()->getLocale());
foreach ($field['subfields'] as $key => $value) {
    $field['subfields'][$key]['label']=$value['placeholder'];
}
if(isset($field['value'])){
    $field['subfields']['Regulations']['value']=$field['value'][0];
    $field['subfields']['father']['value']=$field['value'][1];
}
$model = $Amer->getModel();
$Regulations = ['field'=>$field['subfields']['Regulations']];
$father= ['field'=>$field['subfields']['father']];
?>
<div "class"="form-group col-sm-12" "data-entity"="jobnames" "data-init-function"="bpFieldInitChecklistDependencyElement">
        <div class="row">
            <div class="col-sm-12" id="fullDiv_{{$Regulations['field']['name']}}">
            <label for="{{$Regulations['field']['name']}}" class="form-label">{{$Regulations['field']['label']}}</label>
            @include(fieldview($Regulations['field']['type']),['field'=>$Regulations['field']])
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" id="fullDiv_{{$father['field']['name']}}">
            <label for="{{$father['field']['name']}}" class="form-label">{{$father['field']['label']}}</label>
            @include(fieldview($father['field']['type']),['field'=>$father['field']])
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
    disableselect2('father');
    @endif
    @if(isset($field['value']))
    setold();
    @endif
    function setold(){
        attatchlink('father',{'Regulations':$('select[name^=Regulations]').val()});
    }
    $('select[name^=Regulations]').on("select2:select", function() {
        var value =$(this).val();
        reopenoptions('father');
        attatchlink('father',{'Regulations':value});
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