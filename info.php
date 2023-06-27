<?php
include 'koneksi.php';
$sql1 = "SELECT * FROM info WHERE name = 'keywords' ";
$result1 = $conn->query($sql1);
$sql2 = "SELECT * FROM info WHERE name = 'api' ";
$result2 = $conn->query($sql2);
$response['keywords'] = array();
$response['key'] = array();
$r['info']= array();
  while($row1 = $result1->fetch_assoc()) {    
    $response['keywords']=$row1['value'];
  }

  while($row2 = $result2->fetch_assoc()) {

    $ch = curl_init(); 

    // set url 
    curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/youtube/v3/videos?id=7lCDEYXw3mM&key=".$row2['value']);

    // return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    // $output contains the output string 
    $output = curl_exec($ch); 

    // tutup curl 
    curl_close($ch);      

    $data=json_decode($output);

    // menampilkan hasil curl
    // echo $data->error->code;
     
    if (isset($data->error->code)) {
      // echo $data->error->code;
      
      # code...
    }
    else {
      $response['key']=$row2['value'];
    }

  }


$x=  array("keywords"=>$response['keywords'], "ytapi"=>$response['key']);
array_push($r['info'],$x);
echo json_encode($r);


$conn->close();
?>