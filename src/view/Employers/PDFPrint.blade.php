<?php
//dd($data);
$data->Mosama_OrgStruses[3]=new \stdClass;
$data->Mosama_OrgStruses[3]->id=23323;
$data->Mosama_OrgStruses[3]->text=23323;
$data->Mosama_OrgStruses[3]->type=1;
$data->Mosama_OrgStruses[4]=new \stdClass;
$data->Mosama_OrgStruses[4]->id=23323;
$data->Mosama_OrgStruses[4]->text=23323;
$data->Mosama_OrgStruses[4]->type=1;
$Mosama_Managers=$data->Mosama_Managers->implode('text','.<br>');
if(!function_exists('getconn')){
    function getconn($data,$t){
        $res= $data->Mosama_Connections->filter(function($v,$k) use($t){
                return $v->type == $t;
            });
        return $res->implode('text','</li><li>');
    }
}
if(!function_exists('Mosama_Tasks')){
    function Mosama_Tasks($data,$t){
        $res= $data->Mosama_Tasks->filter(function($v,$k) use($t){
                return $v->type == $t;
            });
            if(count($res)){return $res->implode('text','</li><li>');}
        return false;
    }
}
//dd(getconn($data,'in'));
if(!function_exists('getorg')){
    function getorg($data,$t){
        $res= $data->Mosama_OrgStruses->filter(function($v,$k) use($t){
                return $v->type == $t;
            });
        return $res->implode('text','.<br>');
    }
}
if(!function_exists('gettext')){
    function gettext($t,$f=null,$pre=null){
        $tr=__('EMPLANG::Mosama.print');
        if(!isset($tr[$t])){
            $tex=$t;
        }else{
            $tex=$tr[$t];
        }
        if($f){$tex=$tex." ".$f;}
        if($pre){$tex=$pre." ".$tex;}
        return $tex;
    }
}
?><table>
    <thead>
        <tr>
            <th  class="loHightTd w190 scopeRow">{{gettext('title')}}<br>{{ $data->text}}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_JobTitles',':')}}</th>
            <td class="fullright w65">{{ $data->jobtitle_id->text}}</td>
            <th class="w30 title scopeCol">{{gettext('Mosama_Groups',':')}}</th>
            <td class="fullright w65">{{ $data->jobtitle_id->text}}</td>
        </tr>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Degrees',':')}}</th>
            <td class="fullright w65">{{ $data->jobtitle_id->text}}</td>
            <th class="w30 title scopeCol">{{gettext('directMosama_Managers',':')}}</th>
            <td class="fullright w65">{!! $Mosama_Managers !!}</td>
        </tr>
        @if(getorg($data,1))
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_OrgStru_1',':')}}</th>
            <td class="fullright w160">{!! getorg($data,1) !!}</td>
        </tr>
        @endif
        @if(getorg($data,2))
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_OrgStru_2',':')}}</th>
            <td class="fullright w160">{!! getorg($data,2) !!}</td>
        </tr>
        @endif
        @if(getorg($data,4))
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_OrgStru_4',':')}}</th>
            <td class="fullright w160">{!! getorg($data,4) !!}</td>
        </tr>
        @endif
        @if(count($data->Mosama_Goals))
        <tr>
            <th  class="loHightTd w190 scopeRow">{{gettext('BreifJob')}}</th>
        </tr>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Goals',':')}}</th>
            <td class="fullright w160"><ol><li>{!! $data->Mosama_Goals->implode('text','</li><li>') !!}</li></ol></td>
        </tr>
        @endif
        <tr>
            <th  class="loHightTd w190 scopeRow">{{gettext('Mosama_Connections')}}</th>
        </tr>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Connections_in',':')}}</th>
            <td class="fullright w160"><ol><li>{!! getconn($data,'in') !!}</li></ol></td>
        </tr>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Connections_out',':')}}</th>
            <td class="fullright w160"><ol><li>{!! getconn($data,'out') !!}</li></ol></td>
        </tr>
        @if(Mosama_Tasks($data,'fatherof'))
        <tr>
            <th class="w30 title scopeCol">{{gettext('fatherofCom',':')}}</th>
            <td class="fullright w160"><ol><li>{!! Mosama_Tasks($data,'fatherof') !!}</li></ol></td>
        </tr>
        @endif
        <tr>
            <th  class="loHightTd w190 scopeRow">{{gettext('Mosama_Tasks')}}</th>
        </tr>
        @if(Mosama_Tasks($data,'eshraf'))
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Tasks_eshraf',':')}}</th>
            <td class="fullright w160"><ol><li>{!! Mosama_Tasks($data,'eshraf') !!}</li></ol></td>
        </tr>
        @endif
        @if(Mosama_Tasks($data,'wazifia'))
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Tasks_wazifia',':')}}</th>
            <td class="fullright w160"><ol><li>{!! Mosama_Tasks($data,'wazifia') !!}</li></ol></td>
        </tr>
        @endif
        @if(Mosama_Tasks($data,'tanfiz'))
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Tasks_tanfiz',':')}}</th>
            <td class="fullright w160"><ol><li>{!! Mosama_Tasks($data,'tanfiz') !!}</li></ol></td>
        </tr>
        @endif
        <tr>
            <th  class="loHightTd w190 scopeRow">{{gettext('jobwnt')}}</th>
        </tr>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Competencies',':')}}</th>
            <td class="fullright w160">{!! $data->Mosama_Competencies->implode('text',' - ') !!}</td>
        </tr>
        <tr>
            <th  class="loHightTd w190 scopeRow">{{gettext('shroot')}}</th>
        </tr>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Educations',':')}}</th>
            <td class="fullright w160">{!! $data->Mosama_Educations->implode('text',' - ') !!}</td>
        </tr>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Experiences',':')}}</th>
            <td class="fullright w160">{!! $data->Mosama_Experiences->implode('text',' - ') !!}</td>
        </tr>
        <tr>
            <th class="w30 title scopeCol">{{gettext('Mosama_Skills',':')}}</th>
            <td class="fullright w160">{!! $data->Mosama_Skills->implode('text',' - ') !!}</td>
        </tr>
    </tbody>
</table>

