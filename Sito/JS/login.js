var app = new Vue({
    el: '#vue-container',
    data: {
        checkLogin:true,
        checkRegistra:false,

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



            }
            else
                error="Campi inseriti non validi";
            document.getElementById("pError").innerHTML=error;
        },
        controlloValiditaEmail()
        {
            //check = true -> mail non valida
            //check = false -> mail valida
            //faccio i controlli e ritorno il risultato

            var check=true;
            var mail=document.getElementById("tLogin").value;
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
                //effettuo controllo presenza database
                //  se non è già presente regstro accountù
                //  se è già presente genero errore



            }
            else
                error="Campi inseriti non validi";
                this.switch2Register(false);
            document.getElementById("pError2").innerHTML=error;
        },
        switch2Register(check)
        {
            if(check)
            {
                //nascondo form login
                this.checkLogin=false;
                setTimeout(function() {app.vis2=true }, 500);
                this.checkRegistra=true;
            }
            else
            {
                this.checkRegistra=false;
                setTimeout(function() {app.vis2=true }, 500);
                this.checkLogin=true;
            }
            
        }

    }
});