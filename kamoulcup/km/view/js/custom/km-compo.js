$( document ).ready(function() {
    
    $('#closeBtn').click(function() {
        $("#compoPopup").removeClass("show").addClass("hide");
    });
});

function loadCompo(uri){
    // AJAX request compo
        $("#compoPopup").removeClass("hide").addClass("show");
        clearCompo();
        $.getJSON(uri).done(function(data) {
            fillCompo(data);
        });
}

function clearCompo() {
    $('#dayScores h2 span').text('');
    $('#compo').find('.compoPlayer').remove();
    $('#bench').find('.benchPlayer').remove();
    $('#bench h2').text('');
}

function fillCompo(data) {
    // Titre
    $('#dayScores h2 span:first').text(data.journee);
	$('#dayScores h2 span:last').text(data.score.toFixed(2));
    // Titulaires
    if (data.gardiens.length>0) {
        $('#compo').append(buildCompoPlayerDiv(data.gardiens[0],'G0'));
    }
    if (data.defenseurs.length>0) {
        $('#compo').append(buildCompoPlayerDiv(data.defenseurs[0],'D0'));
    }
    if (data.defenseurs.length>1) {
        $('#compo').append(buildCompoPlayerDiv(data.defenseurs[1],'D1'));
    }
    if (data.milieux.length>0) {
        $('#compo').append(buildCompoPlayerDiv(data.milieux[0],'M0'));
    }
    if (data.milieux.length>1) {
        $('#compo').append(buildCompoPlayerDiv(data.milieux[1],'M1'));
    }
    if (data.attaquants.length>0) {
        $('#compo').append(buildCompoPlayerDiv(data.attaquants[0],'A0'));
    }
    if (data.attaquants.length>1) {
        $('#compo').append(buildCompoPlayerDiv(data.attaquants[1],'A1'));
    }
    // Banc
    if (data.remplacants.length>0) {
         $('#bench h2').text('Non retenus :');
    data.remplacants.forEach(function(entry) {
        $('#bench ul').append(buildBenchPlayerLi(entry));
    });
    }
    
}

function buildCompoPlayerDiv($player,$targetSpot) {
    $div = '<div id="compo'+$targetSpot+'" class="compoPlayer">';
    if ($player.swappedIn === true) {
        $div = $div+'<div class="actionCompoPlayer"><i class="fa fa-level-up fa-2x"></i>'+$player.swaptime+'\'</div>'
    }
    $div=$div+'<p>'+$player.nom+'</p><p><i class="fa fa-trophy"></i> '+$player.score.toFixed(2)+' Pts</p></div>';
    return $div;
}

function buildBenchPlayerLi($player) {
    $li = '<li class="benchPlayer">';
    if ($player.swappedOut === true) {
        $li = $li+'<div class="actionCompoPlayer"><i class="fa fa-level-down"></i></div>'
    }
    return $li+'<p>'+$player.nom+'</p><p><i class="fa fa-trophy"></i> '+$player.score.toFixed(2)+' Pts</p></li>';
}