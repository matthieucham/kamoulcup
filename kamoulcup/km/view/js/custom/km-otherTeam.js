$( document ).ready(function() {
  
    $('#team_scores li a[linkCompo]').click(function (){
        var compoReq = $(this).attr('linkCompo');
        loadCompo(compoReq);
    });
});