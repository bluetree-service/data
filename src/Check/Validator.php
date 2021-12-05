<?php

/**
 * contains all methods to validate data
 *
 * @package     BlueData
 * @subpackage  Data
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */

declare(strict_types=1);

namespace BlueData\Check;

use function preg_match;
use function preg_replace;
use function substr;
use function strlen;
use function abs;

class Validator
{
    public const IBAN_CHARS = [
        '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4',
        '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9',
        'A' => '10', 'B' => '11', 'C' => '12', 'D' => '13', 'E' => '14',
        'F' => '15', 'G' => '16', 'H' => '17', 'I' => '18', 'J' => '19',
        'K' => '20', 'L' => '21', 'M' => '22', 'N' => '23', 'O' => '24',
        'P' => '25', 'Q' => '26', 'R' => '27', 'S' => '28', 'T' => '29',
        'U' => '30', 'V' => '31', 'W' => '32', 'X' => '33', 'Y' => '34',
        'Z' => '35'
    ];

    /**
     * array of regular expressions used to validate
     * @var array
     */
    public static $regularExpressions = [
        'string' =>             '#^[\p{L} ]*$#u',
        'letters' =>            '#^[\p{L} _ ,.-]*$#u',
        'letters_extend' =>     '#^[\p{L}_ ,\\.;:-]*$#u',
        'fullchars' =>          '#^[\p{L}\\d_ ,\\.;:/!@\\#$%^&*()+=|\\\{}\\]\\[<>?`~\'"-]*$#u',
        'integer' =>            '#^[\\d]*$#',
        'multinum' =>           '#^[\\d /-]*$#',
        'num_chars' =>          '#^[\p{L}\\d\\.,_ -]*$#u',
        'num_char_extends' =>   '#^[\p{L}\\d_ ,\\.;:-]*$#u',
        'numeric' =>            '#^(-)?[\\d]*$#',
        'float' =>              '#^(-)?[\\d]*((,|\\.){1}[\\d]*){1}$#',
        'rational' =>           '#^(-)?[\\d]*((,|\\.){1}[\\d]*)?$#',
        'mail' =>               '#^[\\w_\.-]*[\\w_]@[\\w_\.-]*\\.[\\w_-]{2,3}$#',
        'url' =>                '#^(http://)?[\\w_-]+\\.[\\w]{2,3}(/)?$#',
        'url_extend' =>         '#^((http|https|ftp|ftps)://)?[\\w_-]+\\.[\\w]{2,3}(/)?$#',
        'url_full' =>           '#^((http|https|ftp|ftps)://)?[\\w_-]+\\.[\\w]{2,3}([\\w_/-]*)?(\\?[\\w&%=+-]*)?$#',
        'price' =>              '#^[\\d]*((,|\\.)[\\d]{0,2})?$#',
        'postcode' =>           '#^[\\d]{2}-[\\d]{3}$#',
        'phone' =>              '#^((\\+)[\\d]{2})?( ?\\( ?[\\d]+ ?\\) ?)?[\\d -]*$#',
        'date2' =>              '#^[\\d]{2}-[\\d]{2}-[\\d]{4}$#',
        'date' =>               '#^[\\d]{4}-[\\d]{2}-[\\d]{2}$#',
        'month' =>              '#^[\\d]{4}-[\\d]{2}$#',
        'datetime' =>           '#^[\\d]{4}-[\\d]{2}-[\\d]{2} [\\d]{2}:[\\d]{2}$#',
        'jdate' =>              '#^[\\d]{2}/[\\d]{2}/[\\d]{4}$#',                        //time from jquery datepicker
        'jdatetime' =>          '#^[\\d]{2}/[\\d]{2}/[\\d]{4} [\\d]{2}:[\\d]{2}$#',      //time from jquery datepicker
        'time' =>               '#^[\\d]{2}:[\\d]{2}(:[\\d]{2})?$#',
        'hex_color' =>          '/^#[\\da-f]{6}$/i',
        'hex' =>                '/^#[\\da-f]+$/i',
        'hex2' =>               '#^0x[\\da-f]+$#i',
        'octal' =>              '#^0[0-7]+$#',
        'binary' =>             '#^b[0-1]+$#i',
    ];

