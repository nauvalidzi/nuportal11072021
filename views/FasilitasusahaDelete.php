<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitasusahaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ffasilitasusahadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ffasilitasusahadelete = currentForm = new ew.Form("ffasilitasusahadelete", "delete");
    loadjs.done("ffasilitasusahadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.fasilitasusaha) ew.vars.tables.fasilitasusaha = <?= JsonEncode(GetClientVar("tables", "fasilitasusaha")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffasilitasusahadelete" id="ffasilitasusahadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fasilitasusaha">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fasilitasusaha_id" class="fasilitasusaha_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th class="<?= $Page->pid->headerCellClass() ?>"><span id="elh_fasilitasusaha_pid" class="fasilitasusaha_pid"><?= $Page->pid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->namausaha->Visible) { // namausaha ?>
        <th class="<?= $Page->namausaha->headerCellClass() ?>"><span id="elh_fasilitasusaha_namausaha" class="fasilitasusaha_namausaha"><?= $Page->namausaha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
        <th class="<?= $Page->bidangusaha->headerCellClass() ?>"><span id="elh_fasilitasusaha_bidangusaha" class="fasilitasusaha_bidangusaha"><?= $Page->bidangusaha->caption() ?></span></th>
<?php } ?>
<?php if ($Page->badanhukum->Visible) { // badanhukum ?>
        <th class="<?= $Page->badanhukum->headerCellClass() ?>"><span id="elh_fasilitasusaha_badanhukum" class="fasilitasusaha_badanhukum"><?= $Page->badanhukum->caption() ?></span></th>
<?php } ?>
<?php if ($Page->siup->Visible) { // siup ?>
        <th class="<?= $Page->siup->headerCellClass() ?>"><span id="elh_fasilitasusaha_siup" class="fasilitasusaha_siup"><?= $Page->siup->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bpom->Visible) { // bpom ?>
        <th class="<?= $Page->bpom->headerCellClass() ?>"><span id="elh_fasilitasusaha_bpom" class="fasilitasusaha_bpom"><?= $Page->bpom->caption() ?></span></th>
<?php } ?>
<?php if ($Page->irt->Visible) { // irt ?>
        <th class="<?= $Page->irt->headerCellClass() ?>"><span id="elh_fasilitasusaha_irt" class="fasilitasusaha_irt"><?= $Page->irt->caption() ?></span></th>
<?php } ?>
<?php if ($Page->potensiblm->Visible) { // potensiblm ?>
        <th class="<?= $Page->potensiblm->headerCellClass() ?>"><span id="elh_fasilitasusaha_potensiblm" class="fasilitasusaha_potensiblm"><?= $Page->potensiblm->caption() ?></span></th>
<?php } ?>
<?php if ($Page->aset->Visible) { // aset ?>
        <th class="<?= $Page->aset->headerCellClass() ?>"><span id="elh_fasilitasusaha_aset" class="fasilitasusaha_aset"><?= $Page->aset->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_modal->Visible) { // modal ?>
        <th class="<?= $Page->_modal->headerCellClass() ?>"><span id="elh_fasilitasusaha__modal" class="fasilitasusaha__modal"><?= $Page->_modal->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
        <th class="<?= $Page->hasilsetahun->headerCellClass() ?>"><span id="elh_fasilitasusaha_hasilsetahun" class="fasilitasusaha_hasilsetahun"><?= $Page->hasilsetahun->caption() ?></span></th>
<?php } ?>
<?php if ($Page->kendala->Visible) { // kendala ?>
        <th class="<?= $Page->kendala->headerCellClass() ?>"><span id="elh_fasilitasusaha_kendala" class="fasilitasusaha_kendala"><?= $Page->kendala->caption() ?></span></th>
<?php } ?>
<?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <th class="<?= $Page->fasilitasperlu->headerCellClass() ?>"><span id="elh_fasilitasusaha_fasilitasperlu" class="fasilitasusaha_fasilitasperlu"><?= $Page->fasilitasperlu->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><span id="elh_fasilitasusaha_foto" class="fasilitasusaha_foto"><?= $Page->foto->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_id" class="fasilitasusaha_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <td <?= $Page->pid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_pid" class="fasilitasusaha_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->namausaha->Visible) { // namausaha ?>
        <td <?= $Page->namausaha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_namausaha" class="fasilitasusaha_namausaha">
<span<?= $Page->namausaha->viewAttributes() ?>>
<?= $Page->namausaha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
        <td <?= $Page->bidangusaha->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_bidangusaha" class="fasilitasusaha_bidangusaha">
<span<?= $Page->bidangusaha->viewAttributes() ?>>
<?= $Page->bidangusaha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->badanhukum->Visible) { // badanhukum ?>
        <td <?= $Page->badanhukum->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_badanhukum" class="fasilitasusaha_badanhukum">
<span<?= $Page->badanhukum->viewAttributes() ?>>
<?= $Page->badanhukum->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->siup->Visible) { // siup ?>
        <td <?= $Page->siup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_siup" class="fasilitasusaha_siup">
<span<?= $Page->siup->viewAttributes() ?>>
<?= $Page->siup->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bpom->Visible) { // bpom ?>
        <td <?= $Page->bpom->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_bpom" class="fasilitasusaha_bpom">
<span<?= $Page->bpom->viewAttributes() ?>>
<?= $Page->bpom->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->irt->Visible) { // irt ?>
        <td <?= $Page->irt->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_irt" class="fasilitasusaha_irt">
<span<?= $Page->irt->viewAttributes() ?>>
<?= $Page->irt->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->potensiblm->Visible) { // potensiblm ?>
        <td <?= $Page->potensiblm->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_potensiblm" class="fasilitasusaha_potensiblm">
<span<?= $Page->potensiblm->viewAttributes() ?>>
<?= $Page->potensiblm->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->aset->Visible) { // aset ?>
        <td <?= $Page->aset->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_aset" class="fasilitasusaha_aset">
<span<?= $Page->aset->viewAttributes() ?>>
<?= $Page->aset->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_modal->Visible) { // modal ?>
        <td <?= $Page->_modal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha__modal" class="fasilitasusaha__modal">
<span<?= $Page->_modal->viewAttributes() ?>>
<?= $Page->_modal->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
        <td <?= $Page->hasilsetahun->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_hasilsetahun" class="fasilitasusaha_hasilsetahun">
<span<?= $Page->hasilsetahun->viewAttributes() ?>>
<?= $Page->hasilsetahun->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->kendala->Visible) { // kendala ?>
        <td <?= $Page->kendala->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_kendala" class="fasilitasusaha_kendala">
<span<?= $Page->kendala->viewAttributes() ?>>
<?= $Page->kendala->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <td <?= $Page->fasilitasperlu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_fasilitasperlu" class="fasilitasusaha_fasilitasperlu">
<span<?= $Page->fasilitasperlu->viewAttributes() ?>>
<?= $Page->fasilitasperlu->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <td <?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_foto" class="fasilitasusaha_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
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
