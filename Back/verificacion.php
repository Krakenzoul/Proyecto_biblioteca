<?php
function verifica_valores_numeros($texto)
{
    $estado = false;

    if (preg_match('/[0-9]/', $texto)) {
        $estado = true;
    }
    return $estado;
}
function contar_numeros($numero,$valor_minimo,$valor_maximo)
{
    $estado=true;
    if (strlen((string)$numero) >= $valor_minimo && strlen((string)$numero) <=$valor_maximo ) {
        $estado=true;
    } else {
       $estado=false;
    }
    return $estado;
}
function verifica_valores_especiales($texto)
{
    $estado = false;

    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $texto)) {
        $estado = true;
    }
    return $estado;
}