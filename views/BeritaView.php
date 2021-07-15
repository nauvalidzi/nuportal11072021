<?php

namespace PHPMaker2021\nuportal;

// Page object
$BeritaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fberitaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fberitaview = currentForm = new ew.Form("fberitaview", "view");
    loadjs.done("fberitaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.berita) ew.vars.tables.berita = <?= JsonEncode(GetClientVar("tables", "berita")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fberitaview" id="fberitaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="berita">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->judul->Visible) { // judul ?>
    <tr id="r_judul">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_berita_judul"><?= $Page->judul->caption() ?></span></td>
        <td data-name="judul" <?= $Page->judul->cellAttributes() ?>>
<span id="el_berita_judul">
<span<?= $Page->judul->viewAttributes() ?>>
<?= $Page->judul->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->slug->Visible) { // slug ?>
    <tr id="r_slug">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_berita_slug"><?= $Page->slug->caption() ?></span></td>
        <td data-name="slug" <?= $Page->slug->cellAttributes() ?>>
<span id="el_berita_slug">
<span<?= $Page->slug->viewAttributes() ?>>
<?= $Page->slug->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->deskripsi->Visible) { // deskripsi ?>
    <tr id="r_deskripsi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_berita_deskripsi"><?= $Page->deskripsi->caption() ?></span></td>
        <td data-name="deskripsi" <?= $Page->deskripsi->cellAttributes() ?>>
<span id="el_berita_deskripsi">
<span<?= $Page->deskripsi->viewAttributes() ?>>
<?= $Page->deskripsi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_berita_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_berita_foto">
<span>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_berita_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<span id="el_berita_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
