<?php

namespace PHPMaker2021\nuportal;

// Page object
$PendidikanpesantrenView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpendidikanpesantrenview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpendidikanpesantrenview = currentForm = new ew.Form("fpendidikanpesantrenview", "view");
    loadjs.done("fpendidikanpesantrenview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pendidikanpesantren) ew.vars.tables.pendidikanpesantren = <?= JsonEncode(GetClientVar("tables", "pendidikanpesantren")) ?>;
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
<form name="fpendidikanpesantrenview" id="fpendidikanpesantrenview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendidikanpesantren">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->pid->Visible) { // pid ?>
    <tr id="r_pid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_pid"><?= $Page->pid->caption() ?></span></td>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<span id="el_pendidikanpesantren_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->idjenispp->Visible) { // idjenispp ?>
    <tr id="r_idjenispp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_idjenispp"><?= $Page->idjenispp->caption() ?></span></td>
        <td data-name="idjenispp" <?= $Page->idjenispp->cellAttributes() ?>>
<span id="el_pendidikanpesantren_idjenispp">
<span<?= $Page->idjenispp->viewAttributes() ?>>
<?= $Page->idjenispp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_pendidikanpesantren_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
    <tr id="r_ijin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_ijin"><?= $Page->ijin->caption() ?></span></td>
        <td data-name="ijin" <?= $Page->ijin->cellAttributes() ?>>
<span id="el_pendidikanpesantren_ijin">
<span<?= $Page->ijin->viewAttributes() ?>>
<?= $Page->ijin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
    <tr id="r_tglberdiri">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_tglberdiri"><?= $Page->tglberdiri->caption() ?></span></td>
        <td data-name="tglberdiri" <?= $Page->tglberdiri->cellAttributes() ?>>
<span id="el_pendidikanpesantren_tglberdiri">
<span<?= $Page->tglberdiri->viewAttributes() ?>>
<?= $Page->tglberdiri->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
    <tr id="r_ijinakhir">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_ijinakhir"><?= $Page->ijinakhir->caption() ?></span></td>
        <td data-name="ijinakhir" <?= $Page->ijinakhir->cellAttributes() ?>>
<span id="el_pendidikanpesantren_ijinakhir">
<span<?= $Page->ijinakhir->viewAttributes() ?>>
<?= $Page->ijinakhir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
    <tr id="r_jumlahpengajar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_jumlahpengajar"><?= $Page->jumlahpengajar->caption() ?></span></td>
        <td data-name="jumlahpengajar" <?= $Page->jumlahpengajar->cellAttributes() ?>>
<span id="el_pendidikanpesantren_jumlahpengajar">
<span<?= $Page->jumlahpengajar->viewAttributes() ?>>
<?= $Page->jumlahpengajar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_pendidikanpesantren_foto">
<span>
<?= GetImageViewTag($Page->foto, $Page->foto->getViewValue()) ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
    <tr id="r_dokumen">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendidikanpesantren_dokumen"><?= $Page->dokumen->caption() ?></span></td>
        <td data-name="dokumen" <?= $Page->dokumen->cellAttributes() ?>>
<span id="el_pendidikanpesantren_dokumen">
<span<?= $Page->dokumen->viewAttributes() ?>>
<?= $Page->dokumen->getViewValue() ?></span>
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
