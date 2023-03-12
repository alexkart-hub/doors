<?php
/** @var int $curRoomNumber */
$nextRoom1 = $curRoomNumber+1;
if ($this->room->doubleOut) {
    $nextRoom2 = $nextRoom1;
    $random = array_rand([1, 2]);
    if ($random == 1) {
        $nextRoom1 .= '&add=surprise';
    } else {
        $nextRoom2 .= '&add=surprise';
    }
}
?>
    <div class="col-1 text-center">
        <div class="flex-column">
            <a href="/?room=<?=$nextRoom1?>"class="mb-1 btn btn-secondary<?=($curRoomNumber>=100?' disabled':'')?>">></a>
            <? if ($this->room->doubleOut) {?>
                <a href="/?room=<?=$nextRoom2?>"class="mb-1 btn btn-secondary<?=($curRoomNumber>=100?' disabled':'')?>">></a>
            <? } ?>
        </div>
    </div>
</div>
