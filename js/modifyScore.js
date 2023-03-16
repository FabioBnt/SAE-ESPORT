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
        // go to modifyScore.php
        window.location.href = "index.php?page=saisirscore&IDJ=" + idj + "&poule=" + poule + "&equipe1=" + score1Id + "&equipe2=" + score2Id + "&score1=" + score1 + "&score2=" + score2 + "&NomT=" + NomT + "&JeuT=" + JeuT;
    }
    
}

// if double click on a score <td class = score>, change it to a text input in the whole row
let score = document.getElementsByClassName("score");
for (let i = 0; i < score.length; i++) {
    score[i].addEventListener("dblclick", function () {
        let anotherScoreIndex = i;
        // if i is even, it's the first score of the row
        if (i % 2 == 0) {
            anotherScoreIndex = i - 1;
        } else {
            anotherScoreIndex = i + 1;
        }
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
}


