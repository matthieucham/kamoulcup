$( document ).ready(function() {
  
    $('#teamsRanking table a').click(function (){
        var compoReq = $(this).attr('linkCompo');
        loadCompo(compoReq);
    });
    
    $("a[roundRanking]").click(function (){
        $("div#teamsRanking").empty();
        var roundId = $(this).attr('roundRanking');
        var uri='../api/html/teamsRanking.php?roundid='+roundId;
        
        $.get(uri).done(function(output) {
            $("div#teamsRanking").append(output);
            $('#teamsRanking table a').click(function (){
                var compoReq = $(this).attr('linkCompo');
                loadCompo(compoReq);
            });
        });
        
        $("div#playersRanking").empty();
        var roundId = $(this).attr('roundRanking');
        var uri='../api/html/playersRanking.php?roundid='+roundId;
        
        $.get(uri).done(function(output) {
            $("div#playersRanking").append(output);
        });
    });
});