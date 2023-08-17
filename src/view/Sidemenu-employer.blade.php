    <button class="btn btn-toggle align-items-center list-group-item-action rounded" data-bs-toggle="collapse" data-bs-target="#mosamiat-collapse" aria-expanded="false">
        <i class="fas fa-address-card"></i>المسميات الوظيفية
    </button>

    <div class="collapse list-group list-group-flush" id="mosamiat-collapse" style="">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <button class="btn btn-toggle align-items-center list-group-item-action rounded" data-bs-toggle="collapse" data-bs-target="#basemosamiat-collapse" aria-expanded="false">
                <i class="fas fa-sitemap"></i>الاضافات الاساسية
                </button>
                <div class="collapse list-group list-group-flush" id="basemosamiat-collapse" style="">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <!-- {{Amerurl('Mosama_Goals')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Goals')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Goals.Mosama_Goals')}}</a></li>
                        <!-- {{Amerurl('Mosama_Competencies')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Competencies')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Competencies.Mosama_Competencies')}}</a></li>
                        <!-- {{Amerurl('Mosama_Connections')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Connections')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Connections.Mosama_Connections')}}</a></li>
                        <!-- {{Amerurl('Mosama_Degrees')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Degrees')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Degrees.Mosama_Degrees')}}</a></li>
                        <!-- {{Amerurl('Mosama_Educations')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Educations')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Educations.Mosama_Educations')}}</a></li>
                        <!-- {{Amerurl('Mosama_Experiences')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Experiences')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Experiences.Mosama_Experiences')}}</a></li>
                        <!-- {{Amerurl('Mosama_Goals')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Goals')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Goals.Mosama_Goals')}}</a></li>
                        <!-- {{Amerurl('Mosama_Managers')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Managers')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Managers.Mosama_Managers')}}</a></li>
                        <!-- {{Amerurl('Mosama_OrgStruses')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_OrgStruses')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_OrgStruses.Mosama_OrgStruses')}}</a></li>
                        <!-- {{Amerurl('Mosama_Skills')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Skills')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Skills.Mosama_Skills')}}</a></li>
                        <!-- {{Amerurl('Mosama_Tasks')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Tasks')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Tasks.Mosama_Tasks')}}</a></li>
                    </ul>
                </div>
            </li>
            <!-- {{Amerurl('Mosama_Groups')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_Groups')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Groups.Mosama_Groups')}}</a></li>
<!-- {{Amerurl('Mosama_JobNames')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_JobNames')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_JobNames.Mosama_JobNames')}}</a></li>
<!-- {{Amerurl('Mosama_JobTitles')}} --><li class="nav-item"><a href="{{Amerurl('Mosama_JobTitles')}}" class="rounded nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_JobTitles.Mosama_JobTitles')}}</a></li>
<!-- {{Amerurl('admin.Mosama.index')}} --><li class="nav-item"><a href="{{route('admin.Mosama.index')}}" class="rounded nav-link"><i class="fa fa-eye" aria-hidden="true"></i>عرض</a></li>
        </ul>
    </div>
</li>
<button class="btn btn-toggle align-items-center list-group-item-action rounded" data-bs-toggle="collapse" data-bs-target="#Orgstrus-collapse" aria-expanded="false">
        <i class="fas fa-address-card"></i>المناطق والقطاعات
    </button>
    <div class="collapse list-group list-group-flush" id="Orgstrus-collapse" style="">
        <!-- {{Amerurl('OrgStru_Types')}} --><a href="{{Amerurl('OrgStru_Types')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::OrgStru_Types.OrgStru_Types')}}</a>
        <!-- {{Amerurl('OrgStru_Sections')}} --><a href="{{Amerurl('OrgStru_Sections')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::OrgStru_Sections.OrgStru_Sections')}}</a>
        <!-- {{Amerurl('OrgStru_Areas')}} --><a href="{{Amerurl('OrgStru_Areas')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::OrgStru_Areas.OrgStru_Areas')}}</a>
        <!-- {{Amerurl('OrgStru_Mahatas')}} --><a href="{{Amerurl('OrgStru_Mahatas')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::OrgStru_Mahatas.OrgStru_Mahatas')}}</a>
    </div>
    <button class="btn btn-toggle align-items-center list-group-item-action rounded" data-bs-toggle="collapse" data-bs-target="#Regulations-collapse" aria-expanded="false">
        <i class="fas fa-address-card"></i>{{trans('EMPLANG::Regulations.Regulations')}}
    </button>
    <div class="collapse list-group list-group-flush" id="Regulations-collapse" style="">
        <!-- {{Amerurl('Regulations')}} --><a href="{{Amerurl('Regulations')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Regulations.Regulations')}}</a>
        <!-- {{Amerurl('Regulations_Topics')}} --><a href="{{Amerurl('Regulations_Topics')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Regulations_Topics.Regulations_Topics')}}</a>
        <!-- {{Amerurl('Regulations_Articles')}} --><a href="{{Amerurl('Regulations_Articles')}}" class="white-text nav-link"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Regulations_Articles.Regulations_Articles')}}</a>
    </div>