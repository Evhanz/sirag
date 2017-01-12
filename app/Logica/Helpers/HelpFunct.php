<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25/11/16
 * Time: 11:46 AM
 */

namespace sirag\Helpers;
use sirag\Entities\Obj;

class HelpFunct
{

    /**
     * Reemplaza todos los acentos por sus equivalentes sin ellos
     *
     * @param $string
     *  string la cadena a sanear
     *
     * @return $string
     *  string saneada
     */

    static public function sanear_string($string)
    {

        $string = trim($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        //no se usara por mientras
        /*
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             ".", " "), '',   $string);
        */


        return $string;

    }

    static public function orderArrayNumberAsc($arreglo)
    {

        for ($i = 0; $i < count($arreglo) - 1; $i++) {
            for ($x = $i + 1; $x < count($arreglo); $x++) {
                if ($arreglo[$i] > $arreglo[$x]) {

                    $aux = $arreglo[$i];
                    $arreglo[$i] = $arreglo[$x];
                    $arreglo[$x] = $aux;
                }
            }
        }

        return $arreglo;

    }

    static public function getItemsByLenOfArray($len, $arreglo)
    {
        $response = array();

        for ($i = 0; $i < count($arreglo); $i++) {
            $var = $arreglo[$i];
            if (strlen("$var") == $len) {
                array_push($response, $var);
            }
        }

        return $response;
    }

    /**
     * la funcion saca los valores unicos de los elementos del array
     * desde un inicio a un fin de cada valor :
     * ----------------Respuesta--------------------
     * @return $response
     * ----------------Necesita-------------------
     * int $inicio : desde donde empezara a sacar el valor
     * int $fin: cuantos caracteres sacaremos
     * array $arreglo
     *
     */

    static public function getPartValuesUniquesOfArray($inicio, $fin, $arreglo)
    {

        $reponse = array();

        for ($i = 0; $i < count($arreglo); $i++) {
            $val = $arreglo[$i];
            $val = substr($val, $inicio, $fin);

            if (!in_array($val, $reponse)) {
                array_push($reponse, $val);
            }
        }

        return $reponse;

    }

    /**
     * esta funcion es para sacar los items que perenecen a el parron y al fundo
     * correspondiente , tener en consideracion que
     *
     * ----------------Respuesta-----------------
     * @return $response : es un array de objetos que tendra los codigos formateados
     * -----------------Requiere----------------
     * array $arreglo : donde estan los items
     */
    static public function getItemsByFundoAndParron($arreglo)
    {

        $response = array();
        $codigos = array();

        //primero separamos las campañas
        $campañas = self::getPartValuesUniquesOfArray(0, 2, $arreglo);

        //recorremos cada campaña para sacar sus códigos
        for ($i = 0; $i < count($campañas); $i++) {

            $val = new Obj();
            $codigos = [];

            for ($x = 0; $x < count($arreglo); $x++) {

                $a = $arreglo[$x];

                if (substr($a, 0, 2) == $campañas[$i]) {
                    array_push($codigos, $arreglo[$x]);
                }

            }
            $val->campain = $campañas[$i];
            $val->codigos = $codigos;
            array_push($response, $val);
        }
        return $response;

    }

    /**
     * la funcion llena con ceros de acuerdo a la cantidad que sean necesarias al
     * lado izquierdo
     * @return $response
     * ------------Necesita--------------------
     * int $limit: de acuerdo al limite llenara de ceros
     * string $item: la cadena a modificar
     */
    static public function fillZerosLeft($limit, $item)
    {

        $cant_zero = $limit - strlen($item);
        $zeros = '';
        for ($i = 0; $i < $cant_zero; $i++) {
            $zeros .= '0';
        }

        $response = $zeros . $item;
        return $response;
    }

    /**
     * la funcion necesita de un string que sera separado  por la bandera
     * luego unido en la misma posicion
     * */
    static public function divideStringForBanderaAndUnite($string, $bandera)
    {

        $response = explode($bandera, $string);
        $response = $response[0] . $response[1] . $response[2];

        return $response;
    }

    /**
     * la funcion necesita una query para escribirla en un txt
     * */
    static public function writeQuery($query)
    {

        $file = fopen(base_path()."/storage/logs/query_temp.txt", "w");
        fputs($file,$query);
        fclose($file);
    }


    /**
     *esta funcion transforma un string a un tipo date específico, como se muestra en la siguiente
     * informacion, sacada de : https://msdn.microsoft.com/es-es/library/ms187928.aspx
     *
     * Sin el siglo (AA) (1)	Con el siglo (aaaa)	Standard	Entrada/salida (3)
    -	0 or 100 (1,2)	Valor predeterminado para datetime y smalldatetime	mes dd aaaa hh:mia.m. (o p.m.)
    1	101	EE. UU.	1 = mm/dd/aa

    101 = mm/dd/aaaa
    2	102	ANSI	2 = aa.mm.dd

    102 = aaaa.mm.dd
    3	103	Británico/Francés	3 = dd/mm/aa

    103 = dd/mm/aaaa
    4	104	Alemán	4 = dd.mm.aa

    104 = dd.mm.aaaa
    5	105	Italiano	5 = dd-mm-aa

    105 = dd-mm-aaaa
    6	106 (1)	-	6 = dd mes aa

    106 = dd mes aaaa
    7	107 (1)	-	7 = Mes dd, aa

    107 = Mes dd, aaaa
    8	108	-	hh:mi:ss
    -	9 or 109 (1,2)	Valor predeterminado + milisegundos	mes dd aaaa hh:mi:ss:mmma.m. (o p.m.)
    10	110	EE. UU.	10 = mm-dd-aa

    110 = mm-dd-aaaa
    11	111	JAPÓN	11 = aa/mm/dd

    111 = aaaa/mm/dd
    12	112	ISO	12 = aammdd

    112 = aaaammdd
    -	13 or 113 (1,2)	Europeo predeterminado + milisegundos	dd mes aaaa hh:mi:ss:mmm(24h)
    14	114	-	hh:mi:ss:mmm(24h)
    -	20 o 120 (2)	ODBC canónico	aaaa-mm-dd hh:mi:ss(24h)
    -	21 o 121 (2)	ODBC canónico (con milisegundos), valor predeterminado para time, date, datetime2 y datetimeoffset	aaaa-mm-dd hh:mi:ss.mmm(24h)
    -	126 (4)	ISO8601	aaaa-mm-ddThh:mi:ss.mmm (sin espacios)

    Nota: Si el valor de milisegundos (mmm) es 0, no se muestra el valor de milisegundos. Por ejemplo, el valor '2012-11-07T18:26:20.000' se muestra como '2012-11-07T18:26:20'.
    -	127(6, 7)	ISO8601 con zona horaria Z.	aaaa-mm-ddThh:mi:ss.mmmZ (sin espacios)

    Nota: Si el valor de milisegundos (mmm) es 0, no se muestra el valor de milisegundos. Por ejemplo, el valor '2012-11-07T18:26:20.000' se muestra como '2012-11-07T18:26:20'.
    -	130 (1,2)	Hijri (5)	dd mes aaaa hh:mi:ss:mmma.m.

    En este estilo, mes es una representación Unicode Hijri multitoken del nombre completo del mes. Este valor no se representará correctamente en una instalación estadounidense predeterminada de SSMS.
    -	131 (2)	Hijri (5)	dd/mm/aaaa hh:mi:ss:mmma.m.
     *
     *
     * -----------------Require--------------------
     * string $date: el string tiene que estar en formato - YYYYMMDD
     * string $tipo : el tipo es de acuerdo al caso que se encuentra en la informacion antes dada
     */

    static public function transformStringToDate($date,$tipo)
    {

        $response = '';

        switch ($tipo){

            case '103':
                $response =substr($date,6,2).'/'.substr($date,4,2).'/'. substr($date,0,4);
                break;
        }

        return $response;
    }



}