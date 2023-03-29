jQuery(function() {
    var scores = Array();
    function setScore(pool, team1, team2, score1, score2){
        event.preventDefault();
        var idj = findGetParameter('IDJ');
        $.ajax({
            url: "./index.php?page=saisirscore",
            type: "GET",
            data: {
                IDJ: idj,
                poule: pool,
                equipe1: team1,
                equipe2: team2,
                score1: score1,
                score2: score2
            },
            success: function (data) {
                // write in log
                console.log(data);
            }
        });
    }
    // if button is of id submitScore
    $('#ModifS7').click(function () {
        // for each pool
        for (var pool in scores) {  
            // for each two teams
            for (var teams in scores[pool]) {
                // get the two scores
                var score1 = scores[pool][teams][0];
                var score2 = scores[pool][teams][1];
                // get the two teams
                var team1 = teams.split("-")[0];
                var team2 = teams.split("-")[1];
                // set the score
                setScore(pool, team1, team2, score1, score2);
            }
        }
        let tounamentName = findGetParameter('NomT');
        alert("Score modifié avec succés");
        window.location.href = "index.php?page=listetournoi&nom=" + tounamentName + "&message=Score modifié avec succés";
    });
    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;
    }
    $('table').on('dblclick', 'td', function () {
        // if the td of class score 
        if ($(this).hasClass('score')) {
            var td = $(this);
            var tdSibling = td.siblings('.score');
            // make td editable
            var td = $(this);
            var tdSibling = td.siblings('.score');
            var score = td.text();
            var anotherScore = tdSibling.text();
            var input = $('<input />', {
                type: 'number',
                min: 0,
                max: 999,
                value: (score == "TBD") ? 0 : score,
                style: 'width: 60%; height: 100%; text-align: center; font-weight: bold; border: none; background-color: transparent; padding: 0; margin: 0; outline: none; color: white;'
            });
            // change the color of the text of tdSibling
            tdSibling.css("color", "white");
            // change the value if the other td is TBD
            if (anotherScore == "TBD") {
                anotherScore = 0;
                tdSibling.text(anotherScore);
            }
            td.html(input);
            input.focus();
            input.select();
            // on blur or enter key is pressed
            input.on('blur keydown', function (e) {
                // if enter key is pressed
                if (e.which == 13 || e.type == "blur") {
                    var val = input.val();
                    if (isNaN(val)) {
                        val = 0;
                    } else if (val < 0) {
                        val = 0;
                    } else if (val > 999) {
                        val = 999;
                    }// null is not allowed and will be replaced by 0
                    else if (val == null || val == "") {
                        val = 0;
                    }// zero at the beginning is not allowed and will be replaced by 0
                    else if (val[0] == "0") {
                        val = 0;
                    }// if value contais space, replace it by 0
                    else if (val.includes(" ")) {
                        val = 0;
                    }else if (val.includes(",")) {
                        val = 0;
                    }else if (val.includes(".")) {
                        val = 0;
                    }
                    input.val(val);
                    td.html(val);
                    // return the color of the other td to normal
                    tdSibling.css("color", "black");
                    // get the parent table of the td
                    var table = td.closest('table');
                    // get the child of the parent table that has the class modifyScore
                    var div = table.find('.modifyScore');
                    var idPool = div.text();
                    // alert the value of the div
                    //alert(div.text());
                    // alert the $_GET['IDJ'] value
                    //alert(findGetParameter('IDJ'));*/
                    //get the id of the two td
                    var idTeam = td.attr('id');
                    var idTeamSibling = tdSibling.attr('id');
                    // put the values idPool, idTeam, idTeamSibling, val and anotherScore in an array
                    // for each pool and each two teams we have two scores val
                    if (typeof scores[idPool] === 'undefined') {
                        scores[idPool] = [];
                    }
                    if (idTeam < idTeamSibling) {
                        scores[idPool][idTeam + "-" + idTeamSibling] = [val, anotherScore];
                    } else {
                        scores[idPool][idTeamSibling + "-" + idTeam] = [anotherScore, val];
                    }
                }
            });
        }
    });
})