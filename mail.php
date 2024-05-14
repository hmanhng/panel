<?php

namespace App\Controllers;

use App\Models\CodeModel;
use App\Models\UserModel;
use CodeIgniter\Config\Services;

include('conn.php');

// For Users Mail
$sql = "SELECT email FROM users where username='Owner'";
$result = mysqli_query($conn, $sql);
$usersmail = mysqli_fetch_assoc($result);

if (session()->has('userid'))
{
$this->userid = session()->userid;
$this->model = new UserModel();
$this->user = $this->model->getUser($this->userid);
$user = $this->user;
$usern = $user->username;
}else {
$usern = "No User Account found";
}
function getUserIP1()
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
$user_ip = getUserIP1();


date_default_timezone_set('Asia/Ho_Chi_Minh');
$iplogfile = 'logs.html';
$webpage = $_SERVER['REQUEST_URI'];
$timestamp = date('d/m/Y h:i:sa');
$accesstime = date('h:i:sa');
$browser = $_SERVER['HTTP_USER_AGENT'];
$url = $_SERVER['SERVER_NAME'];

$email = \Config\Services::email();
$email->setFrom('panel@just-panel.xyz', 'Panel By Spencer Knox');
$email->setTo($usersmail);
$email->setSubject("Someone visited your panel at $accesstime");
$email->setMessage("$user_ip visited your panel!
Browser - $browser
Visit time - $accesstime
Page visited - $webpage");
$email->send();

?>