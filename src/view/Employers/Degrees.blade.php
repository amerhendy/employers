<!-- dependencyJson -->
<?php
$language=Str::replace('_', '-', app()->getLocale());
if(isset($field['value'])){
    $field['subfields']['Mosama_Groups']['value']=$field['value'][0];
    $field['subfields']['Mosama_Experiences']['value']=$field['value'][1];
}

$model = $Amer->getModel();
$Mosama_Groups = ['field'=>$field['subfields']['Mosama_Groups']];
$Mosama_Experiences= ['field'=>$field['subfields']['Mosama_Experiences']];
?>
<div "class"="form-group col-sm-12" "data-entity"="jobnames" "data-init-function"="bpFieldInitChecklistDependencyElement">
    <div class="row">
        <div class="col-sm-6" id="fullDiv_Mosama_Groups">
            @include(fieldview('select2_from_ajax'),$Mosama_Groups)
        </div>
        <div class="col-sm-6"  id="fullDiv_Mosama_Experiences">
            @include(fieldview('select2_from_ajax'),$Mosama_Experiences)
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
    disableselect2('Mosama_Experiences');
    @endif
    $('select[name^=Mosama_Groups]').on("select2:select", function() {
        var value =$(this).val();
        reopenoptions('Mosama_Experiences');
        attatchlink('Mosama_Experiences',{'Mosama_Groups':value});
    });
    @if(isset($field['value']))
    setold();
    @endif
    function setold(){
        attatchlink('Mosama_Experiences',{'Mosama_Groups':$('select[name^=Mosama_Groups]').val()});
        
    }
    function disableselect2(name,action=true){
        $('select[name^='+name+']').prop('disabled', action);
    }
    function reopenoptions(name){
        disableselect2(name,false);
        removeAllOptions(document.getElementsByName(name+'[]')[0]);
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