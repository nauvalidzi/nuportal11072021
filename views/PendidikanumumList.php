<?php

namespace PHPMaker2021\nuportal;

// Page object
$PendidikanumumList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpendidikanumumlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpendidikanumumlist = currentForm = new ew.Form("fpendidikanumumlist", "list");
    fpendidikanumumlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fpendidikanumumlist");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "pesantren") {
    if ($Page->MasterRecordExists) {
        include_once "views/PesantrenMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pendidikanumum">
<form name="fpendidikanumumlist" id="fpendidikanumumlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendidikanumum">
<?php if ($Page->getCurrentMasterTable() == "pesantren" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pesantren">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_pendidikanumum" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_pendidikanumumlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_pendidikanumum_id" class="pendidikanumum_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Page->pid->headerCellClass() ?>"><div id="elh_pendidikanumum_pid" class="pendidikanumum_pid"><?= $Page->renderSort($Page->pid) ?></div></th>
<?php } ?>
<?php if ($Page->idjenispu->Visible) { // idjenispu ?>
        <th data-name="idjenispu" class="<?= $Page->idjenispu->headerCellClass() ?>"><div id="elh_pendidikanumum_idjenispu" class="pendidikanumum_idjenispu"><?= $Page->renderSort($Page->idjenispu) ?></div></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>"><div id="elh_pendidikanumum_nama" class="pendidikanumum_nama"><?= $Page->renderSort($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
        <th data-name="ijin" class="<?= $Page->ijin->headerCellClass() ?>"><div id="elh_pendidikanumum_ijin" class="pendidikanumum_ijin"><?= $Page->renderSort($Page->ijin) ?></div></th>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
        <th data-name="tglberdiri" class="<?= $Page->tglberdiri->headerCellClass() ?>"><div id="elh_pendidikanumum_tglberdiri" class="pendidikanumum_tglberdiri"><?= $Page->renderSort($Page->tglberdiri) ?></div></th>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
        <th data-name="ijinakhir" class="<?= $Page->ijinakhir->headerCellClass() ?>"><div id="elh_pendidikanumum_ijinakhir" class="pendidikanumum_ijinakhir"><?= $Page->renderSort($Page->ijinakhir) ?></div></th>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <th data-name="jumlahpengajar" class="<?= $Page->jumlahpengajar->headerCellClass() ?>"><div id="elh_pendidikanumum_jumlahpengajar" class="pendidikanumum_jumlahpengajar"><?= $Page->renderSort($Page->jumlahpengajar) ?></div></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th data-name="foto" class="<?= $Page->foto->headerCellClass() ?>"><div id="elh_pendidikanumum_foto" class="pendidikanumum_foto"><?= $Page->renderSort($Page->foto) ?></div></th>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
        <th data-name="dokumen" class="<?= $Page->dokumen->headerCellClass() ?>"><div id="elh_pendidikanumum_dokumen" class="pendidikanumum_dokumen"><?= $Page->renderSort($Page->dokumen) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_pendidikanumum", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->idjenispu->Visible) { // idjenispu ?>
        <td data-name="idjenispu" <?= $Page->idjenispu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_idjenispu">
<span<?= $Page->idjenispu->viewAttributes() ?>>
<?= $Page->idjenispu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ijin->Visible) { // ijin ?>
        <td data-name="ijin" <?= $Page->ijin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_ijin">
<span<?= $Page->ijin->viewAttributes() ?>>
<?= $Page->ijin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
        <td data-name="tglberdiri" <?= $Page->tglberdiri->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_tglberdiri">
<span<?= $Page->tglberdiri->viewAttributes() ?>>
<?= $Page->tglberdiri->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
        <td data-name="ijinakhir" <?= $Page->ijinakhir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_ijinakhir">
<span<?= $Page->ijinakhir->viewAttributes() ?>>
<?= $Page->ijinakhir->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <td data-name="jumlahpengajar" <?= $Page->jumlahpengajar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_jumlahpengajar">
<span<?= $Page->jumlahpengajar->viewAttributes() ?>>
<?= $Page->jumlahpengajar->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->foto->Visible) { // foto ?>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_foto">
<span>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dokumen->Visible) { // dokumen ?>
        <td data-name="dokumen" <?= $Page->dokumen->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendidikanumum_dokumen">
<span<?= $Page->dokumen->viewAttributes() ?>>
<?= GetFileViewTag($Page->dokumen, $Page->dokumen->getViewValue(), false) ?>
</span>
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
    ew.addEventHandlers("pendidikanumum");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
