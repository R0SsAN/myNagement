var app = new Vue({
    el: '#vue-container',
    data: {
        type: 0,
    },
    mounted(){
        console.log("Vue funziona");
    },
    methods: {
        abilita()
        {
            document.getElementById("data").style.visibility = "visible";
            this.type=1;
        },
        disabilita()
        {
            document.getElementById("data").style.visibility = "hidden";
            this.type=0;
        },
        creaDipendente()
        {
            if(this.controllaCampi())
            {
                $.post( "../PHP/register_api.php",{
                    tipo: "ingaggio",
                    nome: document.getElementById("firstname"),
                    cognome: document.getElementById("lastname").value,
                    email: document.getElementById("email").value,
                    cf: document.getElementById("cf").value,
                    indirizzo: document.getElementById("indirizzo").value,
                    telefono: document.getElementById("tel").value,
                    mansione: document.getElementById("mansione").value,
                    tipoContratto: this.type,
                    dataInizio: document.getElementById("inizio").value,
                    dataFine: document.getElementById("fine").value,
                    orario:document.getElementsByName("orario").value,
                    salario:document.getElementById("salario").value,

                }, function( data ) 
                {
                    if(data=="true")
                        window.location.href = "dashboard.php";
                    else
                        error="Credenziali non valide";
                });
            }
            else
                document.getElementById("errore").innerHTML="Dati mancanti";
        },
        controllaCampi()
        {
            if($("#firstname").val()!="" &&  $("#lastname").val()!="" && $("#email").val()!="" && $("#cf").val()!="" && $("#indirizzo").val()!="" && $("#tel").val()!="" && $("#mansione").val()!="" && document.getElementsByName("orario").value!="")
            {
                //se è indeterminato
                if(this.type==0)
                    return true;
                //se è determinato
                if($("#inizio").val()!="" && $("#fine").val()!="")
                    return true;
            }
            return false;
        }
    }
});
document.getElementById('inizio').value = new Date().toDateInputValue();