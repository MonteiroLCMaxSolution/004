<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<html>
<head>


<script type="text/javascript">
    
    setTimeout(function() {
}, 180); // 3 minutos
</script>
<script type="text/javascript">
//var tempo = new Number();
// Tempo em segundos

tempo = 180;

function startCountdown(){

    // Se o tempo não for zerado

    if((tempo - 1) >= 0){

 

        // Pega a parte inteira dos minutos

        var min = parseInt(tempo/60);

        // Calcula os segundos restantes

        var seg = tempo%60;

 

        // Formata o número menor que dez, ex: 08, 07, ...

        if(min < 10){

            min = "0"+min;

            min = min.substr(0, 2);

        }

        if(seg <=9){

            seg = "0"+seg;

        }

        // Cria a variável para formatar no estilo hora/cronômetro

        horaImprimivel = '00:' + min + ':' + seg;

        //JQuery pra setar o valor

        //$("#sessao").html(horaImprimivel);

 

        // Define que a função será executada novamente em 1000ms = 1 segundo

        setTimeout('startCountdown()',10);

 

        // diminui o tempo

        tempo--;

 

    // Quando o contador chegar a zero faz esta ação

    } else {

        $.ajax({
            url: "pg1.php",
            type: "GET",
            dataType:"html",
            success: function(data){
                //window.location.href="https://appaba.com.br/appaba/view/?pg=audiencias";
                $("#sessao").html(data);

                tempo = 180;
                $("#sessao1").html(tempo);
                startCountdowntempo();
            }
            
    });
    }

 

}

 

// Chama a função ao carregar a tela

startCountdown();

 

</script>
<div id="sessao"></div>
<div id="sessao1"></div>