<?php

namespace PHPMaker2021\nuportal;

// Page object
$WilayahView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fwilayahview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fwilayahview = currentForm = new ew.Form("fwilayahview", "view");
    loadjs.done("fwilayahview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.wilayah) ew.vars.tables.wilayah = <?= JsonEncode(GetClientVar("tables", "wilayah")) ?>;
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
<form name="fwilayahview" id="fwilayahview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="wilayah">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->iduser->Visible) { // iduser ?>
    <tr id="r_iduser">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_wilayah_iduser"><?= $Page->iduser->caption() ?></span></td>
        <td data-name="iduser" <?= $Page->iduser->cellAttributes() ?>>
<span id="el_wilayah_iduser">
<span<?= $Page->iduser->viewAttributes() ?>>
<?= $Page->iduser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idprovinsis->Visible) { // idprovinsis ?>
    <tr id="r_idprovinsis">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_wilayah_idprovinsis"><?= $Page->idprovinsis->caption() ?></span></td>
        <td data-name="idprovinsis" <?= $Page->idprovinsis->cellAttributes() ?>>
<span id="el_wilayah_idprovinsis">
<span<?= $Page->idprovinsis->viewAttributes() ?>>
<?= $Page->idprovinsis->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idkabupatens->Visible) { // idkabupatens ?>
    <tr id="r_idkabupatens">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_wilayah_idkabupatens"><?= $Page->idkabupatens->caption() ?></span></td>
        <td data-name="idkabupatens" <?= $Page->idkabupatens->cellAttributes() ?>>
<span id="el_wilayah_idkabupatens">
<span<?= $Page->idkabupatens->viewAttributes() ?>>
<?= $Page->idkabupatens->getViewValue() ?></span>
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
