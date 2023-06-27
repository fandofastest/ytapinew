<?php
include 'koneksi.php';

$response['data'] = array();

$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$halaman =isset($_GET["size"]) ? (int)$_GET["size"] : 25;
$page    =isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$mulai    =($page>1) ? ($page * $halaman) - $halaman : 0;


$sql = "SELECT * FROM video";
$result = $conn->query($sql);
$total = mysqli_num_rows($result);
$pages = ceil($total/$halaman);
$tampilMas    =$conn->query("SELECT * FROM video LIMIT $mulai, $halaman");
$no    =$mulai+1;

$response['pages'] = $pages;
$response['total'] = $total;
if ($page!==$pages) {
    $response['next'] = $actual_link.'?page='.($page+1);
}
if ($page!==1) {
    $response['prev'] = $actual_link.'?page='.($page-1);
}

$response['current'] = $actual_link.'?page='.$page;
while($row = $tampilMas->fetch_assoc()) {
    array_push($response["data"],$row['videoid']);
}

// // var_dump($total);


echo json_encode($response);


$conn->close();
?>