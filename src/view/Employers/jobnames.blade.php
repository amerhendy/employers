<!-- dependencyJson -->
<?php
$language=Str::replace('_', '-', app()->getLocale());
foreach ($field['subfields'] as $key => $value) {
    $field['subfields'][$key]['label']=$value['placeholder'];
}
$Mosama_JobNames_model = $Amer->getModel();
if(isset($field['value'])){ 
    $field['subfields']['Group_id']['value']=$field['value'][0];
    $field['subfields']['JobTitle_id']['value']=$field['value'][1];
    $field['subfields']['Degree_id']['value']=$field['value'][2];
    $field['subfields']['Mosama_Competencies']['value']=$field['value'][4];
    $field['subfields']['Mosama_Experiences']['value']=$field['value'][3];
    $field['subfields']['Mosama_Connections']['value']=$field['value'][5];
    $field['subfields']['Mosama_Educations']['value']=$field['value'][6];
    $field['subfields']['Mosama_Goals']['value']=$field['value'][7];
    $field['subfields']['Mosama_Managers']['value']=$field['value'][8];
    $field['subfields']['Mosama_OrgStruses']['value']=$field['value'][9];
    $field['subfields']['Mosama_Tasks']['value']=$field['value'][11];
    $field['subfields']['Mosama_Skills']['value']=$field['value'][10];
}
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
    var lists=['Mosama_JobTitles', 'Mosama_Degrees','Mosama_Experiences','Mosama_Competencies','Mosama_Connections','Mosama_Educations','Mosama_Goals','Mosama_Managers','Mosama_OrgStruses','Mosama_Skills','Mosama_Tasks'];
    @if(!isset($field['value']))
        $.each(lists,function(key,ele){
            disableselect2(ele);
        });
    @else
    attatchlink('Mosama_JobTitles',{'Group_id':$('select[name^=Mosama_Groups]').val()});
    attatchlink('Mosama_Degrees',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_Experiences',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_Competencies',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_Connections',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_Educations',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_Goals',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_Managers',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_OrgStruses',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_Skills',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    attatchlink('Mosama_Tasks',{'JobTitle_id':$('select[name^=Mosama_JobTitles]').val()});
    @endif
    $('select[name^=Mosama_Groups]').on("select2:select", function() {
        $.each(lists,function(key,ele){
            disableselect2(ele);
            removeAllOptions($('select[name^='+ele+']')[0]);
        });
        var value =$(this).val();
        reopenoptions('Mosama_JobTitles');
        attatchlink('Mosama_JobTitles',{'Group_id':value});
    });
    $('select[name^=Mosama_JobTitles]').on("select2:select", function() {
        var lists=['Mosama_Degrees','Mosama_Experiences','Mosama_Competencies','Mosama_Connections','Mosama_Educations','Mosama_Goals','Mosama_Managers','Mosama_OrgStruses','Mosama_Skills','Mosama_Tasks'];
        var value =$(this).val();
        $.each(lists,function(key,ele){
            removeAllOptions($('select[name^='+ele+']')[0]);
            reopenoptions(ele);
            attatchlink(ele,{'JobTitle_id':value});
        });
        
        
    });
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
    function disableselect2(name,action=true){
        $('select[name^='+name+']').prop('disabled', action);
    }
</script>
@endLoadOnce
@endpush