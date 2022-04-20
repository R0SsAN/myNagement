<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../CSS/gestionedipendenti_style.css">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://kit.fontawesome.com/b1ee2cf5f1.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div id="vue-container">
        <div class="tabella">
            <div class="date">
                <i class="fa-solid fa-angles-left fa-xl" @click="aggiornadata(-1,0)" style="cursor: pointer;"></i>
                <i class="fa-solid fa-angle-left fa-xl" @click="aggiornadata(0,-1)" style="cursor: pointer;"></i>
                <label id="current_date"></label>
                <i class="fa-solid fa-angle-right fa-xl" @click="aggiornadata(0,1)" style="cursor: pointer;"></i>
                <i class="fa-solid fa-angles-right fa-xl" @click="aggiornadata(1,0)" style="cursor: pointer;"></i>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>nome</th>
                        <th>contratto</th>
                        <th>ore totali</th>
                        <th>stipendio</th>
                        <th>cassa integrazione</th>
                        <th>malattia</th>
                        <th>ferie</th>
                        <th>maternità</th>
                        <th>anagrafiche</th>
                    </tr>
                </thead>
                <tbody id="table">

                </tbody>
            </table>
        </div>
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titoloAnagrafica">Anagrafica di:</h5>
                    </div>
                    <div class="modal-body">
                        <div class="dipendente">
                            Nome: <label type="text" name="nome" id="nDip"></label><br><br>
                            Codice Fiscale: <label type="text" name="cf" id="cFisc"></label><br><br>
                            Telefono: <label type="tel" name="tel" id="tel"></label><br><br>
                            Email: <label type="mail" name="mail" id="mail"></label><br><br>
                            Indirizzo: <label type="ind" name="ind" id="ind"></label><br><br>
                        </div>
                        <div class="contratto">
                            Mansione: <label type="mans" name="mans" id="mans"></label><br><br>
                            Salario: <label type="sal" name="sal" id="sal"></label><br><br>
                            Ore: <label type="ore" name="ore" id="ore"></label><br><br>
                            Data inizio: <label type="inizio" name="inizio" id="inizio"></label><br><br>
                            Data fine: <label type="fine" name="fine" id="fine"></label><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="../../JS/gestione-dipendenti_script.js"></script>
</body>

</html>