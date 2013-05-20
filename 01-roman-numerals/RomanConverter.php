<?php

/** @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> */
class RomanConverter
{
    protected $conversions = array(
        1000 => 'M',
        900 => 'CM',
        500 => 'D',
        400 => 'CD',
        100 => 'C',
        90 => 'XC',
        50 => 'L',
        40 => 'XL',
        10 => 'X',
        9 => 'IX',
        5 => 'V',
        4 => 'IV',
        1 => 'I',
    );

    public function convert($inArabic)
    {
        if ($inArabic <= 0) {
            return '';
        }
        list ($arabic, $roman) = $this->converstionFactorFor($inArabic);
        return $roman . $this->convert($inArabic - $arabic);
    }

    protected function converstionFactorFor($inArabic)
    {
        foreach ($this->conversions as $arabic => $roman) {
            if ($arabic <= $inArabic) {
                return array($arabic, $roman);
            }
        }
    }
}