    /**
     * standard validate method, use validation from $regularExpressions variable
     *
     * 'string' =>             '#^[\p{L} ]*$#u',
     * 'letters' =>            '#^[\p{L} _ ,.-]*$#u',
     * 'letters_extend' =>     '#^[\p{L}_ ,\\.;:-]*$#u',
     * 'fullchars' =>          '#^[\p{L}\\d_ ,\\.;:/!@\\#$%^&*()+=|\\\{}\\]\\[<>?`~\'"-]*$#u',
     * 'integer' =>            '#^[\\d]*$#',
     * 'multinum' =>           '#^[\\d /-]*$#',
     * 'num_chars' =>          '#^[\p{L}\\d\\.,_ -]*$#u',
     * 'num_char_extends' =>   '#^[\p{L}\\d_ ,\\.;:-]*$#u',
     * 'numeric' =>            '#^(-)?[\\d]*$#',
     * 'float' =>              '#^(-)?[\\d]*((,|\\.){1}[\\d]*){1}$#',
     * 'rational' =>           '#^(-)?[\\d]*((,|\\.){1}[\\d]*)?$#',
     * 'mail' =>               '#^[\\w_\.-]*[\\w_]@[\\w_\.-]*\\.[\\w_-]{2,3}$#',
     * 'url' =>                '#^(http://)?[\\w_-]+\\.[\\w]{2,3}(/)?$#',
     * 'url_extend' =>         '#^((http|https|ftp|ftps)://)?[\\w\\._-]+(/)?$#',
     * 'url_full' =>           '#^((http|https|ftp|ftps)://)?[\\w\\._/-]+(\\?[\\w&%=+-]*)?$#',
     * 'price' =>              '#^[\\d]*((,|\\.)[\\d]{0,2})?$#',
     * 'postcode' =>           '#^[\\d]{2}-[\\d]{3}$#',
     * 'phone' =>              '#^((\\+)[\\d]{2})?( ?\\( ?[\\d]+ ?\\) ?)?[\\d -]*$#',
     * 'date2' =>              '#^[\\d]{2}-[\\d]{2}-[\\d]{4}$#',
     * 'date' =>               '#^[\\d]{4}-[\\d]{2}-[\\d]{2}$#',
     * 'month' =>              '#^[\\d]{4}-[\\d]{2}$#',
     * 'datetime' =>           '#^[\\d]{4}-[\\d]{2}-[\\d]{2} [\\d]{2}:[\\d]{2}$#',
     * 'jdate' =>              '#^[\\d]{2}/[\\d]{2}/[\\d]{4}$#',                        //time from jquery datepicker
     * 'jdatetime' =>          '#^[\\d]{2}/[\\d]{2}/[\\d]{4} [\\d]{2}:[\\d]{2}$#',      //time from jquery datepicker
     * 'time' =>               '#^[\\d]{2}:[\\d]{2}(:[\\d]{2})?$#',
     * 'hex_color' =>          '/^#[\\da-f]{6}$/i',
     * 'hex' =>                '/^#[\\da-f]+$/i',
     * 'hex2' =>               '#^0x[\\da-f]+$#i',
     * 'octal' =>              '#^0[0-7]+$#',
     * 'binary' =>             '#^b[0-1]+$#i',
     *
     * @param string $value value to check
     * @param string $type validation type
     * @return bool|null if ok return true, of not return false, return null if validation type wasn't founded
     */
    public static function valid(string $value, string $type): ?bool
    {
        if (!isset(self::$regularExpressions[$type])) {
            return null;
        }

        return (bool)preg_match(self::$regularExpressions[$type], $value);
    }

    /**
     * check e-mail address format
     *
     * @param string $address
     * @return bool
     */
    public static function mail(string $address): bool
    {
        return (bool)preg_match(self::$regularExpressions['mail'], $address);
    }

    /**
     * check price format
     *
     * @param int|string $value
     * @return bool
     */
    public static function price($value): bool
    {
        return (bool)preg_match((string)self::$regularExpressions['price'], (string)$value);
    }

