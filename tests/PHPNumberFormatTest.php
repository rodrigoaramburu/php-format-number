<?php 

declare(strict_types=1);

use PHPNumberFormat\PHPNumberFormat;

test('Deve formatar um número inteiro',function($mask, $number, $expected){

    $value = PHPNumberFormat::format($mask, $number);
    expect( $value )->toBe( $expected);

})->with([
    ['###',10.5,'010'],
    ['#'  ,10.5,'10']
]);

test('Deve formatar um numero com casas decimais', function($mask, $number, $expected){

    $value = PHPNumberFormat::format('#,##', 10.5);
    expect( $value )->toBe('10,50');

})->with([
    ['#,##',10.5,'10,50'],
    ['#,##',10.505,'10,50'],
    
]);

test('Deve aceitar caracteres no meio dos numeros da mascara', function($mask, $number, $expected){
    $value = PHPNumberFormat::format($mask, $number);
    expect($value)->toBe($expected);
})->with([
    ['#$###,##',12345.678,'12$345,67'],
    ['#A#B##C,##',12345.678,'12A3B45C,67'],
]);