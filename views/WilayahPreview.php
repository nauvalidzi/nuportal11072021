<?php

namespace PHPMaker2021\nuportal;

// Page object
$WilayahPreview = &$Page;
?>
<script>
if (!ew.vars.tables.wilayah) ew.vars.tables.wilayah = <?= JsonEncode(GetClientVar("tables", "wilayah")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid wilayah"><!-- .card -->
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
<?php if ($Page->iduser->Visible) { // iduser ?>
    <?php if ($Page->SortUrl($Page->iduser) == "") { ?>
        <th class="<?= $Page->iduser->headerCellClass() ?>"><?= $Page->iduser->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->iduser->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->iduser->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->iduser->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->iduser->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->iduser->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->iduser->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idprovinsis->Visible) { // idprovinsis ?>
    <?php if ($Page->SortUrl($Page->idprovinsis) == "") { ?>
        <th class="<?= $Page->idprovinsis->headerCellClass() ?>"><?= $Page->idprovinsis->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idprovinsis->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idprovinsis->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idprovinsis->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idprovinsis->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idprovinsis->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idprovinsis->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->idkabupatens->Visible) { // idkabupatens ?>
    <?php if ($Page->SortUrl($Page->idkabupatens) == "") { ?>
        <th class="<?= $Page->idkabupatens->headerCellClass() ?>"><?= $Page->idkabupatens->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->idkabupatens->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->idkabupatens->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->idkabupatens->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->idkabupatens->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->idkabupatens->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->idkabupatens->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->iduser->Visible) { // iduser ?>
        <!-- iduser -->
        <td<?= $Page->iduser->cellAttributes() ?>>
<span<?= $Page->iduser->viewAttributes() ?>>
<?= $Page->iduser->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idprovinsis->Visible) { // idprovinsis ?>
        <!-- idprovinsis -->
        <td<?= $Page->idprovinsis->cellAttributes() ?>>
<span<?= $Page->idprovinsis->viewAttributes() ?>>
<?= $Page->idprovinsis->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->idkabupatens->Visible) { // idkabupatens ?>
        <!-- idkabupatens -->
        <td<?= $Page->idkabupatens->cellAttributes() ?>>
<span<?= $Page->idkabupatens->viewAttributes() ?>>
<?= $Page->idkabupatens->getViewValue() ?></span>
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
