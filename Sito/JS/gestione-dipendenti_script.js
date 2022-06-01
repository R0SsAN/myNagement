var app = new Vue({
    el: '#vue-container',
    data: {
        year: 0,
        month: 0,
        monthArr: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
        hidden: false
    },
    mounted() {
        console.log("Vue funziona");
        $.fn.dataTableExt.sErrMode = 'throw';
        date = new Date();
        this.year = date.getFullYear();
        this.month = date.getMonth();
        mo = this.monthArr[this.month];
        document.getElementById("current_date").innerHTML = mo + " " + this.year;
        this.aggiornadata(0, 0);
        setInterval(myTimer, 1000);
    },
    methods: {
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
            $.post("../../PHP/gestione_dip.php", {
                mese: this.month + 1,
                year: this.year,
            }, function (data) {
                console.log(data);
                if(data == "<tr><td>nessun dipendente presente</td></tr>")
                    document.getElementById("table").innerHTML = data;
                else if (data != "Errore") 
                {
                    document.getElementById("table").innerHTML = data;
                    generaDatatable();
                }
                else
                    error = "Errore";
            });
        },
        anagraficaDip(id) {
            $.post("../../PHP/gestione_dip.php", {
                idDip: id,
            }, function (data) {
                //console.log(data);
                if (data != "Errore") {
                    document.getElementById("modal-body").innerHTML = data;
                }
                else
                    error = "Errore";
            });
        },
        disabilita() {
            var disabled = $(".txt").prop('disabled');
            $(".txt").prop('disabled', !disabled);
            this.save();
        },
        save() {
            if (this.hidden) {
                $('#salva').hide();
            } else {
                $('#salva').show();
            }
            this.hidden = !this.hidden;
        },
        edit() {
            $.post("../../PHP/gestione_dip.php", {
                mansione: document.getElementById("mans").value,
                salario: document.getElementById("sal").value,
                ore: document.getElementById("ore").value,
                datai: document.getElementById("inizio").value,
                dataf: document.getElementById("fine").value,
                idDip: $('.contratto')[0].id,
                rfid: document.getElementById("rfid").value,
            }, function (data) {
                console.log(data);
                if (data != "Errore") {
                    $('#myModal').modal('hide');
                    app.compariAlertSuccess("Modificato");
                }
                else
                    app.compariAlertErrore("Errore modifica");
            });
        },
        compariAlertErrore($stringa) {
            $.bootstrapGrowl($stringa, {
                ele: "body",
                type: "danger",
                offset: { from: "top", amount: 10 },
                align: "right",
                delay: 2000,
                allow_dismiss: false,
                stackup_spacing: 10,
                width: "auto",
            });
        },
        compariAlertSuccess($stringa) {
            $.bootstrapGrowl($stringa, {
                ele: "body",
                type: "success",
                offset: { from: "top", amount: 10 },
                align: "right",
                delay: 1500,
                allow_dismiss: false,
                stackup_spacing: 10,
                width: "auto",
            });
        },
    }
});
function anagraficaDip(id) {
    app.anagraficaDip(id);
}
function disable() {
    $('#salva').hide();
    app.disabilita();
}
function save() {
    app.edit();
}
$('#myModal').on('hide.bs.modal', function () {
    $('#salva').hide();
    app.hidden = true;
    app.disabilita();
});

function generaDatatable() {
    $('#tabellla').DataTable({
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
    table = document.getElementById("table");
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

function myTimer() {
    $(".loader-wrapper").fadeOut("slow");
}