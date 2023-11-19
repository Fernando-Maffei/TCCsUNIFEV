<?php
// Verificar se a extensão mysqli está habilitada
if (!extension_loaded('mysqli')) {
    die('A extensão mysqli não está habilitada.');
} else {
    echo 'A extensão mysqli está habilitada.';
}
?>