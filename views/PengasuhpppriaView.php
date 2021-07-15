<?php

namespace PHPMaker2021\nuportal;

// Page object
$PengasuhpppriaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpengasuhpppriaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpengasuhpppriaview = currentForm = new ew.Form("fpengasuhpppriaview", "view");
    loadjs.done("fpengasuhpppriaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pengasuhpppria) ew.vars.tables.pengasuhpppria = <?= JsonEncode(GetClientVar("tables", "pengasuhpppria")) ?>;
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
<form name="fpengasuhpppriaview" id="fpengasuhpppriaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengasuhpppria">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_pengasuhpppria_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
    <tr id="r_pid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_pid"><?= $Page->pid->caption() ?></span></td>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<span id="el_pengasuhpppria_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_pengasuhpppria_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nik->Visible) { // nik ?>
    <tr id="r_nik">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_nik"><?= $Page->nik->caption() ?></span></td>
        <td data-name="nik" <?= $Page->nik->cellAttributes() ?>>
<span id="el_pengasuhpppria_nik">
<span<?= $Page->nik->viewAttributes() ?>>
<?= $Page->nik->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <tr id="r_alamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_alamat"><?= $Page->alamat->caption() ?></span></td>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el_pengasuhpppria_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <tr id="r_hp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_hp"><?= $Page->hp->caption() ?></span></td>
        <td data-name="hp" <?= $Page->hp->cellAttributes() ?>>
<span id="el_pengasuhpppria_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->md->Visible) { // md ?>
    <tr id="r_md">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_md"><?= $Page->md->caption() ?></span></td>
        <td data-name="md" <?= $Page->md->cellAttributes() ?>>
<span id="el_pengasuhpppria_md">
<span<?= $Page->md->viewAttributes() ?>>
<?= $Page->md->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mts->Visible) { // mts ?>
    <tr id="r_mts">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_mts"><?= $Page->mts->caption() ?></span></td>
        <td data-name="mts" <?= $Page->mts->cellAttributes() ?>>
<span id="el_pengasuhpppria_mts">
<span<?= $Page->mts->viewAttributes() ?>>
<?= $Page->mts->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ma->Visible) { // ma ?>
    <tr id="r_ma">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_ma"><?= $Page->ma->caption() ?></span></td>
        <td data-name="ma" <?= $Page->ma->cellAttributes() ?>>
<span id="el_pengasuhpppria_ma">
<span<?= $Page->ma->viewAttributes() ?>>
<?= $Page->ma->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pesantren->Visible) { // pesantren ?>
    <tr id="r_pesantren">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_pesantren"><?= $Page->pesantren->caption() ?></span></td>
        <td data-name="pesantren" <?= $Page->pesantren->cellAttributes() ?>>
<span id="el_pengasuhpppria_pesantren">
<span<?= $Page->pesantren->viewAttributes() ?>>
<?= $Page->pesantren->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->s1->Visible) { // s1 ?>
    <tr id="r_s1">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_s1"><?= $Page->s1->caption() ?></span></td>
        <td data-name="s1" <?= $Page->s1->cellAttributes() ?>>
<span id="el_pengasuhpppria_s1">
<span<?= $Page->s1->viewAttributes() ?>>
<?= $Page->s1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->s2->Visible) { // s2 ?>
    <tr id="r_s2">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_s2"><?= $Page->s2->caption() ?></span></td>
        <td data-name="s2" <?= $Page->s2->cellAttributes() ?>>
<span id="el_pengasuhpppria_s2">
<span<?= $Page->s2->viewAttributes() ?>>
<?= $Page->s2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->s3->Visible) { // s3 ?>
    <tr id="r_s3">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_s3"><?= $Page->s3->caption() ?></span></td>
        <td data-name="s3" <?= $Page->s3->cellAttributes() ?>>
<span id="el_pengasuhpppria_s3">
<span<?= $Page->s3->viewAttributes() ?>>
<?= $Page->s3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->organisasi->Visible) { // organisasi ?>
    <tr id="r_organisasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_organisasi"><?= $Page->organisasi->caption() ?></span></td>
        <td data-name="organisasi" <?= $Page->organisasi->cellAttributes() ?>>
<span id="el_pengasuhpppria_organisasi">
<span<?= $Page->organisasi->viewAttributes() ?>>
<?= $Page->organisasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
    <tr id="r_jabatandiorganisasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_jabatandiorganisasi"><?= $Page->jabatandiorganisasi->caption() ?></span></td>
        <td data-name="jabatandiorganisasi" <?= $Page->jabatandiorganisasi->cellAttributes() ?>>
<span id="el_pengasuhpppria_jabatandiorganisasi">
<span<?= $Page->jabatandiorganisasi->viewAttributes() ?>>
<?= $Page->jabatandiorganisasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
    <tr id="r_tglawalorganisasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_tglawalorganisasi"><?= $Page->tglawalorganisasi->caption() ?></span></td>
        <td data-name="tglawalorganisasi" <?= $Page->tglawalorganisasi->cellAttributes() ?>>
<span id="el_pengasuhpppria_tglawalorganisasi">
<span<?= $Page->tglawalorganisasi->viewAttributes() ?>>
<?= $Page->tglawalorganisasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pemerintah->Visible) { // pemerintah ?>
    <tr id="r_pemerintah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_pemerintah"><?= $Page->pemerintah->caption() ?></span></td>
        <td data-name="pemerintah" <?= $Page->pemerintah->cellAttributes() ?>>
<span id="el_pengasuhpppria_pemerintah">
<span<?= $Page->pemerintah->viewAttributes() ?>>
<?= $Page->pemerintah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
    <tr id="r_jabatandipemerintah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_jabatandipemerintah"><?= $Page->jabatandipemerintah->caption() ?></span></td>
        <td data-name="jabatandipemerintah" <?= $Page->jabatandipemerintah->cellAttributes() ?>>
<span id="el_pengasuhpppria_jabatandipemerintah">
<span<?= $Page->jabatandipemerintah->viewAttributes() ?>>
<?= $Page->jabatandipemerintah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
    <tr id="r_tglmenjabat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_tglmenjabat"><?= $Page->tglmenjabat->caption() ?></span></td>
        <td data-name="tglmenjabat" <?= $Page->tglmenjabat->cellAttributes() ?>>
<span id="el_pengasuhpppria_tglmenjabat">
<span<?= $Page->tglmenjabat->viewAttributes() ?>>
<?= $Page->tglmenjabat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_pengasuhpppria_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ijazah->Visible) { // ijazah ?>
    <tr id="r_ijazah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_ijazah"><?= $Page->ijazah->caption() ?></span></td>
        <td data-name="ijazah" <?= $Page->ijazah->cellAttributes() ?>>
<span id="el_pengasuhpppria_ijazah">
<span<?= $Page->ijazah->viewAttributes() ?>>
<?= GetFileViewTag($Page->ijazah, $Page->ijazah->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sertifikat->Visible) { // sertifikat ?>
    <tr id="r_sertifikat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pengasuhpppria_sertifikat"><?= $Page->sertifikat->caption() ?></span></td>
        <td data-name="sertifikat" <?= $Page->sertifikat->cellAttributes() ?>>
<span id="el_pengasuhpppria_sertifikat">
<span<?= $Page->sertifikat->viewAttributes() ?>>
<?= GetFileViewTag($Page->sertifikat, $Page->sertifikat->getViewValue(), false) ?>
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
