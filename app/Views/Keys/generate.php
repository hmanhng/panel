<?php
include('mail.php');
?>

<?= $this->extend('Layout/Starter') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <?= $this->include('Layout/msgStatus') ?>
        <?php if (session()->getFlashdata('user_key')) : ?>
            <div class="alert alert-success" role="alert">
            <?php
            $durate = '';
            if(session()->getFlashdata('duration') <= 24) {
                $duration = session()->getFlashdata('duration');
                $durate .=$duration." Hour(s)";
            } else {
                $duration = (session()->getFlashdata('duration')/24);
                $durate .=$duration." Day(s)";
            }
            ?>
                Game : <?= session()->getFlashdata('game') ?> / <?php echo $durate ?><br>
                License : <strong class="key-sensi"><?= session()->getFlashdata('user_key') ?></strong><br>
                Available for <?= session()->getFlashdata('max_devices') ?> Devices<br>
                <small>
                    <i>Duration will start when license login.</i><br>
                    <i class="bi bi-wallet"></i> Saldo Reduce :
                    <span class="text-danger">-<?= session()->getFlashdata('fees') ?></span>
                    (Total left <?= $user->saldo ?>₹)
                </small>
            </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-header p3 bg-dark text-white">
                <div class="row">
                    <div class="col pt-1">
                        Create License
                    </div>
                    <div class="col text-end">
                        <a class="btn btn-outline-light btn-sm" href="<?= site_url('keys/download/new') ?>"><i class="bi bi-download"></i></a>
                        <a class="btn btn-sm btn-outline-light" href="<?= site_url('keys') ?>"><i class="bi bi-people"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= form_open() ?>

                <div class="row">
                    <div class="form-group col-lg-6 mb-3">
                        <label for="game" class="form-label">Games</label>
                        <?= form_dropdown(['class' => 'form-select', 'name' => 'game', 'id' => 'game'], $game, old('game') ?: '') ?>
                        <?php if ($validation->hasError('game')) : ?>
                            <small id="help-game" class="text-danger"><?= $validation->getError('game') ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="form-group col-lg-6 mb-3">
                        <label for="max_devices" class="form-label">Max Devices</label>
                        
                        <input type="number" name="max_devices" id="max_devices" class="form-control" placeholder="1" value="<?= old('max_devices') ?: 1 ?>" max="99999999999999999999999999999999999999999999999999999999999999999999999999" min="1">
                        <?php if ($validation->hasError('game')) : ?>
                        
                        
                            <small id="help-max_devices" class="text-danger"><?= $validation->getError('max_devices') ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <?= form_dropdown(['class' => 'form-select', 'name' => 'duration', 'id' => 'duration'], $duration, old('duration') ?: '') ?>
                    <?php if ($validation->hasError('duration')) : ?>
                        <small id="help-duration" class="text-danger"><?= $validation->getError('duration') ?></small>
                    <?php endif; ?>
                </div>
                
                <div class="form-group col-lg-6 mb-3">
                   <label for="loopcount" class="form-label">Bulk Keys</label>         
                      <?= form_dropdown(['class'=>'form-select', 'name'=>'loopcount', 'id'=>'loopcount'], $loopcount, old('loopcount') ?: '') ?>
                      <?php if ($validation->hasError('loopcount')) : ?>
                            <small id="help-loopcount" class="text-danger"><?= $validation->getError('loopcount') ?></small>
                      <?php endif; ?>
                </div>
                
                
                <div class="form-group mb-3">
                    <label for="estimation" class="form-label">Estimation</label>
                    <input type="text" id="estimation" class="form-control" placeholder="Your order will total" readonly>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-dark">Generate</button>
                </div>
                <?= form_close() ?>

            </div>
        </div>
    </div>
</div>
</br></br></br>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?php if(($user->level == 1) || ($user->level == 2)) : ?>
<script>
    $(document).ready(function() {
        var price = JSON.parse('<?= $price ?>');
        getPrice(price);
        // When selected
        $("#max_devices, #loopcount, #duration, #game").change(function() {
            getPrice(price);
        });
        // try to get price
        function getPrice(price) {
            var price = price;
            var device = $("#max_devices").val();
            var durate = $("#duration").val();
            var bulk = $("#loopcount").val();
            var gprice = price[durate];
            if (gprice != NaN) {
                var res123 = (device * gprice);
                var result = (res123 * bulk);
                $("#estimation").val(result);
            } else {
                $("#estimation").val('Estimation error');
            }
        }
    });
</script>
<?php endif; ?>
<?php if($user->level == 3) : ?>
<script>
    $(document).ready(function() {
        var price = JSON.parse('<?= $price ?>');
        getPrice(price);
        // When selected
        $("#max_devices, #duration, #game").change(function() {
            getPrice(price);
        });
        // try to get price
        function getPrice(price) {
            var price = price;
            var device = $("#max_devices").val();
            var durate = $("#duration").val();
            var gprice = price[durate];
            if (gprice != NaN) {
                var result = (device * gprice);
                $("#estimation").val(result);
            } else {
                $("#estimation").val('Estimation error');
            }
        }
    });
</script>
<?php endif; ?>
<?= $this->endSection() ?>