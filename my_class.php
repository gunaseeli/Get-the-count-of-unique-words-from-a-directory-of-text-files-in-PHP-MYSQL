<?php 
//error_reporting(0);
$ip=$_SERVER["SERVER_ADDR"];


	define("DB_HOST", "localhost");
	define("DB_NAME", "mydb");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_TABLE1", "watchlisttbl");
	
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
	if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	} 
	
	// Create database
	$sql_qer = "CREATE DATABASE IF NOT EXISTS ".DB_NAME;
	if ($conn->query($sql_qer) === TRUE) {
	   // echo "Database created successfully";
	} else {
		echo "Error creating database: " . $conn->error;
	}
	
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS,DB_NAME) or die('Error connecting to database');
	
	$query = "SELECT ID FROM watchlisttbl";
	$result = mysqli_query($link, $query);

	if(empty($result)) {
                $query2 = "CREATE TABLE ".DB_TABLE1." (
                          id int(11) AUTO_INCREMENT,
                          words blob,                          
                          PRIMARY KEY  (ID)
                          )";
                $result = mysqli_query($link, $query2);
	}
	$conn->close();
	
	



class mysql{ 


function add_query($field,$table){
			global $link;
			
			//Check if column exist in your table
			$selected_field=array();
			foreach ($field as $key => $value) {
				$result = mysqli_query($link, "SHOW COLUMNS FROM ".$table." LIKE '".$key."'");
				$exists = (mysqli_num_rows($result))?1:0;
				if($exists==1) {
				$selected_field[$key]=addslashes($value);
				}
			}
			
			$key_value = implode(",", array_keys($selected_field));
			$org_value = "'" . implode("','", array_values($selected_field)) . "'" ;			
			
		 	$sql="insert into $table($key_value) values ($org_value)";
			$query=mysqli_query($link,$sql); 
			return mysqli_insert_id($link);
		}
		
			
function select_query($table, $where){	
			 global $link;	 	     	
			 $sql=mysqli_query($link,"select * from $table $where"); 			
			 $num=mysqli_num_rows($sql);	 $array_category= array();			
			
			if($num!=0)
			{   
				$i=0;
				$array_category= array();				
				while($query=mysqli_fetch_assoc($sql))
				{
					 foreach ($query as $key => $value) {
					 $array_category[$i][$key]=stripslashes($value);
					 }
							
					$i++;
				}
			}			
			return $array_category;	
		}
		
function view_query($table,$where, $link){ global $link;
					$sql=mysqli_query($link, "select * from $table $where");
			return $query=mysqli_fetch_array($link, $sql);
	    }
			
		
function update_query($field,$table,$where){
			global $link;
			
			//Check if column exist in your table
			$selected_field=array();
			foreach ($field as $key => $value) {
				$result = mysqli_query($link, "SHOW COLUMNS FROM ".$table." LIKE '".$key."'");
				$exists = (mysqli_num_rows($result))?1:0;
				if($exists==1) {
				$selected_field[$key]=$value;
				}
			}
			
			
			$cn=1; $cnt_field=count($selected_field);  $update='';
			foreach($selected_field as $key => $val)
			{
				if($cn!=$cnt_field)$comma= ", ";else $comma='';				
				$update.=$key."='".addslashes($val)."'".$comma; 
				$cn++;
			}		
			
		 	$sql="Update $table set $update $where";
			$query=mysqli_query($link,$sql);
			return true;
		}
		
		
		
function cnt_table($table, $where){ global $link;
			$num=mysqli_num_rows(mysqli_query($link,"select * from $table $where"));			
			return $num;
}
		
}


function file_uniq_words($myFile)
{
	
	$lines = file($myFile);//file in to an array
	$filestring = implode(" ", $lines); 
	trim($filestring, " "); $arr_file=array();
	$arr_file=exp_word($filestring);
	return $arr_file;
	
}


function joinwords($arr_db,$arr_file)
{
	$joinarr=array_merge($arr_db,$arr_file);
	$joinarr = array_values(array_filter($joinarr));//remove empty array element and reindex
	
	$getuqwords=array_unique($joinarr);
	return $getuqwords=implode(' ', $getuqwords);
}

function exp_word($string) {
	$words=array();
	if($string!='') {
    $string = explode(' ', strtolower($string));
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
	return $words=$string;	
	}
}

function array_duplicates(array $array)
{
    return array_diff_assoc($array, array_unique($array));
}
function hasDuplicate($array) {
            $defarray = array();
        $filterarray = array();
        foreach($array as $val){
            if (isset($defarray[$val])) {
                $filterarray[] = $val;
            }
            $defarray[$val] = $val;
        }
		$string3 = implode(" ", $filterarray);
		$filterarray = array_values(array_filter($filterarray));
		$filterarray=array_unique($filterarray);
        return $filterarray;
}