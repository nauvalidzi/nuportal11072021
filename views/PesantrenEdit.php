<?php

namespace PHPMaker2021\nuportal;

// Page object
$PesantrenEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpesantrenedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fpesantrenedit = currentForm = new ew.Form("fpesantrenedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pesantren")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pesantren)
        ew.vars.tables.pesantren = currentTable;
    fpesantrenedit.addFields([
        ["kode", [fields.kode.visible && fields.kode.required ? ew.Validators.required(fields.kode.caption) : null], fields.kode.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["deskripsi", [fields.deskripsi.visible && fields.deskripsi.required ? ew.Validators.required(fields.deskripsi.caption) : null], fields.deskripsi.isInvalid],
        ["jalan", [fields.jalan.visible && fields.jalan.required ? ew.Validators.required(fields.jalan.caption) : null], fields.jalan.isInvalid],
        ["propinsi", [fields.propinsi.visible && fields.propinsi.required ? ew.Validators.required(fields.propinsi.caption) : null], fields.propinsi.isInvalid],
        ["kabupaten", [fields.kabupaten.visible && fields.kabupaten.required ? ew.Validators.required(fields.kabupaten.caption) : null], fields.kabupaten.isInvalid],
        ["kecamatan", [fields.kecamatan.visible && fields.kecamatan.required ? ew.Validators.required(fields.kecamatan.caption) : null], fields.kecamatan.isInvalid],
        ["desa", [fields.desa.visible && fields.desa.required ? ew.Validators.required(fields.desa.caption) : null], fields.desa.isInvalid],
        ["kodepos", [fields.kodepos.visible && fields.kodepos.required ? ew.Validators.required(fields.kodepos.caption) : null], fields.kodepos.isInvalid],
        ["telpon", [fields.telpon.visible && fields.telpon.required ? ew.Validators.required(fields.telpon.caption) : null], fields.telpon.isInvalid],
        ["web", [fields.web.visible && fields.web.required ? ew.Validators.required(fields.web.caption) : null], fields.web.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["nspp", [fields.nspp.visible && fields.nspp.required ? ew.Validators.required(fields.nspp.caption) : null], fields.nspp.isInvalid],
        ["nspptglmulai", [fields.nspptglmulai.visible && fields.nspptglmulai.required ? ew.Validators.required(fields.nspptglmulai.caption) : null, ew.Validators.datetime(7)], fields.nspptglmulai.isInvalid],
        ["nspptglakhir", [fields.nspptglakhir.visible && fields.nspptglakhir.required ? ew.Validators.required(fields.nspptglakhir.caption) : null, ew.Validators.datetime(7)], fields.nspptglakhir.isInvalid],
        ["dokumennspp", [fields.dokumennspp.visible && fields.dokumennspp.required ? ew.Validators.fileRequired(fields.dokumennspp.caption) : null], fields.dokumennspp.isInvalid],
        ["yayasan", [fields.yayasan.visible && fields.yayasan.required ? ew.Validators.required(fields.yayasan.caption) : null], fields.yayasan.isInvalid],
        ["noakta", [fields.noakta.visible && fields.noakta.required ? ew.Validators.required(fields.noakta.caption) : null], fields.noakta.isInvalid],
        ["tglakta", [fields.tglakta.visible && fields.tglakta.required ? ew.Validators.required(fields.tglakta.caption) : null, ew.Validators.datetime(7)], fields.tglakta.isInvalid],
        ["namanotaris", [fields.namanotaris.visible && fields.namanotaris.required ? ew.Validators.required(fields.namanotaris.caption) : null], fields.namanotaris.isInvalid],
        ["alamatnotaris", [fields.alamatnotaris.visible && fields.alamatnotaris.required ? ew.Validators.required(fields.alamatnotaris.caption) : null], fields.alamatnotaris.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["ktp", [fields.ktp.visible && fields.ktp.required ? ew.Validators.fileRequired(fields.ktp.caption) : null], fields.ktp.isInvalid],
        ["dokumen", [fields.dokumen.visible && fields.dokumen.required ? ew.Validators.fileRequired(fields.dokumen.caption) : null], fields.dokumen.isInvalid],
        ["validasi", [fields.validasi.visible && fields.validasi.required ? ew.Validators.required(fields.validasi.caption) : null], fields.validasi.isInvalid],
        ["validator", [fields.validator.visible && fields.validator.required ? ew.Validators.required(fields.validator.caption) : null], fields.validator.isInvalid],
        ["validasi_pusat", [fields.validasi_pusat.visible && fields.validasi_pusat.required ? ew.Validators.required(fields.validasi_pusat.caption) : null], fields.validasi_pusat.isInvalid],
        ["validator_pusat", [fields.validator_pusat.visible && fields.validator_pusat.required ? ew.Validators.required(fields.validator_pusat.caption) : null], fields.validator_pusat.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpesantrenedit,
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
    fpesantrenedit.validate = function () {
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
    fpesantrenedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpesantrenedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpesantrenedit.lists.propinsi = <?= $Page->propinsi->toClientList($Page) ?>;
    fpesantrenedit.lists.kabupaten = <?= $Page->kabupaten->toClientList($Page) ?>;
    fpesantrenedit.lists.kecamatan = <?= $Page->kecamatan->toClientList($Page) ?>;
    fpesantrenedit.lists.desa = <?= $Page->desa->toClientList($Page) ?>;
    fpesantrenedit.lists.validasi = <?= $Page->validasi->toClientList($Page) ?>;
    fpesantrenedit.lists.validator = <?= $Page->validator->toClientList($Page) ?>;
    fpesantrenedit.lists.validasi_pusat = <?= $Page->validasi_pusat->toClientList($Page) ?>;
    fpesantrenedit.lists.validator_pusat = <?= $Page->validator_pusat->toClientList($Page) ?>;
    loadjs.done("fpesantrenedit");
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
<form name="fpesantrenedit" id="fpesantrenedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pesantren">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->kode->Visible) { // kode ?>
    <div id="r_kode" class="form-group row">
        <label id="elh_pesantren_kode" for="x_kode" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kode->caption() ?><?= $Page->kode->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kode->cellAttributes() ?>>
<span id="el_pesantren_kode">
<span<?= $Page->kode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->kode->getDisplayValue($Page->kode->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pesantren" data-field="x_kode" data-hidden="1" name="x_kode" id="x_kode" value="<?= HtmlEncode($Page->kode->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_pesantren_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_pesantren_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="pesantren" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->deskripsi->Visible) { // deskripsi ?>
    <div id="r_deskripsi" class="form-group row">
        <label id="elh_pesantren_deskripsi" for="x_deskripsi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->deskripsi->caption() ?><?= $Page->deskripsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->deskripsi->cellAttributes() ?>>
<span id="el_pesantren_deskripsi">
<textarea data-table="pesantren" data-field="x_deskripsi" name="x_deskripsi" id="x_deskripsi" cols="35" rows="4"<?= $Page->deskripsi->editAttributes() ?> aria-describedby="x_deskripsi_help"><?= $Page->deskripsi->EditValue ?></textarea>
<?= $Page->deskripsi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->deskripsi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jalan->Visible) { // jalan ?>
    <div id="r_jalan" class="form-group row">
        <label id="elh_pesantren_jalan" for="x_jalan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jalan->caption() ?><?= $Page->jalan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jalan->cellAttributes() ?>>
<span id="el_pesantren_jalan">
<input type="<?= $Page->jalan->getInputTextType() ?>" data-table="pesantren" data-field="x_jalan" name="x_jalan" id="x_jalan" size="30" maxlength="255" value="<?= $Page->jalan->EditValue ?>"<?= $Page->jalan->editAttributes() ?> aria-describedby="x_jalan_help">
<?= $Page->jalan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jalan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->propinsi->Visible) { // propinsi ?>
    <div id="r_propinsi" class="form-group row">
        <label id="elh_pesantren_propinsi" for="x_propinsi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->propinsi->caption() ?><?= $Page->propinsi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->propinsi->cellAttributes() ?>>
<span id="el_pesantren_propinsi">
<?php $Page->propinsi->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_propinsi"
        name="x_propinsi"
        class="form-control ew-select<?= $Page->propinsi->isInvalidClass() ?>"
        data-select2-id="pesantren_x_propinsi"
        data-table="pesantren"
        data-field="x_propinsi"
        data-value-separator="<?= $Page->propinsi->displayValueSeparatorAttribute() ?>"
        <?= $Page->propinsi->editAttributes() ?>>
        <?= $Page->propinsi->selectOptionListHtml("x_propinsi") ?>
    </select>
    <?= $Page->propinsi->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->propinsi->getErrorMessage() ?></div>
<?= $Page->propinsi->Lookup->getParamTag($Page, "p_x_propinsi") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pesantren_x_propinsi']"),
        options = { name: "x_propinsi", selectId: "pesantren_x_propinsi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pesantren.fields.propinsi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kabupaten->Visible) { // kabupaten ?>
    <div id="r_kabupaten" class="form-group row">
        <label id="elh_pesantren_kabupaten" for="x_kabupaten" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kabupaten->caption() ?><?= $Page->kabupaten->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kabupaten->cellAttributes() ?>>
<span id="el_pesantren_kabupaten">
<?php $Page->kabupaten->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_kabupaten"
        name="x_kabupaten"
        class="form-control ew-select<?= $Page->kabupaten->isInvalidClass() ?>"
        data-select2-id="pesantren_x_kabupaten"
        data-table="pesantren"
        data-field="x_kabupaten"
        data-value-separator="<?= $Page->kabupaten->displayValueSeparatorAttribute() ?>"
        <?= $Page->kabupaten->editAttributes() ?>>
        <?= $Page->kabupaten->selectOptionListHtml("x_kabupaten") ?>
    </select>
    <?= $Page->kabupaten->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->kabupaten->getErrorMessage() ?></div>
<?= $Page->kabupaten->Lookup->getParamTag($Page, "p_x_kabupaten") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pesantren_x_kabupaten']"),
        options = { name: "x_kabupaten", selectId: "pesantren_x_kabupaten", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pesantren.fields.kabupaten.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kecamatan->Visible) { // kecamatan ?>
    <div id="r_kecamatan" class="form-group row">
        <label id="elh_pesantren_kecamatan" for="x_kecamatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kecamatan->caption() ?><?= $Page->kecamatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kecamatan->cellAttributes() ?>>
<span id="el_pesantren_kecamatan">
<?php $Page->kecamatan->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x_kecamatan"
        name="x_kecamatan"
        class="form-control ew-select<?= $Page->kecamatan->isInvalidClass() ?>"
        data-select2-id="pesantren_x_kecamatan"
        data-table="pesantren"
        data-field="x_kecamatan"
        data-value-separator="<?= $Page->kecamatan->displayValueSeparatorAttribute() ?>"
        <?= $Page->kecamatan->editAttributes() ?>>
        <?= $Page->kecamatan->selectOptionListHtml("x_kecamatan") ?>
    </select>
    <?= $Page->kecamatan->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->kecamatan->getErrorMessage() ?></div>
<?= $Page->kecamatan->Lookup->getParamTag($Page, "p_x_kecamatan") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pesantren_x_kecamatan']"),
        options = { name: "x_kecamatan", selectId: "pesantren_x_kecamatan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pesantren.fields.kecamatan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->desa->Visible) { // desa ?>
    <div id="r_desa" class="form-group row">
        <label id="elh_pesantren_desa" for="x_desa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->desa->caption() ?><?= $Page->desa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->desa->cellAttributes() ?>>
<span id="el_pesantren_desa">
    <select
        id="x_desa"
        name="x_desa"
        class="form-control ew-select<?= $Page->desa->isInvalidClass() ?>"
        data-select2-id="pesantren_x_desa"
        data-table="pesantren"
        data-field="x_desa"
        data-value-separator="<?= $Page->desa->displayValueSeparatorAttribute() ?>"
        <?= $Page->desa->editAttributes() ?>>
        <?= $Page->desa->selectOptionListHtml("x_desa") ?>
    </select>
    <?= $Page->desa->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->desa->getErrorMessage() ?></div>
<?= $Page->desa->Lookup->getParamTag($Page, "p_x_desa") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pesantren_x_desa']"),
        options = { name: "x_desa", selectId: "pesantren_x_desa", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pesantren.fields.desa.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->kodepos->Visible) { // kodepos ?>
    <div id="r_kodepos" class="form-group row">
        <label id="elh_pesantren_kodepos" for="x_kodepos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->kodepos->caption() ?><?= $Page->kodepos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->kodepos->cellAttributes() ?>>
<span id="el_pesantren_kodepos">
<input type="<?= $Page->kodepos->getInputTextType() ?>" data-table="pesantren" data-field="x_kodepos" name="x_kodepos" id="x_kodepos" size="30" maxlength="255" value="<?= $Page->kodepos->EditValue ?>"<?= $Page->kodepos->editAttributes() ?> aria-describedby="x_kodepos_help">
<?= $Page->kodepos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->kodepos->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->telpon->Visible) { // telpon ?>
    <div id="r_telpon" class="form-group row">
        <label id="elh_pesantren_telpon" for="x_telpon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->telpon->caption() ?><?= $Page->telpon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->telpon->cellAttributes() ?>>
<span id="el_pesantren_telpon">
<input type="<?= $Page->telpon->getInputTextType() ?>" data-table="pesantren" data-field="x_telpon" name="x_telpon" id="x_telpon" size="30" maxlength="255" value="<?= $Page->telpon->EditValue ?>"<?= $Page->telpon->editAttributes() ?> aria-describedby="x_telpon_help">
<?= $Page->telpon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->telpon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->web->Visible) { // web ?>
    <div id="r_web" class="form-group row">
        <label id="elh_pesantren_web" for="x_web" class="<?= $Page->LeftColumnClass ?>"><?= $Page->web->caption() ?><?= $Page->web->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->web->cellAttributes() ?>>
<span id="el_pesantren_web">
<input type="<?= $Page->web->getInputTextType() ?>" data-table="pesantren" data-field="x_web" name="x_web" id="x_web" size="30" maxlength="255" value="<?= $Page->web->EditValue ?>"<?= $Page->web->editAttributes() ?> aria-describedby="x_web_help">
<?= $Page->web->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->web->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_pesantren__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<span id="el_pesantren__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="pesantren" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nspp->Visible) { // nspp ?>
    <div id="r_nspp" class="form-group row">
        <label id="elh_pesantren_nspp" for="x_nspp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nspp->caption() ?><?= $Page->nspp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nspp->cellAttributes() ?>>
<span id="el_pesantren_nspp">
<input type="<?= $Page->nspp->getInputTextType() ?>" data-table="pesantren" data-field="x_nspp" name="x_nspp" id="x_nspp" size="30" maxlength="255" value="<?= $Page->nspp->EditValue ?>"<?= $Page->nspp->editAttributes() ?> aria-describedby="x_nspp_help">
<?= $Page->nspp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nspp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nspptglmulai->Visible) { // nspptglmulai ?>
    <div id="r_nspptglmulai" class="form-group row">
        <label id="elh_pesantren_nspptglmulai" for="x_nspptglmulai" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nspptglmulai->caption() ?><?= $Page->nspptglmulai->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nspptglmulai->cellAttributes() ?>>
<span id="el_pesantren_nspptglmulai">
<input type="<?= $Page->nspptglmulai->getInputTextType() ?>" data-table="pesantren" data-field="x_nspptglmulai" data-format="7" name="x_nspptglmulai" id="x_nspptglmulai" value="<?= $Page->nspptglmulai->EditValue ?>"<?= $Page->nspptglmulai->editAttributes() ?> aria-describedby="x_nspptglmulai_help">
<?= $Page->nspptglmulai->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nspptglmulai->getErrorMessage() ?></div>
<?php if (!$Page->nspptglmulai->ReadOnly && !$Page->nspptglmulai->Disabled && !isset($Page->nspptglmulai->EditAttrs["readonly"]) && !isset($Page->nspptglmulai->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpesantrenedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fpesantrenedit", "x_nspptglmulai", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nspptglakhir->Visible) { // nspptglakhir ?>
    <div id="r_nspptglakhir" class="form-group row">
        <label id="elh_pesantren_nspptglakhir" for="x_nspptglakhir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nspptglakhir->caption() ?><?= $Page->nspptglakhir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nspptglakhir->cellAttributes() ?>>
<span id="el_pesantren_nspptglakhir">
<input type="<?= $Page->nspptglakhir->getInputTextType() ?>" data-table="pesantren" data-field="x_nspptglakhir" data-format="7" name="x_nspptglakhir" id="x_nspptglakhir" value="<?= $Page->nspptglakhir->EditValue ?>"<?= $Page->nspptglakhir->editAttributes() ?> aria-describedby="x_nspptglakhir_help">
<?= $Page->nspptglakhir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nspptglakhir->getErrorMessage() ?></div>
<?php if (!$Page->nspptglakhir->ReadOnly && !$Page->nspptglakhir->Disabled && !isset($Page->nspptglakhir->EditAttrs["readonly"]) && !isset($Page->nspptglakhir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpesantrenedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fpesantrenedit", "x_nspptglakhir", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dokumennspp->Visible) { // dokumennspp ?>
    <div id="r_dokumennspp" class="form-group row">
        <label id="elh_pesantren_dokumennspp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dokumennspp->caption() ?><?= $Page->dokumennspp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dokumennspp->cellAttributes() ?>>
<span id="el_pesantren_dokumennspp">
<div id="fd_x_dokumennspp">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->dokumennspp->title() ?>" data-table="pesantren" data-field="x_dokumennspp" name="x_dokumennspp" id="x_dokumennspp" lang="<?= CurrentLanguageID() ?>"<?= $Page->dokumennspp->editAttributes() ?><?= ($Page->dokumennspp->ReadOnly || $Page->dokumennspp->Disabled) ? " disabled" : "" ?> aria-describedby="x_dokumennspp_help">
        <label class="custom-file-label ew-file-label" for="x_dokumennspp"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->dokumennspp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dokumennspp->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_dokumennspp" id= "fn_x_dokumennspp" value="<?= $Page->dokumennspp->Upload->FileName ?>">
<input type="hidden" name="fa_x_dokumennspp" id= "fa_x_dokumennspp" value="<?= (Post("fa_x_dokumennspp") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_dokumennspp" id= "fs_x_dokumennspp" value="255">
<input type="hidden" name="fx_x_dokumennspp" id= "fx_x_dokumennspp" value="<?= $Page->dokumennspp->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_dokumennspp" id= "fm_x_dokumennspp" value="<?= $Page->dokumennspp->UploadMaxFileSize ?>">
</div>
<table id="ft_x_dokumennspp" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->yayasan->Visible) { // yayasan ?>
    <div id="r_yayasan" class="form-group row">
        <label id="elh_pesantren_yayasan" for="x_yayasan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->yayasan->caption() ?><?= $Page->yayasan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->yayasan->cellAttributes() ?>>
<span id="el_pesantren_yayasan">
<input type="<?= $Page->yayasan->getInputTextType() ?>" data-table="pesantren" data-field="x_yayasan" name="x_yayasan" id="x_yayasan" size="30" maxlength="255" value="<?= $Page->yayasan->EditValue ?>"<?= $Page->yayasan->editAttributes() ?> aria-describedby="x_yayasan_help">
<?= $Page->yayasan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->yayasan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->noakta->Visible) { // noakta ?>
    <div id="r_noakta" class="form-group row">
        <label id="elh_pesantren_noakta" for="x_noakta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->noakta->caption() ?><?= $Page->noakta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->noakta->cellAttributes() ?>>
<span id="el_pesantren_noakta">
<input type="<?= $Page->noakta->getInputTextType() ?>" data-table="pesantren" data-field="x_noakta" name="x_noakta" id="x_noakta" size="30" maxlength="255" value="<?= $Page->noakta->EditValue ?>"<?= $Page->noakta->editAttributes() ?> aria-describedby="x_noakta_help">
<?= $Page->noakta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->noakta->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tglakta->Visible) { // tglakta ?>
    <div id="r_tglakta" class="form-group row">
        <label id="elh_pesantren_tglakta" for="x_tglakta" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tglakta->caption() ?><?= $Page->tglakta->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tglakta->cellAttributes() ?>>
<span id="el_pesantren_tglakta">
<input type="<?= $Page->tglakta->getInputTextType() ?>" data-table="pesantren" data-field="x_tglakta" data-format="7" name="x_tglakta" id="x_tglakta" value="<?= $Page->tglakta->EditValue ?>"<?= $Page->tglakta->editAttributes() ?> aria-describedby="x_tglakta_help">
<?= $Page->tglakta->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tglakta->getErrorMessage() ?></div>
<?php if (!$Page->tglakta->ReadOnly && !$Page->tglakta->Disabled && !isset($Page->tglakta->EditAttrs["readonly"]) && !isset($Page->tglakta->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpesantrenedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fpesantrenedit", "x_tglakta", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->namanotaris->Visible) { // namanotaris ?>
    <div id="r_namanotaris" class="form-group row">
        <label id="elh_pesantren_namanotaris" for="x_namanotaris" class="<?= $Page->LeftColumnClass ?>"><?= $Page->namanotaris->caption() ?><?= $Page->namanotaris->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->namanotaris->cellAttributes() ?>>
<span id="el_pesantren_namanotaris">
<input type="<?= $Page->namanotaris->getInputTextType() ?>" data-table="pesantren" data-field="x_namanotaris" name="x_namanotaris" id="x_namanotaris" size="30" maxlength="255" value="<?= $Page->namanotaris->EditValue ?>"<?= $Page->namanotaris->editAttributes() ?> aria-describedby="x_namanotaris_help">
<?= $Page->namanotaris->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->namanotaris->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamatnotaris->Visible) { // alamatnotaris ?>
    <div id="r_alamatnotaris" class="form-group row">
        <label id="elh_pesantren_alamatnotaris" for="x_alamatnotaris" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamatnotaris->caption() ?><?= $Page->alamatnotaris->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamatnotaris->cellAttributes() ?>>
<span id="el_pesantren_alamatnotaris">
<input type="<?= $Page->alamatnotaris->getInputTextType() ?>" data-table="pesantren" data-field="x_alamatnotaris" name="x_alamatnotaris" id="x_alamatnotaris" size="30" maxlength="255" value="<?= $Page->alamatnotaris->EditValue ?>"<?= $Page->alamatnotaris->editAttributes() ?> aria-describedby="x_alamatnotaris_help">
<?= $Page->alamatnotaris->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamatnotaris->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_pesantren_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_pesantren_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="pesantren" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
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
<?php if ($Page->ktp->Visible) { // ktp ?>
    <div id="r_ktp" class="form-group row">
        <label id="elh_pesantren_ktp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ktp->caption() ?><?= $Page->ktp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->ktp->cellAttributes() ?>>
<span id="el_pesantren_ktp">
<div id="fd_x_ktp">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->ktp->title() ?>" data-table="pesantren" data-field="x_ktp" name="x_ktp" id="x_ktp" lang="<?= CurrentLanguageID() ?>"<?= $Page->ktp->editAttributes() ?><?= ($Page->ktp->ReadOnly || $Page->ktp->Disabled) ? " disabled" : "" ?> aria-describedby="x_ktp_help">
        <label class="custom-file-label ew-file-label" for="x_ktp"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->ktp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->ktp->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_ktp" id= "fn_x_ktp" value="<?= $Page->ktp->Upload->FileName ?>">
<input type="hidden" name="fa_x_ktp" id= "fa_x_ktp" value="<?= (Post("fa_x_ktp") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_ktp" id= "fs_x_ktp" value="255">
<input type="hidden" name="fx_x_ktp" id= "fx_x_ktp" value="<?= $Page->ktp->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_ktp" id= "fm_x_ktp" value="<?= $Page->ktp->UploadMaxFileSize ?>">
</div>
<table id="ft_x_ktp" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dokumen->Visible) { // dokumen ?>
    <div id="r_dokumen" class="form-group row">
        <label id="elh_pesantren_dokumen" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dokumen->caption() ?><?= $Page->dokumen->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dokumen->cellAttributes() ?>>
<span id="el_pesantren_dokumen">
<div id="fd_x_dokumen">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->dokumen->title() ?>" data-table="pesantren" data-field="x_dokumen" name="x_dokumen" id="x_dokumen" lang="<?= CurrentLanguageID() ?>"<?= $Page->dokumen->editAttributes() ?><?= ($Page->dokumen->ReadOnly || $Page->dokumen->Disabled) ? " disabled" : "" ?> aria-describedby="x_dokumen_help">
        <label class="custom-file-label ew-file-label" for="x_dokumen"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->dokumen->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dokumen->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_dokumen" id= "fn_x_dokumen" value="<?= $Page->dokumen->Upload->FileName ?>">
<input type="hidden" name="fa_x_dokumen" id= "fa_x_dokumen" value="<?= (Post("fa_x_dokumen") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_dokumen" id= "fs_x_dokumen" value="255">
<input type="hidden" name="fx_x_dokumen" id= "fx_x_dokumen" value="<?= $Page->dokumen->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_dokumen" id= "fm_x_dokumen" value="<?= $Page->dokumen->UploadMaxFileSize ?>">
</div>
<table id="ft_x_dokumen" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validasi->Visible) { // validasi ?>
    <div id="r_validasi" class="form-group row">
        <label id="elh_pesantren_validasi" for="x_validasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validasi->caption() ?><?= $Page->validasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->validasi->cellAttributes() ?>>
<span id="el_pesantren_validasi">
    <select
        id="x_validasi"
        name="x_validasi"
        class="form-control ew-select<?= $Page->validasi->isInvalidClass() ?>"
        data-select2-id="pesantren_x_validasi"
        data-table="pesantren"
        data-field="x_validasi"
        data-value-separator="<?= $Page->validasi->displayValueSeparatorAttribute() ?>"
        <?= $Page->validasi->editAttributes() ?>>
        <?= $Page->validasi->selectOptionListHtml("x_validasi") ?>
    </select>
    <?= $Page->validasi->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->validasi->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pesantren_x_validasi']"),
        options = { name: "x_validasi", selectId: "pesantren_x_validasi", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.pesantren.fields.validasi.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pesantren.fields.validasi.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validator->Visible) { // validator ?>
    <div id="r_validator" class="form-group row">
        <label id="elh_pesantren_validator" for="x_validator" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validator->caption() ?><?= $Page->validator->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->validator->cellAttributes() ?>>
<span id="el_pesantren_validator">
    <select
        id="x_validator"
        name="x_validator"
        class="form-control ew-select<?= $Page->validator->isInvalidClass() ?>"
        data-select2-id="pesantren_x_validator"
        data-table="pesantren"
        data-field="x_validator"
        data-value-separator="<?= $Page->validator->displayValueSeparatorAttribute() ?>"
        <?= $Page->validator->editAttributes() ?>>
        <?= $Page->validator->selectOptionListHtml("x_validator") ?>
    </select>
    <?= $Page->validator->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->validator->getErrorMessage() ?></div>
<?= $Page->validator->Lookup->getParamTag($Page, "p_x_validator") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pesantren_x_validator']"),
        options = { name: "x_validator", selectId: "pesantren_x_validator", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pesantren.fields.validator.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validasi_pusat->Visible) { // validasi_pusat ?>
    <div id="r_validasi_pusat" class="form-group row">
        <label id="elh_pesantren_validasi_pusat" for="x_validasi_pusat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validasi_pusat->caption() ?><?= $Page->validasi_pusat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->validasi_pusat->cellAttributes() ?>>
<span id="el_pesantren_validasi_pusat">
    <select
        id="x_validasi_pusat"
        name="x_validasi_pusat"
        class="form-control ew-select<?= $Page->validasi_pusat->isInvalidClass() ?>"
        data-select2-id="pesantren_x_validasi_pusat"
        data-table="pesantren"
        data-field="x_validasi_pusat"
        data-value-separator="<?= $Page->validasi_pusat->displayValueSeparatorAttribute() ?>"
        <?= $Page->validasi_pusat->editAttributes() ?>>
        <?= $Page->validasi_pusat->selectOptionListHtml("x_validasi_pusat") ?>
    </select>
    <?= $Page->validasi_pusat->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->validasi_pusat->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pesantren_x_validasi_pusat']"),
        options = { name: "x_validasi_pusat", selectId: "pesantren_x_validasi_pusat", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.pesantren.fields.validasi_pusat.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pesantren.fields.validasi_pusat.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->validator_pusat->Visible) { // validator_pusat ?>
    <div id="r_validator_pusat" class="form-group row">
        <label id="elh_pesantren_validator_pusat" for="x_validator_pusat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->validator_pusat->caption() ?><?= $Page->validator_pusat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->validator_pusat->cellAttributes() ?>>
<span id="el_pesantren_validator_pusat">
    <select
        id="x_validator_pusat"
        name="x_validator_pusat"
        class="form-control ew-select<?= $Page->validator_pusat->isInvalidClass() ?>"
        data-select2-id="pesantren_x_validator_pusat"
        data-table="pesantren"
        data-field="x_validator_pusat"
        data-value-separator="<?= $Page->validator_pusat->displayValueSeparatorAttribute() ?>"
        <?= $Page->validator_pusat->editAttributes() ?>>
        <?= $Page->validator_pusat->selectOptionListHtml("x_validator_pusat") ?>
    </select>
    <?= $Page->validator_pusat->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->validator_pusat->getErrorMessage() ?></div>
<?= $Page->validator_pusat->Lookup->getParamTag($Page, "p_x_validator_pusat") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pesantren_x_validator_pusat']"),
        options = { name: "x_validator_pusat", selectId: "pesantren_x_validator_pusat", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pesantren.fields.validator_pusat.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="pesantren" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php
    if (in_array("fasilitasusaha", explode(",", $Page->getCurrentDetailTable())) && $fasilitasusaha->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fasilitasusaha", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FasilitasusahaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("pendidikanumum", explode(",", $Page->getCurrentDetailTable())) && $pendidikanumum->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("pendidikanumum", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PendidikanumumGrid.php" ?>
<?php } ?>
<?php
    if (in_array("pengasuhpppria", explode(",", $Page->getCurrentDetailTable())) && $pengasuhpppria->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("pengasuhpppria", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PengasuhpppriaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("pengasuhppwanita", explode(",", $Page->getCurrentDetailTable())) && $pengasuhppwanita->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("pengasuhppwanita", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PengasuhppwanitaGrid.php" ?>
<?php } ?>
<?php
    if (in_array("kitabkuning", explode(",", $Page->getCurrentDetailTable())) && $kitabkuning->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("kitabkuning", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "KitabkuningGrid.php" ?>
<?php } ?>
<?php
    if (in_array("fasilitaspesantren", explode(",", $Page->getCurrentDetailTable())) && $fasilitaspesantren->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fasilitaspesantren", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FasilitaspesantrenGrid.php" ?>
<?php } ?>
<?php
    if (in_array("pendidikanpesantren", explode(",", $Page->getCurrentDetailTable())) && $pendidikanpesantren->DetailEdit) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("pendidikanpesantren", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "PendidikanpesantrenGrid.php" ?>
<?php } ?>
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
    ew.addEventHandlers("pesantren");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
