<?php
namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\UserModel;
use CodeIgniter\Config\Services;

include('conn.php');
$CompName = "Vip Panel";

$this->userid = session()->userid;
$this->model = new UserModel();
$this->user = $this->model->getUser($this->userid);
$user = $this->user;
$usern = $user->username;
$sql = "SELECT `email` from `users` where username='".$user->username."'";
$result = mysqli_query($conn, $sql);
$usermail = mysqli_fetch_assoc($result);

date_default_timezone_set('Asia/Ho_Chi_Minh');
$timestamp = date('d/m/Y h:i:sa');
$accesstime = date('h:i:sa');
$webpage = $_SERVER['REQUEST_URI'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$url = $_SERVER['SERVER_NAME'];
$server = $_SERVER['HTTP_HOST'];

function getUserIP()
{
    $clientIp  = @$_SERVER['HTTP_CLIENT_IP'];
    $forwardIp = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remoteIp  = $_SERVER['REMOTE_ADDR'];
    if(filter_var($clientIp, FILTER_VALIDATE_IP))
    {
        $ipaddress = $clientIp;
    }
    elseif(filter_var($forwardIp, FILTER_VALIDATE_IP))
    {
        $ipaddress = $forwardIp;
    }
    else
    {
        $ipaddress = $remoteIp;
    }
    return $ipaddress;
}
$user_ip = getUserIP();

    if (isset($username)||($email)) {  
        $email = \Config\Services::email();
        $email->setFrom('panel@just-panel.xyz', 'Panel By Spencer');
        $email->setTo($usermail);
        
        $email->setSubject("Successfull login at $server");
        $email->setMessage("Hello $usern
        
You have successfully logged in to your account

Login IP - $user_ip
Login Time - $timestamp
Accessed Page - $webpage
Browser - $browser");
$email->send();
}
?>