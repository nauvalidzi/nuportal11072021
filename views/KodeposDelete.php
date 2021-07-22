<?php

namespace PHPMaker2021\nuportal;

// Page object
$KodeposDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkodeposdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fkodeposdelete = currentForm = new ew.Form("fkodeposdelete", "delete");
    loadjs.done("fkodeposdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.kodepos) ew.vars.tables.kodepos = <?= JsonEncode(GetClientVar("tables", "kodepos")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fkodeposdelete" id="fkodeposdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kodepos">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_kodepos_id" class="kodepos_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kelurahan_id->Visible) { // kelurahan_id ?>
        <th class="<?= $Page->kelurahan_id->headerCellClass() ?>"><span id="elh_kodepos_kelurahan_id" class="kodepos_kelurahan_id"><?= $Page->kelurahan_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kodepos->Visible) { // kodepos ?>
        <th class="<?= $Page->kodepos->headerCellClass() ?>"><span id="elh_kodepos_kodepos" class="kodepos_kodepos"><?= $Page->kodepos->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kodepos_id" class="kodepos_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kelurahan_id->Visible) { // kelurahan_id ?>
        <td <?= $Page->kelurahan_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kodepos_kelurahan_id" class="kodepos_kelurahan_id">
<span<?= $Page->kelurahan_id->viewAttributes() ?>>
<?= $Page->kelurahan_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kodepos->Visible) { // kodepos ?>
        <td <?= $Page->kodepos->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kodepos_kodepos" class="kodepos_kodepos">
<span<?= $Page->kodepos->viewAttributes() ?>>
<?= $Page->kodepos->getViewValue() ?></span>
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
