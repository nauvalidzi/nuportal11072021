<?php

namespace PHPMaker2021\nuportal;

// Table
$kitabkuning = Container("kitabkuning");
?>
<?php if ($kitabkuning->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_kitabkuningmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($kitabkuning->id->Visible) { // id ?>
        <tr id="r_id">
            <td class="<?= $kitabkuning->TableLeftColumnClass ?>"><?= $kitabkuning->id->caption() ?></td>
            <td <?= $kitabkuning->id->cellAttributes() ?>>
<span id="el_kitabkuning_id">
<span<?= $kitabkuning->id->viewAttributes() ?>>
<?= $kitabkuning->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($kitabkuning->pid->Visible) { // pid ?>
        <tr id="r_pid">
            <td class="<?= $kitabkuning->TableLeftColumnClass ?>"><?= $kitabkuning->pid->caption() ?></td>
            <td <?= $kitabkuning->pid->cellAttributes() ?>>
<span id="el_kitabkuning_pid">
<span<?= $kitabkuning->pid->viewAttributes() ?>>
<?= $kitabkuning->pid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($kitabkuning->pelaksanaan->Visible) { // pelaksanaan ?>
        <tr id="r_pelaksanaan">
            <td class="<?= $kitabkuning->TableLeftColumnClass ?>"><?= $kitabkuning->pelaksanaan->caption() ?></td>
            <td <?= $kitabkuning->pelaksanaan->cellAttributes() ?>>
<span id="el_kitabkuning_pelaksanaan">
<span<?= $kitabkuning->pelaksanaan->viewAttributes() ?>>
<?= $kitabkuning->pelaksanaan->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($kitabkuning->metode->Visible) { // metode ?>
        <tr id="r_metode">
            <td class="<?= $kitabkuning->TableLeftColumnClass ?>"><?= $kitabkuning->metode->caption() ?></td>
            <td <?= $kitabkuning->metode->cellAttributes() ?>>
<span id="el_kitabkuning_metode">
<span<?= $kitabkuning->metode->viewAttributes() ?>>
<?= $kitabkuning->metode->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
