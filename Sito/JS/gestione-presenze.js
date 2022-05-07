var app = new Vue({
    el: '#vue-container',
    data: {
        idutente: 0,
    },
    mounted() {
        console.log("Vue funziona");
        this.generatabella();
    },
    methods: {
        generatabella() {
            $.post("../../PHP/presenze_api.php", {
                genera: true,
            }, function(data) {
                console.log(data);
                document.getElementById("contenutotabella").innerHTML = data;
                generaDatatable();
            });
        },
        AggiornaPresenza(cod) {
            $.post("../../PHP/presenze_api.php", {
                aggiorna: true,
                CodDipendente: cod,
            }, function(data) {
                console.log(data);
                app.generatabella();
            });
        },
        AP() {
            $.post("../../PHP/presenze_api.php", {
                aggiornapresenza: document.getElementById("btnam").innerHTML,
                tipomalattia: document.getElementById("assenza").value,
                datainizio: document.getElementById("datainizio").value,
                datafine: document.getElementById("datafine").value,
                percstipendio: document.getElementById("customRange1").value,
                idutente: app.idutente,
            }, function(data) {
                console.log("arrivato");

            });
        },
    }
});

function SalvaCod(cod) {
    app.AggiornaPresenza(cod);
}

function AggiornaButton(am, id) {
    app.idutente = id;
    if (am) {
        document.getElementById("btnam").innerHTML = "Modifica";
    } else {
        document.getElementById("btnam").innerHTML = "Aggiungi";
    }
}

function AggiornaAssenze() {
    app.AP();
}
var slider = document.getElementById("customRange1");
var output = document.getElementById("percstipendio");
output.innerHTML = slider.value + "%";

slider.oninput = function() {
        output.innerHTML = this.value + "%";
    }
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
    var input, filter, table, tr, td, i, t, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabella");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        tds = tr[i].getElementsByTagName("td");
        for (t = 0; t < tds.length; t++) {
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