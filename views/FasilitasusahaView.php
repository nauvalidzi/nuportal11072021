<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitasusahaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ffasilitasusahaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ffasilitasusahaview = currentForm = new ew.Form("ffasilitasusahaview", "view");
    loadjs.done("ffasilitasusahaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.fasilitasusaha) ew.vars.tables.fasilitasusaha = <?= JsonEncode(GetClientVar("tables", "fasilitasusaha")) ?>;
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
<form name="ffasilitasusahaview" id="ffasilitasusahaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fasilitasusaha">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_fasilitasusaha_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
    <tr id="r_pid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_pid"><?= $Page->pid->caption() ?></span></td>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<span id="el_fasilitasusaha_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->namausaha->Visible) { // namausaha ?>
    <tr id="r_namausaha">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_namausaha"><?= $Page->namausaha->caption() ?></span></td>
        <td data-name="namausaha" <?= $Page->namausaha->cellAttributes() ?>>
<span id="el_fasilitasusaha_namausaha">
<span<?= $Page->namausaha->viewAttributes() ?>>
<?= $Page->namausaha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
    <tr id="r_bidangusaha">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_bidangusaha"><?= $Page->bidangusaha->caption() ?></span></td>
        <td data-name="bidangusaha" <?= $Page->bidangusaha->cellAttributes() ?>>
<span id="el_fasilitasusaha_bidangusaha">
<span<?= $Page->bidangusaha->viewAttributes() ?>>
<?= $Page->bidangusaha->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->badanhukum->Visible) { // badanhukum ?>
    <tr id="r_badanhukum">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_badanhukum"><?= $Page->badanhukum->caption() ?></span></td>
        <td data-name="badanhukum" <?= $Page->badanhukum->cellAttributes() ?>>
<span id="el_fasilitasusaha_badanhukum">
<span<?= $Page->badanhukum->viewAttributes() ?>>
<?= $Page->badanhukum->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->siup->Visible) { // siup ?>
    <tr id="r_siup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_siup"><?= $Page->siup->caption() ?></span></td>
        <td data-name="siup" <?= $Page->siup->cellAttributes() ?>>
<span id="el_fasilitasusaha_siup">
<span<?= $Page->siup->viewAttributes() ?>>
<?= $Page->siup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bpom->Visible) { // bpom ?>
    <tr id="r_bpom">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_bpom"><?= $Page->bpom->caption() ?></span></td>
        <td data-name="bpom" <?= $Page->bpom->cellAttributes() ?>>
<span id="el_fasilitasusaha_bpom">
<span<?= $Page->bpom->viewAttributes() ?>>
<?= $Page->bpom->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->irt->Visible) { // irt ?>
    <tr id="r_irt">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_irt"><?= $Page->irt->caption() ?></span></td>
        <td data-name="irt" <?= $Page->irt->cellAttributes() ?>>
<span id="el_fasilitasusaha_irt">
<span<?= $Page->irt->viewAttributes() ?>>
<?= $Page->irt->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->potensiblm->Visible) { // potensiblm ?>
    <tr id="r_potensiblm">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_potensiblm"><?= $Page->potensiblm->caption() ?></span></td>
        <td data-name="potensiblm" <?= $Page->potensiblm->cellAttributes() ?>>
<span id="el_fasilitasusaha_potensiblm">
<span<?= $Page->potensiblm->viewAttributes() ?>>
<?= $Page->potensiblm->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->aset->Visible) { // aset ?>
    <tr id="r_aset">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_aset"><?= $Page->aset->caption() ?></span></td>
        <td data-name="aset" <?= $Page->aset->cellAttributes() ?>>
<span id="el_fasilitasusaha_aset">
<span<?= $Page->aset->viewAttributes() ?>>
<?= $Page->aset->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_modal->Visible) { // modal ?>
    <tr id="r__modal">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha__modal"><?= $Page->_modal->caption() ?></span></td>
        <td data-name="_modal" <?= $Page->_modal->cellAttributes() ?>>
<span id="el_fasilitasusaha__modal">
<span<?= $Page->_modal->viewAttributes() ?>>
<?= $Page->_modal->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
    <tr id="r_hasilsetahun">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_hasilsetahun"><?= $Page->hasilsetahun->caption() ?></span></td>
        <td data-name="hasilsetahun" <?= $Page->hasilsetahun->cellAttributes() ?>>
<span id="el_fasilitasusaha_hasilsetahun">
<span<?= $Page->hasilsetahun->viewAttributes() ?>>
<?= $Page->hasilsetahun->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->kendala->Visible) { // kendala ?>
    <tr id="r_kendala">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_kendala"><?= $Page->kendala->caption() ?></span></td>
        <td data-name="kendala" <?= $Page->kendala->cellAttributes() ?>>
<span id="el_fasilitasusaha_kendala">
<span<?= $Page->kendala->viewAttributes() ?>>
<?= $Page->kendala->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
    <tr id="r_fasilitasperlu">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_fasilitasperlu"><?= $Page->fasilitasperlu->caption() ?></span></td>
        <td data-name="fasilitasperlu" <?= $Page->fasilitasperlu->cellAttributes() ?>>
<span id="el_fasilitasusaha_fasilitasperlu">
<span<?= $Page->fasilitasperlu->viewAttributes() ?>>
<?= $Page->fasilitasperlu->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fasilitasusaha_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_fasilitasusaha_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
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
