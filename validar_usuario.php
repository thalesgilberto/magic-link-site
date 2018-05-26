<?php
session_start();
require 'pessoa.php';
$pessoa = new Pessoa();
$pessoa->setEmail($_POST['email']);
$pessoa->setSenha(sha1($_POST['senha']));
if($pessoa->validar_usuario()){
    header("Location: boleto.php");
}
else{
    
    header("Location: login.php");
}