    /**
     * check post code format
     *
     * @param string $value
     * @return bool
     */
    public static function postcode(string $value): bool
    {
        return (bool)preg_match(self::$regularExpressions['postcode'], $value);
    }

    /**
     * check NIP number format
     *
     * @param string $value
     * @return bool
     */
    public static function nip(string $value): bool
    {
        if (!empty($value)) {
            $weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
            $nip = preg_replace('#[\\s-]#', '', $value);

            return self::processNip($nip, $weights);
        }

        return false;
    }

    /**
     * @param string $nip
     * @param array $weights
     * @return bool
     */
    protected static function processNip(string $nip, array $weights): bool
    {
        if (\is_numeric($nip) && strlen($nip) === 10) {
            $sum = 0;

            foreach ($weights as $key => $val) {
                $sum += $nip[$key] * $val;
            }

            return (string)($sum % 11) === $nip[9];
        }

        return false;
    }

    /**
     * check string length, possibility to set range
     *
     * @param string $value
     * @param null|int $min minimal string length, if null don't check
     * @param null|int $max maximal string length, if null don't check
     * @return bool
     * @example stringLength('asdasdasd', null, 23)
     * @example stringLength('asdasdasd', 3, 23)
     * @example stringLength('asdasdasd', 3)
     */
    public static function stringLength(string $value, ?int $min = null, ?int $max = null): bool
    {
        $length = \mb_strlen($value);

        return self::range($length, $min, $max);
    }

    /**
     * check range on numeric values
     * allows to check decimal, hex, octal an binary values
     *
     * @param int|string|float $value
     * @param mixed $min minimal string length, if null don't check
     * @param mixed $max maximal string length, if null don't check
     * @example range(23423, null, 23)
     * @example range(23423, 3, 23)
     * @example range(23423, 3)
     * @example range(0xd3a743f2ab, 3)
     * @example range('#aaffff', 3)
     * @return bool
     */
    public static function range($value, $min = null, $max = null): bool
    {
        [$value, $min, $max] = self::getProperValues($value, $min, $max);

        return !(($min !== null && $min > $value) || ($max !== null && $max < $value));
    }

    /**
     * check that numeric value is less than 0
     * if less return true
     *
     * @param int $value
     * @return bool
     */
    public static function underZero(int $value): bool
    {
        return $value < 0;
    }

    /**
     * check PESEL number format
     * also set sex of person in $peselSex variable
     *
     * @param mixed $value
     * @return bool
     */
    public static function pesel($value): bool
    {
        $value = preg_replace('#[\\s-]#', '', (string)$value);

        if (!preg_match('#^\d{11}$#', (string)$value)) {
            return false;
        }

        $arrSteps = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $intSum = 0;

        foreach ($arrSteps as $key => $step) {
            $intSum += $step * $value[$key];
        }

        $int = 10 - $intSum % 10;
        $intControlNr = ($int === 10) ? 0 : $int;

        return (string)$intControlNr === $value[10];
    }

    /**
     * check REGON number format
     *
     * @param mixed $value
     * @return bool
     */
    public static function regon($value): bool
    {
        $value = preg_replace('#[\\s-]#', '', (string)$value);
        $length = strlen($value);

        if (!($length === 9 || $length === 14)) {
            return false;
        }

        $arrSteps = [8, 9, 2, 3, 4, 5, 6, 7];
        $intSum = 0;

        foreach ($arrSteps as $key => $step) {
            $intSum += $step * $value[$key];
        }

        $int = $intSum % 11;
        $intControlNr = ($int === 10) ? 0 : $int;

        return (string)$intControlNr === $value[8];
    }

    /**
     * check account number format in NRB standard
     *
     * @param mixed $value
     * @return bool
     */
    public static function nrb($value): bool
    {
        $iNRB = preg_replace('#[\\s\- ]#', '', (string)$value);

        if (strlen($iNRB) !== 26) {
            return false;
        }

        $iNRB .= '2521';
        $iNRB = substr($iNRB, 2) . substr($iNRB, 0, 2);
        $iNumSum = 0;
        $aNumWeight = [
            1, 10, 3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53,
            45, 62, 38, 89, 17, 73, 51, 25, 56, 75, 71, 31, 19, 93, 57
        ];

        foreach ($aNumWeight as $key => $num) {
            $iNumSum += $num * $iNRB[29 - $key];
        }

        return $iNumSum % 97 === 1;
    }

