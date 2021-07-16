<?php

namespace PHPMaker2021\nuportal;

// Page object
$PendidikanpesantrenPreview = &$Page;
?>
<script>
if (!ew.vars.tables.pendidikanpesantren) ew.vars.tables.pendidikanpesantren = <?= JsonEncode(GetClientVar("tables", "pendidikanpesantren")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid pendidikanpesantren"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->pid->Visible) { // pid ?>
    <?php if ($Page->SortUrl($Page->pid) == "") { ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><?= $Page->pid->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->pid->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->pid->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->pid->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->pid->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->pid->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idjenispp->Visible) { // idjenispp ?>
    <?php if ($Page->SortUrl($Page->idjenispp) == "") { ?>
        <th class="<?= $Page->idjenispp->headerCellClass() ?>"><?= $Page->idjenispp->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idjenispp->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idjenispp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idjenispp->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idjenispp->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idjenispp->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idjenispp->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <?php if ($Page->SortUrl($Page->nama) == "") { ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><?= $Page->nama->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nama->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nama->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nama->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nama->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nama->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
    <?php if ($Page->SortUrl($Page->ijin) == "") { ?>
        <th class="<?= $Page->ijin->headerCellClass() ?>"><?= $Page->ijin->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ijin->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ijin->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ijin->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ijin->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ijin->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ijin->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
    <?php if ($Page->SortUrl($Page->tglberdiri) == "") { ?>
        <th class="<?= $Page->tglberdiri->headerCellClass() ?>"><?= $Page->tglberdiri->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglberdiri->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglberdiri->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglberdiri->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglberdiri->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglberdiri->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglberdiri->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
    <?php if ($Page->SortUrl($Page->ijinakhir) == "") { ?>
        <th class="<?= $Page->ijinakhir->headerCellClass() ?>"><?= $Page->ijinakhir->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ijinakhir->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ijinakhir->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ijinakhir->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ijinakhir->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ijinakhir->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ijinakhir->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
    <?php if ($Page->SortUrl($Page->jumlahpengajar) == "") { ?>
        <th class="<?= $Page->jumlahpengajar->headerCellClass() ?>"><?= $Page->jumlahpengajar->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jumlahpengajar->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jumlahpengajar->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jumlahpengajar->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jumlahpengajar->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jumlahpengajar->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jumlahpengajar->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <?php if ($Page->SortUrl($Page->foto) == "") { ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><?= $Page->foto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->foto->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->foto->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->foto->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->foto->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->foto->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
    <?php if ($Page->SortUrl($Page->dokumen) == "") { ?>
        <th class="<?= $Page->dokumen->headerCellClass() ?>"><?= $Page->dokumen->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dokumen->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->dokumen->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->dokumen->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->dokumen->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->dokumen->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->dokumen->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->pid->Visible) { // pid ?>
        <!-- pid -->
        <td<?= $Page->pid->cellAttributes() ?>>
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idjenispp->Visible) { // idjenispp ?>
        <!-- idjenispp -->
        <td<?= $Page->idjenispp->cellAttributes() ?>>
<span<?= $Page->idjenispp->viewAttributes() ?>>
<?= $Page->idjenispp->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <!-- nama -->
        <td<?= $Page->nama->cellAttributes() ?>>
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
        <!-- ijin -->
        <td<?= $Page->ijin->cellAttributes() ?>>
<span<?= $Page->ijin->viewAttributes() ?>>
<?= $Page->ijin->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
        <!-- tglberdiri -->
        <td<?= $Page->tglberdiri->cellAttributes() ?>>
<span<?= $Page->tglberdiri->viewAttributes() ?>>
<?= $Page->tglberdiri->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
        <!-- ijinakhir -->
        <td<?= $Page->ijinakhir->cellAttributes() ?>>
<span<?= $Page->ijinakhir->viewAttributes() ?>>
<?= $Page->ijinakhir->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <!-- jumlahpengajar -->
        <td<?= $Page->jumlahpengajar->cellAttributes() ?>>
<span<?= $Page->jumlahpengajar->viewAttributes() ?>>
<?= $Page->jumlahpengajar->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <!-- foto -->
        <td<?= $Page->foto->cellAttributes() ?>>
<span>
<?= GetImageViewTag($Page->foto, $Page->foto->getViewValue()) ?></span>
</td>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
        <!-- dokumen -->
        <td<?= $Page->dokumen->cellAttributes() ?>>
<span<?= $Page->dokumen->viewAttributes() ?>>
<?= $Page->dokumen->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
