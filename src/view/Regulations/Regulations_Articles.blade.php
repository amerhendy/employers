<!-- dependencyJson -->
<?php
$language=Str::replace('_', '-', app()->getLocale());
foreach ($field['subfields'] as $key => $value) {
    $field['subfields'][$key]['label']=$value['placeholder'];
}
if(isset($field['value'])){
    $field['subfields']['Regulation_id']['value']=$field['value'][0];
    $field['subfields']['Regulations_Topics']['value']=$field['value'][1];
    
}
$model = $Amer->getModel();
$Regulation_id = ['field'=>$field['subfields']['Regulation_id']];
$Regulations_Topics = ['field'=>$field['subfields']['Regulations_Topics']];
?>
<div "class"="form-group col-sm-12" "data-entity"="jobnames" "data-init-function"="bpFieldInitChecklistDependencyElement">
<div class="row">
            <div class="col-sm-12" id="fullDiv_{{$Regulation_id['field']['name']}}">
            <label for="{{$Regulation_id['field']['name']}}" class="form-label">{{$Regulation_id['field']['label']}}</label>
            @include(fieldview($Regulation_id['field']['type']),['field'=>$Regulation_id['field']])
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" id="fullDiv_{{$Regulations_Topics['field']['name']}}">
            <label for="{{$Regulations_Topics['field']['name']}}" class="form-label">{{$Regulations_Topics['field']['label']}}</label>
            @include(fieldview($Regulations_Topics['field']['type']),['field'=>$Regulations_Topics['field']])
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
    disableselect2('Regulations_Topics');
    @endif
    @if(isset($field['value']))
    setold();
    @endif
    function setold(){
        attatchlink('Regulations_Topics',{'Regulations':$('select[name^=Regulation_id]').val()});
    }
    $('select[name=Regulation_id]').on("select2:select", function() {
        var value =$(this).val();
        dd($(this));
        reopenoptions('Regulations_Topics');
        attatchlink('Regulations_Topics',{'Regulations':value});
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
            bpFieldInitSelect2FromAjax($(element));
        }
        

    }
</script>
@endLoadOnce
@endpush