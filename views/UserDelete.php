<?php

namespace PHPMaker2021\nuportal;

// Page object
$UserDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fuserdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fuserdelete = currentForm = new ew.Form("fuserdelete", "delete");
    loadjs.done("fuserdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.user) ew.vars.tables.user = <?= JsonEncode(GetClientVar("tables", "user")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fuserdelete" id="fuserdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user">
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
<?php if ($Page->namapesantren->Visible) { // namapesantren ?>
        <th class="<?= $Page->namapesantren->headerCellClass() ?>"><span id="elh_user_namapesantren" class="user_namapesantren"><?= $Page->namapesantren->caption() ?></span></th>
<?php } ?>
<?php if ($Page->namapendaftar->Visible) { // namapendaftar ?>
        <th class="<?= $Page->namapendaftar->headerCellClass() ?>"><span id="elh_user_namapendaftar" class="user_namapendaftar"><?= $Page->namapendaftar->caption() ?></span></th>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <th class="<?= $Page->hp->headerCellClass() ?>"><span id="elh_user_hp" class="user_hp"><?= $Page->hp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><span id="elh_user__email" class="user__email"><?= $Page->_email->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <th class="<?= $Page->_username->headerCellClass() ?>"><span id="elh_user__username" class="user__username"><?= $Page->_username->caption() ?></span></th>
<?php } ?>
<?php if ($Page->passsword->Visible) { // passsword ?>
        <th class="<?= $Page->passsword->headerCellClass() ?>"><span id="elh_user_passsword" class="user_passsword"><?= $Page->passsword->caption() ?></span></th>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
        <th class="<?= $Page->grup->headerCellClass() ?>"><span id="elh_user_grup" class="user_grup"><?= $Page->grup->caption() ?></span></th>
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
<?php if ($Page->namapesantren->Visible) { // namapesantren ?>
        <td <?= $Page->namapesantren->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_namapesantren" class="user_namapesantren">
<span<?= $Page->namapesantren->viewAttributes() ?>>
<?= $Page->namapesantren->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->namapendaftar->Visible) { // namapendaftar ?>
        <td <?= $Page->namapendaftar->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_namapendaftar" class="user_namapendaftar">
<span<?= $Page->namapendaftar->viewAttributes() ?>>
<?= $Page->namapendaftar->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <td <?= $Page->hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_hp" class="user_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <td <?= $Page->_email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user__email" class="user__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
        <td <?= $Page->_username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user__username" class="user__username">
<span<?= $Page->_username->viewAttributes() ?>>
<?= $Page->_username->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->passsword->Visible) { // passsword ?>
        <td <?= $Page->passsword->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_passsword" class="user_passsword">
<span<?= $Page->passsword->viewAttributes() ?>>
<?= $Page->passsword->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->grup->Visible) { // grup ?>
        <td <?= $Page->grup->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_grup" class="user_grup">
<span<?= $Page->grup->viewAttributes() ?>>
<?= $Page->grup->getViewValue() ?></span>
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
