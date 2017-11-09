<?php

function preffered_subjects($dbh,$sid,$preffered_subject,$year_list)
{
    $pc=0;
    $size=sizeof($preffered_subject);
    //echo ("</br>".$size."<br>");
    if($size==0)
    {
      foreach ($year_list as $year_table)
      {
          #$year=explode(".",$pref_sub);
          #echo ("</br>---".$year[0]."---</br>");
          #echo ("</br>---".$year[1]."---</br>");
          #$year=explode(".",$pref_sub);
          $sql=$dbh->prepare("SELECT student_info.student_id,".$year_table." FROM student_info INNER JOIN ".$year_table." ON student_info.student_id=".$year_table.".".$year_table."_id WHERE student_id='".$sid."'");
          $sql->execute();
          $result=$sql->fetchAll();
          #var_dump($result);
          foreach ($result as $score)
          {
              $pc=$pc+$score['1'];
          }
      }
    }
    else
    {
        foreach ($preffered_subject as $pref_sub)
        {
            $year=explode(".",$pref_sub);
            //echo ("</br>---".$year[0]."---</br>");
            //echo ("</br>---".$year[1]."---</br>");
            #$year=explode(".",$pref_sub);
            $sql=$dbh->prepare("SELECT student_info.student_id,".$pref_sub." FROM student_info INNER JOIN ".$year[0]." ON student_info.student_id=".$year[0].".".$year[0]."_id WHERE student_id='".$sid."'");
            $sql->execute();
            $result=$sql->fetchAll();
            #var_dump($result);
            foreach ($result as $score)
            {
                $pc=$pc+$score['1'];
            }
        }
    #echo ("\nScore\t\t:".$pc."\n");
    }
    return $pc;
}
function remaining_subjects($dbh,$sid,$year_list)
{
    $rpc=0;
    foreach ($year_list as $yl)
    {
        #echo $yl,$sid;
        $sql=$dbh->prepare("SELECT * FROM ".$yl." WHERE ".$yl."_id='".$sid."'");
        $sql->execute();
        $result=$sql->fetchAll();
        #var_dump ($result);
        #echo ("\n Remaining Subjects\n");
        for ($i=1;$i<=10;$i++)
        {
            foreach ($result as $res)
            {
                #var_dump($res);
                $rpc=$rpc+$res[$i];
            }
        }
    }
    return $rpc;
}

function controller($dbh,$sid,$preffered_subject,$preffered_points,$remaining_points,$total_subject,$year_list,$preffered_subject_count,$R,$name)
{
    $pc=preffered_subjects($dbh,$sid,$preffered_subject,$year_list);
    $pcp=($pc/100)*$preffered_points;
    #echo ("Preffered Score : ".$pc);
    #echo ("\nPC =\t\t".$pcp."\n");
    $rpc=remaining_subjects($dbh,$sid,$year_list);
    $rc=$rpc-$pc;
    $rcp=($rc/100)*$remaining_points;
    $prXP=(($pcp+$rcp)*10)/(($preffered_subject_count*$preffered_points)+($R*$remaining_points));
    $ep=number_format((float)(((certificates($dbh,$sid)+projects($dbh,$sid)+internship($dbh,$sid))/9.99)*10),2,'.','');
    return array($prXP,$ep);
}

function projects($dbh,$sid)
{
    $pc=0;
    $pp=0;
    $sql=$dbh->prepare("SELECT * FROM projects WHERE project_id=".$sid.";");
    $sql->execute();
    $result=$sql->fetchAll();
    for ($i=1;$i<=2;$i++)
    {
        foreach ($result as $res)
        {
            #var_dump($res);
            if($i==1)
            {
                $pp=$pp+$res[$i]*3.33;
                $pc=$pc+$res[$i];
            }
            elseif($i==2)
            {
                $pp=$pp+$res[$i]*2.22;
                $pc=$pc+$res[$i];
            }
        }
    }
    if($pc==0)
    {
        return "None";
    }
    else
    {
        return ($pp/$pc);
    }
}

function internship($dbh,$sid)
{
    $ic=0;
    $ip=0;
    $sql=$dbh->prepare("SELECT * FROM certificate WHERE certificate_id=".$sid.";");
    $sql->execute();
    $result=$sql->fetchAll();
    for ($i=1;$i<=3;$i++)
    {
        foreach ($result as $res)
        {
            #var_dump($res);
            if($i==1)
            {
                $ip=$ip+$res[$i]*1.11;
                $ic=$ic+$res[$i];
            }
            elseif($i==2)
            {
                $ip=$ip+$res[$i]*2.22;
                $ic=$ic+$res[$i];
            }
            else
            {
                $ip=$ip+$res[$i]*3.33;
                $ic=$ic+$res[$i];
            }
        }
    }
    if($ic==0)
    {
        return "None";
    }
    else
    {
        return ($ip/$ic);
    }
}

function certificates($dbh,$sid)
{
    $cc=0;
    $cp=0;
    $sql=$dbh->prepare("SELECT * FROM certificate WHERE certificate_id=".$sid.";");
    $sql->execute();
    $result=$sql->fetchAll();
    for ($i=1;$i<=3;$i++)
    {
        foreach ($result as $res)
        {
            #var_dump($res);
            if($i==1)
            {
                $cp=$cp+$res[$i]*1;
                $cc=$cc+$res[$i];
            }
            elseif($i==2)
            {
                $cp=$cp+$res[$i]*0.75;
                $cc=$cc+$res[$i];
            }
            else
            {
                $cp=$cp+$res[$i]*0.5;
                $cc=$cc+$res[$i];
            }
        }
    }
    if($cc==0)
    {
        return "None";
    }
    else
    {
        return ($cp/$cc)*3.33;
    }
}

