<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitasusahaPreview = &$Page;
?>
<script>
if (!ew.vars.tables.fasilitasusaha) ew.vars.tables.fasilitasusaha = <?= JsonEncode(GetClientVar("tables", "fasilitasusaha")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid fasilitasusaha"><!-- .card -->
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
<?php if ($Page->namausaha->Visible) { // namausaha ?>
    <?php if ($Page->SortUrl($Page->namausaha) == "") { ?>
        <th class="<?= $Page->namausaha->headerCellClass() ?>"><?= $Page->namausaha->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->namausaha->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->namausaha->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->namausaha->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->namausaha->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->namausaha->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->namausaha->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
    <?php if ($Page->SortUrl($Page->bidangusaha) == "") { ?>
        <th class="<?= $Page->bidangusaha->headerCellClass() ?>"><?= $Page->bidangusaha->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bidangusaha->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bidangusaha->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->bidangusaha->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bidangusaha->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->bidangusaha->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->bidangusaha->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->badanhukum->Visible) { // badanhukum ?>
    <?php if ($Page->SortUrl($Page->badanhukum) == "") { ?>
        <th class="<?= $Page->badanhukum->headerCellClass() ?>"><?= $Page->badanhukum->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->badanhukum->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->badanhukum->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->badanhukum->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->badanhukum->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->badanhukum->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->badanhukum->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->siup->Visible) { // siup ?>
    <?php if ($Page->SortUrl($Page->siup) == "") { ?>
        <th class="<?= $Page->siup->headerCellClass() ?>"><?= $Page->siup->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->siup->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->siup->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->siup->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->siup->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->siup->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->siup->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->bpom->Visible) { // bpom ?>
    <?php if ($Page->SortUrl($Page->bpom) == "") { ?>
        <th class="<?= $Page->bpom->headerCellClass() ?>"><?= $Page->bpom->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->bpom->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->bpom->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->bpom->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->bpom->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->bpom->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->bpom->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->irt->Visible) { // irt ?>
    <?php if ($Page->SortUrl($Page->irt) == "") { ?>
        <th class="<?= $Page->irt->headerCellClass() ?>"><?= $Page->irt->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->irt->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->irt->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->irt->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->irt->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->irt->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->irt->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->potensiblm->Visible) { // potensiblm ?>
    <?php if ($Page->SortUrl($Page->potensiblm) == "") { ?>
        <th class="<?= $Page->potensiblm->headerCellClass() ?>"><?= $Page->potensiblm->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->potensiblm->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->potensiblm->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->potensiblm->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->potensiblm->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->potensiblm->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->potensiblm->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->aset->Visible) { // aset ?>
    <?php if ($Page->SortUrl($Page->aset) == "") { ?>
        <th class="<?= $Page->aset->headerCellClass() ?>"><?= $Page->aset->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->aset->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->aset->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->aset->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->aset->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->aset->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->aset->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_modal->Visible) { // modal ?>
    <?php if ($Page->SortUrl($Page->_modal) == "") { ?>
        <th class="<?= $Page->_modal->headerCellClass() ?>"><?= $Page->_modal->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_modal->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->_modal->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_modal->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->_modal->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->_modal->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->_modal->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
    <?php if ($Page->SortUrl($Page->hasilsetahun) == "") { ?>
        <th class="<?= $Page->hasilsetahun->headerCellClass() ?>"><?= $Page->hasilsetahun->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->hasilsetahun->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->hasilsetahun->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->hasilsetahun->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->hasilsetahun->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->hasilsetahun->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->hasilsetahun->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->kendala->Visible) { // kendala ?>
    <?php if ($Page->SortUrl($Page->kendala) == "") { ?>
        <th class="<?= $Page->kendala->headerCellClass() ?>"><?= $Page->kendala->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->kendala->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->kendala->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->kendala->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->kendala->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->kendala->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->kendala->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
    <?php if ($Page->SortUrl($Page->fasilitasperlu) == "") { ?>
        <th class="<?= $Page->fasilitasperlu->headerCellClass() ?>"><?= $Page->fasilitasperlu->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fasilitasperlu->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fasilitasperlu->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->fasilitasperlu->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fasilitasperlu->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->fasilitasperlu->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->fasilitasperlu->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->namausaha->Visible) { // namausaha ?>
        <!-- namausaha -->
        <td<?= $Page->namausaha->cellAttributes() ?>>
<span<?= $Page->namausaha->viewAttributes() ?>>
<?= $Page->namausaha->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
        <!-- bidangusaha -->
        <td<?= $Page->bidangusaha->cellAttributes() ?>>
<span<?= $Page->bidangusaha->viewAttributes() ?>>
<?= $Page->bidangusaha->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->badanhukum->Visible) { // badanhukum ?>
        <!-- badanhukum -->
        <td<?= $Page->badanhukum->cellAttributes() ?>>
<span<?= $Page->badanhukum->viewAttributes() ?>>
<?= $Page->badanhukum->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->siup->Visible) { // siup ?>
        <!-- siup -->
        <td<?= $Page->siup->cellAttributes() ?>>
<span<?= $Page->siup->viewAttributes() ?>>
<?= $Page->siup->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->bpom->Visible) { // bpom ?>
        <!-- bpom -->
        <td<?= $Page->bpom->cellAttributes() ?>>
<span<?= $Page->bpom->viewAttributes() ?>>
<?= $Page->bpom->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->irt->Visible) { // irt ?>
        <!-- irt -->
        <td<?= $Page->irt->cellAttributes() ?>>
<span<?= $Page->irt->viewAttributes() ?>>
<?= $Page->irt->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->potensiblm->Visible) { // potensiblm ?>
        <!-- potensiblm -->
        <td<?= $Page->potensiblm->cellAttributes() ?>>
<span<?= $Page->potensiblm->viewAttributes() ?>>
<?= $Page->potensiblm->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->aset->Visible) { // aset ?>
        <!-- aset -->
        <td<?= $Page->aset->cellAttributes() ?>>
<span<?= $Page->aset->viewAttributes() ?>>
<?= $Page->aset->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_modal->Visible) { // modal ?>
        <!-- modal -->
        <td<?= $Page->_modal->cellAttributes() ?>>
<span<?= $Page->_modal->viewAttributes() ?>>
<?= $Page->_modal->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
        <!-- hasilsetahun -->
        <td<?= $Page->hasilsetahun->cellAttributes() ?>>
<span<?= $Page->hasilsetahun->viewAttributes() ?>>
<?= $Page->hasilsetahun->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->kendala->Visible) { // kendala ?>
        <!-- kendala -->
        <td<?= $Page->kendala->cellAttributes() ?>>
<span<?= $Page->kendala->viewAttributes() ?>>
<?= $Page->kendala->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <!-- fasilitasperlu -->
        <td<?= $Page->fasilitasperlu->cellAttributes() ?>>
<span<?= $Page->fasilitasperlu->viewAttributes() ?>>
<?= $Page->fasilitasperlu->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <!-- foto -->
        <td<?= $Page->foto->cellAttributes() ?>>
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
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
