<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitaspesantrenView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ffasilitaspesantrenview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ffasilitaspesantrenview = currentForm = new ew.Form("ffasilitaspesantrenview", "view");
    loadjs.done("ffasilitaspesantrenview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.fasilitaspesantren) ew.vars.tables.fasilitaspesantren = <?= JsonEncode(GetClientVar("tables", "fasilitaspesantren")) ?>;
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
<form name="ffasilitaspesantrenview" id="ffasilitaspesantrenview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fasilitaspesantren">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitaspesantren_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_fasilitaspesantren_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
    <tr id="r_pid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitaspesantren_pid"><?= $Page->pid->caption() ?></span></td>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<span id="el_fasilitaspesantren_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
    <tr id="r_namafasilitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitaspesantren_namafasilitas"><?= $Page->namafasilitas->caption() ?></span></td>
        <td data-name="namafasilitas" <?= $Page->namafasilitas->cellAttributes() ?>>
<span id="el_fasilitaspesantren_namafasilitas">
<span<?= $Page->namafasilitas->viewAttributes() ?>>
<?= $Page->namafasilitas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitaspesantren_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_fasilitaspesantren_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
    <tr id="r_fotofasilitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitaspesantren_fotofasilitas"><?= $Page->fotofasilitas->caption() ?></span></td>
        <td data-name="fotofasilitas" <?= $Page->fotofasilitas->cellAttributes() ?>>
<span id="el_fasilitaspesantren_fotofasilitas">
<span<?= $Page->fotofasilitas->viewAttributes() ?>>
<?= GetFileViewTag($Page->fotofasilitas, $Page->fotofasilitas->getViewValue(), false) ?>
</span>
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
