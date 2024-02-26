    <button class="btn btn-toggle align-items-center list-group-item list-group-item-action rounded" data-bs-toggle="collapse" data-bs-target="#mosamiat-collapse" aria-expanded="false">
        <i class="fas fa-address-card"></i>المسميات الوظيفية
    </button>
    <div class="collapse list-group list-group-flush" id="mosamiat-collapse" style="">
        <button class="btn btn-toggle align-items-center list-group-item list-group-item-action rounded" data-bs-toggle="collapse" data-bs-target="#basemosamiat-collapse" aria-expanded="false">
            <i class="fas fa-sitemap"></i>الاضافات الاساسية
        </button>
            <div class="collapse list-group list-group-flush" id="basemosamiat-collapse" style="">
                    <!-- {{Employer_url('Mosama_Goals')}} --><a href="{{Employer_url('Mosama_Goals')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Goals.Mosama_Goals')}}</a>
                        <!-- {{Employer_url('Mosama_Competencies')}} --><a href="{{Employer_url('Mosama_Competencies')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Competencies.Mosama_Competencies')}}</a>
                        <!-- {{Employer_url('Mosama_Connections')}} --><a href="{{Employer_url('Mosama_Connections')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Connections.Mosama_Connections')}}</a>
                        <!-- {{Employer_url('Mosama_Degrees')}} --><a href="{{Employer_url('Mosama_Degrees')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Degrees.Mosama_Degrees')}}</a>
                        <!-- {{Employer_url('Mosama_Educations')}} --><a href="{{Employer_url('Mosama_Educations')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Educations.Mosama_Educations')}}</a>
                        <!-- {{Employer_url('Mosama_Experiences')}} --><a href="{{Employer_url('Mosama_Experiences')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Experiences.Mosama_Experiences')}}</a>

                        <!-- {{Employer_url('Mosama_Managers')}} --><a href="{{Employer_url('Mosama_Managers')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Managers.Mosama_Managers')}}</a>
                        <!-- {{Employer_url('Mosama_OrgStruses')}} --><a href="{{Employer_url('Mosama_OrgStruses')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_OrgStruses.Mosama_OrgStruses')}}</a>
                        <!-- {{Employer_url('Mosama_Skills')}} --><a href="{{Employer_url('Mosama_Skills')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Skills.Mosama_Skills')}}</a>
                        <!-- {{Employer_url('Mosama_Tasks')}} --><a href="{{Employer_url('Mosama_Tasks')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Tasks.Mosama_Tasks')}}</a>
            </div>
            <!-- {{Employer_url('Mosama_Groups')}} --><a href="{{Employer_url('Mosama_Groups')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_Groups.Mosama_Groups')}}</a>
<!-- {{Employer_url('Mosama_JobNames')}} --><a href="{{Employer_url('Mosama_JobNames')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_JobNames.Mosama_JobNames')}}</a>
<!-- {{Employer_url('Mosama_JobTitles')}} --><a href="{{Employer_url('Mosama_JobTitles')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Mosama_JobTitles.Mosama_JobTitles')}}</a>
<!-- {{Employer_url('admin.Mosama.index')}} --><a href="{{route('Mosama.index')}}" class="list-group-item list-group-item-action"><i class="fa fa-eye" aria-hidden="true"></i>عرض</a>
    </div>

<button class="btn btn-toggle align-items-center list-group-item list-group-item-action rounded" data-bs-toggle="collapse" data-bs-target="#Orgstrus-collapse" aria-expanded="false">
        <i class="fas fa-address-card"></i>المناطق والقطاعات
    </button>
    <div class="collapse list-group list-group-flush" id="Orgstrus-collapse" style="">
        <!-- {{Employer_url('OrgStru_Types')}} --><a href="{{Employer_url('OrgStru_Types')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::OrgStru_Types.OrgStru_Types')}}</a>
        <!-- {{Employer_url('OrgStru_Sections')}} --><a href="{{Employer_url('OrgStru_Sections')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::OrgStru_Sections.OrgStru_Sections')}}</a>
        <!-- {{Employer_url('OrgStru_Areas')}} --><a href="{{Employer_url('OrgStru_Areas')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::OrgStru_Areas.OrgStru_Areas')}}</a>
        <!-- {{Employer_url('OrgStru_Mahatas')}} --><a href="{{Employer_url('OrgStru_Mahatas')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::OrgStru_Mahatas.OrgStru_Mahatas')}}</a>
    </div>
    <button class="btn btn-toggle align-items-center list-group-item list-group-item-action rounded" data-bs-toggle="collapse" data-bs-target="#Regulations-collapse" aria-expanded="false">
        <i class="fas fa-address-card"></i>{{trans('EMPLANG::Regulations.Regulations')}}
    </button>
    <div class="collapse list-group list-group-flush" id="Regulations-collapse" style="">
        <!-- {{Employer_url('Regulations')}} --><a href="{{Employer_url('Regulations')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Regulations.Regulations')}}</a>
        <!-- {{Employer_url('Regulations_Topics')}} --><a href="{{Employer_url('Regulations_Topics')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Regulations_Topics.Regulations_Topics')}}</a>
        <!-- {{Employer_url('Regulations_Articles')}} --><a href="{{Employer_url('Regulations_Articles')}}" class="list-group-item list-group-item-action"><span class="fab fa-servicestack"></span>{{trans('EMPLANG::Regulations_Articles.Regulations_Articles')}}</a>
    </div>
    <button class="btn btn-toggle align-items-center list-group-item-action rounded list-group-item" data-bs-toggle="collapse" data-bs-target="#CareerPath-collapse" aria-expanded="false">
        <i class="fas fa-user-graduate"></i>{{trans('EMPLANG::Employers_trainings.Employers_trainings')}}
    </button>
    <div class="collapse list-group list-group-flush" id="CareerPath-collapse" style="">
        <!-- {{Employer_url('Employers_trainings')}} --><a href="{{Employer_url('Employers_trainings')}}" class="list-group-item list-group-item-action"><span class="fas fa-user-graduate"></span>{{trans('EMPLANG::Employers_trainings.Employers_trainings')}}</a>
        <!-- {{Employer_url('Employers_CareerPathes')}} --><a href="{{Employer_url('Employers_CareerPathes')}}" class="list-group-item list-group-item-action"><span class="fas fa-laptop-code"></span>{{trans('EMPLANG::Employers_CareerPathes.Employers_CareerPathes')}}</a>
        <!-- {{Employer_url('Employers_CareerPathFiles')}} --><a href="{{Employer_url('Employers_CareerPathFiles')}}" class="list-group-item list-group-item-action"><span class="fas fa-book-open"></span>{{trans('EMPLANG::Employers_CareerPathFiles.Employers_CareerPathFiles')}}</a>
    </div>