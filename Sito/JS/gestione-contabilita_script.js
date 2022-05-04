var app = new Vue({
    el: '#vue-container',
    data: {
        year: 2022,
        month: 04,
        monthArr: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
        temp: 0,
        temp2: 0,
        year2: 2022,
        month2: 04,
    },
    mounted(){
        console.log("Vue funziona");
        $.fn.dataTableExt.sErrMode = 'throw';
        date = new Date();
        this.year = date.getFullYear();
        this.month = date.getMonth();
        this.year2 = date.getFullYear();
        this.month2 = date.getMonth();
        mo = this.monthArr[this.month];
        document.getElementById("current_date").innerHTML = mo + " " + this.year;
        this.aggiornadata(0, 0);


    },
    methods: {
        aggiungiMovimento()
        {
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
                        app.compariAlertSuccess("Movimento aggiunto correttamente!");
                    }
                    else
                    app.compariAlertErrore("Errore aggiunta movimento!");
                });
            }
            else
                this.compariAlertErrore("Campi mancanti o non inseriti correttamente!");

        },
        controllaCampi()
        {
            if($("#input-descrizione").val()!="" &&  $("#input-valore").val()!="" && $("#input-data").val()!="" && document.getElementsByName("input-tipo").value!="")
                return true;
            return false;
        },
        generaStatistiche()
        {
            this.aggiornadata2(0,-1);

            this.getSommaEntrate(this.year,this.month, true);
            this.getEntrateMovimenti();
            this.getEntrateProdotti();
            this.getSommaUscite(this.year,this.month, true);
            this.getUsciteProdotti();
            this.getUsciteMovimenti();
            this.getStipendiMensili();
            this.getRicavo();
            setTimeout(function() { app.caricaTabellaMovimenti(); }, 800);

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
        getSommaEntrate(year, month, check)
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "entrate-movimenti",
                anno: year,
                mese: month+1,
            }, function( data ) 
            {
                app.temp=parseInt(data);
                $.get( "../../PHP/contabilita_api.php",{
                    type: "entrate-prodotti",
                    anno: year,
                    mese: month+1,
                }, function( data ) 
                {
                    app.temp+=parseInt(data);
                    if(check)
                    {
                        if(!isNaN(app.temp))
                            document.getElementById("somma-entrate").innerHTML=formatter.format(app.temp);
                        else
                            app.compariInsufficente();
                    }
                        
                });
            });

            /*
            let a=parseInt(this.getEntrateMovimenti());
            let b=parseInt(this.getEntrateProdotti());
            let temp= parseInt(this.getEntrateMovimenti())+parseInt(this.getEntrateProdotti()); 
            return a+b;*/
        },
        getSommaUscite(year, month, check)
        {
            $.get( "../../PHP/contabilita_api.php",{
                type: "uscite-movimenti",
                anno: year,
                mese: month+1,
            }, function( data ) 
            {
                app.temp2=parseInt(data);
                $.get( "../../PHP/contabilita_api.php",{
                    type: "uscite-prodotti",
                    anno: year,
                    mese: month+1,
                }, function( data ) 
                {
                    app.temp2+=parseInt(data);
                    $.get( "../../PHP/contabilita_api.php",{
                        type: "uscite-stipendi",
                        anno: year,
                        mese: month+1,
                    }, function( data ) 
                    {
                        app.temp2+=parseInt(data);
                        if(check)
                        {
                            if(!isNaN(app.temp))
                                document.getElementById("somma-uscite").innerHTML=formatter.format(app.temp2);
                            else
                                app.compariInsufficente();
                        }
                    });

                    
                });
            });
        },
        getRicavo()
        {
            setTimeout(function() {
                var ricavoAttuale=app.temp-app.temp2;
                document.getElementById("ricavi").innerHTML=formatter.format(ricavoAttuale);
                //ora ricavo la percentuale
                app.getSommaEntrate(app.year2,app.month2, false);
                app.getSommaUscite(app.year2,app.month2, false);
                var ricavoScorso= app.temp-app.temp2;
                var percentuale= ((ricavoAttuale-ricavoScorso)/130)*100;
                if(percentuale < 0)
                    document.getElementById("percentuale").setAttribute("style", "color: red;");
                else
                    document.getElementById("percentuale").setAttribute("style", "color: green;");

                document.getElementById("percentuale").innerHTML= percentuale + "%";
            }, 700);
            
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
                if(data=="")
                {
                    var temp="<tr><td>Movimenti non presenti in questo mese</td></tr>";
                    for (let i = 0; i < 9; i++) 
                        temp+="<tr></tr>"
                        document.getElementById("body").innerHTML=temp;
                }
                else
                {
                    document.getElementById("body").innerHTML=data;
                    generaDatatable();
                }
                
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

            this.year2=this.year;   
            this.month2=this.month;

            $(".mese-anno").each(function()  {
                $(this).html(mo + " " + app.year);
            });
            this.generaStatistiche();

        },
        aggiornadata2(a, y) {
            if (this.month2 == 11) {
                if (y > 0) {
                    this.year2 += 1;
                    this.month2 = 0;
                }
                else {
                    this.year2 += a;
                    this.month2 += y;
                }
            }
            else if (this.month2 == 0) {
                if (y < 0) {
                    this.year2 -= 1;
                    this.month2 = 11;
                }
                else {
                    this.year2 += a;
                    this.month2 += y;
                }
            }
            else {
                this.year2 += a;
                this.month2 += y;
            }
        },
        svuotaTutto()
        {
            var elements = document.getElementsByTagName("input");
            for (var ii=0; ii < elements.length; ii++) {
                elements[ii].value = "";
            }
            document.getElementById('input-data').value = new Date().toDateInputValue();
        },
        compariInsufficente()
        {
            document.getElementById("uscite-stipendi").innerHTML="Valori insufficenti";
            document.getElementById("somma-entrate").innerHTML="Valori insufficenti";
            document.getElementById("somma-uscite").innerHTML="Valori insufficenti";
            document.getElementById("uscite-movimenti").innerHTML="Valori insufficenti";
            document.getElementById("entrate-movimenti").innerHTML="Valori insufficenti";
            document.getElementById("uscite-prodotti").innerHTML="Valori insufficenti";
            document.getElementById("entrate-prodotti").innerHTML="Valori insufficenti";
            document.getElementById("ricavi").innerHTML="Valori insufficenti";
            document.getElementById("percentuale").innerHTML="-100%";
            document.getElementById("percentuale").setAttribute("style", "color: red;");
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
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
document.getElementById('input-data').value = new Date().toDateInputValue();