<?php

namespace PHPMaker2021\nuportal;

// Page object
$PendidikanumumDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpendidikanumumdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpendidikanumumdelete = currentForm = new ew.Form("fpendidikanumumdelete", "delete");
    loadjs.done("fpendidikanumumdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pendidikanumum) ew.vars.tables.pendidikanumum = <?= JsonEncode(GetClientVar("tables", "pendidikanumum")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpendidikanumumdelete" id="fpendidikanumumdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendidikanumum">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_pendidikanumum_id" class="pendidikanumum_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_pendidikanumum_pid" class="pendidikanumum_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->idjenispu->Visible) { // idjenispu ?>
        <th class="<?= $Page->idjenispu->headerCellClass() ?>"><span id="elh_pendidikanumum_idjenispu" class="pendidikanumum_idjenispu"><?= $Page->idjenispu->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pendidikanumum_nama" class="pendidikanumum_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
        <th class="<?= $Page->ijin->headerCellClass() ?>"><span id="elh_pendidikanumum_ijin" class="pendidikanumum_ijin"><?= $Page->ijin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
        <th class="<?= $Page->tglberdiri->headerCellClass() ?>"><span id="elh_pendidikanumum_tglberdiri" class="pendidikanumum_tglberdiri"><?= $Page->tglberdiri->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
        <th class="<?= $Page->ijinakhir->headerCellClass() ?>"><span id="elh_pendidikanumum_ijinakhir" class="pendidikanumum_ijinakhir"><?= $Page->ijinakhir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <th class="<?= $Page->jumlahpengajar->headerCellClass() ?>"><span id="elh_pendidikanumum_jumlahpengajar" class="pendidikanumum_jumlahpengajar"><?= $Page->jumlahpengajar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><span id="elh_pendidikanumum_foto" class="pendidikanumum_foto"><?= $Page->foto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
        <th class="<?= $Page->dokumen->headerCellClass() ?>"><span id="elh_pendidikanumum_dokumen" class="pendidikanumum_dokumen"><?= $Page->dokumen->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_pendidikanumum_id" class="pendidikanumum_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <td <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_pid" class="pendidikanumum_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->idjenispu->Visible) { // idjenispu ?>
        <td <?= $Page->idjenispu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_idjenispu" class="pendidikanumum_idjenispu">
<span<?= $Page->idjenispu->viewAttributes() ?>>
<?= $Page->idjenispu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_nama" class="pendidikanumum_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
        <td <?= $Page->ijin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_ijin" class="pendidikanumum_ijin">
<span<?= $Page->ijin->viewAttributes() ?>>
<?= $Page->ijin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
        <td <?= $Page->tglberdiri->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_tglberdiri" class="pendidikanumum_tglberdiri">
<span<?= $Page->tglberdiri->viewAttributes() ?>>
<?= $Page->tglberdiri->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
        <td <?= $Page->ijinakhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_ijinakhir" class="pendidikanumum_ijinakhir">
<span<?= $Page->ijinakhir->viewAttributes() ?>>
<?= $Page->ijinakhir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <td <?= $Page->jumlahpengajar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_jumlahpengajar" class="pendidikanumum_jumlahpengajar">
<span<?= $Page->jumlahpengajar->viewAttributes() ?>>
<?= $Page->jumlahpengajar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <td <?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_foto" class="pendidikanumum_foto">
<span>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
        <td <?= $Page->dokumen->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_dokumen" class="pendidikanumum_dokumen">
<span<?= $Page->dokumen->viewAttributes() ?>>
<?= GetFileViewTag($Page->dokumen, $Page->dokumen->getViewValue(), false) ?>
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
