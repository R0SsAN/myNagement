<?php
session_start();
if (isset($_SESSION["userId"]))
    header("Location: dashboard.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNagement - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/login_style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js" integrity="sha512-pBoUgBw+mK85IYWlMTSeBQ0Djx3u23anXFNQfBiIm2D8MbVT9lr+IxUccP8AMMQ6LCvgnlhUCK3ZCThaBCr8Ng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>

<body style="background-color:lightgray">
    <div id="vue-container">
        <div class="content">
            <!--Form per il login-->
            <div class="form">
                <form method="" action="" id="login">
                    <img src="../IMG/logo.jpeg" alt="" id="logo">
                    <!--div contenente i campi per email e password e il bottone per loggarsi-->
                    <div id="dati" v-if="checkLogin" ref="dati">
                        <div class="campo">
                            <img src="../IMG/envelope.svg" class="icon">
                            <div class="testoCampo">
                                <input type="text" id="tEmail" class="testoCampo" placeholder="Email" v-on:keyup.enter="onEnter">
                            </div>
                        </div>
                        <div class="campo">
                            <img src="../IMG/lock.svg" class="icon">
                            <div class="testoCampo">
                                <input type="password" id="tPassword" class="testoCampo" placeholder="Password" v-on:keyup.enter="onEnter">
                            </div>
                        </div>
                        <button type="button" class="bConferma" @click="controlloLogin()">
                            <p id="bTesto">LOGIN</p>
                        </button>
                        <button type="button" class="bCrea" @click="switch2Register(1)">
                            <p id="bTesto">CREA ACCOUNT</p>
                        </button>
                        <button type="button" id="bAzienda" class="bCrea" @click="switch2Register(-1)">
                            <p id="bTesto">REGISTRA AZIENDA</p>
                        </button>
                        <p id="pError" class="pError">&nbsp</p>
                    </div>
                    <div id="registra" v-if="checkRegistraUtente">
                        <div class="registra-full">
                            <div class="registra-semi">
                                <div class="campo">
                                    <img src="../IMG/person.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="tNome" class="testoCampo" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/person.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="tCognome" class="testoCampo" placeholder="Cognome">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/telephone.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="number" id="tTelefono" class="testoCampo" placeholder="Telefono">
                                    </div>
                                </div>
                            </div>
                            <div class="registra-semi">
                                <div class="campo">
                                    <img src="../IMG/envelope.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="tEmail" class="testoCampo" placeholder="Email">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/lock.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="password" id="tPassword" class="testoCampo" placeholder="Password">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/building.svg" class="icon">
                                    <div class="testoCampo">
                                        <select name="azienda" id="tAzienda" class="testoCampo"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-button">
                            <button type="button" class="bCrea" @click="registraAccount()" style="margin-right:-21px">
                                <p id="bTesto">REGISTRATI</p>
                            </button>
                            <button type="button" class="bConferma" @click="switch2Register(0);" style="background-color:lightcoral;">
                                <p id="bTesto">TORNA INDIETRO</p>
                            </button>
                        </div>
                        <p id="pError2" class="pError">&nbsp</p>
                    </div>
                    <div id="registra" v-if="checkRegistraAzienda">
                        <div class="registra-full">
                            <div class="registra-semi">
                                <div class="campo">
                                    <img src="../IMG/building.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="aNome" class="testoCampo" placeholder="Nome azienda">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/telephone.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="number" id="aTelefono" class="testoCampo" placeholder="Telefono">
                                    </div>
                                </div>
                            </div>
                            <div class="registra-semi">
                                <div class="campo">
                                    <img src="../IMG/briefcase.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="aRagione" class="testoCampo" placeholder="Ragione sociale">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/geo-alt.svg" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="aIndirizzo" class="testoCampo" placeholder="Indirizzo">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="campo" style="margin-top: 1px">
                            <img src="../IMG/envelope.svg" class="icon">
                            <div class="testoCampo">
                                <input type="text" id="aEmail" class="testoCampo" placeholder="Email">
                            </div>
                        </div>
                        <div class="container-button">
                            <button type="button" class="bCrea" @click="registraAzienda()" style="margin-right:-21px">
                                <p id="bTesto">REGISTRA AZIENDA</p>
                            </button>
                            <button type="button" class="bConferma" @click="switch2Register(0);" style="background-color:lightcoral;">
                                <p id="bTesto">TORNA INDIETRO</p>
                            </button>
                        </div>
                        <p id="pError3" class="pError">&nbsp</p>
                    </div>
                </form>
            </div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
            <div class="cube"></div>
        </div>

    </div>
    <script src="../JS/login.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
<?php
    if(isset($_POST["id"]))
        echo "<script>
            app.id=".$_POST["id"].";
            document.getElementById('bAzienda').style.display='none';
            </script>";
?>