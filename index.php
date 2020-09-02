<?php




$settings = require "settings.php";

function config($optionValue, $defaultValue = NULL)
{

    global $settings;
    $localSetting=$settings;

    //решение №1


    $vals = explode('.', $optionValue); //$optionValue - разбиваем на массивы по делителю


    $returnVal=null;

    foreach ($vals as $val) {
        if(isset($localSetting[$val])){
            $localSetting=$localSetting[$val];
            $returnVal=$localSetting;
        }else{
            $returnVal=null;
            break;
        }
    }
    var_dump($returnVal);




    // для того чтобы мы смогли работать с воложеностю настроек
//    $current=$settings[$startVal];       // мы должны получить первый элемент массива и если такой элемент существует мы путем перебора и перезадания текущего элемента  проверем на существоание нужного нам элемента
//    $returnVal=null;                     // переменная отвечающая за сзачение настройки
//    if(isset($current)){
//        if(count($vals)){                // проверка на настройку без вложений при разбивке строки на массив и при извлечении первого  элемента мы  "отсекаем" от массива первый елемент
//            foreach ($vals as $val) {
//                if (isset( $current[$val])) {
//                    $current =$current[$val];
//                    $returnVal=$current;
//
//                } else {
//                    $returnVal=null;
//                    break;
//                }
//            }
//        }else{
//            $returnVal=$current;
//        }
//    }else{
//        $returnVal= null;
//    }




//    if($defaultValue&&!$returnVal){
//        $vals1 = explode('.', $optionValue);//вновь получаем вложенный массив
//        $vals2=  array_reverse($vals1);// разворачиваем вложенность в обратном порядке
////        $startVal2=array_shift($vals2); // для того чтобы мы смогли работать с воложеностю настроек
//        $data=array();
////        $data[$startVal2]=$defaultValue;
//
//
//
//            foreach ($vals2 as $item) {
//                $data=array($item=>$defaultValue);
//                $defaultValue=$data;
////
//            }
//            $merges=array_merge_recursive($settings,$data);
//    }










//    $count = count($vals);
//   var_dump( {"[$vals[0]]"});
    // используя рекурсию мы добираемся донужного нам элемента если у нас нет такого элеента в функцию вернется нулл если есть то значение

//    $res = getData($settings[$vals[0]], $vals, $count, 0);
//
//    var_dump($res);

}



///////////////////////////////////////////////////////////////////////////////////////////////


function getData($current, $options, $count, $pos)
{
    if (isset($current)) {//  проверяем наличие элемента
        if ($count == $pos + 1) { //если элемент имеется мы провермяем позицию в массиве если позиция явлется последней в цепочке то мы его возвращаем
            return $current;
        } else { // если элемент не последний то мы увеличиваем позицию и снова запускаем рекурсию
            $pos++;
            if (isset($current[$options[$pos]])) { //проверка на существование элемента
                return getData($current[$options[$pos]], $options, $count, $pos);
            } else {
                return null;
            }
        }

    } else {
        return null;
    }
}
function config1($optionValue, $defaultValue = NULL)
{
    global $settings;
    //решение №2
    $vals = explode('.', $optionValue); //$optionValue - разбиваем на массивы по делителю
    $count = count($vals);
    $res = getData($settings[$vals[0]], $vals, $count, 0);//     используя рекурсию мы добираемся донужного нам элемента если у нас нет такого элеента в функцию вернется нулл если есть то значение

    var_dump($res);

}


config('app.services.resizerw');
//config1('site_name');