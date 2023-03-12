<?php /** @var int $curRoomNumber */?>
<div class="row">
    <div class="col-1 text-center btn-left">
        <div class="btn-group-vertical">
            <a href="/?room=<?=$curRoomNumber - 1?>" class="btn btn-secondary<?=($curRoomNumber <= 0 ? ' disabled' : '')?>"><</a>
        </div>
    </div>
