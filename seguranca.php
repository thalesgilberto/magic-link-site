<?php
session_start();

if(!isset($_SESSION['id_pessoa_cliente'], $_SESSION['nome_cliente'])){ 
    session_destroy();
    header('Location: login.php');
}
