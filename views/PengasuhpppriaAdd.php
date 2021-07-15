<?php

namespace PHPMaker2021\nuportal;

// Page object
$PengasuhpppriaAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpengasuhpppriaadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpengasuhpppriaadd = currentForm = new ew.Form("fpengasuhpppriaadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pengasuhpppria")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pengasuhpppria)
        ew.vars.tables.pengasuhpppria = currentTable;
    fpengasuhpppriaadd.addFields([
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["nik", [fields.nik.visible && fields.nik.required ? ew.Validators.required(fields.nik.caption) : null], fields.nik.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["hp", [fields.hp.visible && fields.hp.required ? ew.Validators.required(fields.hp.caption) : null], fields.hp.isInvalid],
        ["md", [fields.md.visible && fields.md.required ? ew.Validators.required(fields.md.caption) : null], fields.md.isInvalid],
        ["mts", [fields.mts.visible && fields.mts.required ? ew.Validators.required(fields.mts.caption) : null], fields.mts.isInvalid],
        ["ma", [fields.ma.visible && fields.ma.required ? ew.Validators.required(fields.ma.caption) : null], fields.ma.isInvalid],
        ["pesantren", [fields.pesantren.visible && fields.pesantren.required ? ew.Validators.required(fields.pesantren.caption) : null], fields.pesantren.isInvalid],
        ["s1", [fields.s1.visible && fields.s1.required ? ew.Validators.required(fields.s1.caption) : null], fields.s1.isInvalid],
        ["s2", [fields.s2.visible && fields.s2.required ? ew.Validators.required(fields.s2.caption) : null], fields.s2.isInvalid],
        ["s3", [fields.s3.visible && fields.s3.required ? ew.Validators.required(fields.s3.caption) : null], fields.s3.isInvalid],
        ["organisasi", [fields.organisasi.visible && fields.organisasi.required ? ew.Validators.required(fields.organisasi.caption) : null], fields.organisasi.isInvalid],
        ["jabatandiorganisasi", [fields.jabatandiorganisasi.visible && fields.jabatandiorganisasi.required ? ew.Validators.required(fields.jabatandiorganisasi.caption) : null], fields.jabatandiorganisasi.isInvalid],
        ["tglawalorganisasi", [fields.tglawalorganisasi.visible && fields.tglawalorganisasi.required ? ew.Validators.required(fields.tglawalorganisasi.caption) : null, ew.Validators.datetime(7)], fields.tglawalorganisasi.isInvalid],
        ["pemerintah", [fields.pemerintah.visible && fields.pemerintah.required ? ew.Validators.required(fields.pemerintah.caption) : null], fields.pemerintah.isInvalid],
        ["jabatandipemerintah", [fields.jabatandipemerintah.visible && fields.jabatandipemerintah.required ? ew.Validators.required(fields.jabatandipemerintah.caption) : null], fields.jabatandipemerintah.isInvalid],
        ["tglmenjabat", [fields.tglmenjabat.visible && fields.tglmenjabat.required ? ew.Validators.required(fields.tglmenjabat.caption) : null, ew.Validators.datetime(7)], fields.tglmenjabat.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["ijazah", [fields.ijazah.visible && fields.ijazah.required ? ew.Validators.fileRequired(fields.ijazah.caption) : null], fields.ijazah.isInvalid],
        ["sertifikat", [fields.sertifikat.visible && fields.sertifikat.required ? ew.Validators.fileRequired(fields.sertifikat.caption) : null], fields.sertifikat.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpengasuhpppriaadd,
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
    fpengasuhpppriaadd.validate = function () {
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
    fpengasuhpppriaadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpengasuhpppriaadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpengasuhpppriaadd.lists.pid = <?= $Page->pid->toClientList($Page) ?>;
    loadjs.done("fpengasuhpppriaadd");
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
<form name="fpengasuhpppriaadd" id="fpengasuhpppriaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengasuhpppria">
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
        <label id="elh_pengasuhpppria_pid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pid->caption() ?><?= $Page->pid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el_pengasuhpppria_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x_pid" name="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_pengasuhpppria_pid">
<?php
$onchange = $Page->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x_pid" class="ew-auto-suggest">
    <input type="<?= $Page->pid->getInputTextType() ?>" class="form-control" name="sv_x_pid" id="sv_x_pid" value="<?= RemoveHtml($Page->pid->EditValue) ?>" size="30"<?= $Page->pid->editAttributes() ?> aria-describedby="x_pid_help">
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="pengasuhpppria" data-field="x_pid" data-input="sv_x_pid" data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>" name="x_pid" id="x_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>"<?= $onchange ?>>
<?= $Page->pid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fpengasuhpppriaadd"], function() {
    fpengasuhpppriaadd.createAutoSuggest(Object.assign({"id":"x_pid","forceSelect":false}, ew.vars.tables.pengasuhpppria.fields.pid.autoSuggestOptions));
});
</script>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x_pid") ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_pengasuhpppria_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_pengasuhpppria_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nik->Visible) { // nik ?>
    <div id="r_nik" class="form-group row">
        <label id="elh_pengasuhpppria_nik" for="x_nik" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nik->caption() ?><?= $Page->nik->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nik->cellAttributes() ?>>
<span id="el_pengasuhpppria_nik">
<input type="<?= $Page->nik->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_nik" name="x_nik" id="x_nik" size="30" maxlength="255" value="<?= $Page->nik->EditValue ?>"<?= $Page->nik->editAttributes() ?> aria-describedby="x_nik_help">
<?= $Page->nik->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nik->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_pengasuhpppria_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<span id="el_pengasuhpppria_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="255" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help">
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
    <div id="r_hp" class="form-group row">
        <label id="elh_pengasuhpppria_hp" for="x_hp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->hp->caption() ?><?= $Page->hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->hp->cellAttributes() ?>>
<span id="el_pengasuhpppria_hp">
<input type="<?= $Page->hp->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_hp" name="x_hp" id="x_hp" size="30" maxlength="255" value="<?= $Page->hp->EditValue ?>"<?= $Page->hp->editAttributes() ?> aria-describedby="x_hp_help">
<?= $Page->hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->hp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->md->Visible) { // md ?>
    <div id="r_md" class="form-group row">
        <label id="elh_pengasuhpppria_md" for="x_md" class="<?= $Page->LeftColumnClass ?>"><?= $Page->md->caption() ?><?= $Page->md->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->md->cellAttributes() ?>>
<span id="el_pengasuhpppria_md">
<input type="<?= $Page->md->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_md" name="x_md" id="x_md" size="30" maxlength="255" value="<?= $Page->md->EditValue ?>"<?= $Page->md->editAttributes() ?> aria-describedby="x_md_help">
<?= $Page->md->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->md->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->mts->Visible) { // mts ?>
    <div id="r_mts" class="form-group row">
        <label id="elh_pengasuhpppria_mts" for="x_mts" class="<?= $Page->LeftColumnClass ?>"><?= $Page->mts->caption() ?><?= $Page->mts->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->mts->cellAttributes() ?>>
<span id="el_pengasuhpppria_mts">
<input type="<?= $Page->mts->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_mts" name="x_mts" id="x_mts" size="30" maxlength="255" value="<?= $Page->mts->EditValue ?>"<?= $Page->mts->editAttributes() ?> aria-describedby="x_mts_help">
<?= $Page->mts->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->mts->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->ma->Visible) { // ma ?>
    <div id="r_ma" class="form-group row">
        <label id="elh_pengasuhpppria_ma" for="x_ma" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ma->caption() ?><?= $Page->ma->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ma->cellAttributes() ?>>
<span id="el_pengasuhpppria_ma">
<input type="<?= $Page->ma->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_ma" name="x_ma" id="x_ma" size="30" maxlength="255" value="<?= $Page->ma->EditValue ?>"<?= $Page->ma->editAttributes() ?> aria-describedby="x_ma_help">
<?= $Page->ma->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ma->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pesantren->Visible) { // pesantren ?>
    <div id="r_pesantren" class="form-group row">
        <label id="elh_pengasuhpppria_pesantren" for="x_pesantren" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pesantren->caption() ?><?= $Page->pesantren->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pesantren->cellAttributes() ?>>
<span id="el_pengasuhpppria_pesantren">
<input type="<?= $Page->pesantren->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_pesantren" name="x_pesantren" id="x_pesantren" size="30" maxlength="255" value="<?= $Page->pesantren->EditValue ?>"<?= $Page->pesantren->editAttributes() ?> aria-describedby="x_pesantren_help">
<?= $Page->pesantren->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pesantren->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->s1->Visible) { // s1 ?>
    <div id="r_s1" class="form-group row">
        <label id="elh_pengasuhpppria_s1" for="x_s1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->s1->caption() ?><?= $Page->s1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->s1->cellAttributes() ?>>
<span id="el_pengasuhpppria_s1">
<input type="<?= $Page->s1->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_s1" name="x_s1" id="x_s1" size="30" maxlength="255" value="<?= $Page->s1->EditValue ?>"<?= $Page->s1->editAttributes() ?> aria-describedby="x_s1_help">
<?= $Page->s1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->s1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->s2->Visible) { // s2 ?>
    <div id="r_s2" class="form-group row">
        <label id="elh_pengasuhpppria_s2" for="x_s2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->s2->caption() ?><?= $Page->s2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->s2->cellAttributes() ?>>
<span id="el_pengasuhpppria_s2">
<input type="<?= $Page->s2->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_s2" name="x_s2" id="x_s2" size="30" maxlength="255" value="<?= $Page->s2->EditValue ?>"<?= $Page->s2->editAttributes() ?> aria-describedby="x_s2_help">
<?= $Page->s2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->s2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->s3->Visible) { // s3 ?>
    <div id="r_s3" class="form-group row">
        <label id="elh_pengasuhpppria_s3" for="x_s3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->s3->caption() ?><?= $Page->s3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->s3->cellAttributes() ?>>
<span id="el_pengasuhpppria_s3">
<input type="<?= $Page->s3->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_s3" name="x_s3" id="x_s3" size="30" maxlength="255" value="<?= $Page->s3->EditValue ?>"<?= $Page->s3->editAttributes() ?> aria-describedby="x_s3_help">
<?= $Page->s3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->s3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->organisasi->Visible) { // organisasi ?>
    <div id="r_organisasi" class="form-group row">
        <label id="elh_pengasuhpppria_organisasi" for="x_organisasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->organisasi->caption() ?><?= $Page->organisasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->organisasi->cellAttributes() ?>>
<span id="el_pengasuhpppria_organisasi">
<input type="<?= $Page->organisasi->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_organisasi" name="x_organisasi" id="x_organisasi" size="30" maxlength="255" value="<?= $Page->organisasi->EditValue ?>"<?= $Page->organisasi->editAttributes() ?> aria-describedby="x_organisasi_help">
<?= $Page->organisasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->organisasi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
    <div id="r_jabatandiorganisasi" class="form-group row">
        <label id="elh_pengasuhpppria_jabatandiorganisasi" for="x_jabatandiorganisasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatandiorganisasi->caption() ?><?= $Page->jabatandiorganisasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatandiorganisasi->cellAttributes() ?>>
<span id="el_pengasuhpppria_jabatandiorganisasi">
<input type="<?= $Page->jabatandiorganisasi->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_jabatandiorganisasi" name="x_jabatandiorganisasi" id="x_jabatandiorganisasi" size="30" maxlength="255" value="<?= $Page->jabatandiorganisasi->EditValue ?>"<?= $Page->jabatandiorganisasi->editAttributes() ?> aria-describedby="x_jabatandiorganisasi_help">
<?= $Page->jabatandiorganisasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatandiorganisasi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
    <div id="r_tglawalorganisasi" class="form-group row">
        <label id="elh_pengasuhpppria_tglawalorganisasi" for="x_tglawalorganisasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglawalorganisasi->caption() ?><?= $Page->tglawalorganisasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglawalorganisasi->cellAttributes() ?>>
<span id="el_pengasuhpppria_tglawalorganisasi">
<input type="<?= $Page->tglawalorganisasi->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_tglawalorganisasi" data-format="7" name="x_tglawalorganisasi" id="x_tglawalorganisasi" value="<?= $Page->tglawalorganisasi->EditValue ?>"<?= $Page->tglawalorganisasi->editAttributes() ?> aria-describedby="x_tglawalorganisasi_help">
<?= $Page->tglawalorganisasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglawalorganisasi->getErrorMessage() ?></div>
<?php if (!$Page->tglawalorganisasi->ReadOnly && !$Page->tglawalorganisasi->Disabled && !isset($Page->tglawalorganisasi->EditAttrs["readonly"]) && !isset($Page->tglawalorganisasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhpppriaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhpppriaadd", "x_tglawalorganisasi", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pemerintah->Visible) { // pemerintah ?>
    <div id="r_pemerintah" class="form-group row">
        <label id="elh_pengasuhpppria_pemerintah" for="x_pemerintah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pemerintah->caption() ?><?= $Page->pemerintah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pemerintah->cellAttributes() ?>>
<span id="el_pengasuhpppria_pemerintah">
<input type="<?= $Page->pemerintah->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_pemerintah" name="x_pemerintah" id="x_pemerintah" size="30" maxlength="255" value="<?= $Page->pemerintah->EditValue ?>"<?= $Page->pemerintah->editAttributes() ?> aria-describedby="x_pemerintah_help">
<?= $Page->pemerintah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pemerintah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
    <div id="r_jabatandipemerintah" class="form-group row">
        <label id="elh_pengasuhpppria_jabatandipemerintah" for="x_jabatandipemerintah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jabatandipemerintah->caption() ?><?= $Page->jabatandipemerintah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jabatandipemerintah->cellAttributes() ?>>
<span id="el_pengasuhpppria_jabatandipemerintah">
<input type="<?= $Page->jabatandipemerintah->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_jabatandipemerintah" name="x_jabatandipemerintah" id="x_jabatandipemerintah" size="30" maxlength="255" value="<?= $Page->jabatandipemerintah->EditValue ?>"<?= $Page->jabatandipemerintah->editAttributes() ?> aria-describedby="x_jabatandipemerintah_help">
<?= $Page->jabatandipemerintah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jabatandipemerintah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
    <div id="r_tglmenjabat" class="form-group row">
        <label id="elh_pengasuhpppria_tglmenjabat" for="x_tglmenjabat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglmenjabat->caption() ?><?= $Page->tglmenjabat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglmenjabat->cellAttributes() ?>>
<span id="el_pengasuhpppria_tglmenjabat">
<input type="<?= $Page->tglmenjabat->getInputTextType() ?>" data-table="pengasuhpppria" data-field="x_tglmenjabat" data-format="7" name="x_tglmenjabat" id="x_tglmenjabat" value="<?= $Page->tglmenjabat->EditValue ?>"<?= $Page->tglmenjabat->editAttributes() ?> aria-describedby="x_tglmenjabat_help">
<?= $Page->tglmenjabat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglmenjabat->getErrorMessage() ?></div>
<?php if (!$Page->tglmenjabat->ReadOnly && !$Page->tglmenjabat->Disabled && !isset($Page->tglmenjabat->EditAttrs["readonly"]) && !isset($Page->tglmenjabat->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhpppriaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhpppriaadd", "x_tglmenjabat", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_pengasuhpppria_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_pengasuhpppria_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="pengasuhpppria" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
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
<?php if ($Page->ijazah->Visible) { // ijazah ?>
    <div id="r_ijazah" class="form-group row">
        <label id="elh_pengasuhpppria_ijazah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ijazah->caption() ?><?= $Page->ijazah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ijazah->cellAttributes() ?>>
<span id="el_pengasuhpppria_ijazah">
<div id="fd_x_ijazah">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->ijazah->title() ?>" data-table="pengasuhpppria" data-field="x_ijazah" name="x_ijazah" id="x_ijazah" lang="<?= CurrentLanguageID() ?>"<?= $Page->ijazah->editAttributes() ?><?= ($Page->ijazah->ReadOnly || $Page->ijazah->Disabled) ? " disabled" : "" ?> aria-describedby="x_ijazah_help">
        <label class="custom-file-label ew-file-label" for="x_ijazah"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->ijazah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ijazah->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_ijazah" id= "fn_x_ijazah" value="<?= $Page->ijazah->Upload->FileName ?>">
<input type="hidden" name="fa_x_ijazah" id= "fa_x_ijazah" value="0">
<input type="hidden" name="fs_x_ijazah" id= "fs_x_ijazah" value="255">
<input type="hidden" name="fx_x_ijazah" id= "fx_x_ijazah" value="<?= $Page->ijazah->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_ijazah" id= "fm_x_ijazah" value="<?= $Page->ijazah->UploadMaxFileSize ?>">
</div>
<table id="ft_x_ijazah" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sertifikat->Visible) { // sertifikat ?>
    <div id="r_sertifikat" class="form-group row">
        <label id="elh_pengasuhpppria_sertifikat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sertifikat->caption() ?><?= $Page->sertifikat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sertifikat->cellAttributes() ?>>
<span id="el_pengasuhpppria_sertifikat">
<div id="fd_x_sertifikat">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->sertifikat->title() ?>" data-table="pengasuhpppria" data-field="x_sertifikat" name="x_sertifikat" id="x_sertifikat" lang="<?= CurrentLanguageID() ?>"<?= $Page->sertifikat->editAttributes() ?><?= ($Page->sertifikat->ReadOnly || $Page->sertifikat->Disabled) ? " disabled" : "" ?> aria-describedby="x_sertifikat_help">
        <label class="custom-file-label ew-file-label" for="x_sertifikat"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->sertifikat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sertifikat->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_sertifikat" id= "fn_x_sertifikat" value="<?= $Page->sertifikat->Upload->FileName ?>">
<input type="hidden" name="fa_x_sertifikat" id= "fa_x_sertifikat" value="0">
<input type="hidden" name="fs_x_sertifikat" id= "fs_x_sertifikat" value="255">
<input type="hidden" name="fx_x_sertifikat" id= "fx_x_sertifikat" value="<?= $Page->sertifikat->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_sertifikat" id= "fm_x_sertifikat" value="<?= $Page->sertifikat->UploadMaxFileSize ?>">
</div>
<table id="ft_x_sertifikat" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
    ew.addEventHandlers("pengasuhpppria");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
