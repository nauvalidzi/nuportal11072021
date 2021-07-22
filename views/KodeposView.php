<?php

namespace PHPMaker2021\nuportal;

// Page object
$KodeposView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fkodeposview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fkodeposview = currentForm = new ew.Form("fkodeposview", "view");
    loadjs.done("fkodeposview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.kodepos) ew.vars.tables.kodepos = <?= JsonEncode(GetClientVar("tables", "kodepos")) ?>;
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
<form name="fkodeposview" id="fkodeposview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kodepos">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kodepos_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_kodepos_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kelurahan_id->Visible) { // kelurahan_id ?>
    <tr id="r_kelurahan_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kodepos_kelurahan_id"><?= $Page->kelurahan_id->caption() ?></span></td>
        <td data-name="kelurahan_id" <?= $Page->kelurahan_id->cellAttributes() ?>>
<span id="el_kodepos_kelurahan_id">
<span<?= $Page->kelurahan_id->viewAttributes() ?>>
<?= $Page->kelurahan_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kodepos->Visible) { // kodepos ?>
    <tr id="r_kodepos">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_kodepos_kodepos"><?= $Page->kodepos->caption() ?></span></td>
        <td data-name="kodepos" <?= $Page->kodepos->cellAttributes() ?>>
<span id="el_kodepos_kodepos">
<span<?= $Page->kodepos->viewAttributes() ?>>
<?= $Page->kodepos->getViewValue() ?></span>
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
