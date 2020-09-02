<?php


$settings = require "settings.php";


//решение №1
function config($optionValue, $defaultValue = NULL)
{
    global $settings;
    $localSetting = $settings;
    $vals = explode('.', $optionValue); //$optionValue - разбиваем на массивы по делителю
    $returnVal = null;
    foreach ($vals as $val) { // переберая все элементы массива (вложенность)
        if (isset($localSetting[$val])) { // проверяем существует ли элемент настроки с нужной вложенностью
            $localSetting = $localSetting[$val]; //если существует то мы "спускаемся на уровень выше"
            $returnVal = $localSetting;
        } else {
            $returnVal = null;// если не существует то выходим из цикла
            break;
        }
    }
   return returnData($optionValue,$defaultValue,$returnVal);

}
function returnData($optionValue,$defaultValue,$returnVal){
    global $settings;
    if ($defaultValue && !$returnVal) { // если есть значение по умолчанию то мы его и не существует элемент настройки то мы его создаем
        $defVal = $defaultValue;
        $vals1 = explode('.', $optionValue);//вновь получаем вложенный массив
        $reversVal = array_reverse($vals1);// разворачиваем вложенность в обратном порядке
        $data = array();
        foreach ($reversVal as $item) {
            $data = array($item => $defVal);//добавляем в обратном порядке значения массива
            $defVal = $data;
        }

        $settingsNew = array_merge_recursive($settings, $data);//объеденяем рекурсивно массивы настроек и нового значнеия
        return [
            'defaultValue' => $defaultValue,
            'newSettings' => $settingsNew
        ];
    }elseif ($returnVal&&!$defaultValue){
        return [
            'returnVal' => $returnVal,
        ];
    }elseif (!$returnVal&&!$defaultValue){
        throw new Exception('Ошибка - не существует параметра '.$optionValue .' настройки и не задано значение по умолчанию');
    }
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
    $returnVal = getData($settings[$vals[0]], $vals, $count, 0);//     используя рекурсию мы добираемся донужного нам элемента если у нас нет такого элеента в функцию вернется нулл если есть то значение
    return returnData($optionValue,$defaultValue,$returnVal);

}

try {
    echo '<pre> ';
    echo '1) Решение через цикл '. "\n";
    var_dump( config("site_url")); // http://mysite.ru
    var_dump( config("db.user")); // admin
    var_dump( config("app.services.resizer.fallback_format")); // jpeg
    var_dump( config("db.host", "localhost")); // localhost
    var_dump( config("db.host2")); // localhost
    echo '</pre>';
} catch (Exception $e){
    echo "Произошло исключение: " . $e->getMessage();
}
try {
    echo '<pre> ';
    echo  "\n";
    echo  "\n";
    echo '2) Решение через рекурсию '. "\n";
    var_dump( config1("site_url")); // http://mysite.ru
    var_dump( config1("db.user")); // admin
    var_dump( config1("app.services.resizer.fallback_format")); // jpeg
    var_dump( config1("db.host", "localhost")); // localhost
    var_dump( config1("db.host3")); // localhost

    echo '</pre>';
} catch (Exception $e){
    echo "Произошло исключение: " . $e->getMessage();
}