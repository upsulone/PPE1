$(document).ready(function () {

    $("#btnValiderExam").click(function () {

        if($('#saisieNb').val().trim() == ''){
            window.location.href = "http://serveur1.arras-sio.com/symfony4-4059/PPE1/web/index.php?page=langexam"
        }
        else{
            window.location.href = "http://serveur1.arras-sio.com/symfony4-4059/PPE1/web/index.php?page=langexam&nbMini=" + $('#saisieNb').val();
            console.log($('#saisieNb').val())
        }

    });


});

