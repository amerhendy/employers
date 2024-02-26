@extends(Baseview('app'))
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
    <link href="{{asset('js/packages/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('js/packages/select2-bootstrap-theme/dist/select2-bootstrap-5-theme.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
@if(Auth::guard('Employers')->user())
        <div class="row">
            <div class="col-sm-1">الاسم</div>
            <div class="col-sm-3">{{$user->fullname}}</div>
            <div class="col-sm-1">الرقم الوظيفى</div>
            <div class="col-sm-3">{{$user->uid}}</div>
            <div class="col-sm-1">الرقم القومى</div>
            <div class="col-sm-3">{{$user->nid}}</div>
    </div>
    <div class="row">
            <div class="col-sm-1">الوظيفة</div>
            <div class="col-sm-11">{{$user['JobName'][0]->text ?? ''}}</div>
            <div class="col-sm-1">موقف العمل</div>
            <div class="col-sm-3"></div>
    </div>
    <div class="row">
        @php
            //dd($user['JobName'][0]->id);
        @endphp
        <div class="col-sm-2">
                <a href="{{route('Mosama_print.index')}}" target="_blank"  onclick="event.preventDefault();document.getElementById('Mosama_print-form').submit();">
                الوصف الوظيفى</a>
                <form id="Mosama_print-form" action="{{ route('Mosama_print.index') }}" method="POST" style="display: none;"  target="_blank">
                                        @csrf
                                        <input type="text" name="jobnameselect[]" value="{{$user['JobName'][0]->id}}">
                </form>
        </div>
        @if(isset($user['trainings']))
        <div class="col-sm-2">
            <span class="btn btn-primary btn-sm " id="app_pro" role="button"  data-bs-toggle="modal" data-bs-target="#exampleModal">{{trans("EMPLANG::Employers_CareerPathes.Employers_CareerPathes")}}</span>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{trans("EMPLANG::Employers_CareerPathes.Employers_CareerPathes")}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                <?php
                                $trainings=$user['trainings']->toArray();
                                //dd($trainings[0]);
                                ?>
                                @foreach($trainings  as $a=>$b)
                                @if($b['TestDate'] !== null)
                                                    @if($b['TestDate'][2] == 'past')
                                                    @break
                                                    @endif
                                    @endif
                                <div class="my-1 p-1 bg-body rounded shadow-sm">
                                    <div class="row border rounded">
                                        <div class="col-sm-2">{{trans('EMPLANG::Employers_trainings.Year')}}</div>
                                        <div class="col-sm-1">{{$b['Year']}}</div>
                                        <div class="col-sm-1">{{trans('EMPLANG::Employers_trainings.Stage')}}</div>
                                        <div class="col-sm-1">{{$b['Stage']}} </div>
                                        <div class="col-sm-2">{{trans('EMPLANG::Employers_CareerPathes.Employers_CareerPathes')}}</div>
                                        <div class="col-sm-5">{{$b['CareerPath_id']}}</div>
                                        <div class="col-sm-2">{{trans('EMPLANG::Mosama_JobNames.singular')}}</div>
                                        <div class="col-sm-10">
                                            {{trans('EMPLANG::Mosama_JobTitles.singular')}}:{{$b['JobNames_id']['Mosama_JobTitles']}} - 
                                            {{trans('EMPLANG::Mosama_Degrees.singular')}}:{{$b['JobNames_id']['Mosama_Degrees']}} - 
                                            {{trans('EMPLANG::Mosama_Groups.singular')}}:{{$b['JobNames_id']['Mosama_Groups']}} 
                                        </div>
                                    </div>
                                    <div class="row border rounded">
                                        <div class="col-sm-2">{{trans('EMPLANG::Employers_trainings.TrainningTime')}}
                                            @if(isset($b['TrainningStatus']))
                                            <br>
                                            <span class="badge 
                                                    @if($b['TrainningStatus'] == 'past')
                                                    bg-success
                                                    @elseif($b['TrainningStatus'] == 'future')
                                                    bg-info
                                                    @else
                                                    bg-warning
                                                    @endif
                                                    ">
                                                    {{trans('EMPLANG::Employers_trainings.TrainningDateStatus.'.$b['TrainningStatus'])}}
                                                </span>
                                            @endif
                                        
                                        </div>
                                        <div class="col-sm-4">{{$b['TrainningTimeStart'][1]}} </div>
                                        <div class="col-sm-1">{{trans('EMPLANG::Employers_trainings.to')}}</div>
                                        <div class="col-sm-5">{{$b['TrainningTimeEnd'][1]}} </div>
                                        </div>
                                    <div class="row border rounded">
                                        <div class="col-sm-2">{{trans('EMPLANG::Employers_trainings.Trainer')}}</div>
                                        <div class="col-sm-3">
                                            @if($b['Trainer'] == null)
                                            {{trans('EMPLANG::Employers_trainings.notSelectedYet')}}
                                            @else
                                                {{$b['Trainer']}}
                                            @endif
                                        </div>
                                        <div class="col-sm-3">{{trans('EMPLANG::Employers_trainings.TrainningLink')}}</div>
                                        <div class="col-sm-4">
                                            @if($b['TrainningLink'] == null)
                                            {{trans('EMPLANG::Employers_trainings.notSelectedYet')}}
                                            @else
                                                <a href="{{$b['TrainningLink']}}" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row border rounded">
                                        <div class="col-sm-3">{{trans('EMPLANG::Employers_CareerPathFiles.Employers_CareerPathFiles')}}</div>
                                        <div class="col-sm-9">
                                            @if($b['Files'] == null)
                                            {{trans('EMPLANG::Employers_trainings.notSelectedYet')}}
                                            @else
                                                @foreach($b['Files'] as $file)
                                                    <a href="{{$file['Link']}}" target="_blank"><i class="fa fa-link" aria-hidden="true"></i>{{$file['Text']}}</a>
                                                @endforeach
                                                
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row border rounded">
                                        <div class="col-sm-2">{{trans('EMPLANG::Employers_trainings.TestDate')}}</div>
                                        <div class="col-sm-10">
                                            @if($b['TestDate'] == null)
                                            {{trans('EMPLANG::Employers_trainings.notSelectedYet')}}
                                            @else
                                            <span class="badge 
                                                    @if($b['TestDate'][2] == 'past')
                                                    bg-success
                                                    @elseif($b['TestDate'][2] == 'future')
                                                    bg-info
                                                    @else
                                                    bg-warning
                                                    @endif
                                                    ">
                                                    {{trans('EMPLANG::Employers_trainings.TestDateStatus.'.$b['TestDate'][2])}}
                                                </span>
                                                {{$b['TestDate'][1]}}
                                            @endif
                                        </div>
                                        <?php
                                        //dd($b['TestDate'][2]);
                                        ?>
                                    </div><hr>
                                    </div>
    
                                @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans('JOBLANG::apply.close')}}</button>
                                <button type="submit" class="btn btn-primary" method="POST" id="savechanges" style="display: none;">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(count($Regulations))
        <div class="col-sm-3">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item me-3 me-lg-0 dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="Regulations" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bank"></i>لوائح العمل
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="Regulations">
                        @foreach($Regulations as $Regulation)
                        <li>
                            <a class="dropdown-item" href="{{route('Regulations')}}"  target="_blank"  onclick="event.preventDefault();document.getElementById('Regulations-{{$Regulation['id']}}-form').submit();">{{$Regulation['text']}}<i class="fa fa-group"></i></a>
                            <form id="Regulations-{{$Regulation['id']}}-form" action="{{ route('Regulations') }}" method="POST" style="display: none;"  target="_blank">
                                        @csrf
                                        <input type="text" name="Regulationid" value="{{$Regulation['id']}}">
                                    </form>
                        </li>
                        @endforeach
                    </ul>
                    
                </li>
            </ul>
        </div>
        @endif                        
        </div>        
@endif
@endsection
@if(isset($user['trainings']))
@loadOnce("trainings")
@push('after_scripts')
<script>
    let Usertr={{ Illuminate\Support\Js::from($user['trainings']) }};
</script>
@endpush
@endLoadOnce
@endif