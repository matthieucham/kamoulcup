$( document ).ready(function() {
  
    $('#teamsRanking table a').click(function (){
        var compoReq = $(this).attr('linkCompo');
        loadCompo(compoReq);
    });
});