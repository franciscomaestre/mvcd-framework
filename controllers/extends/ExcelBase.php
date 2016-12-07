<?php

namespace controllers\bases;

abstract class ExcelBase extends SmartyBase {

    protected function toExcel($view,$filename){
        header('Content-type: application/vnd.ms-excel; charset=windows-1258');
        header("Content-Disposition: attachment; filename=".$filename.date('d-m-Y').".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $result = $this->fetch($view);
        echo iconv("UTF-8","windows-1258",$result);
    }

}
