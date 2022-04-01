<?php
    session_start();
    if(isset($_SESSION["userId"]))
        header("Location: dashboard.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyNagement - Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/login_style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div id="vue-container">
        <div class="content">
            <!--Form per il login-->
            <div class="form">
                <form method="" action="" id="login">
                    <img src="../IMG/logo.jpeg" alt="" id="logo">
                    <!--div contenente i campi per email e password e il bottone per loggarsi-->
                    <div id="dati" v-if="checkLogin" ref="dati">
                        <div class="campo">
                            <img src="../IMG/icona_mail.png" class="icon">
                            <div class="testoCampo">
                                <input type="text" id="tEmail" class="testoCampo" placeholder="Email">
                            </div>
                        </div>
                        <div class="campo">
                            <img src="../IMG/icona_mail.png" class="icon">
                            <div class="testoCampo">
                                <input type="password" id="tPassword" class="testoCampo" placeholder="Password">
                            </div>
                        </div>
                        <button type="button" class="bConferma" @click="controlloLogin()">
                            <p id="bTesto">LOGIN</p>
                        </button>
                        <button type="button" class="bCrea" @click="switch2Register(1)">
                            <p id="bTesto">CREA ACCOUNT</p>
                        </button>
                        <button type="button" class="bCrea" @click="switch2Register(-1)">
                            <p id="bTesto">REGISTRA AZIENDA</p>
                        </button>
                        <p id="pError" class="pError">&nbsp</p>
                    </div>
                    <div id="registra" v-if="checkRegistraUtente">
                        <div class="registra-full">
                            <div class="registra-semi">
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="tNome" class="testoCampo" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="tCognome" class="testoCampo" placeholder="Cognome">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="number" id="tTelefono" class="testoCampo" placeholder="Telefono">
                                    </div>
                                </div>
                            </div>
                            <div class="registra-semi">
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="tEmail" class="testoCampo" placeholder="Email">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="password" id="tPassword" class="testoCampo" placeholder="Password">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <select name="azienda" id="tAzienda" class="testoCampo"></select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="bConferma" @click="registraAccount()">
                            <p id="bTesto">REGISTRATI</p>
                        </button>
                        <p id="pError2" class="pError">&nbsp</p>
                    </div>
                    <div id="registra" v-if="checkRegistraAzienda">
                        <div class="registra-full">
                            <div class="registra-semi">
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="aNome" class="testoCampo" placeholder="Nome azienda">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="number" id="aTelefono" class="testoCampo" placeholder="Telefono">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="aEmail" class="testoCampo" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="registra-semi">
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="aRagione" class="testoCampo" placeholder="Ragione sociale">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="aIndirizzo" class="testoCampo" placeholder="Indirizzo">
                                    </div>
                                </div>
                                <div class="campo">
                                    <img src="../IMG/icona_mail.png" class="icon">
                                    <div class="testoCampo">
                                        <input type="text" id="" class="testoCampo" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="bConferma" @click="registraAzienda()">
                            <p id="bTesto">REGISTRA AZIENDA</p>
                        </button>
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