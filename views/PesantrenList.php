<?php

namespace PHPMaker2021\nuportal;

// Page object
$PesantrenList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpesantrenlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpesantrenlist = currentForm = new ew.Form("fpesantrenlist", "list");
    fpesantrenlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fpesantrenlist");
});
</script>
<style>
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "left" : "right";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pesantren">
<form name="fpesantrenlist" id="fpesantrenlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pesantren">
<div id="gmp_pesantren" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_pesantrenlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->kode->Visible) { // kode ?>
        <th data-name="kode" class="<?= $Page->kode->headerCellClass() ?>"><div id="elh_pesantren_kode" class="pesantren_kode"><?= $Page->renderSort($Page->kode) ?></div></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_nama" class="pesantren_nama"><?= $Page->renderSort($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->propinsi->Visible) { // propinsi ?>
        <th data-name="propinsi" class="<?= $Page->propinsi->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_propinsi" class="pesantren_propinsi"><?= $Page->renderSort($Page->propinsi) ?></div></th>
<?php } ?>
<?php if ($Page->kabupaten->Visible) { // kabupaten ?>
        <th data-name="kabupaten" class="<?= $Page->kabupaten->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_kabupaten" class="pesantren_kabupaten"><?= $Page->renderSort($Page->kabupaten) ?></div></th>
<?php } ?>
<?php if ($Page->telpon->Visible) { // telpon ?>
        <th data-name="telpon" class="<?= $Page->telpon->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_telpon" class="pesantren_telpon"><?= $Page->renderSort($Page->telpon) ?></div></th>
<?php } ?>
<?php if ($Page->nspp->Visible) { // nspp ?>
        <th data-name="nspp" class="<?= $Page->nspp->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_nspp" class="pesantren_nspp"><?= $Page->renderSort($Page->nspp) ?></div></th>
<?php } ?>
<?php if ($Page->nspptglmulai->Visible) { // nspptglmulai ?>
        <th data-name="nspptglmulai" class="<?= $Page->nspptglmulai->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_nspptglmulai" class="pesantren_nspptglmulai"><?= $Page->renderSort($Page->nspptglmulai) ?></div></th>
<?php } ?>
<?php if ($Page->nspptglakhir->Visible) { // nspptglakhir ?>
        <th data-name="nspptglakhir" class="<?= $Page->nspptglakhir->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_nspptglakhir" class="pesantren_nspptglakhir"><?= $Page->renderSort($Page->nspptglakhir) ?></div></th>
<?php } ?>
<?php if ($Page->yayasan->Visible) { // yayasan ?>
        <th data-name="yayasan" class="<?= $Page->yayasan->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_yayasan" class="pesantren_yayasan"><?= $Page->renderSort($Page->yayasan) ?></div></th>
<?php } ?>
<?php if ($Page->_userid->Visible) { // userid ?>
        <th data-name="_userid" class="<?= $Page->_userid->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren__userid" class="pesantren__userid"><?= $Page->renderSort($Page->_userid) ?></div></th>
<?php } ?>
<?php if ($Page->validasi->Visible) { // validasi ?>
        <th data-name="validasi" class="<?= $Page->validasi->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_validasi" class="pesantren_validasi"><?= $Page->renderSort($Page->validasi) ?></div></th>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
        <th data-name="validator" class="<?= $Page->validator->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_validator" class="pesantren_validator"><?= $Page->renderSort($Page->validator) ?></div></th>
<?php } ?>
<?php if ($Page->validasi_pusat->Visible) { // validasi_pusat ?>
        <th data-name="validasi_pusat" class="<?= $Page->validasi_pusat->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_validasi_pusat" class="pesantren_validasi_pusat"><?= $Page->renderSort($Page->validasi_pusat) ?></div></th>
<?php } ?>
<?php if ($Page->validator_pusat->Visible) { // validator_pusat ?>
        <th data-name="validator_pusat" class="<?= $Page->validator_pusat->headerCellClass() ?>" style="white-space: nowrap;"><div id="elh_pesantren_validator_pusat" class="pesantren_validator_pusat"><?= $Page->renderSort($Page->validator_pusat) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_pesantren", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->kode->Visible) { // kode ?>
        <td data-name="kode" <?= $Page->kode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<?= $Page->kode->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->propinsi->Visible) { // propinsi ?>
        <td data-name="propinsi" <?= $Page->propinsi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_propinsi">
<span<?= $Page->propinsi->viewAttributes() ?>>
<?= $Page->propinsi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->kabupaten->Visible) { // kabupaten ?>
        <td data-name="kabupaten" <?= $Page->kabupaten->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_kabupaten">
<span<?= $Page->kabupaten->viewAttributes() ?>>
<?= $Page->kabupaten->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->telpon->Visible) { // telpon ?>
        <td data-name="telpon" <?= $Page->telpon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_telpon">
<span<?= $Page->telpon->viewAttributes() ?>>
<?= $Page->telpon->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nspp->Visible) { // nspp ?>
        <td data-name="nspp" <?= $Page->nspp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_nspp">
<span<?= $Page->nspp->viewAttributes() ?>>
<?= $Page->nspp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nspptglmulai->Visible) { // nspptglmulai ?>
        <td data-name="nspptglmulai" <?= $Page->nspptglmulai->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_nspptglmulai">
<span<?= $Page->nspptglmulai->viewAttributes() ?>>
<?= $Page->nspptglmulai->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nspptglakhir->Visible) { // nspptglakhir ?>
        <td data-name="nspptglakhir" <?= $Page->nspptglakhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_nspptglakhir">
<span<?= $Page->nspptglakhir->viewAttributes() ?>>
<?= $Page->nspptglakhir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->yayasan->Visible) { // yayasan ?>
        <td data-name="yayasan" <?= $Page->yayasan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_yayasan">
<span<?= $Page->yayasan->viewAttributes() ?>>
<?= $Page->yayasan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_userid->Visible) { // userid ?>
        <td data-name="_userid" <?= $Page->_userid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren__userid">
<span<?= $Page->_userid->viewAttributes() ?>>
<?= $Page->_userid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->validasi->Visible) { // validasi ?>
        <td data-name="validasi" <?= $Page->validasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_validasi">
<span<?= $Page->validasi->viewAttributes() ?>>
<?= $Page->validasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->validator->Visible) { // validator ?>
        <td data-name="validator" <?= $Page->validator->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_validator">
<span<?= $Page->validator->viewAttributes() ?>>
<?= $Page->validator->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->validasi_pusat->Visible) { // validasi_pusat ?>
        <td data-name="validasi_pusat" <?= $Page->validasi_pusat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_validasi_pusat">
<span<?= $Page->validasi_pusat->viewAttributes() ?>>
<?= $Page->validasi_pusat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->validator_pusat->Visible) { // validator_pusat ?>
        <td data-name="validator_pusat" <?= $Page->validator_pusat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pesantren_validator_pusat">
<span<?= $Page->validator_pusat->viewAttributes() ?>>
<?= $Page->validator_pusat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("pesantren");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
