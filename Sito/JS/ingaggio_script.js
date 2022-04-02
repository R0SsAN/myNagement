var app = new Vue({
    el: '#vue-container',
    data: {
        type: 0,
        orario: 5,
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
            //controllo orario
            if(document.getElementById("5h").checked)
                this.orario=5;
            else
                this.orario=8;
            console.log(this.orario);
            if(this.controllaCampi())
            {
                $.post( "../../PHP/ingaggio.php",{
                    tipo: "ingaggio",
                    nome: document.getElementById("firstname").value,
                    cognome: document.getElementById("lastname").value,
                    email: document.getElementById("email").value,
                    cf: document.getElementById("cf").value,
                    indirizzo: document.getElementById("indirizzo").value,
                    telefono: document.getElementById("tel").value,
                    mansione: document.getElementById("mansione").value,
                    tipoContratto: this.type,
                    dataInizio: document.getElementById("inizio").value,
                    dataFine: document.getElementById("fine").value,
                    orario:this.orario,
                    salario:document.getElementById("salario").value,
                    nascita:document.getElementById("nascita").value,

                }, function( data ) 
                {
                    console.log(data);
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


Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
document.getElementById('inizio').value = new Date().toDateInputValue();
document.getElementById('nascita').value = new Date().toDateInputValue();