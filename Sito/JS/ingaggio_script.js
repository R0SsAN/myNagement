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
            $temp=document.getElementById("indirizzo").value.replace("'", " ");
                console.log($temp);
            if(this.controllaCampi())
            {
                $.post( "../../PHP/ingaggio.php",{
                    tipo: "ingaggio",
                    nome: document.getElementById("firstname").value,
                    cognome: document.getElementById("lastname").value,
                    email: document.getElementById("email").value,
                    cf: document.getElementById("cf").value,
                    indirizzo: $temp,
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
                    {
                        app.compariAlertSuccess("Dipendente aggiunto correttamente");
                        app.svuotaTutto();
                    }
                    else
                    app.compariAlertErrore("Errore aggiunta dipendente");
                });
            }
            else
                this.compariAlertErrore("Dati mancanti");
        },
        controllaCampi()
        {
            if($("#firstname").val()!="" &&  $("#lastname").val()!="" && $("#email").val()!="" && $("#cf").val()!="" && $("#indirizzo").val()!="" && $("#tel").val()!="" && $("#mansione").val()!="" && document.getElementsByName("orario").value!="")
            {
                document.getElementById("indirizzo").value.replace("'", " ");
                //se è indeterminato
                if(this.type==0)
                    return true;
                //se è determinato
                if($("#inizio").val()!="" && $("#fine").val()!="")
                    return true;
            }
            return false;
        },
        svuotaTutto()
        {
            var elements = document.getElementsByTagName("input");
            for (var ii=0; ii < elements.length; ii++) {
              if (elements[ii].type == "text") {
                elements[ii].value = "";
              }
            }
            document.getElementById('inizio').value = new Date().toDateInputValue();
            document.getElementById('nascita').value = new Date().toDateInputValue();
        },
        compariAlertErrore($stringa)
        {
            $.bootstrapGrowl($stringa,{
                ele: "body",
                type: "danger",
                offset: {from:"top", amount:10},
                align: "right",
                delay: 2000,
                allow_dismiss: false,
                stackup_spacing: 10,
                width: "auto",
            });
        },
        compariAlertSuccess($stringa)
        {
            $.bootstrapGrowl($stringa,{
                ele: "body",
                type: "success",
                offset: {from:"top", amount:10},
                align: "right",
                delay: 1500,
                allow_dismiss: false,
                stackup_spacing: 10,
                width: "auto",
            });
        },
    }
});


Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
document.getElementById('inizio').value = new Date().toDateInputValue();
document.getElementById('nascita').value = new Date().toDateInputValue();