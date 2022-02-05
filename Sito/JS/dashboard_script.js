
var app = new Vue({
    el: '#container',
    data: {
        ciao: false,
    },
    mounted() {
        console.log("Vue funziona");
    },
    methods: {
        toggleMenu() {
            let toggle = document.querySelector('.toggle');
            let navigation = document.querySelector('.navigation');
            let main = document.querySelector('.main');
            toggle.classList.toggle('active');
            navigation.classList.toggle('active');
            main.classList.toggle('active');
        },
        apriHelp() {
            var httpr = new XMLHttpRequest();
            httpr.open("POST", "interfaccie/help.php", true);
            httpr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            httpr.onreadystatechange = function () {
                if (httpr.readyState == 4 && httpr.status == 200) {
                    document.getElementById("content").innerHTML = httpr.responseText;
                }
            }
            httpr.send();
            setTimeout(function () {
                app.$forceUpdate();
            }, 500)
        },
        inviaHelp() {
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
        },
    }
});
function inviaHelp() {
    app.inviaHelp();
}