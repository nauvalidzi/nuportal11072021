<?php

namespace PHPMaker2021\nuportal;

// Page object
$KodeposAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkodeposadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fkodeposadd = currentForm = new ew.Form("fkodeposadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "kodepos")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.kodepos)
        ew.vars.tables.kodepos = currentTable;
    fkodeposadd.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null, ew.Validators.integer], fields.id.isInvalid],
        ["kelurahan_id", [fields.kelurahan_id.visible && fields.kelurahan_id.required ? ew.Validators.required(fields.kelurahan_id.caption) : null, ew.Validators.integer], fields.kelurahan_id.isInvalid],
        ["kodepos", [fields.kodepos.visible && fields.kodepos.required ? ew.Validators.required(fields.kodepos.caption) : null], fields.kodepos.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkodeposadd,
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
    fkodeposadd.validate = function () {
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
    fkodeposadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkodeposadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fkodeposadd");
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
<form name="fkodeposadd" id="fkodeposadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kodepos">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id" class="form-group row">
        <label id="elh_kodepos_id" for="x_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?><?= $Page->id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id->cellAttributes() ?>>
<span id="el_kodepos_id">
<input type="<?= $Page->id->getInputTextType() ?>" data-table="kodepos" data-field="x_id" name="x_id" id="x_id" value="<?= $Page->id->EditValue ?>"<?= $Page->id->editAttributes() ?> aria-describedby="x_id_help">
<?= $Page->id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kelurahan_id->Visible) { // kelurahan_id ?>
    <div id="r_kelurahan_id" class="form-group row">
        <label id="elh_kodepos_kelurahan_id" for="x_kelurahan_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kelurahan_id->caption() ?><?= $Page->kelurahan_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kelurahan_id->cellAttributes() ?>>
<span id="el_kodepos_kelurahan_id">
<input type="<?= $Page->kelurahan_id->getInputTextType() ?>" data-table="kodepos" data-field="x_kelurahan_id" name="x_kelurahan_id" id="x_kelurahan_id" size="30" value="<?= $Page->kelurahan_id->EditValue ?>"<?= $Page->kelurahan_id->editAttributes() ?> aria-describedby="x_kelurahan_id_help">
<?= $Page->kelurahan_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kelurahan_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kodepos->Visible) { // kodepos ?>
    <div id="r_kodepos" class="form-group row">
        <label id="elh_kodepos_kodepos" for="x_kodepos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kodepos->caption() ?><?= $Page->kodepos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodepos->cellAttributes() ?>>
<span id="el_kodepos_kodepos">
<input type="<?= $Page->kodepos->getInputTextType() ?>" data-table="kodepos" data-field="x_kodepos" name="x_kodepos" id="x_kodepos" size="30" maxlength="10" value="<?= $Page->kodepos->EditValue ?>"<?= $Page->kodepos->editAttributes() ?> aria-describedby="x_kodepos_help">
<?= $Page->kodepos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kodepos->getErrorMessage() ?></div>
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
    ew.addEventHandlers("kodepos");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
