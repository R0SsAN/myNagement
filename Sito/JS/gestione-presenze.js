var app = new Vue({
    el: '#vue-container',
    data: {
    },
    mounted() {
        console.log("Vue funziona");
        this.generatabella();
    },
    methods: {
        generatabella() {
            $.post("../../PHP/presenze_api.php", {
                genera: true,
            }, function (data) {
                console.log(data);
                document.getElementById("contenutotabella").innerHTML = data;
            });
        },AggiornaPresenza(cod){

            $.post("../../PHP/presenze_api.php", {
                aggiorna:true,
                CodDipendente:cod,

            },function(data){
            });
            this.generatabella();
        }

    }
});

function SalvaCod(cod) {
    app.AggiornaPresenza(cod);
}

function AggiungiAssenza(){
    
}
