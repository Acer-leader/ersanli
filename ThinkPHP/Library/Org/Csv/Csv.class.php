<?php

class Csv
{
    //导出csv文件
    public function put_csv($name, $list, $title){
        header ( 'Content-Type: application/vnd.ms-excel' );
        header ( 'Content-Disposition: attachment;filename='.$name.".xls" );
        header ( 'Cache-Control: max-age=0' );
        header("Expires: 0");
        $file = fopen('php://output',"a");
        $limit=1000;
        $calc=0;
        //foreach ($title as $v){
        //    $tit[]=iconv('UTF-8', 'GB2312//IGNORE',$v);
        //}
        fputcsv($file,$title,"\t");
        foreach ($list as $v){
            $calc++;
            if($limit==$calc){
                ob_flush();
                flush();
                $calc=0;
            }
            //foreach ($v as $t){
            //    $tarr[]=iconv('UTF-8', 'GB2312//IGNORE',$t);
            //}
            fputcsv($file,$v,"\t");
            //unset($tarr);
        }
        unset($list);
        fclose($file);
        exit();
    }
}