<?php

namespace App\Controllers;

use App\Models\User;


class Elostuff extends BaseController
{
    public function index()
    {
                
        $sql = EloModel::firstOrNew(array('nama'=>'ransrue'));
        $sql->nama = 'ransrue';
        $sql->save();

        $sql = EloModel::find(1);
        echo json_encode($sql);
        echo '<br>';

        $sql = EloModel::firstOrNew(array('nama'=>'buroq'));
        $sql->update(array('nama'=>'buroq.app'));

        $sql = EloModel::get();
        echo json_encode($sql);
        echo '<br>';
    }
}
