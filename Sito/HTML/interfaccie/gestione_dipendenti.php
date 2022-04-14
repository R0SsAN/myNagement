<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/gestionedipendenti_style.css">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://kit.fontawesome.com/b1ee2cf5f1.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div id="vue-container">
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
    <script src="../../JS/gestione-dipendenti_script.js"></script>
</body>

</html>