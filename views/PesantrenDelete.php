<?php

namespace PHPMaker2021\nuportal;

// Page object
$PesantrenDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpesantrendelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpesantrendelete = currentForm = new ew.Form("fpesantrendelete", "delete");
    loadjs.done("fpesantrendelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pesantren) ew.vars.tables.pesantren = <?= JsonEncode(GetClientVar("tables", "pesantren")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpesantrendelete" id="fpesantrendelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pesantren">
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
<?php if ($Page->kode->Visible) { // kode ?>
        <th class="<?= $Page->kode->headerCellClass() ?>"><span id="elh_pesantren_kode" class="pesantren_kode"><?= $Page->kode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pesantren_nama" class="pesantren_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->deskripsi->Visible) { // deskripsi ?>
        <th class="<?= $Page->deskripsi->headerCellClass() ?>"><span id="elh_pesantren_deskripsi" class="pesantren_deskripsi"><?= $Page->deskripsi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jalan->Visible) { // jalan ?>
        <th class="<?= $Page->jalan->headerCellClass() ?>"><span id="elh_pesantren_jalan" class="pesantren_jalan"><?= $Page->jalan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->telpon->Visible) { // telpon ?>
        <th class="<?= $Page->telpon->headerCellClass() ?>"><span id="elh_pesantren_telpon" class="pesantren_telpon"><?= $Page->telpon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nspp->Visible) { // nspp ?>
        <th class="<?= $Page->nspp->headerCellClass() ?>"><span id="elh_pesantren_nspp" class="pesantren_nspp"><?= $Page->nspp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nspptglmulai->Visible) { // nspptglmulai ?>
        <th class="<?= $Page->nspptglmulai->headerCellClass() ?>"><span id="elh_pesantren_nspptglmulai" class="pesantren_nspptglmulai"><?= $Page->nspptglmulai->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nspptglakhir->Visible) { // nspptglakhir ?>
        <th class="<?= $Page->nspptglakhir->headerCellClass() ?>"><span id="elh_pesantren_nspptglakhir" class="pesantren_nspptglakhir"><?= $Page->nspptglakhir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->yayasan->Visible) { // yayasan ?>
        <th class="<?= $Page->yayasan->headerCellClass() ?>"><span id="elh_pesantren_yayasan" class="pesantren_yayasan"><?= $Page->yayasan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_userid->Visible) { // userid ?>
        <th class="<?= $Page->_userid->headerCellClass() ?>"><span id="elh_pesantren__userid" class="pesantren__userid"><?= $Page->_userid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->validasi->Visible) { // validasi ?>
        <th class="<?= $Page->validasi->headerCellClass() ?>"><span id="elh_pesantren_validasi" class="pesantren_validasi"><?= $Page->validasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
        <th class="<?= $Page->validator->headerCellClass() ?>"><span id="elh_pesantren_validator" class="pesantren_validator"><?= $Page->validator->caption() ?></span></th>
<?php } ?>
<?php if ($Page->validasi_pusat->Visible) { // validasi_pusat ?>
        <th class="<?= $Page->validasi_pusat->headerCellClass() ?>"><span id="elh_pesantren_validasi_pusat" class="pesantren_validasi_pusat"><?= $Page->validasi_pusat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->validator_pusat->Visible) { // validator_pusat ?>
        <th class="<?= $Page->validator_pusat->headerCellClass() ?>"><span id="elh_pesantren_validator_pusat" class="pesantren_validator_pusat"><?= $Page->validator_pusat->caption() ?></span></th>
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
<?php if ($Page->kode->Visible) { // kode ?>
        <td <?= $Page->kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_kode" class="pesantren_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_nama" class="pesantren_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->deskripsi->Visible) { // deskripsi ?>
        <td <?= $Page->deskripsi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_deskripsi" class="pesantren_deskripsi">
<span<?= $Page->deskripsi->viewAttributes() ?>>
<?= $Page->deskripsi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jalan->Visible) { // jalan ?>
        <td <?= $Page->jalan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_jalan" class="pesantren_jalan">
<span<?= $Page->jalan->viewAttributes() ?>>
<?= $Page->jalan->getViewValue() ?>
<script>
loadjs.ready("head", function() {
    ew.googleMaps.push(jQuery.extend({"id":"gm_pesantren_x_jalan","name":"Google Maps","width":200,"width_field":null,"height":200,"height_field":null,"latitude":null,"latitude_field":"latitude","longitude":null,"longitude_field":"longitude","address":null,"address_field":null,"type":"ROADMAP","type_field":null,"zoom":8,"zoom_field":null,"title":null,"title_field":null,"icon":null,"icon_field":null,"description":null,"description_field":null,"use_single_map":true,"single_map_width":400,"single_map_height":400,"show_map_on_top":true,"show_all_markers":true,"geocoding_delay":250,"use_marker_clusterer":true,"cluster_max_zoom":-1,"cluster_grid_size":-1,"cluster_styles":-1,"template_id":"orig<?= $Page->RowCount ?>_pesantren_jalan"}, {
        latitude: <?= JsonEncode($Page->latitude->CurrentValue, "number") ?>,
        longitude: <?= JsonEncode($Page->longitude->CurrentValue, "number") ?>,
    }));
});
</script>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->telpon->Visible) { // telpon ?>
        <td <?= $Page->telpon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_telpon" class="pesantren_telpon">
<span<?= $Page->telpon->viewAttributes() ?>>
<?= $Page->telpon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nspp->Visible) { // nspp ?>
        <td <?= $Page->nspp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_nspp" class="pesantren_nspp">
<span<?= $Page->nspp->viewAttributes() ?>>
<?= $Page->nspp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nspptglmulai->Visible) { // nspptglmulai ?>
        <td <?= $Page->nspptglmulai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_nspptglmulai" class="pesantren_nspptglmulai">
<span<?= $Page->nspptglmulai->viewAttributes() ?>>
<?= $Page->nspptglmulai->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nspptglakhir->Visible) { // nspptglakhir ?>
        <td <?= $Page->nspptglakhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_nspptglakhir" class="pesantren_nspptglakhir">
<span<?= $Page->nspptglakhir->viewAttributes() ?>>
<?= $Page->nspptglakhir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->yayasan->Visible) { // yayasan ?>
        <td <?= $Page->yayasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_yayasan" class="pesantren_yayasan">
<span<?= $Page->yayasan->viewAttributes() ?>>
<?= $Page->yayasan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_userid->Visible) { // userid ?>
        <td <?= $Page->_userid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren__userid" class="pesantren__userid">
<span<?= $Page->_userid->viewAttributes() ?>>
<?= $Page->_userid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->validasi->Visible) { // validasi ?>
        <td <?= $Page->validasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_validasi" class="pesantren_validasi">
<span<?= $Page->validasi->viewAttributes() ?>>
<?= $Page->validasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
        <td <?= $Page->validator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_validator" class="pesantren_validator">
<span<?= $Page->validator->viewAttributes() ?>>
<?= $Page->validator->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->validasi_pusat->Visible) { // validasi_pusat ?>
        <td <?= $Page->validasi_pusat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_validasi_pusat" class="pesantren_validasi_pusat">
<span<?= $Page->validasi_pusat->viewAttributes() ?>>
<?= $Page->validasi_pusat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->validator_pusat->Visible) { // validator_pusat ?>
        <td <?= $Page->validator_pusat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_validator_pusat" class="pesantren_validator_pusat">
<span<?= $Page->validator_pusat->viewAttributes() ?>>
<?= $Page->validator_pusat->getViewValue() ?></span>
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
