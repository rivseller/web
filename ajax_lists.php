<?php

# подключение БД
require 'connect_matrix.php';
mysql_query("SET NAMES 'utf8");
mysql_query("SET CHARACTER SET 'utf8'");

# Отрисовка выпадающих списков в форме
switch ($_POST['action']){
                
        case "showSkillForInsert":
                echo 'Выберите область знаний ';
                echo '<select size="1" name="skill" onchange="javascript:selectCompetence();">';
                echo "<option value='' selected></option>";
                $parent_dict=mysql_query("SELECT parent_name FROM competency_dict WHERE 1 group by parent_name order by parent_name") or die(mysql_error());
                $arr_parent_dict=mysql_fetch_array($parent_dict);
                do
                    {echo "<option value=".$arr_parent_dict['parent_name'].">".$arr_parent_dict['parent_name']."</option>";}
                while ($arr_parent_dict = mysql_fetch_array($parent_dict));
                echo '</select>';
                break;
       

        case "showCompetenceForInsert":
                $parent_name=$_POST['id_skill'];
                $competency_dict=mysql_query("SELECT `value`,`name` FROM `competency_dict` WHERE parent_name='$parent_name' order by name") or die(mysql_error());
                $arr_competency_dict=mysql_fetch_array($competency_dict);

                echo 'Оцените компетенцию <br><br>';
                $c_arr=array();
                
                do
                    {
                    /*селекты для выпадающих списков по оценке и частоте*/
                    $value_dict1=mysql_query("SELECT `value`,`name` FROM `value_dict` WHERE 1 limit 0,30") or die(mysql_error());
                    $arr_value_dict1=mysql_fetch_array($value_dict1);
                    
                    $freq_dict1=mysql_query("SELECT `value`,`name` FROM `freq_dict` WHERE 1 limit 0,30") or die(mysql_error());
                    $arr_freq_dict1=mysql_fetch_array($freq_dict1);
                    
                    $competency_v=$arr_competency_dict['value'];
                    array_push($c_arr, $competency_v);

                    echo "<b>".$arr_competency_dict['name']."</b>";

                        
                        /*выпадающий список с оценкой компетенции*/
                        echo "<br>Уровень знаний: <select name='value".$competency_v."' value='оценка".$competency_v."'>";
                        do
                        {
                            $value=$arr_value_dict1['value'];
                            echo "<option value=".$value.">".$arr_value_dict1['name']."</option>   ";
                        }
                        while ($arr_value_dict1 = mysql_fetch_array($value_dict1));
                        echo "</select>";
                        
                        /*выпадающий список с частотой*/
                        echo "<br>Частота применения: <select name='freq".$competency_v."' value='частота".$competency_v."'>";
                        do
                        {
                            $freq=$arr_freq_dict1['value'];
                            echo "<option value=".$freq.">".$arr_freq_dict1['name']."</option>";
                        }
                        while ($arr_freq_dict1 = mysql_fetch_array($freq_dict1));
                        echo "</select><br>====================================<br>";

                    ;}
                while ($arr_competency_dict = mysql_fetch_array($competency_dict));
                
                /*создаём массив полученных навыков и передаем его на страницу rtportal с помощью скрытой переменной на форме*/
                $c_array=implode(' ', $c_arr);
                echo "<p><input type='hidden' name='competency_arr' value='$c_array'></p>";
        
};

?>
