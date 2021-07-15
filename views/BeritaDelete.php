<?php

namespace PHPMaker2021\nuportal;

// Page object
$BeritaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fberitadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fberitadelete = currentForm = new ew.Form("fberitadelete", "delete");
    loadjs.done("fberitadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.berita) ew.vars.tables.berita = <?= JsonEncode(GetClientVar("tables", "berita")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fberitadelete" id="fberitadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="berita">
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
<?php if ($Page->judul->Visible) { // judul ?>
        <th class="<?= $Page->judul->headerCellClass() ?>"><span id="elh_berita_judul" class="berita_judul"><?= $Page->judul->caption() ?></span></th>
<?php } ?>
<?php if ($Page->slug->Visible) { // slug ?>
        <th class="<?= $Page->slug->headerCellClass() ?>"><span id="elh_berita_slug" class="berita_slug"><?= $Page->slug->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><span id="elh_berita_foto" class="berita_foto"><?= $Page->foto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_berita_status" class="berita_status"><?= $Page->status->caption() ?></span></th>
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
<?php if ($Page->judul->Visible) { // judul ?>
        <td <?= $Page->judul->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_berita_judul" class="berita_judul">
<span<?= $Page->judul->viewAttributes() ?>>
<?= $Page->judul->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->slug->Visible) { // slug ?>
        <td <?= $Page->slug->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_berita_slug" class="berita_slug">
<span<?= $Page->slug->viewAttributes() ?>>
<?= $Page->slug->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <td <?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_berita_foto" class="berita_foto">
<span>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_berita_status" class="berita_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
