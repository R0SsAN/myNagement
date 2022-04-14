var app = new Vue({
    el: '#vue-container',
    data: {
        mese: "4",
        anno: "2022",
    },
    mounted(){
        console.log("Vue funziona");
        this.generaStatistiche();
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
        generaStatistiche()
        {
            document.getElementById("somma-entrate").innerHTML=this.getSommaEntrate();
            document.getElementById("entrate-prodotti").innerHTML=this.getEntrateProdotti();
            document.getElementById("entrate-movimenti").innerHTML=this.getEntrateMovimenti();
            
            document.getElementById("somma-uscite").innerHTML=this.getSommaUscite();
            document.getElementById("uscite-prodotti").innerHTML=this.getUsciteProdotti();
            document.getElementById("uscite-movimenti").innerHTML=this.getEntrateMovimenti();
            document.getElementById("uscite-stipendi").innerHTML=this.getStipendiMensili();
            
            document.getElementById("ricavi").innerHTML=this.getSommaEntrate()-this.getSommaUscite();
            //ora calcolo percentuale
        },
        getStipendiMensili()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "somma-stipendi",
                anno: this.anno,
                mese: this.mese,
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getSommaEntrate()
        {
            return this.getEntrateMovimenti()+this.getEntrateProdotti();
        },
        getSommaUscite()
        {
            return this.getUsciteMovimenti()+this.getUsciteProdotti() + this.getStipendiMensili();
        },
        getUsciteMovimenti()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "uscite-movimenti",
                anno: this.anno,
                mese: this.mese,
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getEntrateMovimenti()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "entrate-movimenti",
                anno: this.anno,
                mese: this.mese,
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getUsciteProdotti()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "uscite-prodotti",
                anno: this.anno,
                mese: this.mese,
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getEntrateProdotti()
        {
            let temp=$.get( "../../PHP/contabilita_api.php",{
                type: "entrate-prodotti",
                anno: this.anno,
                mese: this.mese,
            }, function( data ) 
            {
                return data;
            });
            return temp;
        },
        getListaMovimenti()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "uscite-movimenti",
                anno: this.anno,
                mese: this.mese,
            }, function( data ) 
            {
                
            });
        }
    }
});