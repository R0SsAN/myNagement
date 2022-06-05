var app = new Vue({
    el: '#vue-container',
    data: {

    },
    mounted(){
        console.log("Vue funziona");
    },
    methods: {
        inviaRichiesta()
        {
            $.post("../../PHP/help_api.php",{
                nome:document.getElementById("nome").value,
                cognome:document.getElementById("cognome").value,
                oggettoSegnalazione:document.getElementById("oggettoSegnalazione").value,
                societa:document.getElementById("societa").value,
                mail:document.getElementById("mail").value,
                telefono:document.getElementById("telefono").value,
                testo_richiesta:document.getElementById("testo_richiesta").value,
    
            }, function(data){
                if(data=="true")
                    app.compariAlertSuccess("Segnalazione inviata");
                else if(data=="false")
                    app.compariAlertErrore("Errore nell'invio segnalazione");
                else
                    app.compariAlertErrore("Campi non inseriti correttamente");
            });
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
