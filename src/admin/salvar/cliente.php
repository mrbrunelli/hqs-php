<?php

// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

print_r($_POST);
