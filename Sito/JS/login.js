var app = new Vue({
    el: '#vue-container',
    data: {
        checkLogin:true,
        checkRegistraUtente:false,
        checkRegistraAzienda:false,

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
                var httpr=new XMLHttpRequest();
                httpr.open("POST","../PHP/login_api.php",true);
                httpr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                httpr.onreadystatechange=function(){
                    if(httpr.readyState==4 && httpr.status==200){
                        if(httpr.responseText=="true")
                        {
                            //loggato
                            console.log("entrato");
                            window.location.href="dashboard.html";
                        }
                        else if(httpr.responseText=="false")
                        {
                            //credenziali errate
                            console.log("credenziali sbagliate")
                            error="Credenziali non valide!";
                            document.getElementById("pError").innerHTML=error;
                        }
                    }
                }
                httpr.send("email="+document.getElementById("tLogin").value +"&password="+document.getElementById("tPassword").value);

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
                var httpr=new XMLHttpRequest();
                httpr.open("POST","../PHP/register_api.php",true);
                httpr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                httpr.onreadystatechange=function(){
                    if(httpr.readyState==4 && httpr.status==200){
                        if(httpr.responseText=="false")
                        {
                            //credenziali errate
                            error="Email già registrata!";
                            document.getElementById("pError2").innerHTML=error;
                        }
                        else
                            app.switch2Register(0);
                    }
                }
                httpr.send("email="+document.getElementById("tLogin").value +"&password="+document.getElementById("tPassword").value);


            }
            else
                error="Campi inseriti non validi";
            document.getElementById("pError2").innerHTML=error;
        },
        registraAzienda()
        {
            var error="⠀";
            //controllo campi vuoti
            if(!(this.controlloValiditaEmail()))
            {
                //effettuo controllo presenza database
                //  se non è già presente regstro accountù
                //  se è già presente genero errore
                var httpr=new XMLHttpRequest();
                httpr.open("POST","../PHP/register_api.php",true);
                httpr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                httpr.onreadystatechange=function(){
                    if(httpr.readyState==4 && httpr.status==200){
                        if(httpr.responseText=="false")
                        {
                            //credenziali errate
                            error="Email già registrata!";
                            document.getElementById("pError2").innerHTML=error;
                        }
                        else
                            app.switch2Register(0);
                    }
                }
                httpr.send("email="+document.getElementById("tLogin").value +"&password="+document.getElementById("tPassword").value);


            }
            else
                error="Campi inseriti non validi";
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
            }
            else if(check == 0)
            {
                //visualizzo form login
                this.checkRegistraUtente=false;
                setTimeout(function() {app.vis2=true }, 500);
                this.checkLogin=true;
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
            return false;
        },
        registraAzienda()
        {
            var error="⠀";
            if(this.controlloCampi())
            {
                //se tutti i valori sono validi registro l'azienda
                axios
                .get("http://localhost:8080/Books/getByParam/{param}", {
                    params: {
                        nome: document.getElementById("aNome"),
                        telefono: document.getElementById("aTelefono"),
                        email: document.getElementById("aEmail"),
                        ragione: document.getElementById("aRagione"),
                        indirizzo: document.getElementById("aIndirizzo"),
                    }   
                })
                .then(response => {
                    //funzione da eseguire dopo (response contiene il valore restituito)
                })
            }
            else
                error="Informazioni non valide";

            document.getElementById("pError3").innerHTML=error;
        }

    }
});

function initialize() {
    var input = document.getElementById('searchTextField');
    new google.maps.places.Autocomplete(input);
  }
  
  google.maps.event.addDomListener(window, 'load', initialize);