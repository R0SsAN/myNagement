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
    },
    methods: {
        aggiornadata(a, y) {
            date = new Date();
            this.year += a;
            this.month += y;
            console.log(this.month);
            mo = this.monthArr[this.month];
            document.getElementById("current_date").innerHTML = mo + " " + this.year;
        },
    }
});
