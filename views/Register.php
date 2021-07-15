<?php

namespace PHPMaker2021\nuportal;

// Page object
$Register = &$Page;
?>
<script>
var currentForm, currentPageID;
var fregister;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "register";
    fregister = currentForm = new ew.Form("fregister", "register");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "user")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.user)
        ew.vars.tables.user = currentTable;
    fregister.addFields([
        ["namapesantren", [fields.namapesantren.visible && fields.namapesantren.required ? ew.Validators.required(fields.namapesantren.caption) : null], fields.namapesantren.isInvalid],
        ["namapendaftar", [fields.namapendaftar.visible && fields.namapendaftar.required ? ew.Validators.required(fields.namapendaftar.caption) : null], fields.namapendaftar.isInvalid],
        ["hp", [fields.hp.visible && fields.hp.required ? ew.Validators.required(fields.hp.caption) : null], fields.hp.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["_username", [fields._username.visible && fields._username.required ? ew.Validators.required(fields._username.caption) : null, ew.Validators.username(fields._username.raw)], fields._username.isInvalid],
        ["c_passsword", [ew.Validators.required(ew.language.phrase("ConfirmPassword")), ew.Validators.mismatchPassword], fields.passsword.isInvalid],
        ["passsword", [fields.passsword.visible && fields.passsword.required ? ew.Validators.required(fields.passsword.caption) : null, ew.Validators.password(fields.passsword.raw)], fields.passsword.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fregister,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fregister.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }
        return true;
    }

    // Form_CustomValidate
    fregister.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fregister.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fregister");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregister" id="fregister" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="t" value="user">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php } ?>
<div class="ew-register-div"><!-- page* -->
<?php if ($Page->namapesantren->Visible) { // namapesantren ?>
    <div id="r_namapesantren" class="form-group row">
        <label id="elh_user_namapesantren" for="x_namapesantren" class="<?= $Page->LeftColumnClass ?>"><?= $Page->namapesantren->caption() ?><?= $Page->namapesantren->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namapesantren->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_namapesantren">
<input type="<?= $Page->namapesantren->getInputTextType() ?>" data-table="user" data-field="x_namapesantren" name="x_namapesantren" id="x_namapesantren" size="30" maxlength="255" value="<?= $Page->namapesantren->EditValue ?>"<?= $Page->namapesantren->editAttributes() ?> aria-describedby="x_namapesantren_help">
<?= $Page->namapesantren->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namapesantren->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_namapesantren">
<span<?= $Page->namapesantren->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->namapesantren->getDisplayValue($Page->namapesantren->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user" data-field="x_namapesantren" data-hidden="1" name="x_namapesantren" id="x_namapesantren" value="<?= HtmlEncode($Page->namapesantren->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->namapendaftar->Visible) { // namapendaftar ?>
    <div id="r_namapendaftar" class="form-group row">
        <label id="elh_user_namapendaftar" for="x_namapendaftar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->namapendaftar->caption() ?><?= $Page->namapendaftar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namapendaftar->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_namapendaftar">
<input type="<?= $Page->namapendaftar->getInputTextType() ?>" data-table="user" data-field="x_namapendaftar" name="x_namapendaftar" id="x_namapendaftar" size="30" maxlength="255" value="<?= $Page->namapendaftar->EditValue ?>"<?= $Page->namapendaftar->editAttributes() ?> aria-describedby="x_namapendaftar_help">
<?= $Page->namapendaftar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namapendaftar->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_namapendaftar">
<span<?= $Page->namapendaftar->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->namapendaftar->getDisplayValue($Page->namapendaftar->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user" data-field="x_namapendaftar" data-hidden="1" name="x_namapendaftar" id="x_namapendaftar" value="<?= HtmlEncode($Page->namapendaftar->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <div id="r_hp" class="form-group row">
        <label id="elh_user_hp" for="x_hp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hp->caption() ?><?= $Page->hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hp->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_hp">
<input type="<?= $Page->hp->getInputTextType() ?>" data-table="user" data-field="x_hp" name="x_hp" id="x_hp" size="30" maxlength="255" value="<?= $Page->hp->EditValue ?>"<?= $Page->hp->editAttributes() ?> aria-describedby="x_hp_help">
<?= $Page->hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hp->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->hp->getDisplayValue($Page->hp->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user" data-field="x_hp" data-hidden="1" name="x_hp" id="x_hp" value="<?= HtmlEncode($Page->hp->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_user__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="user" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user__email">
<span<?= $Page->_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_email->getDisplayValue($Page->_email->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user" data-field="x__email" data-hidden="1" name="x__email" id="x__email" value="<?= HtmlEncode($Page->_email->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_username->Visible) { // username ?>
    <div id="r__username" class="form-group row">
        <label id="elh_user__username" for="x__username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_username->caption() ?><?= $Page->_username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_username->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user__username">
<input type="<?= $Page->_username->getInputTextType() ?>" data-table="user" data-field="x__username" name="x__username" id="x__username" size="30" maxlength="20" value="<?= $Page->_username->EditValue ?>"<?= $Page->_username->editAttributes() ?> aria-describedby="x__username_help">
<?= $Page->_username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_username->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user__username">
<span<?= $Page->_username->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_username->getDisplayValue($Page->_username->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user" data-field="x__username" data-hidden="1" name="x__username" id="x__username" value="<?= HtmlEncode($Page->_username->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->passsword->Visible) { // passsword ?>
    <div id="r_passsword" class="form-group row">
        <label id="elh_user_passsword" for="x_passsword" class="<?= $Page->LeftColumnClass ?>"><?= $Page->passsword->caption() ?><?= $Page->passsword->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->passsword->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_user_passsword">
<div class="input-group">
    <input type="password" name="x_passsword" id="x_passsword" autocomplete="new-password" data-field="x_passsword" size="30" maxlength="20"<?= $Page->passsword->editAttributes() ?> aria-describedby="x_passsword_help">
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<?= $Page->passsword->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->passsword->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_user_passsword">
<span<?= $Page->passsword->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->passsword->getDisplayValue($Page->passsword->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user" data-field="x_passsword" data-hidden="1" name="x_passsword" id="x_passsword" value="<?= HtmlEncode($Page->passsword->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->passsword->Visible) { // passsword ?>
    <div id="r_c_passsword" class="form-group row">
        <label id="elh_c_user_passsword" for="c_passsword" class="<?= $Page->LeftColumnClass ?>"><?= $Language->phrase("Confirm") ?> <?= $Page->passsword->caption() ?><?= $Page->passsword->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->passsword->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_c_user_passsword">
<div class="input-group">
    <input type="password" name="c_passsword" id="c_passsword" autocomplete="new-password" data-field="x_passsword" size="30" maxlength="20"<?= $Page->passsword->editAttributes() ?> aria-describedby="x_passsword_help">
    <div class="input-group-append"><button type="button" class="btn btn-default ew-toggle-password rounded-right" onclick="ew.togglePassword(event);"><i class="fas fa-eye"></i></button></div>
</div>
<?= $Page->passsword->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->passsword->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_c_user_passsword">
<span<?= $Page->passsword->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->passsword->getDisplayValue($Page->passsword->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="user" data-field="x_passsword" data-hidden="1" name="c_passsword" id="c_passsword" value="<?= HtmlEncode($Page->passsword->FormValue) ?>">
<?php } ?>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" onclick="this.form.action.value='confirm';"><?= $Language->phrase("RegisterBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" onclick="this.form.action.value='cancel';"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("user");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
