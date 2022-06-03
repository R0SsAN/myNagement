var app = new Vue({
    el: '#vue-container',
    data: {
        checkLogin:true,
        checkRegistraUtente:false,
        checkRegistraAzienda:false,
        id:-1,
    },
    mounted(){
        console.log("Vue funziona");
    },
    methods: {
        controlloLogin(){
            var error="⠀";
            //controllo campi vuoti
            if(!(this.controlloValiditaEmail() || document.getElementById("tPassword").value==""))
            {
                //controllo login da database e eventuali errori
                $.post( "../PHP/register_api.php",{
                    tipo: "login",
                    email: document.getElementById("tEmail").value,
                    password: document.getElementById("tPassword").value,
                }, function( data ) 
                {
                    console.log(data);
                    if(data=="true")
                        window.location.href = "dashboard.php";
                    else
                        app.compariAlertErrore("Credenziali non valide");
                });
            }
            else
                this.compariAlertErrore("Campi inseriti non validi");
            document.getElementById("pError").innerHTML=error;
        },
        controlloValiditaEmail()
        {
            //check = true -> mail non valida
            //check = false -> mail valida
            //faccio i controlli e ritorno il risultato

            var check=true;
            var mail=document.getElementById("tEmail").value;
            if(mail.indexOf('@') > -1)
            {
                check=false;
                var pos=mail.indexOf('@');
                var sub=mail.substring(pos);
                if(!(sub.indexOf('.') > -1))
                    check=true;
            }
            return check;
        },
        registraAccount()
        {
            var error="⠀";
            //controllo campi vuoti
            if(!(this.controlloValiditaEmail() || document.getElementById("tPassword").value==""))
            {
                $.post( "../PHP/register_api.php",{
                    tipo: "titolare",
                    nome: document.getElementById("tNome").value,
                    cognome: document.getElementById("tCognome").value,
                    telefono: document.getElementById("tTelefono").value,
                    email: document.getElementById("tEmail").value,
                    password: document.getElementById("tPassword").value,
                    azienda: document.getElementById("tAzienda").value,
                }, function( data ) 
                {
                    console.log(data);
                    app.switch2Register(0);
                });
            }
            else
                this.compariAlertErrore("Campi inseriti non validi");
            document.getElementById("pError2").innerHTML=error;
        },
        switch2Register(check)
        {
            if(check==1)
            {
                //visualizzo form registra utente
                this.checkLogin=false;
                setTimeout(function() {app.vis2=true }, 500);
                this.checkRegistraUtente=true;
                document.getElementById("login").style.width="700px";
                document.getElementsByClassName("form")[0].style.width="700px";
                this.caricaAziende();
            }
            else if(check == 0)
            {
                //visualizzo form login
                this.checkRegistraUtente=false;
                this.checkRegistraAzienda=false;
                setTimeout(function() {app.vis2=true }, 500);
                this.checkLogin=true;
                document.getElementById("login").style.width="450px";
                document.getElementsByClassName("form")[0].style.width="450px";
            }
            else if(check==-1)
            {
                //visualizzo form registra azienda
                this.checkLogin=false;
                setTimeout(function() {app.vis2=true }, 500);
                this.checkRegistraAzienda=true;
                document.getElementById("login").style.width="700px";
                document.getElementsByClassName("form")[0].style.width="700px";
            }
            
        },
        controlloCampi()
        {
            if(this.g("aNome") && this.g("aEmail") && this.g("aRagione") && this.g("aIndirizzo"))
                return true;
            return false;
        },
        registraAzienda()
        {
            var error="⠀";
            if(this.controlloCampi())
            {
                //se tutti i valori sono validi registro l'azienda
                $.post( "../PHP/register_api.php",{
                    tipo: "azienda",
                    nome: document.getElementById("aNome").value,
                    ragione: document.getElementById("aRagione").value,
                    email: document.getElementById("aEmail").value,
                    telefono: document.getElementById("aTelefono").value,
                    indirizzo: document.getElementById("aIndirizzo").value,
                }, function( data ) 
                {
                    console.log(data);
                    app.switch2Register(0);
                });
            }
            else
                this.compariAlertErrore("Informazioni mancanti");

            document.getElementById("pError3").innerHTML=error;
        },
        onEnter: function() {
            if(this.checkLogin)
                this.controlloLogin();
        },
        caricaAziende()
        {
            $.post( "../PHP/register_api.php",{
                tipo: "check",
                id: this.id,
            }, function( data ) 
            {
                console.log(data);
                document.getElementById("tAzienda").innerHTML=data;
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
        g(nome)
        {
            if(document.getElementById(nome).value!="")
                return true;
            return false;
        }
    }
});