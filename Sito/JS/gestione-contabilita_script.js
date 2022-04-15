var app = new Vue({
    el: '#vue-container',
    data: {
        year: 2022,
        month: 04,
        monthArr: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
        temp: 0,
        temp2: 0,
    },
    mounted(){
        console.log("Vue funziona");
        $.fn.dataTableExt.sErrMode = 'throw';
        date = new Date();
        this.year = date.getFullYear();
        this.month = date.getMonth();
        mo = this.monthArr[this.month];
        document.getElementById("current_date").innerHTML = mo + " " + this.year;
        this.aggiornadata(0, 0);


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
            this.getSommaEntrate();
            this.getEntrateMovimenti();
            this.getEntrateProdotti();
            this.getSommaUscite();
            this.getUsciteProdotti();
            this.getUsciteMovimenti();
            this.getStipendiMensili();
            this.getRicavo();
            setTimeout(function() { app.caricaTabellaMovimenti(); }, 800);
            
            /*document.getElementById("somma-entrate").innerHTML=this.getSommaEntrate();
            document.getElementById("entrate-prodotti").innerHTML=this.getEntrateProdotti();
            document.getElementById("entrate-movimenti").innerHTML=this.getEntrateMovimenti();
            
            document.getElementById("somma-uscite").innerHTML=this.getSommaUscite();
            document.getElementById("uscite-prodotti").innerHTML=this.getUsciteProdotti();
            document.getElementById("uscite-movimenti").innerHTML=this.getEntrateMovimenti();
            document.getElementById("uscite-stipendi").innerHTML=this.getStipendiMensili();
            
            document.getElementById("ricavi").innerHTML=this.getSommaEntrate()-this.getSommaUscite(); */
            //ora calcolo percentuale
        },
        getStipendiMensili()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "uscite-stipendi",
                anno: this.year,
                mese: this.month+1,
            }, function( data ) 
            {
                document.getElementById("uscite-stipendi").innerHTML=formatter.format(data);
            });
        },
        getSommaEntrate()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "entrate-movimenti",
                anno: this.year,
                mese: this.month+1,
            }, function( data ) 
            {
                app.temp=parseInt(data);
                $.get( "../../PHP/contabilita_api.php",{
                    type: "entrate-prodotti",
                    anno: app.year,
                    mese: app.month+1,
                }, function( data ) 
                {
                    app.temp+=parseInt(data);
                    document.getElementById("somma-entrate").innerHTML=formatter.format(app.temp);
                });
            });

            /*
            let a=parseInt(this.getEntrateMovimenti());
            let b=parseInt(this.getEntrateProdotti());
            let temp= parseInt(this.getEntrateMovimenti())+parseInt(this.getEntrateProdotti()); 
            return a+b;*/
        },
        getSommaUscite()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "uscite-movimenti",
                anno: this.year,
                mese: this.month+1,
            }, function( data ) 
            {
                app.temp2=parseInt(data);
                $.get( "../../PHP/contabilita_api.php",{
                    type: "uscite-prodotti",
                    anno: app.year,
                    mese: app.month+1,
                }, function( data ) 
                {
                    app.temp2+=parseInt(data);
                    $.get( "../../PHP/contabilita_api.php",{
                        type: "uscite-stipendi",
                        anno: app.year,
                        mese: app.month+1,
                    }, function( data ) 
                    {
                        app.temp2+=parseInt(data);
                        document.getElementById("somma-uscite").innerHTML=formatter.format(app.temp2);
                    });

                    
                });
            });
        },
        getRicavo()
        {
            setTimeout(function() { document.getElementById("ricavi").innerHTML=formatter.format(app.temp-app.temp2); }, 600);
        },
        getUsciteMovimenti()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "uscite-movimenti",
                anno: this.year,
                mese: this.month+1,
            }, function( data ) 
            {
                document.getElementById("uscite-movimenti").innerHTML=formatter.format(data);
            });
        },
        getEntrateMovimenti()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "entrate-movimenti",
                anno: this.year,
                mese: this.month+1,
            }, function( data ) 
            {
                document.getElementById("entrate-movimenti").innerHTML=formatter.format(data);
            });
        },
        getUsciteProdotti()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "uscite-prodotti",
                anno: this.year,
                mese: this.month+1,
            }, function( data ) 
            {
                document.getElementById("uscite-prodotti").innerHTML=formatter.format(data);
            });
        },
        getEntrateProdotti()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "entrate-prodotti",
                anno: this.year,
                mese: this.month+1,
            }, function( data ) 
            {
                document.getElementById("entrate-prodotti").innerHTML=formatter.format(data);
            });
        },
        caricaTabellaMovimenti()
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "lista-movimenti",
                anno: this.year,
                mese: this.month+1,
            }, function( data ) 
            {
                document.getElementById("body").innerHTML=data;
                generaDatatable();
            });
        },
        aggiornadata(a, y) {
            if (this.month == 11) {
                if (y > 0) {
                    this.year += 1;
                    this.month = 0;
                }
                else {
                    this.year += a;
                    this.month += y;
                }
            }
            else if (this.month == 0) {
                if (y < 0) {
                    this.year -= 1;
                    this.month = 11;
                }
                else {
                    this.year += a;
                    this.month += y;
                }
            }
            else {
                this.year += a;
                this.month += y;
            }
            mo = this.monthArr[this.month];
            document.getElementById("current_date").innerHTML = mo + " " + this.year;

            this.generaStatistiche();
        },
    }
});
var formatter = new Intl.NumberFormat('it', {
    style: 'currency',
    currency: 'EUR',
  
    // These options are needed to round to whole numbers if that's what you want.
    //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});

//per datatable
function generaDatatable() {
    $('#tabella').DataTable({
        paging: false,
        searching: false,
        ordering: true,
        info: false,
        "bDestroy": true,
        autoWidth: false
        
    });
}


function cercaInTabella() {
// Declare variables
var input, filter, table, tr, td, i,t, txtValue;
input = document.getElementById("myInput");
filter = input.value.toUpperCase();
table = document.getElementById("tabella");
tr = table.getElementsByTagName("tr");

// Loop through all table rows, and hide those who don't match the search query
for (i = 0; i < tr.length; i++) {
    tds= tr[i].getElementsByTagName("td");
    for(t=0;t<tds.length;t++)
    {
        td = tds[t];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                break;
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
}