<?php

namespace PHPMaker2021\nuportal;

// Page object
$KitabkuningAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fkitabkuningadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fkitabkuningadd = currentForm = new ew.Form("fkitabkuningadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "kitabkuning")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.kitabkuning)
        ew.vars.tables.kitabkuning = currentTable;
    fkitabkuningadd.addFields([
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["pelaksanaan", [fields.pelaksanaan.visible && fields.pelaksanaan.required ? ew.Validators.required(fields.pelaksanaan.caption) : null], fields.pelaksanaan.isInvalid],
        ["metode", [fields.metode.visible && fields.metode.required ? ew.Validators.required(fields.metode.caption) : null], fields.metode.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkitabkuningadd,
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
    fkitabkuningadd.validate = function () {
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
    fkitabkuningadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkitabkuningadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fkitabkuningadd.lists.pid = <?= $Page->pid->toClientList($Page) ?>;
    fkitabkuningadd.lists.pelaksanaan = <?= $Page->pelaksanaan->toClientList($Page) ?>;
    fkitabkuningadd.lists.metode = <?= $Page->metode->toClientList($Page) ?>;
    loadjs.done("fkitabkuningadd");
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
<form name="fkitabkuningadd" id="fkitabkuningadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="kitabkuning">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "pesantren") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pesantren">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->pid->Visible) { // pid ?>
    <div id="r_pid" class="form-group row">
        <label id="elh_kitabkuning_pid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid->caption() ?><?= $Page->pid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el_kitabkuning_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_pid" name="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_kitabkuning_pid">
<?php
$onchange = $Page->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x_pid" class="ew-auto-suggest">
    <input type="<?= $Page->pid->getInputTextType() ?>" class="form-control" name="sv_x_pid" id="sv_x_pid" value="<?= RemoveHtml($Page->pid->EditValue) ?>" size="30"<?= $Page->pid->editAttributes() ?> aria-describedby="x_pid_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="kitabkuning" data-field="x_pid" data-input="sv_x_pid" data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>" name="x_pid" id="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->pid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fkitabkuningadd"], function() {
    fkitabkuningadd.createAutoSuggest(Object.assign({"id":"x_pid","forceSelect":false}, ew.vars.tables.kitabkuning.fields.pid.autoSuggestOptions));
});
</script>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x_pid") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pelaksanaan->Visible) { // pelaksanaan ?>
    <div id="r_pelaksanaan" class="form-group row">
        <label id="elh_kitabkuning_pelaksanaan" for="x_pelaksanaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pelaksanaan->caption() ?><?= $Page->pelaksanaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pelaksanaan->cellAttributes() ?>>
<span id="el_kitabkuning_pelaksanaan">
    <select
        id="x_pelaksanaan"
        name="x_pelaksanaan"
        class="form-control ew-select<?= $Page->pelaksanaan->isInvalidClass() ?>"
        data-select2-id="kitabkuning_x_pelaksanaan"
        data-table="kitabkuning"
        data-field="x_pelaksanaan"
        data-value-separator="<?= $Page->pelaksanaan->displayValueSeparatorAttribute() ?>"
        <?= $Page->pelaksanaan->editAttributes() ?>>
        <?= $Page->pelaksanaan->selectOptionListHtml("x_pelaksanaan") ?>
    </select>
    <?= $Page->pelaksanaan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pelaksanaan->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='kitabkuning_x_pelaksanaan']"),
        options = { name: "x_pelaksanaan", selectId: "kitabkuning_x_pelaksanaan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.kitabkuning.fields.pelaksanaan.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kitabkuning.fields.pelaksanaan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->metode->Visible) { // metode ?>
    <div id="r_metode" class="form-group row">
        <label id="elh_kitabkuning_metode" for="x_metode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->metode->caption() ?><?= $Page->metode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->metode->cellAttributes() ?>>
<span id="el_kitabkuning_metode">
    <select
        id="x_metode"
        name="x_metode"
        class="form-control ew-select<?= $Page->metode->isInvalidClass() ?>"
        data-select2-id="kitabkuning_x_metode"
        data-table="kitabkuning"
        data-field="x_metode"
        data-value-separator="<?= $Page->metode->displayValueSeparatorAttribute() ?>"
        <?= $Page->metode->editAttributes() ?>>
        <?= $Page->metode->selectOptionListHtml("x_metode") ?>
    </select>
    <?= $Page->metode->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->metode->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='kitabkuning_x_metode']"),
        options = { name: "x_metode", selectId: "kitabkuning_x_metode", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.kitabkuning.fields.metode.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kitabkuning.fields.metode.selectOptions);
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
    ew.addEventHandlers("kitabkuning");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
