<?php
/**
 * contains all methods to validate data
 *
 * @package     BlueData
 * @subpackage  Data
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */
namespace BlueData\Check;

class Validator
{
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
        'mail' =>               '#^[\\w_\.-]*[\\w_]@[\\w_\.-]*\\.[\\w_-]{2,3}$#e',
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
     * 'mail' =>               '#^[\\w_\.-]*[\\w_]@[\\w_\.-]*\\.[\\w_-]{2,3}$#e',
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
     * @param mixed $value value to check
     * @param string $type validation type
     * @return boolean if ok return true, of not return false, return null if validation type wasn't founded
     */
    public static function valid($value, $type)
    {
        if (!isset(self::$regularExpressions[$type])) {
            return null;
        }

        $bool = preg_match(self::$regularExpressions[$type], $value);

        if (!$bool) {
            return false;
        }

        return true;
    }

    /**
     * check e-mail address format
     *
     * @param string $address
     * @return boolean
     */
    public static function mail($address)
    {
        if (!preg_match(self::$regularExpressions['mail'], $address)) {
            return false;
        }

        return true;
    }

    /**
     * check price format
     *
     * @param int $value
     * @return boolean
     */
    public static function price($value)
    {
        $bool = preg_match(self::$regularExpressions['price'], $value);

        if (!$bool) {
            return false;
        }

        return true;
    }

    /**
     * check post code format
     *
     * @param string $value
     * @return boolean
     */
    public static function postcode($value)
    {
        $bool = preg_match(self::$regularExpressions['postcode'], $value);

        if (!$bool) {
            return false;
        }

        return true;
    }

    /**
     * check NIP number format
     *
     * @param string $value
     * @return boolean
     */
    public static function nip($value)
    {
        if (!empty($value)) {
            $weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
            $nip = preg_replace('#[\\s-]#', '', $value);

            if (is_numeric($nip) && strlen($nip) === 10) {
                $sum = 0;

                foreach ($weights as $key => $val) {
                    $sum += $nip[$key] * $val;
                }

                return (string)($sum % 11) === $nip[9];
            }
        }

        return false;
    }

    /**
     * check string length, possibility to set range
     *
     * @param string $value
     * @param int $min minimal string length, if null don't check
     * @param int $max maximal string length, if null don't check
     * @return boolean
     * @example stringLength('asdasdasd', null, 23)
     * @example stringLength('asdasdasd', 3, 23)
     * @example stringLength('asdasdasd', 3)
     */
    public static function stringLength($value, $min = null, $max = null)
    {
        $length = mb_strlen($value);

        return self::range($length, $min, $max);
    }

    /**
     * check range on numeric values
     * allows to check decimal, hex, octal an binary values
     *
     * @param int $value
     * @param int $min minimal string length, if null don't check
     * @param int $max maximal string length, if null don't check
     * @example range(23423, null, 23)
     * @example range(23423, 3, 23)
     * @example range(23423, 3)
     * @example range(0xd3a743f2ab, 3)
     * @example range('#aaffff', 3)
     * @return boolean
     */
    public static function range($value, $min = null, $max = null)
    {
        list($value, $min, $max) = self::getProperValues($value, $min, $max);

        return !(($min !== null && $min > $value) || ($max !== null && $max < $value));
    }

    /**
     * check that numeric value is less than 0
     * if less return true
     *
     * @param int $value
     * @return boolean
     */
    public static function underZero($value)
    {
        return $value < 0;
    }

    /**
     * check PESEL number format
     * also set sex of person in $peselSex variable
     *
     * @param mixed $value
     * @return boolean
     */
    public static function pesel($value)
    {
        $value = preg_replace('#[\\s-]#', '', $value);
        if (!preg_match('#^\d{11}$#', $value)) {
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
     * @return boolean
     */
    public static function regon($value)
    {
        $value = preg_replace('#[\\s-]#', '', $value);
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
     * @return boolean
     */
    public static function nrb($value)
    {
        $iNRB = preg_replace('#[\\s- ]#', '', $value);

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
            $iNumSum += $num * $iNRB[29 -$key];
        }

        return $iNumSum % 97 === 1;
    }

    /**
     * check account number format in IBAN standard
     *
     * @param mixed $value
     * @return boolean
     */
    public static function iban($value)
    {
        $values = '';
        $mod = 0;
        $remove = [' ', '-', '_', '.', ',','/', '|'];
        $cleared = str_replace($remove, '', $value);
        $temp = strtoupper($cleared);
        $chars = [
            '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4',
            '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9',
            'A' => '10', 'B' => '11', 'C' => '12', 'D' => '13', 'E' => '14',
            'F' => '15', 'G' => '16', 'H' => '17', 'I' => '18', 'J' => '19',
            'K' => '20', 'L' => '21', 'M' => '22', 'N' => '23', 'O' => '24',
            'P' => '25', 'Q' => '26', 'R' => '27', 'S' => '28', 'T' => '29',
            'U' => '30', 'V' => '31', 'W' => '32', 'X' => '33', 'Y' => '34',
            'Z' => '35'
        ];

        $firstChar = $temp{0} <= '9';
        $secondChar = $temp{1} <= '9';

        if ($firstChar && $secondChar) {
            $temp = 'PL' . $temp;
        }

        $temp = substr($temp, 4) . substr($temp, 0, 4);

        foreach (str_split($temp) as $val) {
            $values .= $chars[$val];
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
     * @return boolean
     */
    public static function url($url, $type = null)
    {
        switch ($type) {
            case 1:
                $type = self::$regularExpressions['url_extend'];
                break;

            case 2:
                $type = self::$regularExpressions['url_full'];
                break;

            default:
                $type = self::$regularExpressions['url'];
                break;
        }

        $bool = preg_match($type, $url);

        if (!$bool) {
            return false;
        }

        return true;
    }

    /**
     * check phone number format
     * eg +48 ( 052 ) 131 231-2312
     *
     * @param mixed $phone
     * @return boolean
     */
    public static function phone($phone)
    {
        if (!preg_match(self::$regularExpressions['phone'], $phone)) {
            return false;
        }

        return true;
    }

    /**
     * check step of value
     *
     * @param int|float $value
     * @param int|float $step step to check
     * @param int|float $default default value (0)
     * @return boolean
     * @example step(15, 5, 5) true
     * @example step(12, 5) false
     */
    public static function step($value, $step, $default = 0)
    {
        if (!self::valid($step, 'rational')
            || !self::valid($default, 'rational')
            || !self::valid($value, 'rational')
        ) {
            return false;
        }

        $check = (abs($value) -abs($default)) % $step;

        if ($check) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     * @return array
     */
    protected static function getProperValues($value, $min, $max)
    {
        if ((self::validKey('hex', $min) || self::validKey('hex2', $min))
            && (self::validKey('hex', $max) || self::validKey('hex2', $max))
        ) {
            $value = hexdec(str_replace('#', '', $value));
            $min = hexdec(str_replace('#', '', $min));
            $max = hexdec(str_replace('#', '', $max));
        }

        if (self::validKey('octal', $min) && self::validKey('octal', $max)) {
            $value = octdec($value);
            $min = octdec($min);
            $max = octdec($max);
        }

        if (self::validKey('binary', $min) && self::validKey('binary', $max)) {
            $value = bindec($value);
            $min = bindec($min);
            $max = bindec($max);
        }

        return [$value, $min, $max];
    }

    /**
     * @param string $key
     * @param int $value
     * @return int
     */
    protected static function validKey($key, $value)
    {
        return preg_match(self::$regularExpressions[$key], $value);
    }
}
