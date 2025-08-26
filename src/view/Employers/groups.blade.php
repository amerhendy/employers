<!-- dependencyJson -->
<?php
$language=Str::replace('_', '-', app()->getLocale());
foreach ($field['subfields'] as $key => $value) {
    $field['subfields'][$key]['label']=$value['placeholder'];
}
$Mosama_JobNames_model = $Amer->getModel();
if(isset($field['value'])){
    $field['subfields']['Mosama_Competencies']['value']=$field['value'][0];
    $field['subfields']['Mosama_Connections']['value']=$field['value'][1];
    $field['subfields']['Mosama_Degrees']['value']=$field['value'][2];
    $field['subfields']['Mosama_DirectManagers']['value']=$field['value'][3];
    $field['subfields']['Mosama_Educations']['value']=$field['value'][4];
    $field['subfields']['Mosama_Experiences']['value']=$field['value'][5];
    $field['subfields']['Mosama_Goals']['value']=$field['value'][6];
    $field['subfields']['Mosama_Managers']['value']=$field['value'][7];
    $field['subfields']['Mosama_OrgStruses']['value']=$field['value'][8];
    $field['subfields']['Mosama_Skills']['value']=$field['value'][9];
    $field['subfields']['Mosama_Tasks']['value']=$field['value'][10];
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
</script>
@endLoadOnce
@endpush