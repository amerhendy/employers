@extends(Baseview('blank'))
<style>
    iframe {
  border: 1px solid black;
  width: 100%; /* takes precedence over the width set with the HTML width attribute */
  height: 100%;
}
</style>
@section('content')
@endsection
@push('after_scripts')
@loadScriptOnce('js/jquery/jquery-3.6.0.min.js')
@loadScriptOnce('js/packages/jquery-ui-1.14.0.custom/jquery-ui.min.js')
<script>
    const PDFDD=`{{$pdf}}`;
    var file= new Blob([PDFDD],{type:'application/pdf'});
    //var st=PDFDD.split(';\r\n');
    var st=PDFDD.split('.pdf&quot;');
    var st=st[2].split('\r\n\r\n');
    console.log(st);

                    var iframe= document.createElement('iframe');
                    $(iframe).attr('style','top:0; left:0; bottom:0; right:0; width:100%; height:30cm; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;');
                    $('body').html(iframe);
                    iframe.src="data:application/pdf;base64,"+st[0]
</script>
@endpush
