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

}