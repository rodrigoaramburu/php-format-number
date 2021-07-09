<?php 

declare(strict_types=1);

namespace PHPNumberFormat;

class PHPNumberFormat
{

    public static function format(string $mask, float $value): string
    {
        preg_match("/(?<integer>\d+)(\.(?<fraction>\d*))/" , (string) $value, $matchValue);
        preg_match("/(?<integer>#+)(,(?<fraction>#+))?/", $mask, $matchMask );

        $integer = PHPNumberFormat::fillInteger($matchMask['integer'], $matchValue['integer']);

        if(isset($matchMask['fraction'])){
            $fraction = PHPNumberFormat::fillFraction($matchMask['fraction'], $matchValue['fraction']);
            return $integer . ',' . $fraction;
        }

        return $integer;
    }

    public static function fillFraction(string $fractionMask, string $fractionValue  ):string
    {
        $value = '';

        while( strlen($fractionMask) > 0  ){
            if( strlen($fractionValue) <= 0){
                $value =  $value . '0';
            }else{
                $value =  $value . $fractionValue[ 0 ];
            }    
            $fractionValue = substr($fractionValue, 1 ,strlen($fractionValue));
            $fractionMask = substr($fractionMask,1 ,strlen($fractionMask));
        }

        return $value;
    }

    public static function fillInteger(string $integerMask, string $integerValue): string
    {
        $value = '';
        while( strlen($integerValue) > 0 || strlen($integerMask) > 0  ){
            
            if( strlen($integerValue) <= 0 ){
                $value = '0' . $value;
            }else{
                $value =  $integerValue[ strlen($integerValue)-1 ] . $value;
            }

            $integerValue = substr($integerValue,0,strlen($integerValue)-1);
            $integerMask = substr($integerMask,0 ,strlen($integerMask)-1);
        }
        return $value;

    }
}