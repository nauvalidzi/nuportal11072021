<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitaspesantrenDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ffasilitaspesantrendelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ffasilitaspesantrendelete = currentForm = new ew.Form("ffasilitaspesantrendelete", "delete");
    loadjs.done("ffasilitaspesantrendelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.fasilitaspesantren) ew.vars.tables.fasilitaspesantren = <?= JsonEncode(GetClientVar("tables", "fasilitaspesantren")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffasilitaspesantrendelete" id="ffasilitaspesantrendelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fasilitaspesantren">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fasilitaspesantren_id" class="fasilitaspesantren_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_fasilitaspesantren_pid" class="fasilitaspesantren_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
        <th class="<?= $Page->namafasilitas->headerCellClass() ?>"><span id="elh_fasilitaspesantren_namafasilitas" class="fasilitaspesantren_namafasilitas"><?= $Page->namafasilitas->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_fasilitaspesantren_keterangan" class="fasilitaspesantren_keterangan"><?= $Page->keterangan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
        <th class="<?= $Page->fotofasilitas->headerCellClass() ?>"><span id="elh_fasilitaspesantren_fotofasilitas" class="fasilitaspesantren_fotofasilitas"><?= $Page->fotofasilitas->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_id" class="fasilitaspesantren_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <td <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_pid" class="fasilitaspesantren_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
        <td <?= $Page->namafasilitas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_namafasilitas" class="fasilitaspesantren_namafasilitas">
<span<?= $Page->namafasilitas->viewAttributes() ?>>
<?= $Page->namafasilitas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_keterangan" class="fasilitaspesantren_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
        <td <?= $Page->fotofasilitas->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_fotofasilitas" class="fasilitaspesantren_fotofasilitas">
<span<?= $Page->fotofasilitas->viewAttributes() ?>>
<?= GetFileViewTag($Page->fotofasilitas, $Page->fotofasilitas->getViewValue(), false) ?>
</span>
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
