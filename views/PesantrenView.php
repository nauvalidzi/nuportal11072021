<?php

namespace PHPMaker2021\nuportal;

// Page object
$PesantrenView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpesantrenview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpesantrenview = currentForm = new ew.Form("fpesantrenview", "view");
    loadjs.done("fpesantrenview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pesantren) ew.vars.tables.pesantren = <?= JsonEncode(GetClientVar("tables", "pesantren")) ?>;
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
<form name="fpesantrenview" id="fpesantrenview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pesantren">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->kode->Visible) { // kode ?>
    <tr id="r_kode">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_kode"><?= $Page->kode->caption() ?></span></td>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el_pesantren_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_pesantren_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deskripsi->Visible) { // deskripsi ?>
    <tr id="r_deskripsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_deskripsi"><?= $Page->deskripsi->caption() ?></span></td>
        <td data-name="deskripsi" <?= $Page->deskripsi->cellAttributes() ?>>
<span id="el_pesantren_deskripsi">
<span<?= $Page->deskripsi->viewAttributes() ?>>
<?= $Page->deskripsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jalan->Visible) { // jalan ?>
    <tr id="r_jalan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_jalan"><?= $Page->jalan->caption() ?></span></td>
        <td data-name="jalan" <?= $Page->jalan->cellAttributes() ?>>
<span id="el_pesantren_jalan">
<span<?= $Page->jalan->viewAttributes() ?>>
<?= $Page->jalan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->propinsi->Visible) { // propinsi ?>
    <tr id="r_propinsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_propinsi"><?= $Page->propinsi->caption() ?></span></td>
        <td data-name="propinsi" <?= $Page->propinsi->cellAttributes() ?>>
<span id="el_pesantren_propinsi">
<span<?= $Page->propinsi->viewAttributes() ?>>
<?= $Page->propinsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kabupaten->Visible) { // kabupaten ?>
    <tr id="r_kabupaten">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_kabupaten"><?= $Page->kabupaten->caption() ?></span></td>
        <td data-name="kabupaten" <?= $Page->kabupaten->cellAttributes() ?>>
<span id="el_pesantren_kabupaten">
<span<?= $Page->kabupaten->viewAttributes() ?>>
<?= $Page->kabupaten->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kecamatan->Visible) { // kecamatan ?>
    <tr id="r_kecamatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_kecamatan"><?= $Page->kecamatan->caption() ?></span></td>
        <td data-name="kecamatan" <?= $Page->kecamatan->cellAttributes() ?>>
<span id="el_pesantren_kecamatan">
<span<?= $Page->kecamatan->viewAttributes() ?>>
<?= $Page->kecamatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->desa->Visible) { // desa ?>
    <tr id="r_desa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_desa"><?= $Page->desa->caption() ?></span></td>
        <td data-name="desa" <?= $Page->desa->cellAttributes() ?>>
<span id="el_pesantren_desa">
<span<?= $Page->desa->viewAttributes() ?>>
<?= $Page->desa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kodepos->Visible) { // kodepos ?>
    <tr id="r_kodepos">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_kodepos"><?= $Page->kodepos->caption() ?></span></td>
        <td data-name="kodepos" <?= $Page->kodepos->cellAttributes() ?>>
<span id="el_pesantren_kodepos">
<span<?= $Page->kodepos->viewAttributes() ?>>
<?= $Page->kodepos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telpon->Visible) { // telpon ?>
    <tr id="r_telpon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_telpon"><?= $Page->telpon->caption() ?></span></td>
        <td data-name="telpon" <?= $Page->telpon->cellAttributes() ?>>
<span id="el_pesantren_telpon">
<span<?= $Page->telpon->viewAttributes() ?>>
<?= $Page->telpon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->web->Visible) { // web ?>
    <tr id="r_web">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_web"><?= $Page->web->caption() ?></span></td>
        <td data-name="web" <?= $Page->web->cellAttributes() ?>>
<span id="el_pesantren_web">
<span<?= $Page->web->viewAttributes() ?>>
<?= $Page->web->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el_pesantren__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nspp->Visible) { // nspp ?>
    <tr id="r_nspp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_nspp"><?= $Page->nspp->caption() ?></span></td>
        <td data-name="nspp" <?= $Page->nspp->cellAttributes() ?>>
<span id="el_pesantren_nspp">
<span<?= $Page->nspp->viewAttributes() ?>>
<?= $Page->nspp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nspptglmulai->Visible) { // nspptglmulai ?>
    <tr id="r_nspptglmulai">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_nspptglmulai"><?= $Page->nspptglmulai->caption() ?></span></td>
        <td data-name="nspptglmulai" <?= $Page->nspptglmulai->cellAttributes() ?>>
<span id="el_pesantren_nspptglmulai">
<span<?= $Page->nspptglmulai->viewAttributes() ?>>
<?= $Page->nspptglmulai->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nspptglakhir->Visible) { // nspptglakhir ?>
    <tr id="r_nspptglakhir">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_nspptglakhir"><?= $Page->nspptglakhir->caption() ?></span></td>
        <td data-name="nspptglakhir" <?= $Page->nspptglakhir->cellAttributes() ?>>
<span id="el_pesantren_nspptglakhir">
<span<?= $Page->nspptglakhir->viewAttributes() ?>>
<?= $Page->nspptglakhir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dokumennspp->Visible) { // dokumennspp ?>
    <tr id="r_dokumennspp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_dokumennspp"><?= $Page->dokumennspp->caption() ?></span></td>
        <td data-name="dokumennspp" <?= $Page->dokumennspp->cellAttributes() ?>>
<span id="el_pesantren_dokumennspp">
<span<?= $Page->dokumennspp->viewAttributes() ?>>
<?= GetFileViewTag($Page->dokumennspp, $Page->dokumennspp->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->yayasan->Visible) { // yayasan ?>
    <tr id="r_yayasan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_yayasan"><?= $Page->yayasan->caption() ?></span></td>
        <td data-name="yayasan" <?= $Page->yayasan->cellAttributes() ?>>
<span id="el_pesantren_yayasan">
<span<?= $Page->yayasan->viewAttributes() ?>>
<?= $Page->yayasan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->noakta->Visible) { // noakta ?>
    <tr id="r_noakta">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_noakta"><?= $Page->noakta->caption() ?></span></td>
        <td data-name="noakta" <?= $Page->noakta->cellAttributes() ?>>
<span id="el_pesantren_noakta">
<span<?= $Page->noakta->viewAttributes() ?>>
<?= $Page->noakta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglakta->Visible) { // tglakta ?>
    <tr id="r_tglakta">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_tglakta"><?= $Page->tglakta->caption() ?></span></td>
        <td data-name="tglakta" <?= $Page->tglakta->cellAttributes() ?>>
<span id="el_pesantren_tglakta">
<span<?= $Page->tglakta->viewAttributes() ?>>
<?= $Page->tglakta->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->namanotaris->Visible) { // namanotaris ?>
    <tr id="r_namanotaris">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_namanotaris"><?= $Page->namanotaris->caption() ?></span></td>
        <td data-name="namanotaris" <?= $Page->namanotaris->cellAttributes() ?>>
<span id="el_pesantren_namanotaris">
<span<?= $Page->namanotaris->viewAttributes() ?>>
<?= $Page->namanotaris->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamatnotaris->Visible) { // alamatnotaris ?>
    <tr id="r_alamatnotaris">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_alamatnotaris"><?= $Page->alamatnotaris->caption() ?></span></td>
        <td data-name="alamatnotaris" <?= $Page->alamatnotaris->cellAttributes() ?>>
<span id="el_pesantren_alamatnotaris">
<span<?= $Page->alamatnotaris->viewAttributes() ?>>
<?= $Page->alamatnotaris->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userid->Visible) { // userid ?>
    <tr id="r__userid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren__userid"><?= $Page->_userid->caption() ?></span></td>
        <td data-name="_userid" <?= $Page->_userid->cellAttributes() ?>>
<span id="el_pesantren__userid">
<span<?= $Page->_userid->viewAttributes() ?>>
<?= $Page->_userid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_pesantren_foto">
<span>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ktp->Visible) { // ktp ?>
    <tr id="r_ktp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_ktp"><?= $Page->ktp->caption() ?></span></td>
        <td data-name="ktp" <?= $Page->ktp->cellAttributes() ?>>
<span id="el_pesantren_ktp">
<span>
<?= GetFileViewTag($Page->ktp, $Page->ktp->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
    <tr id="r_dokumen">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_dokumen"><?= $Page->dokumen->caption() ?></span></td>
        <td data-name="dokumen" <?= $Page->dokumen->cellAttributes() ?>>
<span id="el_pesantren_dokumen">
<span>
<?= GetFileViewTag($Page->dokumen, $Page->dokumen->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->validasi->Visible) { // validasi ?>
    <tr id="r_validasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_validasi"><?= $Page->validasi->caption() ?></span></td>
        <td data-name="validasi" <?= $Page->validasi->cellAttributes() ?>>
<span id="el_pesantren_validasi">
<span<?= $Page->validasi->viewAttributes() ?>>
<?= $Page->validasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
    <tr id="r_validator">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_validator"><?= $Page->validator->caption() ?></span></td>
        <td data-name="validator" <?= $Page->validator->cellAttributes() ?>>
<span id="el_pesantren_validator">
<span<?= $Page->validator->viewAttributes() ?>>
<?= $Page->validator->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->validasi_pusat->Visible) { // validasi_pusat ?>
    <tr id="r_validasi_pusat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_validasi_pusat"><?= $Page->validasi_pusat->caption() ?></span></td>
        <td data-name="validasi_pusat" <?= $Page->validasi_pusat->cellAttributes() ?>>
<span id="el_pesantren_validasi_pusat">
<span<?= $Page->validasi_pusat->viewAttributes() ?>>
<?= $Page->validasi_pusat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->validator_pusat->Visible) { // validator_pusat ?>
    <tr id="r_validator_pusat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_validator_pusat"><?= $Page->validator_pusat->caption() ?></span></td>
        <td data-name="validator_pusat" <?= $Page->validator_pusat->cellAttributes() ?>>
<span id="el_pesantren_validator_pusat">
<span<?= $Page->validator_pusat->viewAttributes() ?>>
<?= $Page->validator_pusat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_validasi_cabang->Visible) { // tgl_validasi_cabang ?>
    <tr id="r_tgl_validasi_cabang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_tgl_validasi_cabang"><?= $Page->tgl_validasi_cabang->caption() ?></span></td>
        <td data-name="tgl_validasi_cabang" <?= $Page->tgl_validasi_cabang->cellAttributes() ?>>
<span id="el_pesantren_tgl_validasi_cabang">
<span<?= $Page->tgl_validasi_cabang->viewAttributes() ?>>
<?= $Page->tgl_validasi_cabang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tgl_validasi_pusat->Visible) { // tgl_validasi_pusat ?>
    <tr id="r_tgl_validasi_pusat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pesantren_tgl_validasi_pusat"><?= $Page->tgl_validasi_pusat->caption() ?></span></td>
        <td data-name="tgl_validasi_pusat" <?= $Page->tgl_validasi_pusat->cellAttributes() ?>>
<span id="el_pesantren_tgl_validasi_pusat">
<span<?= $Page->tgl_validasi_pusat->viewAttributes() ?>>
<?= $Page->tgl_validasi_pusat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("fasilitasusaha", explode(",", $Page->getCurrentDetailTable())) && $fasilitasusaha->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fasilitasusaha", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FasilitasusahaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("pendidikanumum", explode(",", $Page->getCurrentDetailTable())) && $pendidikanumum->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("pendidikanumum", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PendidikanumumGrid.php" ?>
<?php } ?>
<?php
    if (in_array("pengasuhpppria", explode(",", $Page->getCurrentDetailTable())) && $pengasuhpppria->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("pengasuhpppria", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PengasuhpppriaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("pengasuhppwanita", explode(",", $Page->getCurrentDetailTable())) && $pengasuhppwanita->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("pengasuhppwanita", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PengasuhppwanitaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("kitabkuning", explode(",", $Page->getCurrentDetailTable())) && $kitabkuning->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("kitabkuning", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "KitabkuningGrid.php" ?>
<?php } ?>
<?php
    if (in_array("fasilitaspesantren", explode(",", $Page->getCurrentDetailTable())) && $fasilitaspesantren->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fasilitaspesantren", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FasilitaspesantrenGrid.php" ?>
<?php } ?>
<?php
    if (in_array("pendidikanpesantren", explode(",", $Page->getCurrentDetailTable())) && $pendidikanpesantren->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("pendidikanpesantren", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PendidikanpesantrenGrid.php" ?>
<?php } ?>
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
