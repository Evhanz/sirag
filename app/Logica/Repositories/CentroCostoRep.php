<?php
/**
 * Created by PhpStorm.
 * User: ehernandez
 * Date: 14/09/2016
 * Time: 05:08 PM
 */

namespace sirag\Repositories;


class CentroCostoRep
{

    public function getSaldoCCByCuentaAndPeriodo($data)
    {


        $f_i = $data['f_i'];
        $f_f = $data['f_f'];

        $query = "select CT.CUENTA,CT.ALIAS_CUENTA,CT.DESCRIPCION,
                (SUM(MV.DEBE_ORIGEN) - SUM(MV.HABER_ORIGEN)) AS SALDO, MV.AUX_VALOR1 AS 'CENTRO DE COSTO'
                from flexline.CON_CTACON as CT inner join 
                flexline.CON_MOVCOM as MV ON 
                CT.EMPRESA = MV.EMPRESA AND CT.CUENTA = MV.CUENTA
                WHERE CT.EMPRESA = 'e01' 
                AND CT.CUENTA like '06%'
                AND CT.IND_MOVIMIENTO = 'S'
                and MV.ESTADO='a'
                
                AND DATALENGTH(MV.AUX_VALOR1) > 0 
                AND MV.FECHA BETWEEN '$f_i' AND '$f_f'
                GROUP BY  CT.DESCRIPCION, CT.CUENTA,CT.ALIAS_CUENTA,MV.AUX_VALOR1
                ORDER BY CT.CUENTA";

        $res = \DB::select($query);

        return $res;



    }

}