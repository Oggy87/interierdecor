<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validators
 *
 * @author oggy
 */
class Validators {
    
    /**
     * Static class - cannot be instantiated.
     */
    final public function __construct()
    {
        throw new LogicException("Cannot instantiate static class " . get_class($this));
    }

    public static function verifyRC($rc)
    {
        
        // "be liberal in what you receive"
        if (!preg_match('#^\s*(\d\d)(\d\d)(\d\d)[ /]*(\d\d\d)(\d?)\s*$#', $rc, $matches)) {
            return FALSE;
        }

        list(, $year, $month, $day, $ext, $c) = $matches;

        // do roku 1954 přidělovaná devítimístná RČ nelze ověřit
        if ($c === '') {
            return $year < 54;
        }

        // kontrolní číslice
        $mod = ($year . $month . $day . $ext) % 11;
        if ($mod === 10) $mod = 0;
        if ($mod !== (int) $c) {
            return FALSE;
        }

        // kontrola data
        $year += $year < 54 ? 2000 : 1900;

        // k měsíci může být připočteno 20, 50 nebo 70
        if ($month > 70 && $year > 2003) $month -= 70;
        elseif ($month > 50) $month -= 50;
        elseif ($month > 20 && $year > 2003) $month -= 20;

        if (!checkdate($month, $day, $year)) {
            return FALSE;
        }

        // cislo je OK
        return TRUE;
    }

    public static function verifyIC($IC)
    {
        // "be liberal in what you receive"
        $ic = preg_replace('#\s+#', '', $IC->getValue());

        // má požadovaný tvar?
        if (!preg_match('#^\d{8}$#', $ic)) {
            return FALSE;
        }

        // kontrolní součet
        $a = 0;
        for ($i = 0; $i < 7; $i++) {
            $a += $ic[$i] * (8 - $i);
        }

        $a = $a % 11;

        if ($a === 0) $c = 1;
        elseif ($a === 10) $c = 1;
        elseif ($a === 1) $c = 0;
        else $c = 11 - $a;

        return (int) $ic[7] === $c;
    }

   /* static function check_phone($pnumber, $length = 12) {
        //phone number format: +xxx xxx xxx xxx
        $pnumber = $pnumber->getValue();
        $pnumber = trim($pnumber);
        if (substr($pnumber, 0, 1) != '+')
            return 0;

        $replace = array(' ', '+');
        $replacent = array('', '');
        $pnumber = str_replace($replace, $replacent, $pnumber);

        if (strlen($pnumber) != $length) {
            return 0;
        }

        return 1;
    }*/

}
?>
