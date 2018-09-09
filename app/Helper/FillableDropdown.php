<?php
/**
 * Created by Azam Ali.
 * User: usol
 * Date: 12/7/16
 * Time: 12:30 PM
 */

namespace App;
namespace App\Helper;


class FillableDropdown
{
    public function priority($default = null){

        if($default == true){
            return [''=>'Select priority', 0=>'Heigh',1=>'Normal',2=>'Low'];

        }else{
            return [0=>'Heigh',1=>'Medium',2=>'Low'];

        }
    }

    public function orderStatus($default = null){

        if($default == 1){

            return [''=>'Select Status', 0=>'Un processed', 1=>'processed', 2=>'Pending', 3=>'Canceled', 'all'=>'Get All'];

        }elseif($default == 2){

            return [''=>'Select Status', 0=>'Un processed', 1=>'processed', 2=>'Pending', 3=>'Canceled', ];

        }elseif($default == 3){
            
            return [0=>'Un processed', 1=>'processed', 2=>'Padding', 3=>'Canceled'];

        }
    }

    public function orderType($default = null){

        if($default == true){
            return [''=>'Select Order Type', 0=>'Personal', 1=>'By Call', 2=>'By Message'];

        }else{
            return [0=>'Personal', 1=>'By Call', 2=>'By Message'];

        }
    }

    public function paymentStatus($default = null){

        if($default == true){
            return [''=>'Select Order Status', 1=>'Payed', 0=>'Not'];

        }else{
            return [1=>'Payed', 0=>'Not'];

        }
    }

    public function paymentType($default = null){

        if($default == true){
            return [''=>'Select Payment Type', 0=>'Credit', 1=>'Debit', 2=>'Cash'];

        }else{
            return [0=>'Debit', 1=>'Credit', 2=>'Cash'];

        }
    }

    public function active($default = null){

        if($default == true){
            return [ 1=>'Active', 0=>'Not'];

        }else{
            return [1=>'Active', 0=>'Not'];

        }
    }
    public function orderActiveKeyValue($default = null){

        if($default == 1){

            $data[0]['key']="0";
            $data[0]['value']="Not";
            $data[1]['key']="1";
            $data[1]['value']="Active";
            return $data;

        }else{


        }
    }

    public function orderStatusKeyValue($default = null){

        if($default == 1){

            $data[0]['key']="";
            $data[0]['value']="Select order status";
            $data[1]['key']="0";
            $data[1]['value']="Un processed";
            $data[2]['key']="1";
            $data[2]['value']="processed";
            $data[3]['key']="2";
            $data[3]['value']="Pending";
            $data[4]['key']="3";
            $data[4]['value']="Canceled";
            $data[5]['key']="all";
            $data[5]['value']="Reset";

            return $data;

        }elseif($default == 2){

            $data[0]['key']="";
            $data[0]['value']="Select order status";
            $data[1]['key']="0";
            $data[1]['value']="Un processed";
            $data[2]['key']="1";
            $data[2]['value']="processed";
            $data[3]['key']="2";
            $data[3]['value']="Pending";
            $data[4]['key']="3";
            $data[4]['value']="Canceled";

            return $data;

        }elseif($default == 3){

            $data[0]['key']="0";
            $data[0]['value']="Un processed";
            $data[1]['key']="1";
            $data[1]['value']="processed";
            $data[2]['key']="2";
            $data[2]['value']="Pending";
            $data[3]['key']="3";
            $data[3]['value']="Canceled";

            return $data;

        }elseif($default == 4){

            $data[0]['key']="all";
            $data[0]['value']="Reset order-status";
            $data[1]['key']="0";
            $data[1]['value']="Un processed";
            $data[2]['key']="1";
            $data[2]['value']="processed";
            $data[3]['key']="2";
            $data[3]['value']="Pending";
            $data[4]['key']="3";
            $data[4]['value']="Canceled";

            return $data;

        }else{


        }
    }
    public function orderPriorityKeyValue($default = null){


        [''=>'Select priority', 0=>'Heigh',1=>'Normal',2=>'Low'];

        if($default == 1){

            $data[0]['key']="";
            $data[0]['value']="Select priority";
            $data[1]['key']="0";
            $data[1]['value']="Heigh";
            $data[2]['key']="1";
            $data[2]['value']="Normal";
            $data[3]['key']="2";
            $data[3]['value']="Low";
            $data[4]['key']="all";
            $data[4]['value']="Reset";

            return $data;

        }elseif($default == 2){

            $data[0]['key']="";
            $data[0]['value']="Select priority";
            $data[1]['key']="0";
            $data[1]['value']="Heigh";
            $data[2]['key']="1";
            $data[2]['value']="Normal";
            $data[3]['key']="2";
            $data[3]['value']="Low";

            return $data;

        }elseif($default == 3){

            $data[0]['key']="0";
            $data[0]['value']="Heigh";
            $data[1]['key']="1";
            $data[1]['value']="Normal";
            $data[2]['key']="2";
            $data[2]['value']="Low";

            return $data;

        }elseif($default == 4){

            $data[0]['key']="all";
            $data[0]['value']="Reset Priorities";
            $data[1]['key']="0";
            $data[1]['value']="Heigh";
            $data[2]['key']="1";
            $data[2]['value']="Normal";
            $data[3]['key']="2";
            $data[3]['value']="Low";

            return $data;

        }else{


        }
    }

}