<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01/12/16
 * Time: 04:29 PM
 */

namespace sirag\Repositories\packing;


class MateriaPrimaRep
{

    public function getByParameters($data)
    {

        $query = "";


        $res = \DB::select($query);


        return $res;
    }

    public function store($data)
    {

        $query = "";


        $res = \DB::insert($query);


        return $res;
    }

    public function update($data)
    {

        $query = "";


        $res = \DB::update($query);


        return $res;
    }

    public function delete($data)
    {

        $query = "";


        $res = \DB::delete($query);


        return $res;
    }

    public function getDetalleUva($data){

    }

    public function getDetalleDescarte($data){

    }

    public function storeDetalleUva($data){

    }

    public function storeDetalleDescarte($data){

    }

    public function updateDetalleUva($data){

    }

    public function updateDetalleDescarte($data){

    }

    public function deleteDetalleUva($data){

    }

    public function deleteDetalleDescarte($data){

    }




}