<?php

namespace PHPMaker2021\nuportal;

// Page object
$WilayahAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fwilayahadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fwilayahadd = currentForm = new ew.Form("fwilayahadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "wilayah")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.wilayah)
        ew.vars.tables.wilayah = currentTable;
    fwilayahadd.addFields([
        ["iduser", [fields.iduser.visible && fields.iduser.required ? ew.Validators.required(fields.iduser.caption) : null], fields.iduser.isInvalid],
        ["idprovinsis", [fields.idprovinsis.visible && fields.idprovinsis.required ? ew.Validators.required(fields.idprovinsis.caption) : null], fields.idprovinsis.isInvalid],
        ["idkabupatens", [fields.idkabupatens.visible && fields.idkabupatens.required ? ew.Validators.required(fields.idkabupatens.caption) : null], fields.idkabupatens.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fwilayahadd,
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
    fwilayahadd.validate = function () {
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

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fwilayahadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fwilayahadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fwilayahadd.lists.iduser = <?= $Page->iduser->toClientList($Page) ?>;
    fwilayahadd.lists.idprovinsis = <?= $Page->idprovinsis->toClientList($Page) ?>;
    fwilayahadd.lists.idkabupatens = <?= $Page->idkabupatens->toClientList($Page) ?>;
    loadjs.done("fwilayahadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fwilayahadd" id="fwilayahadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="wilayah">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "user") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="user">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->iduser->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->iduser->Visible) { // iduser ?>
    <div id="r_iduser" class="form-group row">
        <label id="elh_wilayah_iduser" for="x_iduser" class="<?= $Page->LeftColumnClass ?>"><?= $Page->iduser->caption() ?><?= $Page->iduser->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->iduser->cellAttributes() ?>>
<?php if ($Page->iduser->getSessionValue() != "") { ?>
<span id="el_wilayah_iduser">
<span<?= $Page->iduser->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->iduser->getDisplayValue($Page->iduser->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_iduser" name="x_iduser" value="<?= HtmlEncode($Page->iduser->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_wilayah_iduser">
    <select
        id="x_iduser"
        name="x_iduser"
        class="form-control ew-select<?= $Page->iduser->isInvalidClass() ?>"
        data-select2-id="wilayah_x_iduser"
        data-table="wilayah"
        data-field="x_iduser"
        data-value-separator="<?= $Page->iduser->displayValueSeparatorAttribute() ?>"
        <?= $Page->iduser->editAttributes() ?>>
        <?= $Page->iduser->selectOptionListHtml("x_iduser") ?>
    </select>
    <?= $Page->iduser->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->iduser->getErrorMessage() ?></div>
<?= $Page->iduser->Lookup->getParamTag($Page, "p_x_iduser") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x_iduser']"),
        options = { name: "x_iduser", selectId: "wilayah_x_iduser", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.iduser.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idprovinsis->Visible) { // idprovinsis ?>
    <div id="r_idprovinsis" class="form-group row">
        <label id="elh_wilayah_idprovinsis" for="x_idprovinsis" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idprovinsis->caption() ?><?= $Page->idprovinsis->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idprovinsis->cellAttributes() ?>>
<span id="el_wilayah_idprovinsis">
<?php $Page->idprovinsis->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_idprovinsis"
        name="x_idprovinsis"
        class="form-control ew-select<?= $Page->idprovinsis->isInvalidClass() ?>"
        data-select2-id="wilayah_x_idprovinsis"
        data-table="wilayah"
        data-field="x_idprovinsis"
        data-value-separator="<?= $Page->idprovinsis->displayValueSeparatorAttribute() ?>"
        <?= $Page->idprovinsis->editAttributes() ?>>
        <?= $Page->idprovinsis->selectOptionListHtml("x_idprovinsis") ?>
    </select>
    <?= $Page->idprovinsis->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idprovinsis->getErrorMessage() ?></div>
<?= $Page->idprovinsis->Lookup->getParamTag($Page, "p_x_idprovinsis") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x_idprovinsis']"),
        options = { name: "x_idprovinsis", selectId: "wilayah_x_idprovinsis", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.idprovinsis.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idkabupatens->Visible) { // idkabupatens ?>
    <div id="r_idkabupatens" class="form-group row">
        <label id="elh_wilayah_idkabupatens" for="x_idkabupatens" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idkabupatens->caption() ?><?= $Page->idkabupatens->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idkabupatens->cellAttributes() ?>>
<span id="el_wilayah_idkabupatens">
    <select
        id="x_idkabupatens"
        name="x_idkabupatens"
        class="form-control ew-select<?= $Page->idkabupatens->isInvalidClass() ?>"
        data-select2-id="wilayah_x_idkabupatens"
        data-table="wilayah"
        data-field="x_idkabupatens"
        data-value-separator="<?= $Page->idkabupatens->displayValueSeparatorAttribute() ?>"
        <?= $Page->idkabupatens->editAttributes() ?>>
        <?= $Page->idkabupatens->selectOptionListHtml("x_idkabupatens") ?>
    </select>
    <?= $Page->idkabupatens->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idkabupatens->getErrorMessage() ?></div>
<?= $Page->idkabupatens->Lookup->getParamTag($Page, "p_x_idkabupatens") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x_idkabupatens']"),
        options = { name: "x_idkabupatens", selectId: "wilayah_x_idkabupatens", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.idkabupatens.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("wilayah");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
