<?php

include('conn.php');
include('mail.php');
include('UserMail.php');

// For Credits
$sql = "SELECT * FROM credit where id=1";
$result = mysqli_query($conn, $sql);
$credit = mysqli_fetch_assoc($result);

// For Keys count
$sql = "SELECT COUNT(*) as id_keys FROM keys_code";
$result = mysqli_query($conn, $sql);
$keycount = mysqli_fetch_assoc($result);

// For Active Keys count
$sql = "SELECT COUNT(devices) as devices FROM keys_code";
$result = mysqli_query($conn, $sql);
$active = mysqli_fetch_assoc($result);

// For In-Active Keys Count
$sql = "SELECT COUNT(*) as devices FROM keys_code where devices IS NULL";
$result = mysqli_query($conn, $sql);
$inactive = mysqli_fetch_assoc($result);

// For Users Count
$sql = "SELECT COUNT(*) as id_users FROM users";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_assoc($result);

$userid = session()->userid;
$sql = "SELECT `expiration_date` FROM `users` WHERE `id_users` = '".$userid."'";
$query = mysqli_query($conn, $sql);
$period = mysqli_fetch_assoc($query);

function HoursToDays($value)
{
    if($value == 1) {
       return "$value Hour";
    } else if($value >= 2 && $value < 24) {
       return "$value Hours";
    } else if($value == 24) {
       $darkespyt = $value/24;
       return "$darkespyt Day";
    } else if($value > 24) {
       $darkespyt = $value/24;
       return "$darkespyt Days";
    }
}

$dateTime = strtotime($period['expiration_date']);
$getDateTime = date("F d, Y H:i:s", $dateTime);
?>

<?= $this->extend('Layout/Starter') ?>
<?= $this->section('content') ?>
<style>
    @import 'https://fonts.googleapis.com/css?family=Nova+Mono|Eczar';
    
    #exp {
      font-family: 'Nova Mono', monospace;
      text-align: center;
      /*color: #fff;*/
      font-size: 5vw;
      text-shadow: 0px 0px 20px blue;
    }
    
    @media only screen and (max-width: 100%){
      #time {font-size: 1em;}
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <?= $this->include('Layout/msgStatus') ?>
    </div> 
    <h3>
      <center>
        <b>
          <font size="3" color="#000000">
            Panel serviced by - 
              <a href="https://telegram.me/SpencerKnox">
                <font color="#00008B">
                  <?php echo $credit['name']; ?>
                </font>
              </a>
          </font>
        </b>
      </center>
    </h3>
    
    <div class="col-lg-8" style="padding:15px;">
        <div class="card mb-3">
              <div class="card-header text-center text-white bg-warning">
                Account Expiration
              </div>
              <div class="card-body">
                  <p id="exp"></p>
             </div>
        </div>
    </div>
    
    <div class="col-lg-8" style="padding:15px;">
        <div class="card mb-3">
              <div class="card-header text-center text-white bg-danger">
                Key(s) info
              </div>
              <div class="card-body">
                <ul class="list-group list-hover mb-3">
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Total keys<span class="badge text-success">
                            <?php echo $keycount['id_keys']; ?>
                        </span>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Used keys<span class="badge text-success">
                            <?php echo $active['devices']; ?>
                        </span>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Un-used keys<span class="badge text-danger">
                            <?php echo $inactive['devices']; ?>
                        </span>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">Total users<span class="badge text-danger">
                            <?php echo $users['id_users']; ?>
                        </span>
                    </li>
                </ul>
              </div>
            </div>
        </div>

        <div class="col-lg-8" style="padding:15px;">
            <div class="card mb-3">
                <div class="card-header text-center text-white bg-primary">
                    History
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover text-center">
                            <tbody>
                                <?php foreach ($history as $h) : ?>
                                    <?php $in = explode("|", $h->info) ?>
                                    <tr>
                                        <td><span class="align-middle badge text-dark">#3812<?= $h->id_history ?></span></td>
                                        <td><?= $in[0] ?></td>
                                        <td><span class="align-middle badge text-dark"><?= $in[1] ?>**</span></td>
                                        <td><span class="align-middle badge text-dark"><?= HoursToDays($in[2]); ?></span></td>
                                        <td><span class="align-middle badge text-primary"><?= $in[3] ?> Devices</span></td>
                                        <td><i class="align-middle badge text-muted"><?= $time::parse($h->created_at)->humanize() ?></i></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4" style="padding:15px;">
            <div class="card mb-3">
                <div class="card-header text-center text-white bg-success">
                    Information
                </div>
                <div class="card-body">
                    <ul class="list-group list-hover mb-3">
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Role
                            <span class="badge text-dark">
                                <?= getLevel($user->level) ?>
                            </span>
                        </li>
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Saldo Balance
                            <span class="badge text-dark">
                                ₹<?= $user->saldo ?>
                            </span>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Last login
                            <span class="badge text-dark">
                                <?= $time::parse(session()->time_since)->humanize() ?>
                            </span>
                        </li>
                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Auto logout
                            <span class="badge text-dark">
                                <?= $time::now()->difference($time::parse(session()->time_login))->humanize() ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
  <script>
      var countDownTimer = new Date("<?php echo "$getDateTime"; ?>").getTime();
        // Update the count down every 1 second
        var interval = setInterval(function() {
            var current = new Date().getTime();
            // Find the difference between current and the count down date
            var diff = countDownTimer - current;
            // Countdown Time calculation for days, hours, minutes and seconds
            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById("exp").innerHTML = days + "Day(s) : " + hours + "h " +
            minutes + "m " + seconds + "s ";
            // Display Expired, if the count down is over
            if (diff < 0) {
                clearInterval(interval);
                document.getElementById("exp").innerHTML = "Expired";
            }
        }, 1000);
</script>
<?= $this->endSection() ?>