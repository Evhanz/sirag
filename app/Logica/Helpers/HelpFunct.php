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
     * esta funcion es para sacar los items que pertenecen a el parron y al fundo
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
                $response =substr($date,6,2).'/'.substr($date,4,2).'/'. substr($date,0,4);//dd/mm/yyyy
                break;
        }

        return $response;
    }


    /**
     * la funcion te trae el nombre del año de acuerdo al numero
    */
    static public function NameMonth($mes){

        switch ($mes){

            case 1: $response='ENERO'; break;
            case 2: $response='FEBRERO'; break;
            case 3: $response='MARZO'; break;
            case 4: $response='ABRIL'; break;
            case 5: $response='MAYO'; break;
            case 6: $response='JUNIO'; break;
            case 7: $response='JULIO'; break;
            case 8: $response='AGOSTO'; break;
            case 9: $response='SEPTIEMBRE'; break;
            case 10: $response='OCTUBRE'; break;
            case 11: $response='NOVIEMBRE'; break;
            case 12: $response='DICIEMBRE'; break;
            default: $response = 'error'; break;
        }

        return $response;

    }

    /**
     * la funcion devuelve los valor que no se repiten
     * de un conjunto de elementos de la posicion n(desde) -  hasta
     * de cada elemento
     * necesario : $array array
     * devuelve : collect()
     */

    public static function getUniqueValueOfArrayOfNPosition($array,$n = 2, $cant = 1)
    {

        $response = [];

        foreach ($array as $item){

            $val = substr($item,$n,$cant);

            if (!in_array($val,$response)){
                array_push($response,$val);
            }
        }

        return $response;


    }

    public static function getUltimoDiaMes($elAnio,$elMes) {
        return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }

    /*
     * la fecha necesita formato yyyy-mm-dd
     */

    public static function getNextDia($fecha) {
        $f = new \DateTime($fecha);
        $f->add(new \DateInterval('P1D'));//para sacar el siguiente dia

        return $f;
    }

    /*
     * generar un hash code para no colicionar archivos
     * se coge el codigo de consulta concatenado por los dos ultimos
     * igitos del año + el mes + el dia , concatenado por la suma de la hora y los minutos
     *
     * $key: string => es el key que dirige el hash
     * */
    public function setHashCode($key){

        $newDate = getdate();

        if($newDate['mon'] < 10){

            $newDate['mon'] = '0'.$newDate['mon'];
        }

        $year = substr($newDate['year'],2,2);
        $mes = $newDate['mon'];
        $dia = $newDate['mday'];
        $hora = $newDate['H'];
        $minuto = $newDate['i'];


        $hash = $key.($year+$mes+$dia);




    }

    /**
     * Analizar esta funcion , no recuerdo para que la hice pero seguramente te va a servir
     * Ultimo que la hizo: Eidelman ... :3
     * @return string : hash
     */
    public static function getHash(){
        $date_now =  getdate();

        $factor_random = rand(100,600);

        $hash = $factor_random.$date_now['hours'].$date_now['minutes'].$date_now['seconds'];

        return $hash;
    }

    /**
     * @param null $formato = es el formato de fecha devuelto
     * @return \DateTime|false|string
     */

    public static function getFechaActual($formato=null){

        $hoy = getdate();

        /*primero seteamos la fecha con todos los parámetros que deve ir normalmente
            'Y-m-d H:i:s', luego se convierte en el formato que se desee
        */

        $mes  = $hoy['mon'];
        $year = $hoy['year'];
        $dia = $hoy['mday'];

        $segundos = $hoy['seconds'];
        $minutos = $hoy['minutes'];
        $horas = $hoy['hours'];

        if(strlen($mes) == 1 ) $mes= '0'.$mes;
        if(strlen($dia) == 1 ) $dia= '0'.$dia;
        if(strlen($segundos) == 1 ) $segundos= '0'.$segundos;
        if(strlen($minutos) == 1 ) $minutos= '0'.$minutos;
        if(strlen($horas) == 1 ) $horas= '0'.$horas;

        $fecha = "$year-$mes-$dia $horas:$minutos:$segundos";

        $fecha = date_create($fecha);
        $fecha = date_format($fecha, $formato);


        return $fecha;

    }


    /**
     * @param $element : es lo que se le sumará , si dia o mes o año
     * @param $cantidad : cantidad de elementos que se adecionará
     * @param $operacion : si es suma o resta = (+) o (-)
     * @param $fecha : si se ingresa se toma esa fecha y no laactual , la fecha tiene que venir en formato yyyy-mm-dd
     * @return $nuevafecha|string : la fechasumada
     */


    public static function addElementFecha($element,$cantidad,$operacion,$fecha=null){

        #ejemplos : +2 day
        $add = "$operacion".$cantidad." $element";

        if($fecha == null){
            $fecha = date('Y-m-j');
        }

        $nuevafecha = strtotime ( $add , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );


        return $nuevafecha ;

    }

    /**
     * @param $nameFile: el nombre del archivo donde se almacenará el log de desarrollo
     * @param $text: la informacion que estará en el log
     * @param null $tipo_insert puede ser a (para agregar debajon del texto), w para sobre escribir todo
     */

    public static function writeLog($nameFile,$text,$tipo_insert=null){

        $path_archivo = base_path()."/storage/logs/$nameFile";
        if($tipo_insert == null) $tipo_insert = 'w';

        if (!file_exists($path_archivo)) {

            $file = fopen($path_archivo, 'w');
        } else{
            $file = fopen($path_archivo, $tipo_insert);
        }

        fputs($file,$text.PHP_EOL);
        fclose($file);


    }



}