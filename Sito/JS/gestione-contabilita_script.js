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
        aggiungiMovimento()
        {
            var errore="";
            if(this.controllaCampi())
            {
                var temp=0;
                if(document.getElementById("tipo-2").selected)
                    tipo=1;
                $.post( "../../PHP/contabilita_api.php",{
                    tipo: temp,
                    valore: document.getElementById("input-valore").value,
                    data: document.getElementById("input-data").value,
                    descrizione: document.getElementById("input-descrizione").value,
                }, function( data ) 
                {
                    console.log(data);
                    if(data=="true")
                    {
                        app.svuotaTutto();
                        app.errore="Dipendente aggiunto correttamente";
                    }
                    else
                        app.errore="Errore aggiunta movimento";
                    document.getElementById("errore").innerHTML=app.errore;
                });
            }
            else
                errore="Campi mancanti";

            document.getElementById("errore").innerHTML=errore;
        },
        controllaCampi()
        {
            if($("#input-descrizione").val()!="" &&  $("#input-valore").val()!="" && $("#input-data").val()!="" && document.getElementsByName("input-tipo").value!="")
                return true;
            return false;
        },
        getStipendiMensili($anno, $mese)
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "somma-stipendi",
                anno: $anno,
                mese: $mese
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getSommaEntrate()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "somma-entrate-totale",
                anno: $anno,
                mese: $mese
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getSommaUscite()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "somma-uscite-totale",
                anno: $anno,
                mese: $mese
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getUsciteMovimenti()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "somma-uscite-movimenti",
                anno: $anno,
                mese: $mese
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getEntrateMovimenti()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "somma-entrate-movimenti",
                anno: $anno,
                mese: $mese
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getUsciteProdotti()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "somma-uscite-prodotti",
                anno: $anno,
                mese: $mese
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getEntrateProdotti()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "somma-entrate-prodotti",
                anno: $anno,
                mese: $mese
            }, function( data ) 
            {
                return data;
            });
            return temp;
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
                        document.getElementById("errore").innerHTML="Dipendente aggiunto correttamente";
                        app.svuotaTutto();
                    }
                    else
                        error="Errore aggiunta dipendente";
                });
            }
            else
                document.getElementById("errore").innerHTML="Dati mancanti";
        },
        svuotaTutto()
        {
            var elements = document.getElementsByTagName("input");
            for (var ii=0; ii < elements.length; ii++) {
                elements[ii].value = "";
            }
            document.getElementById('input-data').value = new Date().toDateInputValue();
        },
    }
});

Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
document.getElementById('input-data').value = new Date().toDateInputValue();