    /**
     * check account number format in IBAN standard
     *
     * @param mixed $value
     * @return bool
     */
    public static function iban($value): bool
    {
        $values = '';
        $mod = 0;
        $remove = [' ', '-', '_', '.', ',','/', '|'];
        $cleared = \str_replace($remove, '', $value);
        $temp = \strtoupper($cleared);

        $firstChar = $temp[0] <= '9';
        $secondChar = $temp[1] <= '9';

        if ($firstChar && $secondChar) {
            $temp = 'PL' . $temp;
        }

        $temp = substr($temp, 4) . substr($temp, 0, 4);

        foreach (\str_split($temp) as $val) {
            $values .= self::IBAN_CHARS[$val];
        }

        $sum = strlen($values);
        for ($i = 0; $i < $sum; $i += 6) {
            $separated = $mod . substr($values, $i, 6);
            $mod = (int)($separated) % 97;
        }

        return $mod === 1;
    }

    /**
     * check URL address
     *
     * @param string $url
     * @param int|null $type if 1 check protocols also, if 2 check with GET parameters
     * @return bool
     */
    public static function url(string $url, ?int $type = null): bool
    {
        switch ($type) {
            case 1:
                $regType = self::$regularExpressions['url_extend'];
                break;

            case 2:
                $regType = self::$regularExpressions['url_full'];
                break;

            default:
                $regType = self::$regularExpressions['url'];
                break;
        }

        return (bool)preg_match($regType, $url);
    }

    /**
     * check phone number format
     * eg +48 ( 052 ) 131 231-2312
     *
     * @param mixed $phone
     * @return bool
     */
    public static function phone($phone): bool
    {
        return (bool)preg_match(self::$regularExpressions['phone'], $phone);
    }

    /**
     * check step of value
     *
     * @param int|float $value
     * @param int|float $step step to check
     * @param int|float $default default value (0)
     * @return bool
     * @example step(15, 5, 5) true
     * @example step(12, 5) false
     */
    public static function step($value, $step, $default = 0): bool
    {
        if (
            !self::valid((string)$step, 'rational')
            || !self::valid((string)$default, 'rational')
            || !self::valid((string)$value, 'rational')
        ) {
            return false;
        }

        return !((abs($value) - abs($default)) % $step);
    }

    /**
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     * @return array
     */
    protected static function getProperValues($value, $min, $max): array
    {
        if (self::isHex($min, $max)) {
            $value = hexdec(str_replace('#', '', $value));
            $min = hexdec(str_replace('#', '', $min));
            $max = hexdec(str_replace('#', '', $max));
        }

        if (self::isOctal($min, $max)) {
            $value = octdec($value);
            $min = octdec($min);
            $max = octdec($max);
        }

        if (self::isBin($min, $max)) {
            $value = bindec($value);
            $min = bindec($min);
            $max = bindec($max);
        }

        return [$value, $min, $max];
    }

    /**
     * @param mixed $min
     * @param mixed $max
     * @return bool
     */
    protected static function isHex($min, $max): bool
    {
        return (self::validKey('hex', $min) || self::validKey('hex2', $min))
            && (self::validKey('hex', $max) || self::validKey('hex2', $max));
    }

    /**
     * @param mixed $min
     * @param mixed $max
     * @return bool
     */
    protected static function isOctal($min, $max): bool
    {
        return self::validKey('octal', $min) && self::validKey('octal', $max);
    }

    /**
     * @param mixed $min
     * @param mixed $max
     * @return bool
     */
    protected static function isBin($min, $max): bool
    {
        return self::validKey('binary', $min) && self::validKey('binary', $max);
    }

    /**
     * @param string $key
     * @param int|float|double $value
     * @return int
     */
    protected static function validKey($key, $value): int
    {
        return preg_match(self::$regularExpressions[$key], (string)$value);
    }
}
