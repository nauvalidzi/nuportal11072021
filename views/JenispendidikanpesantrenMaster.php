<?php

namespace PHPMaker2021\nuportal;

// Table
$jenispendidikanpesantren = Container("jenispendidikanpesantren");
?>
<?php if ($jenispendidikanpesantren->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_jenispendidikanpesantrenmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($jenispendidikanpesantren->title->Visible) { // title ?>
        <tr id="r_title">
            <td class="<?= $jenispendidikanpesantren->TableLeftColumnClass ?>"><?= $jenispendidikanpesantren->title->caption() ?></td>
            <td <?= $jenispendidikanpesantren->title->cellAttributes() ?>>
<span id="el_jenispendidikanpesantren_title">
<span<?= $jenispendidikanpesantren->title->viewAttributes() ?>>
<?= $jenispendidikanpesantren->title->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
