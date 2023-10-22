<?php
session_start();
require_once 'clientes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientes = buscar_clientes($_POST['busqueda']);
    if (empty($clientes)) {
        $_SESSION['mensaje_buscar'] = "No se encontraron clientes con la búsqueda: {$_POST['busqueda']}.";
    } else {
        $_SESSION['mensaje_buscar'] = "Resultados de la búsqueda para: {$_POST['busqueda']}.";
    }
}

