<?php
require '_header.php'
?><!DOCTYPE html>
<html lang="fr">

<head>
  <title>logescom-ms</title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
  <meta content="Page par défaut" name="description">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <!-- <script src="https://kit.fontawesome.com/8df11ad090.js" crossorigin="anonymous"></script> -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
  <!-- <link rel="stylesheet" href="css/tableau.css"> -->
  <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
  
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

</head>

<body onload="return focus();"><?php
    $pseudo=$_SESSION['pseudo'];

    $products = $DB->querysI('SELECT level, statut FROM login WHERE pseudo=?',array($pseudo));?>
    <nav class="navbar navbar-expand-lg" style="background-color: #253553;">
      <div class="container-fluid">
        <a class="navbar-brand" href="deconnexion.php"><img src="css/img/deconn.jpg" width="30" alt="damko"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link btn btn-danger text-light m-1 active " aria-current="page" href="choix.php">Accueil</a>
            </li>

            <li class="nav-item">
              <a class="nav-link btn btn-danger text-light m-1 active" href="versement.php?client">Entrées</a>
            </li><?php

              if ($_SESSION['statut']=='responsable' or $_SESSION['statut']=='admin') {?>

                <li class="nav-item">
                  <a class="nav-link btn btn-danger text-light m-1 active" href="dec.php?client">Sorties</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link btn btn-danger text-light m-1 active" href="devise.php">Devise</a>
                </li>           
                
                <li class="nav-item">
                  <a class="nav-link btn btn-danger text-light m-1 active" href="top5.php">Statistiques</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link btn btn-danger text-light m-1 active" href="promotion.php">Promotion</a>
                </li><?php 
              }?>

            <li class="nav-item">
              <a class="nav-link btn btn-danger text-light m-1 active" href="comptasemaine.php">Comptabilite</a>
            </li>

            <li class="nav-item">
              <a class="nav-link btn btn-danger text-light m-1 active" href="bulletin.php?compte">Compte</a>
            </li>
            <li class="nav-item"><?php 
              if ($_SESSION['level']>6) {?>
                  <a class="nav-link btn btn-danger text-light m-1 active" href="boutique.php">Boutiques</a><?php 
              }?>
            </li>


          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav><?php 
    $dateJour=date("Y-m-d");