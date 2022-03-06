<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class bitmController extends Controller
{
//   This SQL Query Have to convert
//     public function getfRawHscodeImport($term,$calculation_year)
// {
//     $sql="SELECT CONCAT(t1.name,'--(',t2.hs_code,')--(',t2.schedule,')--(',t2.calculate_year,')') AS name, t2.id AS hsid,t1.id AS itemid
//     FROM items AS t1
//     INNER JOIN hs_code as t2
//     ON t1.name LIKE '%$term%' OR t2.hs_code LIKE '%$term%'
//     WHERE t1.hs_code_id = t2.id
//     AND t1.hs_code = t2.hs_code
//     AND t2.schedule = 'cust_tarrif'
//     AND t2.calculate_year=$calculation_year";
//    $query=$this->db->query($sql);
//    return $query->result();

// }
  
  
  
  
   //After converting to Laravel QueryBuilder
    public function getfRawHscodeImport($term,$calculation_year){
        $itemAll=DB::table('items as t1')
        ->join('hs_code as t2', function ($join) {
            $join->on('t1.name', 'like', '%$term%')
                 ->orOn('t2.hs_code', 'like', '%$term%');
        })
        ->where('t1.hs_code_id', '=', 't2.id')
        ->where('t1.hs_code', '=', 't2.hs_code')
        ->where('t2.schedule', '=', 'cust_tarrif')
        ->where('t2.calculate_year', '=', $calculation_year)
        ->select("t1.*", DB::raw("CONCAT(t1.name,'--(',t2.hs_code,')--(',t2.schedule,')--(',t2.calculate_year,')') AS name "),"t2.id AS hsid","t1.id AS itemid")
        ->get();
        return $itemAll;
    }


       //This is One of that but not sure
  public function getfRawHscodeImport($term,$calculation_year){
        $result=DB::table('items as t1')
        ->join('hs_code as t2', function ($join) {
            $join->on('t1.hs_code_id', '=', 't2.id');      
        })
        ->where('t2.hs_code', 'like', '%$term%')
        ->where('t1.name', 'like', '%$term%')
        ->where('t1.hs_code', '=', 't2.hs_code')
        ->where('t2.schedule', '=', 'cust_tarrif')
        ->where('t2.calculate_year', '=', $calculation_year)
        ->select(DB::raw("CONCAT(t1.name,'--(',t2.hs_code,')--(',t2.schedule,')--(',t2.calculate_year,')') AS name "),"t2.id AS hsid","t1.id AS itemid")
        ->get();
        return $result;
    }

}
