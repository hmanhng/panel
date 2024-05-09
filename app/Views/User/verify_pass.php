<?php
if(isset($_GET['key']) && ($_GET['token']) && ($_GET['mail']))
{
    include('conn.php');
    $emailId = $_GET['mail'];
    $token = $_GET['token'];;
    $password = $_GET['key'];
    date_default_timezone_set('Asia/Calcutta');
    $timestamp = date('Y-m-d h:i:s');
    $sql = mysqli_query($conn, "SELECT * FROM `users` WHERE `reset_link_token`='".$token."'");
    $result = mysqli_fetch_assoc($sql);
    $res = $result['exp_date'];
    $exp = strtotime($res);
    $exp_time = date('Y-m-d h:i:s', $exp);
    if($timestamp < $exp_time)
    {
        $query = mysqli_query($conn,"SELECT * FROM `users` WHERE `reset_link_token`='".$token."'");
        $row = mysqli_num_rows($query);
        if($row)
        {
            mysqli_query($conn,"UPDATE users set  password='" . $password . "', reset_link_token='" . NULL . "' ,exp_date='" . NULL . "' WHERE reset_link_token='" . $token . "'");
            echo '<p>Your password has been updated successfully</p>';
        }else{
            echo "<p>Something went wrong, please try again</p>";
        }
    } elseif($timestamp > $exp_time)
    {
        echo "<p>Expired link</p>";
    }
}else{
echo "<p>Broken link</p>";
}
?>