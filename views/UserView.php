<?php

namespace PHPMaker2021\nuportal;

// Page object
$UserView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fuserview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fuserview = currentForm = new ew.Form("fuserview", "view");
    loadjs.done("fuserview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.user) ew.vars.tables.user = <?= JsonEncode(GetClientVar("tables", "user")) ?>;
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
<form name="fuserview" id="fuserview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->namapesantren->Visible) { // namapesantren ?>
    <tr id="r_namapesantren">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_namapesantren"><?= $Page->namapesantren->caption() ?></span></td>
        <td data-name="namapesantren" <?= $Page->namapesantren->cellAttributes() ?>>
<span id="el_user_namapesantren">
<span<?= $Page->namapesantren->viewAttributes() ?>>
<?= $Page->namapesantren->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->namapendaftar->Visible) { // namapendaftar ?>
    <tr id="r_namapendaftar">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_namapendaftar"><?= $Page->namapendaftar->caption() ?></span></td>
        <td data-name="namapendaftar" <?= $Page->namapendaftar->cellAttributes() ?>>
<span id="el_user_namapendaftar">
<span<?= $Page->namapendaftar->viewAttributes() ?>>
<?= $Page->namapendaftar->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <tr id="r_hp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_hp"><?= $Page->hp->caption() ?></span></td>
        <td data-name="hp" <?= $Page->hp->cellAttributes() ?>>
<span id="el_user_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el_user__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <tr id="r__username">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user__username"><?= $Page->_username->caption() ?></span></td>
        <td data-name="_username" <?= $Page->_username->cellAttributes() ?>>
<span id="el_user__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->passsword->Visible) { // passsword ?>
    <tr id="r_passsword">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_passsword"><?= $Page->passsword->caption() ?></span></td>
        <td data-name="passsword" <?= $Page->passsword->cellAttributes() ?>>
<span id="el_user_passsword">
<span<?= $Page->passsword->viewAttributes() ?>>
<?= $Page->passsword->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
    <tr id="r_grup">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_grup"><?= $Page->grup->caption() ?></span></td>
        <td data-name="grup" <?= $Page->grup->cellAttributes() ?>>
<span id="el_user_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php
    if (in_array("wilayah", explode(",", $Page->getCurrentDetailTable())) && $wilayah->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("wilayah", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "WilayahGrid.php" ?>
<?php } ?>
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
