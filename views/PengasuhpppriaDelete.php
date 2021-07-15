<?php

namespace PHPMaker2021\nuportal;

// Page object
$PengasuhpppriaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpengasuhpppriadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpengasuhpppriadelete = currentForm = new ew.Form("fpengasuhpppriadelete", "delete");
    loadjs.done("fpengasuhpppriadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pengasuhpppria) ew.vars.tables.pengasuhpppria = <?= JsonEncode(GetClientVar("tables", "pengasuhpppria")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpengasuhpppriadelete" id="fpengasuhpppriadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengasuhpppria">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_pengasuhpppria_id" class="pengasuhpppria_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_pengasuhpppria_pid" class="pengasuhpppria_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pengasuhpppria_nama" class="pengasuhpppria_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nik->Visible) { // nik ?>
        <th class="<?= $Page->nik->headerCellClass() ?>"><span id="elh_pengasuhpppria_nik" class="pengasuhpppria_nik"><?= $Page->nik->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_pengasuhpppria_alamat" class="pengasuhpppria_alamat"><?= $Page->alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><span id="elh_pengasuhpppria_hp" class="pengasuhpppria_hp"><?= $Page->hp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->md->Visible) { // md ?>
        <th class="<?= $Page->md->headerCellClass() ?>"><span id="elh_pengasuhpppria_md" class="pengasuhpppria_md"><?= $Page->md->caption() ?></span></th>
<?php } ?>
<?php if ($Page->mts->Visible) { // mts ?>
        <th class="<?= $Page->mts->headerCellClass() ?>"><span id="elh_pengasuhpppria_mts" class="pengasuhpppria_mts"><?= $Page->mts->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ma->Visible) { // ma ?>
        <th class="<?= $Page->ma->headerCellClass() ?>"><span id="elh_pengasuhpppria_ma" class="pengasuhpppria_ma"><?= $Page->ma->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pesantren->Visible) { // pesantren ?>
        <th class="<?= $Page->pesantren->headerCellClass() ?>"><span id="elh_pengasuhpppria_pesantren" class="pengasuhpppria_pesantren"><?= $Page->pesantren->caption() ?></span></th>
<?php } ?>
<?php if ($Page->s1->Visible) { // s1 ?>
        <th class="<?= $Page->s1->headerCellClass() ?>"><span id="elh_pengasuhpppria_s1" class="pengasuhpppria_s1"><?= $Page->s1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->s2->Visible) { // s2 ?>
        <th class="<?= $Page->s2->headerCellClass() ?>"><span id="elh_pengasuhpppria_s2" class="pengasuhpppria_s2"><?= $Page->s2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->s3->Visible) { // s3 ?>
        <th class="<?= $Page->s3->headerCellClass() ?>"><span id="elh_pengasuhpppria_s3" class="pengasuhpppria_s3"><?= $Page->s3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->organisasi->Visible) { // organisasi ?>
        <th class="<?= $Page->organisasi->headerCellClass() ?>"><span id="elh_pengasuhpppria_organisasi" class="pengasuhpppria_organisasi"><?= $Page->organisasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <th class="<?= $Page->jabatandiorganisasi->headerCellClass() ?>"><span id="elh_pengasuhpppria_jabatandiorganisasi" class="pengasuhpppria_jabatandiorganisasi"><?= $Page->jabatandiorganisasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <th class="<?= $Page->tglawalorganisasi->headerCellClass() ?>"><span id="elh_pengasuhpppria_tglawalorganisasi" class="pengasuhpppria_tglawalorganisasi"><?= $Page->tglawalorganisasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pemerintah->Visible) { // pemerintah ?>
        <th class="<?= $Page->pemerintah->headerCellClass() ?>"><span id="elh_pengasuhpppria_pemerintah" class="pengasuhpppria_pemerintah"><?= $Page->pemerintah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <th class="<?= $Page->jabatandipemerintah->headerCellClass() ?>"><span id="elh_pengasuhpppria_jabatandipemerintah" class="pengasuhpppria_jabatandipemerintah"><?= $Page->jabatandipemerintah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
        <th class="<?= $Page->tglmenjabat->headerCellClass() ?>"><span id="elh_pengasuhpppria_tglmenjabat" class="pengasuhpppria_tglmenjabat"><?= $Page->tglmenjabat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><span id="elh_pengasuhpppria_foto" class="pengasuhpppria_foto"><?= $Page->foto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ijazah->Visible) { // ijazah ?>
        <th class="<?= $Page->ijazah->headerCellClass() ?>"><span id="elh_pengasuhpppria_ijazah" class="pengasuhpppria_ijazah"><?= $Page->ijazah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sertifikat->Visible) { // sertifikat ?>
        <th class="<?= $Page->sertifikat->headerCellClass() ?>"><span id="elh_pengasuhpppria_sertifikat" class="pengasuhpppria_sertifikat"><?= $Page->sertifikat->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_id" class="pengasuhpppria_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <td <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_pid" class="pengasuhpppria_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_nama" class="pengasuhpppria_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nik->Visible) { // nik ?>
        <td <?= $Page->nik->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_nik" class="pengasuhpppria_nik">
<span<?= $Page->nik->viewAttributes() ?>>
<?= $Page->nik->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_alamat" class="pengasuhpppria_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <td <?= $Page->hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_hp" class="pengasuhpppria_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->md->Visible) { // md ?>
        <td <?= $Page->md->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_md" class="pengasuhpppria_md">
<span<?= $Page->md->viewAttributes() ?>>
<?= $Page->md->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->mts->Visible) { // mts ?>
        <td <?= $Page->mts->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_mts" class="pengasuhpppria_mts">
<span<?= $Page->mts->viewAttributes() ?>>
<?= $Page->mts->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ma->Visible) { // ma ?>
        <td <?= $Page->ma->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_ma" class="pengasuhpppria_ma">
<span<?= $Page->ma->viewAttributes() ?>>
<?= $Page->ma->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pesantren->Visible) { // pesantren ?>
        <td <?= $Page->pesantren->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_pesantren" class="pengasuhpppria_pesantren">
<span<?= $Page->pesantren->viewAttributes() ?>>
<?= $Page->pesantren->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->s1->Visible) { // s1 ?>
        <td <?= $Page->s1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_s1" class="pengasuhpppria_s1">
<span<?= $Page->s1->viewAttributes() ?>>
<?= $Page->s1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->s2->Visible) { // s2 ?>
        <td <?= $Page->s2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_s2" class="pengasuhpppria_s2">
<span<?= $Page->s2->viewAttributes() ?>>
<?= $Page->s2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->s3->Visible) { // s3 ?>
        <td <?= $Page->s3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_s3" class="pengasuhpppria_s3">
<span<?= $Page->s3->viewAttributes() ?>>
<?= $Page->s3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->organisasi->Visible) { // organisasi ?>
        <td <?= $Page->organisasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_organisasi" class="pengasuhpppria_organisasi">
<span<?= $Page->organisasi->viewAttributes() ?>>
<?= $Page->organisasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <td <?= $Page->jabatandiorganisasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_jabatandiorganisasi" class="pengasuhpppria_jabatandiorganisasi">
<span<?= $Page->jabatandiorganisasi->viewAttributes() ?>>
<?= $Page->jabatandiorganisasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <td <?= $Page->tglawalorganisasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_tglawalorganisasi" class="pengasuhpppria_tglawalorganisasi">
<span<?= $Page->tglawalorganisasi->viewAttributes() ?>>
<?= $Page->tglawalorganisasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pemerintah->Visible) { // pemerintah ?>
        <td <?= $Page->pemerintah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_pemerintah" class="pengasuhpppria_pemerintah">
<span<?= $Page->pemerintah->viewAttributes() ?>>
<?= $Page->pemerintah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <td <?= $Page->jabatandipemerintah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_jabatandipemerintah" class="pengasuhpppria_jabatandipemerintah">
<span<?= $Page->jabatandipemerintah->viewAttributes() ?>>
<?= $Page->jabatandipemerintah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
        <td <?= $Page->tglmenjabat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_tglmenjabat" class="pengasuhpppria_tglmenjabat">
<span<?= $Page->tglmenjabat->viewAttributes() ?>>
<?= $Page->tglmenjabat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <td <?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_foto" class="pengasuhpppria_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->ijazah->Visible) { // ijazah ?>
        <td <?= $Page->ijazah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_ijazah" class="pengasuhpppria_ijazah">
<span<?= $Page->ijazah->viewAttributes() ?>>
<?= GetFileViewTag($Page->ijazah, $Page->ijazah->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->sertifikat->Visible) { // sertifikat ?>
        <td <?= $Page->sertifikat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pengasuhpppria_sertifikat" class="pengasuhpppria_sertifikat">
<span<?= $Page->sertifikat->viewAttributes() ?>>
<?= GetFileViewTag($Page->sertifikat, $Page->sertifikat->getViewValue(), false) ?>
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
