<?php

namespace PHPMaker2021\nuportal;

// Page object
$WilayahDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fwilayahdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fwilayahdelete = currentForm = new ew.Form("fwilayahdelete", "delete");
    loadjs.done("fwilayahdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.wilayah) ew.vars.tables.wilayah = <?= JsonEncode(GetClientVar("tables", "wilayah")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fwilayahdelete" id="fwilayahdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="wilayah">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->iduser->Visible) { // iduser ?>
        <th class="<?= $Page->iduser->headerCellClass() ?>"><span id="elh_wilayah_iduser" class="wilayah_iduser"><?= $Page->iduser->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idprovinsis->Visible) { // idprovinsis ?>
        <th class="<?= $Page->idprovinsis->headerCellClass() ?>"><span id="elh_wilayah_idprovinsis" class="wilayah_idprovinsis"><?= $Page->idprovinsis->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idkabupatens->Visible) { // idkabupatens ?>
        <th class="<?= $Page->idkabupatens->headerCellClass() ?>"><span id="elh_wilayah_idkabupatens" class="wilayah_idkabupatens"><?= $Page->idkabupatens->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->iduser->Visible) { // iduser ?>
        <td <?= $Page->iduser->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_wilayah_iduser" class="wilayah_iduser">
<span<?= $Page->iduser->viewAttributes() ?>>
<?= $Page->iduser->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idprovinsis->Visible) { // idprovinsis ?>
        <td <?= $Page->idprovinsis->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_wilayah_idprovinsis" class="wilayah_idprovinsis">
<span<?= $Page->idprovinsis->viewAttributes() ?>>
<?= $Page->idprovinsis->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idkabupatens->Visible) { // idkabupatens ?>
        <td <?= $Page->idkabupatens->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_wilayah_idkabupatens" class="wilayah_idkabupatens">
<span<?= $Page->idkabupatens->viewAttributes() ?>>
<?= $Page->idkabupatens->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
