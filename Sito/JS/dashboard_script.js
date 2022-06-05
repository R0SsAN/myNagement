
var app = new Vue({
    el: '#container',
    data: {
        ciao: false,
    },
    mounted() {
        console.log("Vue funziona");
        this.apriDashboard();
    },
    methods: {
        toggleMenu() {
            let toggle = document.querySelector('.toggle');
            let navigation = document.querySelector('.navigation');
            let main = document.querySelector('.main');
            let logo = document.querySelector('#logo');
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');
            logo.classList.toggle('active');

        },
        apriHelp() {
            document.getElementById("iframe").src="interfaccie/help.php";
        },
        apriIngaggio(){
            document.getElementById("iframe").src="interfaccie/ingaggio.php";
        },
        apriDipendenti(){
            document.getElementById("iframe").src="interfaccie/gestione_dipendenti.php";
        },
        apriPresenze(){
            document.getElementById("iframe").src="interfaccie/gestione_presenze.php";
        },
        apriContabilita(){
            document.getElementById("iframe").src="interfaccie/gestione_contabilita.php";
        },
        apriMagazzino(){
            document.getElementById("iframe").src="interfaccie/GestioneProdotti/Interfaccia.php";
        },
        apriDashboard(){    
            document.getElementById("iframe").src="interfaccie/index.php";
        },
        logout()
        {
            window.location.href="../PHP/logout.php";
        },
        /*inviaHelp() {
            if (document.getElementById("nome").value != "" && document.getElementById("cognome").value != "" && document.getElementById("telefono").value != "" && document.getElementById("mail").value != "" && document.getElementById("oggettoSegnalazione").value != "" && document.getElementById("societa").value != "" && document.getElementById("testo_richiesta").value != "") {
                var httpr = new XMLHttpRequest();
                httpr.open("POST", "interfaccie/help.php", true);
                httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                httpr.onreadystatechange = function () {
                    if (httpr.readyState == 4 && httpr.status == 200) {
                        document.getElementById("content").innerHTML = httpr.responseText;
                    }
                }
                httpr.send("nome=" + document.getElementById("nome").value + "&cognome=" + document.getElementById("cognome").value + "&telefono=" + document.getElementById("telefono").value + "&societa=" + document.getElementById("societa").value + "&mail=" + document.getElementById("mail").value + "&oggettoSegnalazione=" + document.getElementById("oggettoSegnalazione").value + "&testo_richiesta=" + document.getElementById("testo_richiesta").value);
            }
        },*/
    }
});
function inviaHelp() {
    app.inviaHelp();
}