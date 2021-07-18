<?php 

declare(strict_types=1);

use NumberFormat\NumberFormat;

beforeEach( fn() => NumberFormat::setDecimalSeparator(',') );

test('Deve formatar um número inteiro',function($mask, $number, $expected){

    $value = NumberFormat::format($mask, $number);
    expect( $value )->toBe( $expected);

})->with([
    ['###', 10.5, '010'],
    ['#'  , 10.5, '10']
]);

test('Deve formatar um numero com casas decimais', function($mask, $number, $expected){

    $value = NumberFormat::format('#,##', 10.5);
    expect( $value )->toBe('10,50');

})->with([
    ['#,##',10.5,'10,50'],
    ['#,##',10.505,'10,50'],
    
]);

test('Deve aceitar caracteres no meio dos numeros da mascara', function($mask, $number, $expected){
    $value = NumberFormat::format($mask, $number);
    expect($value)->toBe($expected);
})->with([
    ['#$###,##',12345.678,'12$345,67'],
    ['#A#B##C,##',12345.678,'12A3B45C,67'],
    ['#ABC#,##',12345.678,'1234ABC5,67'],
]);


test('Deve permitir prefixo na mascara', function($mask, $number, $expected){
    $value = NumberFormat::format($mask, $number);
    expect($value)->toBe($expected);
})->with([
    ['R$ #,##', 123.587, 'R$ 123,58'],
    ['R #$###', 1234, 'R 1$234'],
]);


test('Deve permitir sulfixo na mascara', function($mask, $number, $expected){
    $value = NumberFormat::format($mask, $number);
    expect($value)->toBe($expected);
})->with([
    ['#,## A', 123.587, '123,58 A'],
    ['# AC', 1234, '1234 AC'],
]);

test('Deve permitir troca de separador de casas decimais', function($mask, $number, $expected){
    NumberFormat::setDecimalSeparator('.');
    $value = NumberFormat::format($mask, $number);
    expect($value)->toBe($expected);
})->with([
    ['#.##', 123.587, '123.58'],
    ['#,#,#,#.##', 1234.587, '1,2,3,4.58'],
]);


test('Deve formatar valor sem casas decimais mas mascara com', function(){
    
    $value = NumberFormat::format('#,###', 10);
    expect($value)->toBe('10,000');

});