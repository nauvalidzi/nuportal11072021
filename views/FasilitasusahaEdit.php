<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitasusahaEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var ffasilitasusahaedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    ffasilitasusahaedit = currentForm = new ew.Form("ffasilitasusahaedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "fasilitasusaha")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.fasilitasusaha)
        ew.vars.tables.fasilitasusaha = currentTable;
    ffasilitasusahaedit.addFields([
        ["namausaha", [fields.namausaha.visible && fields.namausaha.required ? ew.Validators.required(fields.namausaha.caption) : null], fields.namausaha.isInvalid],
        ["bidangusaha", [fields.bidangusaha.visible && fields.bidangusaha.required ? ew.Validators.required(fields.bidangusaha.caption) : null], fields.bidangusaha.isInvalid],
        ["badanhukum", [fields.badanhukum.visible && fields.badanhukum.required ? ew.Validators.required(fields.badanhukum.caption) : null], fields.badanhukum.isInvalid],
        ["siup", [fields.siup.visible && fields.siup.required ? ew.Validators.required(fields.siup.caption) : null], fields.siup.isInvalid],
        ["bpom", [fields.bpom.visible && fields.bpom.required ? ew.Validators.required(fields.bpom.caption) : null], fields.bpom.isInvalid],
        ["irt", [fields.irt.visible && fields.irt.required ? ew.Validators.required(fields.irt.caption) : null], fields.irt.isInvalid],
        ["potensiblm", [fields.potensiblm.visible && fields.potensiblm.required ? ew.Validators.required(fields.potensiblm.caption) : null], fields.potensiblm.isInvalid],
        ["aset", [fields.aset.visible && fields.aset.required ? ew.Validators.required(fields.aset.caption) : null], fields.aset.isInvalid],
        ["_modal", [fields._modal.visible && fields._modal.required ? ew.Validators.required(fields._modal.caption) : null], fields._modal.isInvalid],
        ["hasilsetahun", [fields.hasilsetahun.visible && fields.hasilsetahun.required ? ew.Validators.required(fields.hasilsetahun.caption) : null], fields.hasilsetahun.isInvalid],
        ["kendala", [fields.kendala.visible && fields.kendala.required ? ew.Validators.required(fields.kendala.caption) : null], fields.kendala.isInvalid],
        ["fasilitasperlu", [fields.fasilitasperlu.visible && fields.fasilitasperlu.required ? ew.Validators.required(fields.fasilitasperlu.caption) : null], fields.fasilitasperlu.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ffasilitasusahaedit,
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
    ffasilitasusahaedit.validate = function () {
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
    ffasilitasusahaedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffasilitasusahaedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ffasilitasusahaedit.lists.badanhukum = <?= $Page->badanhukum->toClientList($Page) ?>;
    loadjs.done("ffasilitasusahaedit");
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
<form name="ffasilitasusahaedit" id="ffasilitasusahaedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fasilitasusaha">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "pesantren") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pesantren">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->namausaha->Visible) { // namausaha ?>
    <div id="r_namausaha" class="form-group row">
        <label id="elh_fasilitasusaha_namausaha" for="x_namausaha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->namausaha->caption() ?><?= $Page->namausaha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namausaha->cellAttributes() ?>>
<span id="el_fasilitasusaha_namausaha">
<input type="<?= $Page->namausaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_namausaha" name="x_namausaha" id="x_namausaha" size="30" maxlength="255" value="<?= $Page->namausaha->EditValue ?>"<?= $Page->namausaha->editAttributes() ?> aria-describedby="x_namausaha_help">
<?= $Page->namausaha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namausaha->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
    <div id="r_bidangusaha" class="form-group row">
        <label id="elh_fasilitasusaha_bidangusaha" for="x_bidangusaha" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bidangusaha->caption() ?><?= $Page->bidangusaha->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bidangusaha->cellAttributes() ?>>
<span id="el_fasilitasusaha_bidangusaha">
<input type="<?= $Page->bidangusaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bidangusaha" name="x_bidangusaha" id="x_bidangusaha" size="30" maxlength="255" value="<?= $Page->bidangusaha->EditValue ?>"<?= $Page->bidangusaha->editAttributes() ?> aria-describedby="x_bidangusaha_help">
<?= $Page->bidangusaha->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bidangusaha->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->badanhukum->Visible) { // badanhukum ?>
    <div id="r_badanhukum" class="form-group row">
        <label id="elh_fasilitasusaha_badanhukum" for="x_badanhukum" class="<?= $Page->LeftColumnClass ?>"><?= $Page->badanhukum->caption() ?><?= $Page->badanhukum->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->badanhukum->cellAttributes() ?>>
<span id="el_fasilitasusaha_badanhukum">
    <select
        id="x_badanhukum"
        name="x_badanhukum"
        class="form-control ew-select<?= $Page->badanhukum->isInvalidClass() ?>"
        data-select2-id="fasilitasusaha_x_badanhukum"
        data-table="fasilitasusaha"
        data-field="x_badanhukum"
        data-value-separator="<?= $Page->badanhukum->displayValueSeparatorAttribute() ?>"
        <?= $Page->badanhukum->editAttributes() ?>>
        <?= $Page->badanhukum->selectOptionListHtml("x_badanhukum") ?>
    </select>
    <?= $Page->badanhukum->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->badanhukum->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='fasilitasusaha_x_badanhukum']"),
        options = { name: "x_badanhukum", selectId: "fasilitasusaha_x_badanhukum", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.fasilitasusaha.fields.badanhukum.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.fasilitasusaha.fields.badanhukum.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->siup->Visible) { // siup ?>
    <div id="r_siup" class="form-group row">
        <label id="elh_fasilitasusaha_siup" for="x_siup" class="<?= $Page->LeftColumnClass ?>"><?= $Page->siup->caption() ?><?= $Page->siup->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->siup->cellAttributes() ?>>
<span id="el_fasilitasusaha_siup">
<input type="<?= $Page->siup->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_siup" name="x_siup" id="x_siup" size="30" maxlength="255" value="<?= $Page->siup->EditValue ?>"<?= $Page->siup->editAttributes() ?> aria-describedby="x_siup_help">
<?= $Page->siup->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->siup->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bpom->Visible) { // bpom ?>
    <div id="r_bpom" class="form-group row">
        <label id="elh_fasilitasusaha_bpom" for="x_bpom" class="<?= $Page->LeftColumnClass ?>"><?= $Page->bpom->caption() ?><?= $Page->bpom->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bpom->cellAttributes() ?>>
<span id="el_fasilitasusaha_bpom">
<input type="<?= $Page->bpom->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bpom" name="x_bpom" id="x_bpom" size="30" maxlength="255" value="<?= $Page->bpom->EditValue ?>"<?= $Page->bpom->editAttributes() ?> aria-describedby="x_bpom_help">
<?= $Page->bpom->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bpom->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->irt->Visible) { // irt ?>
    <div id="r_irt" class="form-group row">
        <label id="elh_fasilitasusaha_irt" for="x_irt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->irt->caption() ?><?= $Page->irt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->irt->cellAttributes() ?>>
<span id="el_fasilitasusaha_irt">
<input type="<?= $Page->irt->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_irt" name="x_irt" id="x_irt" size="30" maxlength="255" value="<?= $Page->irt->EditValue ?>"<?= $Page->irt->editAttributes() ?> aria-describedby="x_irt_help">
<?= $Page->irt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->irt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->potensiblm->Visible) { // potensiblm ?>
    <div id="r_potensiblm" class="form-group row">
        <label id="elh_fasilitasusaha_potensiblm" for="x_potensiblm" class="<?= $Page->LeftColumnClass ?>"><?= $Page->potensiblm->caption() ?><?= $Page->potensiblm->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->potensiblm->cellAttributes() ?>>
<span id="el_fasilitasusaha_potensiblm">
<input type="<?= $Page->potensiblm->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_potensiblm" name="x_potensiblm" id="x_potensiblm" size="30" maxlength="255" value="<?= $Page->potensiblm->EditValue ?>"<?= $Page->potensiblm->editAttributes() ?> aria-describedby="x_potensiblm_help">
<?= $Page->potensiblm->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->potensiblm->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->aset->Visible) { // aset ?>
    <div id="r_aset" class="form-group row">
        <label id="elh_fasilitasusaha_aset" for="x_aset" class="<?= $Page->LeftColumnClass ?>"><?= $Page->aset->caption() ?><?= $Page->aset->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->aset->cellAttributes() ?>>
<span id="el_fasilitasusaha_aset">
<input type="<?= $Page->aset->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_aset" name="x_aset" id="x_aset" size="30" maxlength="255" value="<?= $Page->aset->EditValue ?>"<?= $Page->aset->editAttributes() ?> aria-describedby="x_aset_help">
<?= $Page->aset->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->aset->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_modal->Visible) { // modal ?>
    <div id="r__modal" class="form-group row">
        <label id="elh_fasilitasusaha__modal" for="x__modal" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_modal->caption() ?><?= $Page->_modal->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_modal->cellAttributes() ?>>
<span id="el_fasilitasusaha__modal">
<input type="<?= $Page->_modal->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x__modal" name="x__modal" id="x__modal" size="30" maxlength="255" value="<?= $Page->_modal->EditValue ?>"<?= $Page->_modal->editAttributes() ?> aria-describedby="x__modal_help">
<?= $Page->_modal->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_modal->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
    <div id="r_hasilsetahun" class="form-group row">
        <label id="elh_fasilitasusaha_hasilsetahun" for="x_hasilsetahun" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hasilsetahun->caption() ?><?= $Page->hasilsetahun->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hasilsetahun->cellAttributes() ?>>
<span id="el_fasilitasusaha_hasilsetahun">
<input type="<?= $Page->hasilsetahun->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_hasilsetahun" name="x_hasilsetahun" id="x_hasilsetahun" size="30" maxlength="255" value="<?= $Page->hasilsetahun->EditValue ?>"<?= $Page->hasilsetahun->editAttributes() ?> aria-describedby="x_hasilsetahun_help">
<?= $Page->hasilsetahun->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hasilsetahun->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kendala->Visible) { // kendala ?>
    <div id="r_kendala" class="form-group row">
        <label id="elh_fasilitasusaha_kendala" for="x_kendala" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kendala->caption() ?><?= $Page->kendala->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kendala->cellAttributes() ?>>
<span id="el_fasilitasusaha_kendala">
<input type="<?= $Page->kendala->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_kendala" name="x_kendala" id="x_kendala" size="30" maxlength="255" value="<?= $Page->kendala->EditValue ?>"<?= $Page->kendala->editAttributes() ?> aria-describedby="x_kendala_help">
<?= $Page->kendala->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kendala->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
    <div id="r_fasilitasperlu" class="form-group row">
        <label id="elh_fasilitasusaha_fasilitasperlu" for="x_fasilitasperlu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->fasilitasperlu->caption() ?><?= $Page->fasilitasperlu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->fasilitasperlu->cellAttributes() ?>>
<span id="el_fasilitasusaha_fasilitasperlu">
<textarea data-table="fasilitasusaha" data-field="x_fasilitasperlu" name="x_fasilitasperlu" id="x_fasilitasperlu" cols="3" rows="4"<?= $Page->fasilitasperlu->editAttributes() ?> aria-describedby="x_fasilitasperlu_help"><?= $Page->fasilitasperlu->EditValue ?></textarea>
<?= $Page->fasilitasperlu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->fasilitasperlu->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_fasilitasusaha_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_fasilitasusaha_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="fasilitasusaha" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
        <label class="custom-file-label ew-file-label" for="x_foto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto" id= "fn_x_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto" id= "fa_x_foto" value="<?= (Post("fa_x_foto") == "0") ? "0" : "1" ?>">
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
</div><!-- /page* -->
    <input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("fasilitasusaha");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
