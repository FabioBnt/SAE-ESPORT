jQuery(function() {
    scores = Array();
function setScore(input1, input2, score1, score2){
    if (input1.value === "" || input2.value === "") {
        score[i].innerHTML = "TBD";
        anotherScore.innerHTML = "TBD";
        // show message that you must enter a numiric value
        alert("Vous devez entrer un nombre");
    } else {
        score1.innerHTML = score1;
        score2.innerHTML = score2;
        // get score id
        let score1Id = score1.parentNode.id;
        let score2Id = score2.parentNode.id;
        // get hidden input class pouleid in the same table
        let poule = score1.parentNode.parentNode().find("input.pouleid").val();
       // $_GET['IDJ] 
        window.$_GET = location.search.substr(1).split("&").reduce((o,i)=>(u=decodeURIComponent,[k,v]=i.split("="),o[u(k)]=v&&u(v),o),{});
        let idj = $_GET['IDJ'];
        let NomT = $_GET['NomT'];
        let JeuT = $_GET['JeuT'];
        $.ajax({
            url: "index.php?page=saisirscore",
            type: "GET",
            data: {
                idj: idj,
                poule: poule,
                equipe1: score1Id,
                equipe2: score2Id,
                score1: score1,
                score2: score2
            },
            success: function (data) {
                console.log(data);
            }
        });
    }
}
/*
// if double click on a score <td class = score>, change it to a text input in the whole row
let score = document.getElementsByClassName("score");
for (var i = 0; i < score.length; i++) {
    score[i].addEventListener("dblclick", function () {
        let anotherScoreIndex = i;
        // if i is even, it's the first score of the row
        if (i % 2 == 0) {
            anotherScoreIndex = i - 1;
            anotherScoreIndex = (anotherScoreIndex < 0) ? 0 : anotherScoreIndex;
        } else {
            anotherScoreIndex = i + 1;
        }
        alert(i);
        let anotherScore = score[anotherScoreIndex];
            
        let input = array();
        input[0] = document.createElement("input");
        input[1] = document.createElement("input");
        input[0].type = "number";
        input[0].min = "0";
        input[1].type = "number";
        input[1].min = "0";
        input[0].value = score[i].innerHTML;
        input[1].value = anotherScore.innerHTML;
        if(score[i].innerHTML == "TBD"){
            input[0].value = 0;
            input[1].value = 0;
        }else{
            input[0].value = score[i].innerHTML;
            input[1].value = anotherScore.innerHTML;
        }
        score[i].innerHTML = "";
        anotherScore.innerHTML = "";
        score[i].appendChild(input[0]);
        anotherScore.appendChild(input[1]);
        input[0].focus();
        // if we exit both inputs, we save the new score
        input[0].addEventListener("blur", function () {
            // if input[1] is not focused, we save the new score
            if (!input[1].isFocused) {
                setScore(input[0].value, input[1].value, score[i], anotherScore);
            }
        });
        input[1].addEventListener("blur", function () {
            // if input[0] is not focused, we save the new score
            if (!input[0].isFocused) {
                setScore(input[0].value, input[1].value, score[i], anotherScore);
            }
        }
        );
    });
}*/
// for every table in the page
/*
var tables = document.getElementsByTagName("table");
for (var i = 0; i < tables.length; i++) {
    tables[i].ondblclick = function (event) {
        td = event.target;
        // if event.target is a score <td class = score>
        if (td.classList.contains("score")) {
            var score = td.innerHTML;
            var input = document.createElement('input');
            // et lui donner comme value le texte
            input.value = (score == "TBD") ? 0 : score;
            input.type = "number";
            input.min = 0;
            input.max = 999;
            // style de l'input
            input.style.width = "60%";
            input.style.height = "100%";
            input.style.textAlign = "center";
            input.style.fontWeight = "bold";
            input.style.border = "none";
            input.style.backgroundColor = "transparent";
            input.style.padding = "0";
            input.style.margin = "0";
            input.style.outline = "none";
            input.style.color = "white";
            // remplacer dans le tableau le noeud texte de la cellule par le noeud input
            td.innerHTML = '';
            td.appendChild(input);
            // mettre le focus et sélectionner la ligne d'édition input
            input.focus();
            input.select();
            // quand on quitte le champ d'édition 
            input.onblur = function() {
                // récupérer la valeur saisie à ce moment
                // if valid int value then make it 0
                var val = input.value;
                // if the value is not a number, make it 0
                if (isNaN(val)) {
                    val = 0;
                }else if (val < 0) {
                    val = 0;
                }else if (val > 999) {
                    val = 999;
                }
                input.value = val;
                // et la placer directement dans la cellule 
                td.innerHTML = val;
                alert('test');
                par = td.parentNode.parentNode;
                //find the temp of temps that is in the parent is par
                temps = $('.modifyScore');
                alert (par.first());
                id = parent.getElementsByClassName("modifyScore")[0];
                // supprimer le champ input inutile
                td.removeChild(input);
            }
        }
    }
}
*/  function findGetParameter(parameterName) {
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
        var td = $(this);
        var tdSibling = td.siblings('.score');
        /*// if event.target is a score <td class = score>
        if (td.hasClass("score")) {
            var score = td.text();
            var input = $('<input />', {
                type: 'number',
                min: 0,
                max: 999,
                value: (score == "TBD") ? 0 : score,
                style: 'width: 60%; height: 100%; text-align: center; font-weight: bold; border: none; background-color: transparent; padding: 0; margin: 0; outline: none; color: white;'
            });
            td.html(input);
            input.focus();
            input.select();
            // on blur or enter
            input.on('blur keydown', function (e) {
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
                // get the parent table of the td
                var table = td.closest('table');
                // get the child of the parent table that has the class modifyScore
                var div = table.find('.modifyScore');
                // alert the value of the div
                alert(div.text());
                // alert the $_GET['IDJ'] value
                alert(findGetParameter('IDJ'));
            });
        }*/
        // make td and tdSibling editable
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
                /* 
                // get the parent table of the td
                var table = td.closest('table');
                // get the child of the parent table that has the class modifyScore
                var div = table.find('.modifyScore');
                // alert the value of the div
                alert(div.text());
                // alert the $_GET['IDJ'] value
                alert(findGetParameter('IDJ'));*/
            }
        });
    });

})