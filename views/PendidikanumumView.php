<?php

namespace PHPMaker2021\nuportal;

// Page object
$PendidikanumumView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpendidikanumumview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpendidikanumumview = currentForm = new ew.Form("fpendidikanumumview", "view");
    loadjs.done("fpendidikanumumview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pendidikanumum) ew.vars.tables.pendidikanumum = <?= JsonEncode(GetClientVar("tables", "pendidikanumum")) ?>;
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
<form name="fpendidikanumumview" id="fpendidikanumumview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendidikanumum">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_pendidikanumum_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
    <tr id="r_pid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_pid"><?= $Page->pid->caption() ?></span></td>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<span id="el_pendidikanumum_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idjenispu->Visible) { // idjenispu ?>
    <tr id="r_idjenispu">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_idjenispu"><?= $Page->idjenispu->caption() ?></span></td>
        <td data-name="idjenispu" <?= $Page->idjenispu->cellAttributes() ?>>
<span id="el_pendidikanumum_idjenispu">
<span<?= $Page->idjenispu->viewAttributes() ?>>
<?= $Page->idjenispu->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_pendidikanumum_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
    <tr id="r_ijin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_ijin"><?= $Page->ijin->caption() ?></span></td>
        <td data-name="ijin" <?= $Page->ijin->cellAttributes() ?>>
<span id="el_pendidikanumum_ijin">
<span<?= $Page->ijin->viewAttributes() ?>>
<?= $Page->ijin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
    <tr id="r_tglberdiri">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_tglberdiri"><?= $Page->tglberdiri->caption() ?></span></td>
        <td data-name="tglberdiri" <?= $Page->tglberdiri->cellAttributes() ?>>
<span id="el_pendidikanumum_tglberdiri">
<span<?= $Page->tglberdiri->viewAttributes() ?>>
<?= $Page->tglberdiri->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
    <tr id="r_ijinakhir">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_ijinakhir"><?= $Page->ijinakhir->caption() ?></span></td>
        <td data-name="ijinakhir" <?= $Page->ijinakhir->cellAttributes() ?>>
<span id="el_pendidikanumum_ijinakhir">
<span<?= $Page->ijinakhir->viewAttributes() ?>>
<?= $Page->ijinakhir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
    <tr id="r_jumlahpengajar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_jumlahpengajar"><?= $Page->jumlahpengajar->caption() ?></span></td>
        <td data-name="jumlahpengajar" <?= $Page->jumlahpengajar->cellAttributes() ?>>
<span id="el_pendidikanumum_jumlahpengajar">
<span<?= $Page->jumlahpengajar->viewAttributes() ?>>
<?= $Page->jumlahpengajar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_pendidikanumum_foto">
<span>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
    <tr id="r_dokumen">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanumum_dokumen"><?= $Page->dokumen->caption() ?></span></td>
        <td data-name="dokumen" <?= $Page->dokumen->cellAttributes() ?>>
<span id="el_pendidikanumum_dokumen">
<span<?= $Page->dokumen->viewAttributes() ?>>
<?= GetFileViewTag($Page->dokumen, $Page->dokumen->getViewValue(), false) ?>
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
