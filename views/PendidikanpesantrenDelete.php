<?php

namespace PHPMaker2021\nuportal;

// Page object
$PendidikanpesantrenDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpendidikanpesantrendelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpendidikanpesantrendelete = currentForm = new ew.Form("fpendidikanpesantrendelete", "delete");
    loadjs.done("fpendidikanpesantrendelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pendidikanpesantren) ew.vars.tables.pendidikanpesantren = <?= JsonEncode(GetClientVar("tables", "pendidikanpesantren")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpendidikanpesantrendelete" id="fpendidikanpesantrendelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendidikanpesantren">
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
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_pendidikanpesantren_pid" class="pendidikanpesantren_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idjenispp->Visible) { // idjenispp ?>
        <th class="<?= $Page->idjenispp->headerCellClass() ?>"><span id="elh_pendidikanpesantren_idjenispp" class="pendidikanpesantren_idjenispp"><?= $Page->idjenispp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pendidikanpesantren_nama" class="pendidikanpesantren_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
        <th class="<?= $Page->ijin->headerCellClass() ?>"><span id="elh_pendidikanpesantren_ijin" class="pendidikanpesantren_ijin"><?= $Page->ijin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
        <th class="<?= $Page->tglberdiri->headerCellClass() ?>"><span id="elh_pendidikanpesantren_tglberdiri" class="pendidikanpesantren_tglberdiri"><?= $Page->tglberdiri->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
        <th class="<?= $Page->ijinakhir->headerCellClass() ?>"><span id="elh_pendidikanpesantren_ijinakhir" class="pendidikanpesantren_ijinakhir"><?= $Page->ijinakhir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <th class="<?= $Page->jumlahpengajar->headerCellClass() ?>"><span id="elh_pendidikanpesantren_jumlahpengajar" class="pendidikanpesantren_jumlahpengajar"><?= $Page->jumlahpengajar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><span id="elh_pendidikanpesantren_foto" class="pendidikanpesantren_foto"><?= $Page->foto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
        <th class="<?= $Page->dokumen->headerCellClass() ?>"><span id="elh_pendidikanpesantren_dokumen" class="pendidikanpesantren_dokumen"><?= $Page->dokumen->caption() ?></span></th>
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
<?php if ($Page->pid->Visible) { // pid ?>
        <td <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_pid" class="pendidikanpesantren_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idjenispp->Visible) { // idjenispp ?>
        <td <?= $Page->idjenispp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_idjenispp" class="pendidikanpesantren_idjenispp">
<span<?= $Page->idjenispp->viewAttributes() ?>>
<?= $Page->idjenispp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_nama" class="pendidikanpesantren_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
        <td <?= $Page->ijin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_ijin" class="pendidikanpesantren_ijin">
<span<?= $Page->ijin->viewAttributes() ?>>
<?= $Page->ijin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
        <td <?= $Page->tglberdiri->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_tglberdiri" class="pendidikanpesantren_tglberdiri">
<span<?= $Page->tglberdiri->viewAttributes() ?>>
<?= $Page->tglberdiri->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
        <td <?= $Page->ijinakhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_ijinakhir" class="pendidikanpesantren_ijinakhir">
<span<?= $Page->ijinakhir->viewAttributes() ?>>
<?= $Page->ijinakhir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <td <?= $Page->jumlahpengajar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_jumlahpengajar" class="pendidikanpesantren_jumlahpengajar">
<span<?= $Page->jumlahpengajar->viewAttributes() ?>>
<?= $Page->jumlahpengajar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <td <?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_foto" class="pendidikanpesantren_foto">
<span>
<?= GetImageViewTag($Page->foto, $Page->foto->getViewValue()) ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
        <td <?= $Page->dokumen->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanpesantren_dokumen" class="pendidikanpesantren_dokumen">
<span<?= $Page->dokumen->viewAttributes() ?>>
<?= $Page->dokumen->getViewValue() ?></span>
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
