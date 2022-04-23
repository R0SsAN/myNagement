var app = new Vue({
    el: '#vue-container',
    data: {
        year: 0,
        month: 0,
        monthArr: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"]
    },
    mounted() {
        console.log("Vue funziona");
        date = new Date();
        this.year = date.getFullYear();
        this.month = date.getMonth();
        mo = this.monthArr[this.month];
        document.getElementById("current_date").innerHTML = mo + " " + this.year;
        this.aggiornadata(0, 0);
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
                if (data != "Errore") {
                    document.getElementById("table").innerHTML = data;
                }
                else
                    error = "Errore";
            });
        },
        anagraficaDip(id) {
            $.post("../../PHP/gestione_dip.php", {
                idDip: id,
            }, function (data) {
                console.log(data);
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
            document.getElementById("save").style.display=systemON?"":"none";
        },
    }
});
function anagraficaDip(id) {
    app.anagraficaDip(id);
}
function disable() {
    app.disabilita();
}