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
            this.year += a;
            this.month += y;
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
                    error = "Errore aggiunta dipendente";
            });
        },
    }
});
