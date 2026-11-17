<?php
/** Lit un secret Docker monté sous /run/secrets ; null s'il est absent, illisible ou vide. */
function readSecret(string $name): ?string
{
    $value = @file_get_contents("/run/secrets/$name");
    $value = $value === false ? '' : trim($value);
    return $value !== '' ? $value : null;
}
