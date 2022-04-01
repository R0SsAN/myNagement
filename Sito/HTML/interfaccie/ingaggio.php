<?php
if (isset($_POST['firstname'])&& isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['cf']) && isset($_POST['indirizzo']) && isset($_POST['tel']) && isset($_POST['contratto']) && isset($_POST['mansione']) && isset($_POST['orario'])) {
    Errore("");
    unset($_COOKIE['temp']);
} else {
    if (isset($_COOKIE["temp"])) {
        Errore("Compilare tutti i campi");
    } else {
        setcookie("temp", 1);
        Errore("");
    }
}
function Errore($msg)
{
    /*echo ' <div class="dipendenti">
    <form action="" method="POST">
        <div class="insert">
            <div class="form">
                <div class="input-container ic1">
                    <input id="firstname" class="input" type="text" placeholder=" " name="firstname" />
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">Nome</label>
                </div>
                <div class="input-container ic2">
                    <input id="lastname" class="input" type="text" placeholder=" " name="lastname" />
                    <div class="cut"></div>
                    <label for="lastname" class="placeholder">Cognome</label>
                </div>
                <div class="input-container ic2">
                    <input id="email" class="input" type="text" placeholder=" " name="email" />
                    <div class="cut cut-short"></div>
                    <label for="email" class="placeholder">Email</label>
                </div>
                <div class="input-container ic2">
                    <input id="cf" class="input" type="text" placeholder=" " name="cf" />
                    <div class="cut cut-short"></div>
                    <label for="email" class="placeholder">Codice fiscale</label>
                </div>
                <div class="input-container ic2">
                    <input id="indirizzo" class="input" type="text" placeholder=" " name="indirizzo" />
                    <div class="cut cut-short"></div>
                    <label for="email" class="placeholder">Indirizzo</label>
                </div>
                <div class="input-container ic2">
                    <input id="tel" class="input" type="text" placeholder=" " name="tel" />
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">Numero di telefono</label>
                </div>
            </div>
            <div class="form">
                <div class="input-container ic2">
                    <div class="cut"></div>
                    <label for="lastname" class="placeholder">Tipo contratto</label>
                    <br><br><br>
                    <input type="radio" name="contratto" onclick="disabilita()"> Indeterminato <br>
                    <input type="radio" name="contratto" onclick="abilita()"> Determinato
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                    <div style="visibility: hidden;" id="data">
                        <div class="date" id="beg">
                            Data inizio<input type="date" name="inizio">
                        </div>
                        <div class="date" id="end">
                            Data fine<input type="date" name="fine">
                        </div>
                    </div>
                </div>
                <br><br><br><br><br><br>
                <div class="input-container ic2">
                    <input id="mansione" class="input" type="text" placeholder=" " name="mansione" />
                    <div class="cut cut-short"></div>
                    <label for="email" class="placeholder">Mansione</label>
                </div>
                <div class="input-container ic2">
                    <div class="cut cut-short"></div>
                    <label for="ora" class="placeholder">Orario</label>
                    <br><br><br>
                    <input type="radio" name="orario"> 5H
                    <input type="radio" name="orario"> 8H
                </div>
                <br><br>
                <div class="input-container ic2">
                    <div class="cut cut-short"></div>
                    <label for="salario" class="placeholder">Salario</label>
                    <br><br><br>
                    <input type="range" name="stiendio" value="1000" min="800" max="2000" oninput="this.nextElementSibling.value = this.value">
                    <output>1000</output>&nbsp;€
                </div>
                <div class="input-container ic2">
                    <b><label for="errore" class="placeholder" style="color:red">' . $msg . '</label></b>
                <div>
                <br>
                <button type="text" class="submit">Ingaggia</button>                
            </div>
        </div>
    </form>
</div>
    ';*/
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin dashboard</title>
    <link rel="stylesheet" type="text/css" href="../../CSS/dipendenti_style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfxpqpZZVQGK6TAh5PV1GOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    
</head>

</head>

<body>
    <div id="vue-container"class="dipendenti">
        <div >
            <div class="insert">
                <div class="form">
                    <div class="input-container ic1">
                        <input id="firstname" class="input" type="text" placeholder=" " name="firstname" />
                        <div class="cut"></div>
                        <label for="firstname" class="placeholder">Nome</label>
                    </div>
                    <div class="input-container ic2">
                        <input id="lastname" class="input" type="text" placeholder=" " name="lastname" />
                        <div class="cut"></div>
                        <label for="lastname" class="placeholder">Cognome</label>
                    </div>
                    <div class="input-container ic2">
                        <input id="email" class="input" type="text" placeholder=" " name="email" />
                        <div class="cut cut-short"></div>
                        <label for="email" class="placeholder">Email</label>
                    </div>
                    <div class="input-container ic2">
                        <input id="cf" class="input" type="text" placeholder=" " name="cf" />
                        <div class="cut cut-short"></div>
                        <label for="cf" class="placeholder">Codice fiscale</label>
                    </div>
                    <div class="input-container ic2">
                        <input id="indirizzo" class="input" type="text" placeholder=" " name="indirizzo" />
                        <div class="cut cut-short"></div>
                        <label for="indirizzo" class="placeholder">Indirizzo</label>
                    </div>
                    <div class="input-container ic2">
                        <input id="tel" class="input" type="text" placeholder=" " name="tel" />
                        <div class="cut"></div>
                        <label for="tel" class="placeholder">Numero di telefono</label>
                    </div>
                </div>
                <div class="form">
                    <div class="input-container ic2">
                        <div class="cut"></div>
                        <label for="lastname" class="placeholder">Tipo contratto</label>
                        <br><br><br>
                        <input type="radio" name="contratto" @click="disabilita()"> Indeterminato <br>
                        <input type="radio" name="contratto" @click="abilita()"> Determinato
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
                        <div style="visibility: hidden;" id="data">
                            <div class="date" id="beg">
                                Data inizio<input type="date" name="inizio" id="inizio">
                            </div>
                            <div class="date" id="end">
                                Data fine<input type="date" name="fine" id="fine">
                            </div>
                        </div>
                    </div>
                    <br><br><br><br><br><br>
                    <div class="input-container ic2">
                        <input id="mansione" class="input" type="text" placeholder=" " name="mansione" />
                        <div class="cut cut-short"></div>
                        <label for="mansione" class="placeholder">Mansione</label>
                    </div>
                    <div class="input-container ic2">
                        <div class="cut cut-short"></div>
                        <label for="ora" class="placeholder">Orario</label>
                        <br><br><br>
                        <input type="radio" name="orario" value="5" checked="checked"> 5H
                        <input type="radio" name="orario" value="8"> 8H
                    </div>
                    <br><br>
                    <div class="input-container ic2">
                        <div class="cut cut-short"></div>
                        <label for="salario" class="placeholder">Salario</label>
                        <br><br><br>
                        <input id="salario" type="range" name="stiendio" value="1000" min="800" max="2000" oninput="this.nextElementSibling.value = this.value">
                        <output>1000</output>&nbsp;€
                    </div>
                    <div class="input-container ic2">
                        <b><label id="errore" class="placeholder" style="color:red"></label></b>
                    </div>
                    <br>
                    <button type="text" class="submit" @click="creaDipendente">Ingaggia</button>                
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript" src="../../JS/ingaggio_script.js"></script>
</body>

</html>