<?php

namespace PHPMaker2021\nuportal;

// Page object
$PengasuhppwanitaPreview = &$Page;
?>
<script>
if (!ew.vars.tables.pengasuhppwanita) ew.vars.tables.pengasuhppwanita = <?= JsonEncode(GetClientVar("tables", "pengasuhppwanita")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid pengasuhppwanita"><!-- .card -->
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
<?php if ($Page->nama->Visible) { // nama ?>
    <?php if ($Page->SortUrl($Page->nama) == "") { ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><?= $Page->nama->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nama->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nama->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nama->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nama->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nama->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nik->Visible) { // nik ?>
    <?php if ($Page->SortUrl($Page->nik) == "") { ?>
        <th class="<?= $Page->nik->headerCellClass() ?>"><?= $Page->nik->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nik->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nik->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nik->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nik->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->nik->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->nik->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <?php if ($Page->SortUrl($Page->alamat) == "") { ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><?= $Page->alamat->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->alamat->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->alamat->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->alamat->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->alamat->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->alamat->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <?php if ($Page->SortUrl($Page->hp) == "") { ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><?= $Page->hp->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->hp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->hp->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->hp->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->hp->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->hp->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->md->Visible) { // md ?>
    <?php if ($Page->SortUrl($Page->md) == "") { ?>
        <th class="<?= $Page->md->headerCellClass() ?>"><?= $Page->md->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->md->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->md->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->md->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->md->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->md->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->md->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->mts->Visible) { // mts ?>
    <?php if ($Page->SortUrl($Page->mts) == "") { ?>
        <th class="<?= $Page->mts->headerCellClass() ?>"><?= $Page->mts->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->mts->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->mts->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->mts->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->mts->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->mts->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->mts->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ma->Visible) { // ma ?>
    <?php if ($Page->SortUrl($Page->ma) == "") { ?>
        <th class="<?= $Page->ma->headerCellClass() ?>"><?= $Page->ma->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ma->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ma->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ma->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ma->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ma->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ma->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->pesantren->Visible) { // pesantren ?>
    <?php if ($Page->SortUrl($Page->pesantren) == "") { ?>
        <th class="<?= $Page->pesantren->headerCellClass() ?>"><?= $Page->pesantren->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->pesantren->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->pesantren->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->pesantren->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->pesantren->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->pesantren->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->pesantren->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->s1->Visible) { // s1 ?>
    <?php if ($Page->SortUrl($Page->s1) == "") { ?>
        <th class="<?= $Page->s1->headerCellClass() ?>"><?= $Page->s1->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->s1->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->s1->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->s1->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->s1->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->s1->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->s1->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->s2->Visible) { // s2 ?>
    <?php if ($Page->SortUrl($Page->s2) == "") { ?>
        <th class="<?= $Page->s2->headerCellClass() ?>"><?= $Page->s2->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->s2->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->s2->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->s2->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->s2->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->s2->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->s2->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->s3->Visible) { // s3 ?>
    <?php if ($Page->SortUrl($Page->s3) == "") { ?>
        <th class="<?= $Page->s3->headerCellClass() ?>"><?= $Page->s3->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->s3->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->s3->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->s3->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->s3->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->s3->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->s3->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->organisasi->Visible) { // organisasi ?>
    <?php if ($Page->SortUrl($Page->organisasi) == "") { ?>
        <th class="<?= $Page->organisasi->headerCellClass() ?>"><?= $Page->organisasi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->organisasi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->organisasi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->organisasi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->organisasi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->organisasi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->organisasi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
    <?php if ($Page->SortUrl($Page->jabatandiorganisasi) == "") { ?>
        <th class="<?= $Page->jabatandiorganisasi->headerCellClass() ?>"><?= $Page->jabatandiorganisasi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jabatandiorganisasi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jabatandiorganisasi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jabatandiorganisasi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jabatandiorganisasi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jabatandiorganisasi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jabatandiorganisasi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
    <?php if ($Page->SortUrl($Page->tglawalorganisasi) == "") { ?>
        <th class="<?= $Page->tglawalorganisasi->headerCellClass() ?>"><?= $Page->tglawalorganisasi->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglawalorganisasi->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglawalorganisasi->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglawalorganisasi->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglawalorganisasi->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglawalorganisasi->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglawalorganisasi->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->pemerintah->Visible) { // pemerintah ?>
    <?php if ($Page->SortUrl($Page->pemerintah) == "") { ?>
        <th class="<?= $Page->pemerintah->headerCellClass() ?>"><?= $Page->pemerintah->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->pemerintah->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->pemerintah->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->pemerintah->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->pemerintah->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->pemerintah->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->pemerintah->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
    <?php if ($Page->SortUrl($Page->jabatandipemerintah) == "") { ?>
        <th class="<?= $Page->jabatandipemerintah->headerCellClass() ?>"><?= $Page->jabatandipemerintah->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->jabatandipemerintah->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->jabatandipemerintah->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->jabatandipemerintah->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->jabatandipemerintah->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->jabatandipemerintah->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->jabatandipemerintah->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
    <?php if ($Page->SortUrl($Page->tglmenjabat) == "") { ?>
        <th class="<?= $Page->tglmenjabat->headerCellClass() ?>"><?= $Page->tglmenjabat->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tglmenjabat->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tglmenjabat->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->tglmenjabat->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tglmenjabat->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->tglmenjabat->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->tglmenjabat->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->ijazah->Visible) { // ijazah ?>
    <?php if ($Page->SortUrl($Page->ijazah) == "") { ?>
        <th class="<?= $Page->ijazah->headerCellClass() ?>"><?= $Page->ijazah->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ijazah->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->ijazah->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ijazah->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->ijazah->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->ijazah->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->ijazah->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->sertifikat->Visible) { // sertifikat ?>
    <?php if ($Page->SortUrl($Page->sertifikat) == "") { ?>
        <th class="<?= $Page->sertifikat->headerCellClass() ?>"><?= $Page->sertifikat->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->sertifikat->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->sertifikat->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->sertifikat->getNextSort() ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->sertifikat->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->sertifikat->getSort() == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->sertifikat->getSort() == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->nama->Visible) { // nama ?>
        <!-- nama -->
        <td<?= $Page->nama->cellAttributes() ?>>
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nik->Visible) { // nik ?>
        <!-- nik -->
        <td<?= $Page->nik->cellAttributes() ?>>
<span<?= $Page->nik->viewAttributes() ?>>
<?= $Page->nik->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <!-- alamat -->
        <td<?= $Page->alamat->cellAttributes() ?>>
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <!-- hp -->
        <td<?= $Page->hp->cellAttributes() ?>>
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->md->Visible) { // md ?>
        <!-- md -->
        <td<?= $Page->md->cellAttributes() ?>>
<span<?= $Page->md->viewAttributes() ?>>
<?= $Page->md->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->mts->Visible) { // mts ?>
        <!-- mts -->
        <td<?= $Page->mts->cellAttributes() ?>>
<span<?= $Page->mts->viewAttributes() ?>>
<?= $Page->mts->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ma->Visible) { // ma ?>
        <!-- ma -->
        <td<?= $Page->ma->cellAttributes() ?>>
<span<?= $Page->ma->viewAttributes() ?>>
<?= $Page->ma->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->pesantren->Visible) { // pesantren ?>
        <!-- pesantren -->
        <td<?= $Page->pesantren->cellAttributes() ?>>
<span<?= $Page->pesantren->viewAttributes() ?>>
<?= $Page->pesantren->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->s1->Visible) { // s1 ?>
        <!-- s1 -->
        <td<?= $Page->s1->cellAttributes() ?>>
<span<?= $Page->s1->viewAttributes() ?>>
<?= $Page->s1->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->s2->Visible) { // s2 ?>
        <!-- s2 -->
        <td<?= $Page->s2->cellAttributes() ?>>
<span<?= $Page->s2->viewAttributes() ?>>
<?= $Page->s2->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->s3->Visible) { // s3 ?>
        <!-- s3 -->
        <td<?= $Page->s3->cellAttributes() ?>>
<span<?= $Page->s3->viewAttributes() ?>>
<?= $Page->s3->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->organisasi->Visible) { // organisasi ?>
        <!-- organisasi -->
        <td<?= $Page->organisasi->cellAttributes() ?>>
<span<?= $Page->organisasi->viewAttributes() ?>>
<?= $Page->organisasi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <!-- jabatandiorganisasi -->
        <td<?= $Page->jabatandiorganisasi->cellAttributes() ?>>
<span<?= $Page->jabatandiorganisasi->viewAttributes() ?>>
<?= $Page->jabatandiorganisasi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <!-- tglawalorganisasi -->
        <td<?= $Page->tglawalorganisasi->cellAttributes() ?>>
<span<?= $Page->tglawalorganisasi->viewAttributes() ?>>
<?= $Page->tglawalorganisasi->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->pemerintah->Visible) { // pemerintah ?>
        <!-- pemerintah -->
        <td<?= $Page->pemerintah->cellAttributes() ?>>
<span<?= $Page->pemerintah->viewAttributes() ?>>
<?= $Page->pemerintah->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <!-- jabatandipemerintah -->
        <td<?= $Page->jabatandipemerintah->cellAttributes() ?>>
<span<?= $Page->jabatandipemerintah->viewAttributes() ?>>
<?= $Page->jabatandipemerintah->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
        <!-- tglmenjabat -->
        <td<?= $Page->tglmenjabat->cellAttributes() ?>>
<span<?= $Page->tglmenjabat->viewAttributes() ?>>
<?= $Page->tglmenjabat->getViewValue() ?></span>
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
<?php if ($Page->ijazah->Visible) { // ijazah ?>
        <!-- ijazah -->
        <td<?= $Page->ijazah->cellAttributes() ?>>
<span<?= $Page->ijazah->viewAttributes() ?>>
<?= GetFileViewTag($Page->ijazah, $Page->ijazah->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php if ($Page->sertifikat->Visible) { // sertifikat ?>
        <!-- sertifikat -->
        <td<?= $Page->sertifikat->cellAttributes() ?>>
<span<?= $Page->sertifikat->viewAttributes() ?>>
<?= GetFileViewTag($Page->sertifikat, $Page->sertifikat->getViewValue(), false) ?>
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
