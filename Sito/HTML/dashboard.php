<?php
    session_start();
    if(!isset($_SESSION["userId"]))
      header("Location: login.php");

?>
<!DOCTYPE html>
<html>
<!-- https://www.youtube.com/watch?v=gdA1G5h-D80 18:35-->

<head>
  <meta name="viewport" content="width=device-widtj, initial-scale=1.0" />
  <title>Admin dashboard</title>
  <link rel="stylesheet" type="text/css" href="../CSS/dashboard_style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
</head>

<body>
  <div class="container" id="container">
    <div class="navigation">
      <ul>
        <li>
          <a href="#">
            <span id="logo" style="margin-top:10px;margin-left:11px;margin-right:7px;"><img width="40"></span>
            <span class="title">
              <h2>MyNagement</h2>
            </span>
          </a>
        </li>
        <li>
          <a href="#">
            <span class="icon"><i class="fas fa-home"></i></span>
            <span class="title">Home</span>
          </a>
        </li>
        <li>
          <a href="#" @click="apriDipendenti()">
            <span class="icon"><i class="fas fa-users" aria-hidden="true"></i></span>
            <span class="title">Gestione dipendenti</span>
          </a>
        </li>
        <li>
          <a href="#" @click="apriPresenze()">
            <span class="icon"><i class="fas fa-calendar-check" aria-hidden="true"></i></span>
            <span class="title">Gestione presenze</span>
          </a>
        </li>
        <li>
          <a href="#" @click="apriIngaggio()">
            <span class="icon"><i class="fas fa-user" aria-hidden="true"></i></span>
            <span class="title">Ingaggio dipendenti</span>
          </a>
        </li>
        <li>
          <a href="#" @click="apriContabilita()">
            <span class="icon"><i class="fas fa-dollar" aria-hidden="true"></i></span>
            <span class="title">Gestione contabilita'</span>
          </a>
        </li>
        <li>
          <a href="#" @click="apriMagazzino()">
            <span class="icon"><i class="fas fa-warehouse" aria-hidden="true"></i></span>
            <span class="title">Gestione magazzino</span>
          </a>
        </li>
        <li>
          <a href="#" @click="apriHelp()">
            <span class="icon"><i class="fas fa-question-circle"></i></span>
            <span class="title">Help</span>
          </a>
        </li>
        <li>
          <a href="#" @click="logout()">
            <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
            <span class="title">Logout</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="main">
      <div class="topbar">
        <div class="toggle" @click="toggleMenu()"></div>
        <div class="search">
          <label>
            <input type="text" placeholder="Search here" />
            <i class="fas fa-search"></i>
          </label>
        </div>
        <div class="user">
          <!-- da sistemare -->
          <!--<img src="R:/Documents/Immagini/a18.jpg" />-->
        </div>
      </div>
      <div class="content">
        <iframe id="iframe" width="100%" height="100%" src="" frameBorder="0">
        </iframe>
      </div>
    </div>
  </div>
  <script src="https://kit.fontawesome.com/f69c57d50d.js" crossorigin="anonymous"></script>
  <script src="../JS/dashboard_script.js"></script>
</body>

</html>