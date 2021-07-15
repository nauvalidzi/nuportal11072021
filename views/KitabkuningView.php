<?php

namespace PHPMaker2021\nuportal;

// Page object
$KitabkuningView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fkitabkuningview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fkitabkuningview = currentForm = new ew.Form("fkitabkuningview", "view");
    loadjs.done("fkitabkuningview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.kitabkuning) ew.vars.tables.kitabkuning = <?= JsonEncode(GetClientVar("tables", "kitabkuning")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fkitabkuningview" id="fkitabkuningview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kitabkuning">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kitabkuning_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_kitabkuning_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
    <tr id="r_pid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kitabkuning_pid"><?= $Page->pid->caption() ?></span></td>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<span id="el_kitabkuning_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pelaksanaan->Visible) { // pelaksanaan ?>
    <tr id="r_pelaksanaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kitabkuning_pelaksanaan"><?= $Page->pelaksanaan->caption() ?></span></td>
        <td data-name="pelaksanaan" <?= $Page->pelaksanaan->cellAttributes() ?>>
<span id="el_kitabkuning_pelaksanaan">
<span<?= $Page->pelaksanaan->viewAttributes() ?>>
<?= $Page->pelaksanaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->metode->Visible) { // metode ?>
    <tr id="r_metode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kitabkuning_metode"><?= $Page->metode->caption() ?></span></td>
        <td data-name="metode" <?= $Page->metode->cellAttributes() ?>>
<span id="el_kitabkuning_metode">
<span<?= $Page->metode->viewAttributes() ?>>
<?= $Page->metode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
