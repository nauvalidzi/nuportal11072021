<?php

namespace PHPMaker2021\nuportal;

// Page object
$KitabkuningDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkitabkuningdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fkitabkuningdelete = currentForm = new ew.Form("fkitabkuningdelete", "delete");
    loadjs.done("fkitabkuningdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.kitabkuning) ew.vars.tables.kitabkuning = <?= JsonEncode(GetClientVar("tables", "kitabkuning")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fkitabkuningdelete" id="fkitabkuningdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kitabkuning">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_kitabkuning_id" class="kitabkuning_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_kitabkuning_pid" class="kitabkuning_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pelaksanaan->Visible) { // pelaksanaan ?>
        <th class="<?= $Page->pelaksanaan->headerCellClass() ?>"><span id="elh_kitabkuning_pelaksanaan" class="kitabkuning_pelaksanaan"><?= $Page->pelaksanaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->metode->Visible) { // metode ?>
        <th class="<?= $Page->metode->headerCellClass() ?>"><span id="elh_kitabkuning_metode" class="kitabkuning_metode"><?= $Page->metode->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_kitabkuning_id" class="kitabkuning_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <td <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kitabkuning_pid" class="kitabkuning_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pelaksanaan->Visible) { // pelaksanaan ?>
        <td <?= $Page->pelaksanaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kitabkuning_pelaksanaan" class="kitabkuning_pelaksanaan">
<span<?= $Page->pelaksanaan->viewAttributes() ?>>
<?= $Page->pelaksanaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->metode->Visible) { // metode ?>
        <td <?= $Page->metode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_kitabkuning_metode" class="kitabkuning_metode">
<span<?= $Page->metode->viewAttributes() ?>>
<?= $Page->metode->getViewValue() ?></span>
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
