<?php

namespace PHPMaker2021\nuportal;

// Page object
$PendidikanpesantrenAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpendidikanpesantrenadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpendidikanpesantrenadd = currentForm = new ew.Form("fpendidikanpesantrenadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pendidikanpesantren")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pendidikanpesantren)
        ew.vars.tables.pendidikanpesantren = currentTable;
    fpendidikanpesantrenadd.addFields([
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null], fields.pid.isInvalid],
        ["idjenispp", [fields.idjenispp.visible && fields.idjenispp.required ? ew.Validators.required(fields.idjenispp.caption) : null], fields.idjenispp.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["ijin", [fields.ijin.visible && fields.ijin.required ? ew.Validators.required(fields.ijin.caption) : null], fields.ijin.isInvalid],
        ["tglberdiri", [fields.tglberdiri.visible && fields.tglberdiri.required ? ew.Validators.required(fields.tglberdiri.caption) : null, ew.Validators.datetime(0)], fields.tglberdiri.isInvalid],
        ["ijinakhir", [fields.ijinakhir.visible && fields.ijinakhir.required ? ew.Validators.required(fields.ijinakhir.caption) : null, ew.Validators.datetime(0)], fields.ijinakhir.isInvalid],
        ["jumlahpengajar", [fields.jumlahpengajar.visible && fields.jumlahpengajar.required ? ew.Validators.required(fields.jumlahpengajar.caption) : null], fields.jumlahpengajar.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.required(fields.foto.caption) : null], fields.foto.isInvalid],
        ["dokumen", [fields.dokumen.visible && fields.dokumen.required ? ew.Validators.required(fields.dokumen.caption) : null], fields.dokumen.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpendidikanpesantrenadd,
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
    fpendidikanpesantrenadd.validate = function () {
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
    fpendidikanpesantrenadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpendidikanpesantrenadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpendidikanpesantrenadd.lists.pid = <?= $Page->pid->toClientList($Page) ?>;
    fpendidikanpesantrenadd.lists.idjenispp = <?= $Page->idjenispp->toClientList($Page) ?>;
    loadjs.done("fpendidikanpesantrenadd");
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
<form name="fpendidikanpesantrenadd" id="fpendidikanpesantrenadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendidikanpesantren">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "pesantren") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pesantren">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "jenispendidikanpesantren") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="jenispendidikanpesantren">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->idjenispp->getSessionValue()) ?>">
<?php } ?>
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->pid->Visible) { // pid ?>
    <div id="r_pid" class="form-group row">
        <label id="elh_pendidikanpesantren_pid" for="x_pid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid->caption() ?><?= $Page->pid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el_pendidikanpesantren_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_pid" name="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_pendidikanpesantren_pid">
    <select
        id="x_pid"
        name="x_pid"
        class="form-control ew-select<?= $Page->pid->isInvalidClass() ?>"
        data-select2-id="pendidikanpesantren_x_pid"
        data-table="pendidikanpesantren"
        data-field="x_pid"
        data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>"
        <?= $Page->pid->editAttributes() ?>>
        <?= $Page->pid->selectOptionListHtml("x_pid") ?>
    </select>
    <?= $Page->pid->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x_pid") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanpesantren_x_pid']"),
        options = { name: "x_pid", selectId: "pendidikanpesantren_x_pid", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanpesantren.fields.pid.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->idjenispp->Visible) { // idjenispp ?>
    <div id="r_idjenispp" class="form-group row">
        <label id="elh_pendidikanpesantren_idjenispp" for="x_idjenispp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->idjenispp->caption() ?><?= $Page->idjenispp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->idjenispp->cellAttributes() ?>>
<?php if ($Page->idjenispp->getSessionValue() != "") { ?>
<span id="el_pendidikanpesantren_idjenispp">
<span<?= $Page->idjenispp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->idjenispp->getDisplayValue($Page->idjenispp->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_idjenispp" name="x_idjenispp" value="<?= HtmlEncode($Page->idjenispp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_pendidikanpesantren_idjenispp">
    <select
        id="x_idjenispp"
        name="x_idjenispp"
        class="form-control ew-select<?= $Page->idjenispp->isInvalidClass() ?>"
        data-select2-id="pendidikanpesantren_x_idjenispp"
        data-table="pendidikanpesantren"
        data-field="x_idjenispp"
        data-value-separator="<?= $Page->idjenispp->displayValueSeparatorAttribute() ?>"
        <?= $Page->idjenispp->editAttributes() ?>>
        <?= $Page->idjenispp->selectOptionListHtml("x_idjenispp") ?>
    </select>
    <?= $Page->idjenispp->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->idjenispp->getErrorMessage() ?></div>
<?= $Page->idjenispp->Lookup->getParamTag($Page, "p_x_idjenispp") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanpesantren_x_idjenispp']"),
        options = { name: "x_idjenispp", selectId: "pendidikanpesantren_x_idjenispp", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanpesantren.fields.idjenispp.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_pendidikanpesantren_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_pendidikanpesantren_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ijin->Visible) { // ijin ?>
    <div id="r_ijin" class="form-group row">
        <label id="elh_pendidikanpesantren_ijin" for="x_ijin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ijin->caption() ?><?= $Page->ijin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijin->cellAttributes() ?>>
<span id="el_pendidikanpesantren_ijin">
<input type="<?= $Page->ijin->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_ijin" name="x_ijin" id="x_ijin" size="30" maxlength="255" value="<?= $Page->ijin->EditValue ?>"<?= $Page->ijin->editAttributes() ?> aria-describedby="x_ijin_help">
<?= $Page->ijin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ijin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglberdiri->Visible) { // tglberdiri ?>
    <div id="r_tglberdiri" class="form-group row">
        <label id="elh_pendidikanpesantren_tglberdiri" for="x_tglberdiri" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglberdiri->caption() ?><?= $Page->tglberdiri->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglberdiri->cellAttributes() ?>>
<span id="el_pendidikanpesantren_tglberdiri">
<input type="<?= $Page->tglberdiri->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_tglberdiri" name="x_tglberdiri" id="x_tglberdiri" value="<?= $Page->tglberdiri->EditValue ?>"<?= $Page->tglberdiri->editAttributes() ?> aria-describedby="x_tglberdiri_help">
<?= $Page->tglberdiri->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglberdiri->getErrorMessage() ?></div>
<?php if (!$Page->tglberdiri->ReadOnly && !$Page->tglberdiri->Disabled && !isset($Page->tglberdiri->EditAttrs["readonly"]) && !isset($Page->tglberdiri->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanpesantrenadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanpesantrenadd", "x_tglberdiri", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ijinakhir->Visible) { // ijinakhir ?>
    <div id="r_ijinakhir" class="form-group row">
        <label id="elh_pendidikanpesantren_ijinakhir" for="x_ijinakhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ijinakhir->caption() ?><?= $Page->ijinakhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijinakhir->cellAttributes() ?>>
<span id="el_pendidikanpesantren_ijinakhir">
<input type="<?= $Page->ijinakhir->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_ijinakhir" name="x_ijinakhir" id="x_ijinakhir" value="<?= $Page->ijinakhir->EditValue ?>"<?= $Page->ijinakhir->editAttributes() ?> aria-describedby="x_ijinakhir_help">
<?= $Page->ijinakhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ijinakhir->getErrorMessage() ?></div>
<?php if (!$Page->ijinakhir->ReadOnly && !$Page->ijinakhir->Disabled && !isset($Page->ijinakhir->EditAttrs["readonly"]) && !isset($Page->ijinakhir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanpesantrenadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanpesantrenadd", "x_ijinakhir", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlahpengajar->Visible) { // jumlahpengajar ?>
    <div id="r_jumlahpengajar" class="form-group row">
        <label id="elh_pendidikanpesantren_jumlahpengajar" for="x_jumlahpengajar" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlahpengajar->caption() ?><?= $Page->jumlahpengajar->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlahpengajar->cellAttributes() ?>>
<span id="el_pendidikanpesantren_jumlahpengajar">
<input type="<?= $Page->jumlahpengajar->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" name="x_jumlahpengajar" id="x_jumlahpengajar" size="30" maxlength="255" value="<?= $Page->jumlahpengajar->EditValue ?>"<?= $Page->jumlahpengajar->editAttributes() ?> aria-describedby="x_jumlahpengajar_help">
<?= $Page->jumlahpengajar->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlahpengajar->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_pendidikanpesantren_foto" for="x_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_pendidikanpesantren_foto">
<input type="<?= $Page->foto->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_foto" name="x_foto" id="x_foto" size="30" maxlength="255" value="<?= $Page->foto->EditValue ?>"<?= $Page->foto->editAttributes() ?> aria-describedby="x_foto_help">
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
    <div id="r_dokumen" class="form-group row">
        <label id="elh_pendidikanpesantren_dokumen" for="x_dokumen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dokumen->caption() ?><?= $Page->dokumen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dokumen->cellAttributes() ?>>
<span id="el_pendidikanpesantren_dokumen">
<input type="<?= $Page->dokumen->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_dokumen" name="x_dokumen" id="x_dokumen" size="30" maxlength="255" value="<?= $Page->dokumen->EditValue ?>"<?= $Page->dokumen->editAttributes() ?> aria-describedby="x_dokumen_help">
<?= $Page->dokumen->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dokumen->getErrorMessage() ?></div>
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
    ew.addEventHandlers("pendidikanpesantren");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
