<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'lib/response.php';
require_once 'lib/request.php';


class User
{		
		var $userID;
		var $name;
		var $lastname;
                var $age;
}

require_once('database_connection.php');
$request = new Request(array());

if(isset($request->params))
{

    $array_r=$request->params;
    $user= new User();
    //$user->userID=($array_r->userID);
    $user->name=($array_r->name);
    $user->lastname=($array_r->lastname);
    $user->age=($array_r->age);
    
    //update
    $query="INSERT INTO Users (name,lastname,age) VALUES ('$user->name','$user->lastname',$user->age)";
    $result = mysqli_query($con, $query);
    //object response
    $res = new Response();
    $res->success = true;
    $res->message = "Created Record";
    
    
    //Need to Send USER to EXTjs to be correctly viewd in grid
    $result = mysqli_query($con, "SELECT * FROM Users where userID =".mysqli_insert_id($con));
    $query_array=array();
    $i=0;
    //Iterate all Select
    while($row = mysqli_fetch_array($result))
      {
        //Create New User instance
        $user = new User();
        //Fetch User Info
        $user->userID=$row['userID'];
        $user->name=$row['name'];
        $user->lastname=$row['lastname'];
        $user->age=$row['age'];

        //Add User to ARRAY
        $query_array[$i]=$user;
        $i++;
      }
     
      
    $res->data = $query_array;
    //print Json
    print_r($res->to_json());
}
else
{
    //echo "false";
    $res = new Response();
    $res->success = false;
    $res->message = "Error Create record";
    $res->data = array();
    print_r($res->to_json());
}
?>
