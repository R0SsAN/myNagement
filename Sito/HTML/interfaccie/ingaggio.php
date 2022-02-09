<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-widtj, initial-scale=1.0" />
    <title>Admin dashboard</title>
    <link rel="stylesheet" type="text/css" href="../CSS/dipendenti_style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfxpqpZZVQGK6TAh5PV1GOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
</head>

</head>

<body>
    <div class="dipendenti">
        <div class="insert">
            <div class="form">
                <div class="input-container ic1">
                    <input id="firstname" class="input" type="text" placeholder=" " />
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">Nome</label>
                </div>
                <div class="input-container ic2">
                    <input id="lastname" class="input" type="text" placeholder=" " />
                    <div class="cut"></div>
                    <label for="lastname" class="placeholder">Cognome</label>
                </div>
                <div class="input-container ic2">
                    <input id="email" class="input" type="text" placeholder=" " />
                    <div class="cut cut-short"></div>
                    <label for="email" class="placeholder">Email</label>
                </div>
                <div class="input-container ic2">
                    <input id="cf" class="input" type="text" placeholder=" " />
                    <div class="cut cut-short"></div>
                    <label for="email" class="placeholder">Codice fiscale</label>
                </div>
                <div class="input-container ic2">
                    <input id="indirizzo" class="input" type="text" placeholder=" " />
                    <div class="cut cut-short"></div>
                    <label for="email" class="placeholder">Indirizzo</label>
                </div>
                <div class="input-container ic2">
                    <input id="indirizzo" class="input" type="text" placeholder=" " />
                    <div class="cut cut-short"></div>
                    <label for="email" class="placeholder">Comune</label>
                </div>
                <div class="input-container ic2">
                    <input id="tel" class="input" type="text" placeholder=" " />
                    <div class="cut"></div>
                    <label for="firstname" class="placeholder">Numero di telefono</label>
                </div>
            </div>
            <div class="form">
                <div class="input-container ic2">
                    <div class="cut"></div>
                    <label for="lastname" class="placeholder">Tipo contratto</label>
                    <br><br><br>
                    <input type="radio" name="contratto"> Indeterminato
                    <input type="radio" name="contratto"> Determinato
                </div>
                <br><br>
                <div class="input-container ic2">
                    <input id="mansione" class="input" type="text" placeholder=" " />
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
                    <label for="email" class="placeholder">Salario</label>
                    <br><br><br>
                    <input type="range" min="800" max="2500">
                </div>
                <br><br> <br><br>
                <button type="text" class="submit">Ingaggia</button>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/f69c57d50d.js" crossorigin="anonymous"></script>
    <script src="../JS/dashboard_script.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>

</body>

</html>