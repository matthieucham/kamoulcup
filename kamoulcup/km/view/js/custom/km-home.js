$( document ).ready(function() {
  
    $('#news li a[linkCompo]').click(function (){
        var compoReq = $(this).attr('linkCompo');
        loadCompo(compoReq);
    });
});