function main($preffered_subject)
{
    #$sort=readline("Enter The Sorting Criteria Score = ");
    #$pref_city=readline("Enter Preffered City Name = ");
    $sort=$_GET['pref_score'];
    $pref_city=$_GET['pref_city'];
    if($sort==NULL)
    {
      $sort=0;
    }
    #---------------------------------------Declaration----------------------------
    $total_subject=40;
    #$preffered_subject=array();
    $preffered_subject_count=count($preffered_subject);
    $R=$total_subject-$preffered_subject_count;
    $preffered_points=2;
    $remaining_points=1;
    $year_list=array('firstyear','secondyear','thirdyear','finalyear');
    $user='root';
    $pass='password@123';
    #change HOST name and DB name in below line//////////////////
    #------------------------------------------------------------------------------
    try
    {
        $dbh = new PDO('mysql:host=localhost;dbname=Test', $user, $pass);
        #$sql = $dbh->prepare("INSERT INTO test (value) VALUES(?)");
        #SELECT student_info.name,secondyear.s2 FROM student_info INNER JOIN secondyear ON student_info.student_id=secondyear.secondyear_id WHERE secondyear.s2 > 60;
        $sql = $dbh->prepare("SELECT * FROM student_info");
        $sql->execute();
        $result=$sql->fetchAll();
        $create=$dbh->prepare("CREATE TABLE IF NOT EXISTS list_temp(student_id INT(3) , name VARCHAR(20) , score VARCHAR(5) , CIP_score VARCHAR(5)  , college VARCHAR(20) , city VARCHAR(20))");
        $create->execute();
        echo ("\nStudent_ID\t|\tStudent_Name\t|\tPoints Scored\t|\tCIP Score Secured\t|\tCollege\t\t\t|\tCity\n");
        echo "</br></br>";
        foreach ($result as $ps)
        {
            #echo ("\n-------------------------------------------------------------------------\n");
            #echo ($ps['student_id']."\t\t|\t".$ps['name']."\t\t|\t");
            $name=$ps['name'];
            $sid=$ps['student_id'];
            $city=$ps['city'];
            $college=$ps['college_name'];
            $prXP=controller($dbh,$sid,$preffered_subject,$preffered_points,$remaining_points,$total_subject,$year_list,$preffered_subject_count,$R,$name);
            #echo ($prXP[0]."\t|\t$prXP[1]");
            $prXP[0]=number_format((float)$prXP[0], 2, '.', '');
            #echo ($prXP."\n");
            #echo ("\n-------------------------------------------------------------------------\n");
            #$sql=$dbh->prepare("CREATE TABLE list_temp('student_id' INT(3) , 'name' VARCHAR(20) , 'score' INT(5)");
            #$sql->execute();
            $sql=$dbh->prepare("INSERT INTO list_temp VALUES(".$sid.",'".$name."','".$prXP[0]."','".$prXP[1]."','".$college."','".$city."')");
            $sql->execute();
        }
        $sql=$dbh->prepare("SELECT * FROM list_temp WHERE score>=".$sort." ORDER BY score DESC");
        $sql->execute();
        $result=$sql->fetchAll();
        #var_dump($result);
        foreach ($result as $out)
        {
            echo ("\n".$out[0]."\t\t|\t".$out[1]."\t\t|\t".$out[2]."\t\t|\t".$out[3]."\t\t\t|\t".$out[4]."\t\t|\t".$out[5]);
            echo "</br>";
        }
        echo "</br></br>";
        echo ("\n\n\nCollege\t\t|\tStudents In That College\n");
        echo "</br></br>";
        $sql=$dbh->prepare("SELECT college,count(college) FROM list_temp WHERE score>=".$sort." GROUP BY college ORDER BY count(college) DESC;");
        $sql->execute();
        $result=$sql->fetchAll();
        foreach($result as $out)
        {
            echo("\n".$out[0]."\t\t|\t".$out[1]);
            echo "</br>";
        }
        echo "</br></br>";
        echo ("\n\n");
        echo ("\nCity\t\t|\tStudents In That City\n");
        echo "</br></br>";
        if($pref_city==NULL)
        {
          $pref_city=0;
          $city_sql=$dbh->prepare(" SELECT city,count(city) FROM list_temp WHERE score >=".$sort." GROUP BY city ORDER BY count(city);");
        }
        else
        {
          $city_sql=$dbh->prepare(" SELECT city,count(city) FROM list_temp WHERE score >=".$sort." AND city='".$pref_city."' GROUP BY city ORDER BY count(city);");
        }
        $city_sql->execute();
        $result=$city_sql->fetchAll();
        foreach($result as $out)
        {
            echo ("\n".$out[0]."\t\t|\t".$out[1]);
            echo "</br>";
        }
        echo ("\n\n");
        $sql=$dbh->prepare("DROP TABLE list_temp");
        $sql->execute();
    }
    catch (PDOException $e)
    {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
$subject=(isset($_GET["subject"]) ? $_GET["subject"] : NULL);
$preffered_subject=array();
if ($subject==NULL) {
  main($preffered_subject);
}
else {
foreach ($subject as $sub)
{
    array_push($preffered_subject,$sub);
}
main($preffered_subject);
}
