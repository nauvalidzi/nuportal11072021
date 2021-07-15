<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitaspesantrenAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var ffasilitaspesantrenadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    ffasilitaspesantrenadd = currentForm = new ew.Form("ffasilitaspesantrenadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "fasilitaspesantren")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.fasilitaspesantren)
        ew.vars.tables.fasilitaspesantren = currentTable;
    ffasilitaspesantrenadd.addFields([
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["namafasilitas", [fields.namafasilitas.visible && fields.namafasilitas.required ? ew.Validators.required(fields.namafasilitas.caption) : null], fields.namafasilitas.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["fotofasilitas", [fields.fotofasilitas.visible && fields.fotofasilitas.required ? ew.Validators.fileRequired(fields.fotofasilitas.caption) : null], fields.fotofasilitas.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ffasilitaspesantrenadd,
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
    ffasilitaspesantrenadd.validate = function () {
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
    ffasilitaspesantrenadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffasilitaspesantrenadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ffasilitaspesantrenadd");
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
<form name="ffasilitaspesantrenadd" id="ffasilitaspesantrenadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fasilitaspesantren">
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
        <label id="elh_fasilitaspesantren_pid" for="x_pid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid->caption() ?><?= $Page->pid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el_fasilitaspesantren_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_pid" name="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_fasilitaspesantren_pid">
<input type="<?= $Page->pid->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_pid" name="x_pid" id="x_pid" size="30" maxlength="11" value="<?= $Page->pid->EditValue ?>"<?= $Page->pid->editAttributes() ?> aria-describedby="x_pid_help">
<?= $Page->pid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
    <div id="r_namafasilitas" class="form-group row">
        <label id="elh_fasilitaspesantren_namafasilitas" for="x_namafasilitas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->namafasilitas->caption() ?><?= $Page->namafasilitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namafasilitas->cellAttributes() ?>>
<span id="el_fasilitaspesantren_namafasilitas">
<input type="<?= $Page->namafasilitas->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_namafasilitas" name="x_namafasilitas" id="x_namafasilitas" size="30" maxlength="255" value="<?= $Page->namafasilitas->EditValue ?>"<?= $Page->namafasilitas->editAttributes() ?> aria-describedby="x_namafasilitas_help">
<?= $Page->namafasilitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namafasilitas->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_fasilitaspesantren_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_fasilitaspesantren_keterangan">
<textarea data-table="fasilitaspesantren" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="3" rows="4"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
    <div id="r_fotofasilitas" class="form-group row">
        <label id="elh_fasilitaspesantren_fotofasilitas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fotofasilitas->caption() ?><?= $Page->fotofasilitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fotofasilitas->cellAttributes() ?>>
<span id="el_fasilitaspesantren_fotofasilitas">
<div id="fd_x_fotofasilitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->fotofasilitas->title() ?>" data-table="fasilitaspesantren" data-field="x_fotofasilitas" name="x_fotofasilitas" id="x_fotofasilitas" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->fotofasilitas->editAttributes() ?><?= ($Page->fotofasilitas->ReadOnly || $Page->fotofasilitas->Disabled) ? " disabled" : "" ?> aria-describedby="x_fotofasilitas_help">
        <label class="custom-file-label ew-file-label" for="x_fotofasilitas"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<?= $Page->fotofasilitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fotofasilitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_fotofasilitas" id= "fn_x_fotofasilitas" value="<?= $Page->fotofasilitas->Upload->FileName ?>">
<input type="hidden" name="fa_x_fotofasilitas" id= "fa_x_fotofasilitas" value="0">
<input type="hidden" name="fs_x_fotofasilitas" id= "fs_x_fotofasilitas" value="255">
<input type="hidden" name="fx_x_fotofasilitas" id= "fx_x_fotofasilitas" value="<?= $Page->fotofasilitas->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_fotofasilitas" id= "fm_x_fotofasilitas" value="<?= $Page->fotofasilitas->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_fotofasilitas" id= "fc_x_fotofasilitas" value="<?= $Page->fotofasilitas->UploadMaxFileCount ?>">
</div>
<table id="ft_x_fotofasilitas" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
    ew.addEventHandlers("fasilitaspesantren");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
