<!-- dependencyJson -->
<?php
$language=Str::replace('_', '-', app()->getLocale());
//dd($field['subfields']);
foreach ($field['subfields'] as $key => $value) {
    $field['subfields'][$key]['label']=$value['placeholder'];
}
foreach ($field['subfields'] as $key => $value) {
    //$field['subfields'][$key]['method']='post';
}
$Mosama_JobNames_model = $Amer->getModel();
$Mosama_Groups = ['field'=>$field['subfields']['Mosama_Groups']];
if(isset($Mosama_Groups['field']['multiple'])){
    unset($Mosama_Groups['field']['multiple']);
}
$Mosama_Competencies = ['field'=>$field['subfields']['Mosama_Competencies']];
$Mosama_Connections = ['field'=>$field['subfields']['Mosama_Connections']];
$Mosama_Educations = ['field'=>$field['subfields']['Mosama_Educations']];
$Mosama_Goals = ['field'=>$field['subfields']['Mosama_Goals']];
$Mosama_Managers = ['field'=>$field['subfields']['Mosama_Managers']];
$Mosama_OrgStruses = ['field'=>$field['subfields']['Mosama_OrgStruses']];
$Mosama_Tasks = ['field'=>$field['subfields']['Mosama_Tasks']];
$Mosama_Skills = ['field'=>$field['subfields']['Mosama_Skills']];
if(isset($field['value'])){
    if(count($field['value'][0])){
        $field['subfields']['Mosama_Groups']['value']=$field['value'][0][0];    
    }
    $field['subfields']['Mosama_Competencies']['value']=$field['value'][1];
    $field['subfields']['Mosama_Connections']['value']=$field['value'][2];
    $field['subfields']['Mosama_Educations']['value']=$field['value'][3];
    $field['subfields']['Mosama_Goals']['value']=$field['value'][4];
    $field['subfields']['Mosama_Managers']['value']=$field['value'][5];
    $field['subfields']['Mosama_OrgStruses']['value']=$field['value'][6];
    $field['subfields']['Mosama_Tasks']['value']=$field['value'][7];
    $field['subfields']['Mosama_Skills']['value']=$field['value'][8];
}
$loops=[$Mosama_Groups,$Mosama_Competencies,$Mosama_Connections,$Mosama_Educations,$Mosama_Goals,];
?>
<div "class"="form-group col-sm-12" "data-entity"="jobnames" "data-init-function"="bpFieldInitChecklistDependencyElement">
    @foreach($field['subfields'] as $field)
        <div class="row">
            <div class="col-sm-12" id="fullDiv_{{$field['name']}}">
            <label for="{{$field['name']}}" class="form-label">{{$field['label']}}</label>
            @include(fieldview($field['type']),['field'=>$field])
            </div>
        </div>
    @endforeach
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
    disableselect2('Mosama_Competencies');
    disableselect2('Mosama_Connections');
    disableselect2('Mosama_Educations');
    disableselect2('Mosama_Goals');
    disableselect2('Mosama_Managers');
    disableselect2('Mosama_OrgStruses');
    disableselect2('Mosama_Skills');
    disableselect2('Mosama_Tasks');
    @else
    var selects=['Mosama_Competencies','Mosama_Connections','Mosama_Educations','Mosama_Goals','Mosama_Managers','Mosama_OrgStruses','Mosama_Skills','Mosama_Tasks'];
    $.each(selects,function(key,element){
            attatchlink(element,{'Mosama_Groups':$('select[name^=Mosama_Groups]').val()});
        });
    @endif
    $('select[name^=Mosama_Groups]').on("select2:select", function(event) {
        var selects=['Mosama_Competencies','Mosama_Connections','Mosama_Educations','Mosama_Goals','Mosama_Managers','Mosama_OrgStruses','Mosama_Skills','Mosama_Tasks'];
        var value = $(event.currentTarget).find("option:selected").val();
        $.each(selects,function(key,element){
            disableselect2(element);
            reopenoptions(element);
            attatchlink(element,{'Mosama_Groups':value});
        });
        
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