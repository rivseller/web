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
                $parent_dict=mysql_query("SELECT parent_name FROM competency_dict WHERE 1 group by parent_name order by parent_name") or die(mysql_error());
                $arr_parent_dict=mysql_fetch_array($parent_dict);
                do
                    {echo "<option value=".$arr_parent_dict['parent_name'].">".$arr_parent_dict['parent_name']."</option>";}
                while ($arr_parent_dict = mysql_fetch_array($parent_dict));
                echo '</select>';
                break;
                
        case "showCompetenceForInsert":
                $parent_name=$_POST['id_skill'];
                echo 'Выберите компетенцию ';
                echo '<select size="1" name="competence">';
                $competency_dict=mysql_query("SELECT `value`,`name` FROM `competency_dict` WHERE parent_name='$parent_name' order by name") or die(mysql_error());
                $arr_competency_dict=mysql_fetch_array($competency_dict);
                do
                    {echo "<option value=".$arr_competency_dict['value'].">".$arr_competency_dict['name']."</option>";}
                while ($arr_competency_dict = mysql_fetch_array($competency_dict));
                echo '</select>';
                break;
        
};

?>