<?php

namespace PHPMaker2021\nuportal;

// Page object
$KitabkuningPreview = &$Page;
?>
<script>
if (!ew.vars.tables.kitabkuning) ew.vars.tables.kitabkuning = <?= JsonEncode(GetClientVar("tables", "kitabkuning")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid kitabkuning"><!-- .card -->
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
<?php if ($Page->pelaksanaan->Visible) { // pelaksanaan ?>
    <?php if ($Page->SortUrl($Page->pelaksanaan) == "") { ?>
        <th class="<?= $Page->pelaksanaan->headerCellClass() ?>"><?= $Page->pelaksanaan->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->pelaksanaan->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->pelaksanaan->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->pelaksanaan->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->pelaksanaan->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->pelaksanaan->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->pelaksanaan->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->metode->Visible) { // metode ?>
    <?php if ($Page->SortUrl($Page->metode) == "") { ?>
        <th class="<?= $Page->metode->headerCellClass() ?>"><?= $Page->metode->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->metode->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->metode->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->metode->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->metode->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->metode->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->metode->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->pelaksanaan->Visible) { // pelaksanaan ?>
        <!-- pelaksanaan -->
        <td<?= $Page->pelaksanaan->cellAttributes() ?>>
<span<?= $Page->pelaksanaan->viewAttributes() ?>>
<?= $Page->pelaksanaan->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->metode->Visible) { // metode ?>
        <!-- metode -->
        <td<?= $Page->metode->cellAttributes() ?>>
<span<?= $Page->metode->viewAttributes() ?>>
<?= $Page->metode->getViewValue() ?></span>
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
