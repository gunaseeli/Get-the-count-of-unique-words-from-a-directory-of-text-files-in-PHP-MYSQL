<?
include("my_class.php");
$sql= new mysql();

$field=array();
$myFile = "smallFile.txt";
$arr_file=array();$arr_db=array();
$arr_file=file_uniq_words($myFile);
$where=" where id ='1'";
	
$cnt=$sql->cnt_table(DB_TABLE1, $where);
if($cnt>0) { 		
		$res3=$sql->select_query(DB_TABLE1,$where);
		$dbstring2 = $res3[0]['words'];
		$arr_db=exp_word($dbstring2);		
} else { $arr_db=array();}



$getuqwords=joinwords($arr_db,$arr_file);
$field['words']=$getuqwords;	

if($cnt==0) { 
		$res=$sql->add_query($field,DB_TABLE1);
}
else { 
		$where=" where id ='1'";	
		$res2=$sql->update_query($field,DB_TABLE1,$where);
}

echo "Distinct unique words: " .count($arr_file);


$duplicates = hasDuplicate($arr_file);

echo "<br><br>Watchlist words:<br>";

echo $getstring = implode("<br>", $duplicates);


?>