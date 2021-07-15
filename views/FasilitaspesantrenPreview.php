<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitaspesantrenPreview = &$Page;
?>
<script>
if (!ew.vars.tables.fasilitaspesantren) ew.vars.tables.fasilitaspesantren = <?= JsonEncode(GetClientVar("tables", "fasilitaspesantren")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid fasilitaspesantren"><!-- .card -->
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
<?php if ($Page->id->Visible) { // id ?>
    <?php if ($Page->SortUrl($Page->id) == "") { ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><?= $Page->id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->id->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->id->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
    <?php if ($Page->SortUrl($Page->pid) == "") { ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><?= $Page->pid->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->pid->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->pid->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->pid->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->pid->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->pid->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
    <?php if ($Page->SortUrl($Page->namafasilitas) == "") { ?>
        <th class="<?= $Page->namafasilitas->headerCellClass() ?>"><?= $Page->namafasilitas->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->namafasilitas->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->namafasilitas->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->namafasilitas->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->namafasilitas->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->namafasilitas->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->namafasilitas->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <?php if ($Page->SortUrl($Page->keterangan) == "") { ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><?= $Page->keterangan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->keterangan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->keterangan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->keterangan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->keterangan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->keterangan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
    <?php if ($Page->SortUrl($Page->fotofasilitas) == "") { ?>
        <th class="<?= $Page->fotofasilitas->headerCellClass() ?>"><?= $Page->fotofasilitas->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fotofasilitas->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fotofasilitas->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fotofasilitas->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fotofasilitas->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->fotofasilitas->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->fotofasilitas->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->id->Visible) { // id ?>
        <!-- id -->
        <td<?= $Page->id->cellAttributes() ?>>
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <!-- pid -->
        <td<?= $Page->pid->cellAttributes() ?>>
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
        <!-- namafasilitas -->
        <td<?= $Page->namafasilitas->cellAttributes() ?>>
<span<?= $Page->namafasilitas->viewAttributes() ?>>
<?= $Page->namafasilitas->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <!-- keterangan -->
        <td<?= $Page->keterangan->cellAttributes() ?>>
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
        <!-- fotofasilitas -->
        <td<?= $Page->fotofasilitas->cellAttributes() ?>>
<span<?= $Page->fotofasilitas->viewAttributes() ?>>
<?= GetFileViewTag($Page->fotofasilitas, $Page->fotofasilitas->getViewValue(), false) ?>
</span>
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
