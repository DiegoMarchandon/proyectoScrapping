<?php

/**
 * convierte la entrada en un entero positivo.
 * @param mixed
 * @return int
 */
function digitsOnly($number){

    // si la expresión "strstr($number, ',', true)" es verdadera (Existe una coma en el número) se devuelve el valor de esa expresion. Sino, devuelve $number.
    // después, al valor devuelto por el ternario de arriba le aplico la expresión regular preg_replace para eliminar todo caracter que no sea digito.
    // finalmente, convierto todo eso en intval, el cual retorna 0 si el valor no se pudo convertir. Caso contrario el dato convertido a Entero. 
    return intval(preg_replace('/\D/', '', strstr($number, ',', true) ?: $number));
}

$numero = "123.234,35";

echo "tipo dato: ". gettype($numero)."\n";
// echo strstr($numero, ',', true);
echo digitsOnly($numero)."\n";
// echo "tipo dato de nuevo: ".gettype(digitsOnly($numero));