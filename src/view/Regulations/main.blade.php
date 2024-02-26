@extends(Baseview('app'))
@push('header')
@endpush
@section('content')
<header class="flex-wrap justify-content-center"  id="main">
      <div class="row">
        <div class="col-sm btn btn-sm btn-primary" type="button" id="openNav">الفهرس</div>
        <div class="col-sm btn btn-sm btn-primary" type="button" id="openSearch">بحث</div>
        <div class="col-sm btn btn-sm btn-primary" type="button" id="openmoadSearch">اختر مادة للعرض</div>
        <div class="col-sm btn btn-sm btn-primary closebtn" id="closebtn" type="button">اغلاق</div>
        <div onclick="PrintElem('all');" class="col-sm btn btn-sm btn-primary" id="print" type="button"><i class="fa fa-print" aria-hidden="true"></i></div>
      </div>
    </header>
    <main>
  <div id="mySidepanel" class="sidepanel" style="">
    <div>
      <ul class="list-group">
      <li role="link" class="list-group-item" style="" onclick="seemada(['frontpage'],'single');">الرئيسية</li>
      <li class="list-group-item" style="  margin:0px;padding-top:0px;padding-bottom:0px"></li>
      </ul>
  </div>
  </div>
    <div id="myOverlay" class="overlay">
      <div class="overlay-content">
        <div id="searchbyword" style=""><input type="text" placeholder="بحث ...." class="form-control" id="myInput" data-onkeyup="filterFunction"><div>
          <ul class="list-group"  id="searchresult"></ul>
        </div></div>
        <div id="searchbymoad" style=""><div id='searchselectdiv'></div><button class="btn btn-primary px-4 rounded-pill" type="button" onclick="seemadabysearch()">عرض</button></div>
      </div>
    </div>
    
  <div class="container-fluid my-5 border" id="frontpage" style="">
    <div class="row text-center p-5">
      <div class="col-sm"><h1 class="text-body-emphasis">{{$data[0]['text']}}</h1></div>
      <div class="col-sm"><h3>الشركة القابضة<br> لمياه الشرب والصرف الصحى </h3></div>
      <div class="col-sm">
        <em>
          حقوق التأليف والطباعة والنسخ للشركة القابضة لمياه الشرب والصرف الصحى
          <br>
          حقوق البرمجة والتصميم لشركة مياه الشرب والصرف الصحى بشمال وجنوب سيناء
        </em>
      </div>
    </div>
  </div>
  <div class="row container-fluid" id="madashows">
  </div>
</main>
@endsection
@push('after_styles')
<style>
  @media print{
            header,#main,.sidepanel,.myOverlay,audio,audio{
            display:none !important;
            }
            .bg-body-tertiary{
            background-color: white !important;
            }
            table,thead,tr,td,th,tbody,tfooter{
                border:1px solid black !important;
            }
            #ReadMada{
                color:back !important;
            }
        }
</style>
@endpush
@push('after_scripts')
<script>
    $parent=$('#main-navbar').parent();
    $($parent).hide();
    child=$($parent).parent().children();
    col=$(child)[1];
    $(col).attr('class','col-sm-12');
    const mainlink="{{Route('RegulationsCollection')}}";
    const Regulation_id="{{$data[0]['id']}}";
</script>
@loadScriptOnce('js/fawzy.js');
@endpush