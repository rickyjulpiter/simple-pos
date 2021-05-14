<?php
function clearSpecialCharacter($string)
{
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

function formatUniqueName($string)
{
    $string =  explode(".", $string);
    return round(microtime((true)) . '.' . end($string));
}

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}