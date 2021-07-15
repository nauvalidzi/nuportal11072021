<?php

namespace PHPMaker2021\nuportal;

// Page object
$PendidikanumumAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpendidikanumumadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpendidikanumumadd = currentForm = new ew.Form("fpendidikanumumadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pendidikanumum")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pendidikanumum)
        ew.vars.tables.pendidikanumum = currentTable;
    fpendidikanumumadd.addFields([
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["idjenispu", [fields.idjenispu.visible && fields.idjenispu.required ? ew.Validators.required(fields.idjenispu.caption) : null], fields.idjenispu.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["ijin", [fields.ijin.visible && fields.ijin.required ? ew.Validators.required(fields.ijin.caption) : null], fields.ijin.isInvalid],
        ["tglberdiri", [fields.tglberdiri.visible && fields.tglberdiri.required ? ew.Validators.required(fields.tglberdiri.caption) : null, ew.Validators.datetime(0)], fields.tglberdiri.isInvalid],
        ["ijinakhir", [fields.ijinakhir.visible && fields.ijinakhir.required ? ew.Validators.required(fields.ijinakhir.caption) : null, ew.Validators.datetime(0)], fields.ijinakhir.isInvalid],
        ["jumlahpengajar", [fields.jumlahpengajar.visible && fields.jumlahpengajar.required ? ew.Validators.required(fields.jumlahpengajar.caption) : null], fields.jumlahpengajar.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["dokumen", [fields.dokumen.visible && fields.dokumen.required ? ew.Validators.fileRequired(fields.dokumen.caption) : null], fields.dokumen.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpendidikanumumadd,
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
    fpendidikanumumadd.validate = function () {
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
    fpendidikanumumadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpendidikanumumadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpendidikanumumadd.lists.pid = <?= $Page->pid->toClientList($Page) ?>;
    fpendidikanumumadd.lists.idjenispu = <?= $Page->idjenispu->toClientList($Page) ?>;
    loadjs.done("fpendidikanumumadd");
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
<form name="fpendidikanumumadd" id="fpendidikanumumadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendidikanumum">
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
        <label id="elh_pendidikanumum_pid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid->caption() ?><?= $Page->pid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el_pendidikanumum_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_pid" name="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_pendidikanumum_pid">
<?php
$onchange = $Page->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x_pid" class="ew-auto-suggest">
    <input type="<?= $Page->pid->getInputTextType() ?>" class="form-control" name="sv_x_pid" id="sv_x_pid" value="<?= RemoveHtml($Page->pid->EditValue) ?>" size="30"<?= $Page->pid->editAttributes() ?> aria-describedby="x_pid_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="pendidikanumum" data-field="x_pid" data-input="sv_x_pid" data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>" name="x_pid" id="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->pid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fpendidikanumumadd"], function() {
    fpendidikanumumadd.createAutoSuggest(Object.assign({"id":"x_pid","forceSelect":false}, ew.vars.tables.pendidikanumum.fields.pid.autoSuggestOptions));
});
</script>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x_pid") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idjenispu->Visible) { // idjenispu ?>
    <div id="r_idjenispu" class="form-group row">
        <label id="elh_pendidikanumum_idjenispu" for="x_idjenispu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idjenispu->caption() ?><?= $Page->idjenispu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idjenispu->cellAttributes() ?>>
<span id="el_pendidikanumum_idjenispu">
    <select
        id="x_idjenispu"
        name="x_idjenispu"
        class="form-control ew-select<?= $Page->idjenispu->isInvalidClass() ?>"
        data-select2-id="pendidikanumum_x_idjenispu"
        data-table="pendidikanumum"
        data-field="x_idjenispu"
        data-value-separator="<?= $Page->idjenispu->displayValueSeparatorAttribute() ?>"
        <?= $Page->idjenispu->editAttributes() ?>>
        <?= $Page->idjenispu->selectOptionListHtml("x_idjenispu") ?>
    </select>
    <?= $Page->idjenispu->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idjenispu->getErrorMessage() ?></div>
<?= $Page->idjenispu->Lookup->getParamTag($Page, "p_x_idjenispu") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanumum_x_idjenispu']"),
        options = { name: "x_idjenispu", selectId: "pendidikanumum_x_idjenispu", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanumum.fields.idjenispu.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_pendidikanumum_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_pendidikanumum_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="pendidikanumum" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
    <div id="r_ijin" class="form-group row">
        <label id="elh_pendidikanumum_ijin" for="x_ijin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ijin->caption() ?><?= $Page->ijin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijin->cellAttributes() ?>>
<span id="el_pendidikanumum_ijin">
<input type="<?= $Page->ijin->getInputTextType() ?>" data-table="pendidikanumum" data-field="x_ijin" name="x_ijin" id="x_ijin" size="30" maxlength="255" value="<?= $Page->ijin->EditValue ?>"<?= $Page->ijin->editAttributes() ?> aria-describedby="x_ijin_help">
<?= $Page->ijin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ijin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
    <div id="r_tglberdiri" class="form-group row">
        <label id="elh_pendidikanumum_tglberdiri" for="x_tglberdiri" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglberdiri->caption() ?><?= $Page->tglberdiri->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglberdiri->cellAttributes() ?>>
<span id="el_pendidikanumum_tglberdiri">
<input type="<?= $Page->tglberdiri->getInputTextType() ?>" data-table="pendidikanumum" data-field="x_tglberdiri" name="x_tglberdiri" id="x_tglberdiri" value="<?= $Page->tglberdiri->EditValue ?>"<?= $Page->tglberdiri->editAttributes() ?> aria-describedby="x_tglberdiri_help">
<?= $Page->tglberdiri->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglberdiri->getErrorMessage() ?></div>
<?php if (!$Page->tglberdiri->ReadOnly && !$Page->tglberdiri->Disabled && !isset($Page->tglberdiri->EditAttrs["readonly"]) && !isset($Page->tglberdiri->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanumumadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanumumadd", "x_tglberdiri", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
    <div id="r_ijinakhir" class="form-group row">
        <label id="elh_pendidikanumum_ijinakhir" for="x_ijinakhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ijinakhir->caption() ?><?= $Page->ijinakhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijinakhir->cellAttributes() ?>>
<span id="el_pendidikanumum_ijinakhir">
<input type="<?= $Page->ijinakhir->getInputTextType() ?>" data-table="pendidikanumum" data-field="x_ijinakhir" name="x_ijinakhir" id="x_ijinakhir" value="<?= $Page->ijinakhir->EditValue ?>"<?= $Page->ijinakhir->editAttributes() ?> aria-describedby="x_ijinakhir_help">
<?= $Page->ijinakhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ijinakhir->getErrorMessage() ?></div>
<?php if (!$Page->ijinakhir->ReadOnly && !$Page->ijinakhir->Disabled && !isset($Page->ijinakhir->EditAttrs["readonly"]) && !isset($Page->ijinakhir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanumumadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanumumadd", "x_ijinakhir", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
    <div id="r_jumlahpengajar" class="form-group row">
        <label id="elh_pendidikanumum_jumlahpengajar" for="x_jumlahpengajar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlahpengajar->caption() ?><?= $Page->jumlahpengajar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahpengajar->cellAttributes() ?>>
<span id="el_pendidikanumum_jumlahpengajar">
<input type="<?= $Page->jumlahpengajar->getInputTextType() ?>" data-table="pendidikanumum" data-field="x_jumlahpengajar" name="x_jumlahpengajar" id="x_jumlahpengajar" size="30" maxlength="255" value="<?= $Page->jumlahpengajar->EditValue ?>"<?= $Page->jumlahpengajar->editAttributes() ?> aria-describedby="x_jumlahpengajar_help">
<?= $Page->jumlahpengajar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahpengajar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_pendidikanumum_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_pendidikanumum_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="pendidikanumum" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
        <label class="custom-file-label ew-file-label" for="x_foto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto" id= "fn_x_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto" id= "fa_x_foto" value="0">
<input type="hidden" name="fs_x_foto" id= "fs_x_foto" value="255">
<input type="hidden" name="fx_x_foto" id= "fx_x_foto" value="<?= $Page->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_foto" id= "fm_x_foto" value="<?= $Page->foto->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_foto" id= "fc_x_foto" value="<?= $Page->foto->UploadMaxFileCount ?>">
</div>
<table id="ft_x_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
    <div id="r_dokumen" class="form-group row">
        <label id="elh_pendidikanumum_dokumen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dokumen->caption() ?><?= $Page->dokumen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dokumen->cellAttributes() ?>>
<span id="el_pendidikanumum_dokumen">
<div id="fd_x_dokumen">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->dokumen->title() ?>" data-table="pendidikanumum" data-field="x_dokumen" name="x_dokumen" id="x_dokumen" lang="<?= CurrentLanguageID() ?>"<?= $Page->dokumen->editAttributes() ?><?= ($Page->dokumen->ReadOnly || $Page->dokumen->Disabled) ? " disabled" : "" ?> aria-describedby="x_dokumen_help">
        <label class="custom-file-label ew-file-label" for="x_dokumen"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->dokumen->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dokumen->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_dokumen" id= "fn_x_dokumen" value="<?= $Page->dokumen->Upload->FileName ?>">
<input type="hidden" name="fa_x_dokumen" id= "fa_x_dokumen" value="0">
<input type="hidden" name="fs_x_dokumen" id= "fs_x_dokumen" value="255">
<input type="hidden" name="fx_x_dokumen" id= "fx_x_dokumen" value="<?= $Page->dokumen->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_dokumen" id= "fm_x_dokumen" value="<?= $Page->dokumen->UploadMaxFileSize ?>">
</div>
<table id="ft_x_dokumen" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
    ew.addEventHandlers("pendidikanumum");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
