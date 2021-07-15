<?php

namespace PHPMaker2021\nuportal;

// Page object
$PengasuhppwanitaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpengasuhppwanitalist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpengasuhppwanitalist = currentForm = new ew.Form("fpengasuhppwanitalist", "list");
    fpengasuhppwanitalist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pengasuhppwanita")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pengasuhppwanita)
        ew.vars.tables.pengasuhppwanita = currentTable;
    fpengasuhppwanitalist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
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
        ["tglmenjabat", [fields.tglmenjabat.visible && fields.tglmenjabat.required ? ew.Validators.required(fields.tglmenjabat.caption) : null, ew.Validators.datetime(0)], fields.tglmenjabat.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["ijazah", [fields.ijazah.visible && fields.ijazah.required ? ew.Validators.fileRequired(fields.ijazah.caption) : null], fields.ijazah.isInvalid],
        ["sertifikat", [fields.sertifikat.visible && fields.sertifikat.required ? ew.Validators.fileRequired(fields.sertifikat.caption) : null], fields.sertifikat.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpengasuhppwanitalist,
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
    fpengasuhppwanitalist.validate = function () {
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
    fpengasuhppwanitalist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpengasuhppwanitalist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpengasuhppwanitalist.lists.pid = <?= $Page->pid->toClientList($Page) ?>;
    loadjs.done("fpengasuhppwanitalist");
});
</script>
<style>
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "left" : "right";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "pesantren") {
    if ($Page->MasterRecordExists) {
        include_once "views/PesantrenMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pengasuhppwanita">
<form name="fpengasuhppwanitalist" id="fpengasuhppwanitalist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pengasuhppwanita">
<?php if ($Page->getCurrentMasterTable() == "pesantren" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pesantren">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_pengasuhppwanita" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_pengasuhppwanitalist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_pengasuhppwanita_id" class="pengasuhppwanita_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Page->pid->headerCellClass() ?>"><div id="elh_pengasuhppwanita_pid" class="pengasuhppwanita_pid"><?= $Page->renderSort($Page->pid) ?></div></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Page->nama->headerCellClass() ?>"><div id="elh_pengasuhppwanita_nama" class="pengasuhppwanita_nama"><?= $Page->renderSort($Page->nama) ?></div></th>
<?php } ?>
<?php if ($Page->nik->Visible) { // nik ?>
        <th data-name="nik" class="<?= $Page->nik->headerCellClass() ?>"><div id="elh_pengasuhppwanita_nik" class="pengasuhppwanita_nik"><?= $Page->renderSort($Page->nik) ?></div></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th data-name="alamat" class="<?= $Page->alamat->headerCellClass() ?>"><div id="elh_pengasuhppwanita_alamat" class="pengasuhppwanita_alamat"><?= $Page->renderSort($Page->alamat) ?></div></th>
<?php } ?>
<?php if ($Page->hp->Visible) { // hp ?>
        <th data-name="hp" class="<?= $Page->hp->headerCellClass() ?>"><div id="elh_pengasuhppwanita_hp" class="pengasuhppwanita_hp"><?= $Page->renderSort($Page->hp) ?></div></th>
<?php } ?>
<?php if ($Page->md->Visible) { // md ?>
        <th data-name="md" class="<?= $Page->md->headerCellClass() ?>"><div id="elh_pengasuhppwanita_md" class="pengasuhppwanita_md"><?= $Page->renderSort($Page->md) ?></div></th>
<?php } ?>
<?php if ($Page->mts->Visible) { // mts ?>
        <th data-name="mts" class="<?= $Page->mts->headerCellClass() ?>"><div id="elh_pengasuhppwanita_mts" class="pengasuhppwanita_mts"><?= $Page->renderSort($Page->mts) ?></div></th>
<?php } ?>
<?php if ($Page->ma->Visible) { // ma ?>
        <th data-name="ma" class="<?= $Page->ma->headerCellClass() ?>"><div id="elh_pengasuhppwanita_ma" class="pengasuhppwanita_ma"><?= $Page->renderSort($Page->ma) ?></div></th>
<?php } ?>
<?php if ($Page->pesantren->Visible) { // pesantren ?>
        <th data-name="pesantren" class="<?= $Page->pesantren->headerCellClass() ?>"><div id="elh_pengasuhppwanita_pesantren" class="pengasuhppwanita_pesantren"><?= $Page->renderSort($Page->pesantren) ?></div></th>
<?php } ?>
<?php if ($Page->s1->Visible) { // s1 ?>
        <th data-name="s1" class="<?= $Page->s1->headerCellClass() ?>"><div id="elh_pengasuhppwanita_s1" class="pengasuhppwanita_s1"><?= $Page->renderSort($Page->s1) ?></div></th>
<?php } ?>
<?php if ($Page->s2->Visible) { // s2 ?>
        <th data-name="s2" class="<?= $Page->s2->headerCellClass() ?>"><div id="elh_pengasuhppwanita_s2" class="pengasuhppwanita_s2"><?= $Page->renderSort($Page->s2) ?></div></th>
<?php } ?>
<?php if ($Page->s3->Visible) { // s3 ?>
        <th data-name="s3" class="<?= $Page->s3->headerCellClass() ?>"><div id="elh_pengasuhppwanita_s3" class="pengasuhppwanita_s3"><?= $Page->renderSort($Page->s3) ?></div></th>
<?php } ?>
<?php if ($Page->organisasi->Visible) { // organisasi ?>
        <th data-name="organisasi" class="<?= $Page->organisasi->headerCellClass() ?>"><div id="elh_pengasuhppwanita_organisasi" class="pengasuhppwanita_organisasi"><?= $Page->renderSort($Page->organisasi) ?></div></th>
<?php } ?>
<?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <th data-name="jabatandiorganisasi" class="<?= $Page->jabatandiorganisasi->headerCellClass() ?>"><div id="elh_pengasuhppwanita_jabatandiorganisasi" class="pengasuhppwanita_jabatandiorganisasi"><?= $Page->renderSort($Page->jabatandiorganisasi) ?></div></th>
<?php } ?>
<?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <th data-name="tglawalorganisasi" class="<?= $Page->tglawalorganisasi->headerCellClass() ?>"><div id="elh_pengasuhppwanita_tglawalorganisasi" class="pengasuhppwanita_tglawalorganisasi"><?= $Page->renderSort($Page->tglawalorganisasi) ?></div></th>
<?php } ?>
<?php if ($Page->pemerintah->Visible) { // pemerintah ?>
        <th data-name="pemerintah" class="<?= $Page->pemerintah->headerCellClass() ?>"><div id="elh_pengasuhppwanita_pemerintah" class="pengasuhppwanita_pemerintah"><?= $Page->renderSort($Page->pemerintah) ?></div></th>
<?php } ?>
<?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <th data-name="jabatandipemerintah" class="<?= $Page->jabatandipemerintah->headerCellClass() ?>"><div id="elh_pengasuhppwanita_jabatandipemerintah" class="pengasuhppwanita_jabatandipemerintah"><?= $Page->renderSort($Page->jabatandipemerintah) ?></div></th>
<?php } ?>
<?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
        <th data-name="tglmenjabat" class="<?= $Page->tglmenjabat->headerCellClass() ?>"><div id="elh_pengasuhppwanita_tglmenjabat" class="pengasuhppwanita_tglmenjabat"><?= $Page->renderSort($Page->tglmenjabat) ?></div></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th data-name="foto" class="<?= $Page->foto->headerCellClass() ?>"><div id="elh_pengasuhppwanita_foto" class="pengasuhppwanita_foto"><?= $Page->renderSort($Page->foto) ?></div></th>
<?php } ?>
<?php if ($Page->ijazah->Visible) { // ijazah ?>
        <th data-name="ijazah" class="<?= $Page->ijazah->headerCellClass() ?>"><div id="elh_pengasuhppwanita_ijazah" class="pengasuhppwanita_ijazah"><?= $Page->renderSort($Page->ijazah) ?></div></th>
<?php } ?>
<?php if ($Page->sertifikat->Visible) { // sertifikat ?>
        <th data-name="sertifikat" class="<?= $Page->sertifikat->headerCellClass() ?>"><div id="elh_pengasuhppwanita_sertifikat" class="pengasuhppwanita_sertifikat"><?= $Page->renderSort($Page->sertifikat) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
    if ($Page->isAdd() || $Page->isCopy()) {
        $Page->RowIndex = 0;
        $Page->KeyCount = $Page->RowIndex;
        if ($Page->isCopy() && !$Page->loadRow())
            $Page->CurrentAction = "add";
        if ($Page->isAdd())
            $Page->loadRowValues();
        if ($Page->EventCancelled) // Insert failed
            $Page->restoreFormValues(); // Restore form values

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_pengasuhppwanita", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_id" class="form-group pengasuhppwanita_id"></span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->pid->Visible) { // pid ?>
        <td data-name="pid">
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pid" class="form-group pengasuhppwanita_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_pid" name="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pid" class="form-group pengasuhppwanita_pid">
<?php
$onchange = $Page->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Page->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_pid" id="sv_x<?= $Page->RowIndex ?>_pid" value="<?= RemoveHtml($Page->pid->EditValue) ?>" size="30"<?= $Page->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="pengasuhppwanita" data-field="x_pid" data-input="sv_x<?= $Page->RowIndex ?>_pid" data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_pid" id="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fpengasuhppwanitalist"], function() {
    fpengasuhppwanitalist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.pengasuhppwanita.fields.pid.autoSuggestOptions));
});
</script>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_pid") ?>
</span>
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pid" data-hidden="1" name="o<?= $Page->RowIndex ?>_pid" id="o<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_nama" class="form-group pengasuhppwanita_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nama" name="x<?= $Page->RowIndex ?>_nama" id="x<?= $Page->RowIndex ?>_nama" size="30" maxlength="255" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nama" data-hidden="1" name="o<?= $Page->RowIndex ?>_nama" id="o<?= $Page->RowIndex ?>_nama" value="<?= HtmlEncode($Page->nama->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->nik->Visible) { // nik ?>
        <td data-name="nik">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_nik" class="form-group pengasuhppwanita_nik">
<input type="<?= $Page->nik->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nik" name="x<?= $Page->RowIndex ?>_nik" id="x<?= $Page->RowIndex ?>_nik" size="30" maxlength="255" value="<?= $Page->nik->EditValue ?>"<?= $Page->nik->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nik->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nik" data-hidden="1" name="o<?= $Page->RowIndex ?>_nik" id="o<?= $Page->RowIndex ?>_nik" value="<?= HtmlEncode($Page->nik->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->alamat->Visible) { // alamat ?>
        <td data-name="alamat">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_alamat" class="form-group pengasuhppwanita_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_alamat" name="x<?= $Page->RowIndex ?>_alamat" id="x<?= $Page->RowIndex ?>_alamat" size="30" maxlength="255" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_alamat" data-hidden="1" name="o<?= $Page->RowIndex ?>_alamat" id="o<?= $Page->RowIndex ?>_alamat" value="<?= HtmlEncode($Page->alamat->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->hp->Visible) { // hp ?>
        <td data-name="hp">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_hp" class="form-group pengasuhppwanita_hp">
<input type="<?= $Page->hp->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_hp" name="x<?= $Page->RowIndex ?>_hp" id="x<?= $Page->RowIndex ?>_hp" size="30" maxlength="255" value="<?= $Page->hp->EditValue ?>"<?= $Page->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->hp->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_hp" data-hidden="1" name="o<?= $Page->RowIndex ?>_hp" id="o<?= $Page->RowIndex ?>_hp" value="<?= HtmlEncode($Page->hp->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->md->Visible) { // md ?>
        <td data-name="md">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_md" class="form-group pengasuhppwanita_md">
<input type="<?= $Page->md->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_md" name="x<?= $Page->RowIndex ?>_md" id="x<?= $Page->RowIndex ?>_md" size="30" maxlength="255" value="<?= $Page->md->EditValue ?>"<?= $Page->md->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->md->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_md" data-hidden="1" name="o<?= $Page->RowIndex ?>_md" id="o<?= $Page->RowIndex ?>_md" value="<?= HtmlEncode($Page->md->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->mts->Visible) { // mts ?>
        <td data-name="mts">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_mts" class="form-group pengasuhppwanita_mts">
<input type="<?= $Page->mts->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_mts" name="x<?= $Page->RowIndex ?>_mts" id="x<?= $Page->RowIndex ?>_mts" size="30" maxlength="255" value="<?= $Page->mts->EditValue ?>"<?= $Page->mts->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->mts->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_mts" data-hidden="1" name="o<?= $Page->RowIndex ?>_mts" id="o<?= $Page->RowIndex ?>_mts" value="<?= HtmlEncode($Page->mts->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ma->Visible) { // ma ?>
        <td data-name="ma">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_ma" class="form-group pengasuhppwanita_ma">
<input type="<?= $Page->ma->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_ma" name="x<?= $Page->RowIndex ?>_ma" id="x<?= $Page->RowIndex ?>_ma" size="30" maxlength="255" value="<?= $Page->ma->EditValue ?>"<?= $Page->ma->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ma->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ma" data-hidden="1" name="o<?= $Page->RowIndex ?>_ma" id="o<?= $Page->RowIndex ?>_ma" value="<?= HtmlEncode($Page->ma->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->pesantren->Visible) { // pesantren ?>
        <td data-name="pesantren">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pesantren" class="form-group pengasuhppwanita_pesantren">
<input type="<?= $Page->pesantren->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pesantren" name="x<?= $Page->RowIndex ?>_pesantren" id="x<?= $Page->RowIndex ?>_pesantren" size="30" maxlength="255" value="<?= $Page->pesantren->EditValue ?>"<?= $Page->pesantren->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->pesantren->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pesantren" data-hidden="1" name="o<?= $Page->RowIndex ?>_pesantren" id="o<?= $Page->RowIndex ?>_pesantren" value="<?= HtmlEncode($Page->pesantren->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->s1->Visible) { // s1 ?>
        <td data-name="s1">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s1" class="form-group pengasuhppwanita_s1">
<input type="<?= $Page->s1->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s1" name="x<?= $Page->RowIndex ?>_s1" id="x<?= $Page->RowIndex ?>_s1" size="30" maxlength="255" value="<?= $Page->s1->EditValue ?>"<?= $Page->s1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->s1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s1" data-hidden="1" name="o<?= $Page->RowIndex ?>_s1" id="o<?= $Page->RowIndex ?>_s1" value="<?= HtmlEncode($Page->s1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->s2->Visible) { // s2 ?>
        <td data-name="s2">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s2" class="form-group pengasuhppwanita_s2">
<input type="<?= $Page->s2->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s2" name="x<?= $Page->RowIndex ?>_s2" id="x<?= $Page->RowIndex ?>_s2" size="30" maxlength="255" value="<?= $Page->s2->EditValue ?>"<?= $Page->s2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->s2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s2" data-hidden="1" name="o<?= $Page->RowIndex ?>_s2" id="o<?= $Page->RowIndex ?>_s2" value="<?= HtmlEncode($Page->s2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->s3->Visible) { // s3 ?>
        <td data-name="s3">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s3" class="form-group pengasuhppwanita_s3">
<input type="<?= $Page->s3->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s3" name="x<?= $Page->RowIndex ?>_s3" id="x<?= $Page->RowIndex ?>_s3" size="30" maxlength="255" value="<?= $Page->s3->EditValue ?>"<?= $Page->s3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->s3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s3" data-hidden="1" name="o<?= $Page->RowIndex ?>_s3" id="o<?= $Page->RowIndex ?>_s3" value="<?= HtmlEncode($Page->s3->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->organisasi->Visible) { // organisasi ?>
        <td data-name="organisasi">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_organisasi" class="form-group pengasuhppwanita_organisasi">
<input type="<?= $Page->organisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_organisasi" name="x<?= $Page->RowIndex ?>_organisasi" id="x<?= $Page->RowIndex ?>_organisasi" size="30" maxlength="255" value="<?= $Page->organisasi->EditValue ?>"<?= $Page->organisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->organisasi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_organisasi" data-hidden="1" name="o<?= $Page->RowIndex ?>_organisasi" id="o<?= $Page->RowIndex ?>_organisasi" value="<?= HtmlEncode($Page->organisasi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <td data-name="jabatandiorganisasi">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_jabatandiorganisasi" class="form-group pengasuhppwanita_jabatandiorganisasi">
<input type="<?= $Page->jabatandiorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" name="x<?= $Page->RowIndex ?>_jabatandiorganisasi" id="x<?= $Page->RowIndex ?>_jabatandiorganisasi" size="30" maxlength="255" value="<?= $Page->jabatandiorganisasi->EditValue ?>"<?= $Page->jabatandiorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->jabatandiorganisasi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" data-hidden="1" name="o<?= $Page->RowIndex ?>_jabatandiorganisasi" id="o<?= $Page->RowIndex ?>_jabatandiorganisasi" value="<?= HtmlEncode($Page->jabatandiorganisasi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <td data-name="tglawalorganisasi">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_tglawalorganisasi" class="form-group pengasuhppwanita_tglawalorganisasi">
<input type="<?= $Page->tglawalorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-format="7" name="x<?= $Page->RowIndex ?>_tglawalorganisasi" id="x<?= $Page->RowIndex ?>_tglawalorganisasi" value="<?= $Page->tglawalorganisasi->EditValue ?>"<?= $Page->tglawalorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tglawalorganisasi->getErrorMessage() ?></div>
<?php if (!$Page->tglawalorganisasi->ReadOnly && !$Page->tglawalorganisasi->Disabled && !isset($Page->tglawalorganisasi->EditAttrs["readonly"]) && !isset($Page->tglawalorganisasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitalist", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitalist", "x<?= $Page->RowIndex ?>_tglawalorganisasi", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-hidden="1" name="o<?= $Page->RowIndex ?>_tglawalorganisasi" id="o<?= $Page->RowIndex ?>_tglawalorganisasi" value="<?= HtmlEncode($Page->tglawalorganisasi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->pemerintah->Visible) { // pemerintah ?>
        <td data-name="pemerintah">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pemerintah" class="form-group pengasuhppwanita_pemerintah">
<input type="<?= $Page->pemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pemerintah" name="x<?= $Page->RowIndex ?>_pemerintah" id="x<?= $Page->RowIndex ?>_pemerintah" size="30" maxlength="255" value="<?= $Page->pemerintah->EditValue ?>"<?= $Page->pemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->pemerintah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pemerintah" data-hidden="1" name="o<?= $Page->RowIndex ?>_pemerintah" id="o<?= $Page->RowIndex ?>_pemerintah" value="<?= HtmlEncode($Page->pemerintah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <td data-name="jabatandipemerintah">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_jabatandipemerintah" class="form-group pengasuhppwanita_jabatandipemerintah">
<input type="<?= $Page->jabatandipemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" name="x<?= $Page->RowIndex ?>_jabatandipemerintah" id="x<?= $Page->RowIndex ?>_jabatandipemerintah" size="30" maxlength="255" value="<?= $Page->jabatandipemerintah->EditValue ?>"<?= $Page->jabatandipemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->jabatandipemerintah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" data-hidden="1" name="o<?= $Page->RowIndex ?>_jabatandipemerintah" id="o<?= $Page->RowIndex ?>_jabatandipemerintah" value="<?= HtmlEncode($Page->jabatandipemerintah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
        <td data-name="tglmenjabat">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_tglmenjabat" class="form-group pengasuhppwanita_tglmenjabat">
<input type="<?= $Page->tglmenjabat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglmenjabat" name="x<?= $Page->RowIndex ?>_tglmenjabat" id="x<?= $Page->RowIndex ?>_tglmenjabat" value="<?= $Page->tglmenjabat->EditValue ?>"<?= $Page->tglmenjabat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tglmenjabat->getErrorMessage() ?></div>
<?php if (!$Page->tglmenjabat->ReadOnly && !$Page->tglmenjabat->Disabled && !isset($Page->tglmenjabat->EditAttrs["readonly"]) && !isset($Page->tglmenjabat->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitalist", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitalist", "x<?= $Page->RowIndex ?>_tglmenjabat", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglmenjabat" data-hidden="1" name="o<?= $Page->RowIndex ?>_tglmenjabat" id="o<?= $Page->RowIndex ?>_tglmenjabat" value="<?= HtmlEncode($Page->tglmenjabat->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->foto->Visible) { // foto ?>
        <td data-name="foto">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_foto" class="form-group pengasuhppwanita_foto">
<div id="fd_x<?= $Page->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="pengasuhppwanita" data-field="x_foto" name="x<?= $Page->RowIndex ?>_foto" id="x<?= $Page->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_foto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_foto" id= "fn_x<?= $Page->RowIndex ?>_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_foto" id= "fa_x<?= $Page->RowIndex ?>_foto" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_foto" id= "fs_x<?= $Page->RowIndex ?>_foto" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_foto" id= "fx_x<?= $Page->RowIndex ?>_foto" value="<?= $Page->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_foto" id= "fm_x<?= $Page->RowIndex ?>_foto" value="<?= $Page->foto->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Page->RowIndex ?>_foto" id= "fc_x<?= $Page->RowIndex ?>_foto" value="<?= $Page->foto->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_foto" data-hidden="1" name="o<?= $Page->RowIndex ?>_foto" id="o<?= $Page->RowIndex ?>_foto" value="<?= HtmlEncode($Page->foto->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->ijazah->Visible) { // ijazah ?>
        <td data-name="ijazah">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_ijazah" class="form-group pengasuhppwanita_ijazah">
<div id="fd_x<?= $Page->RowIndex ?>_ijazah">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->ijazah->title() ?>" data-table="pengasuhppwanita" data-field="x_ijazah" name="x<?= $Page->RowIndex ?>_ijazah" id="x<?= $Page->RowIndex ?>_ijazah" lang="<?= CurrentLanguageID() ?>"<?= $Page->ijazah->editAttributes() ?><?= ($Page->ijazah->ReadOnly || $Page->ijazah->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_ijazah"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->ijazah->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_ijazah" id= "fn_x<?= $Page->RowIndex ?>_ijazah" value="<?= $Page->ijazah->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_ijazah" id= "fa_x<?= $Page->RowIndex ?>_ijazah" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_ijazah" id= "fs_x<?= $Page->RowIndex ?>_ijazah" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_ijazah" id= "fx_x<?= $Page->RowIndex ?>_ijazah" value="<?= $Page->ijazah->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_ijazah" id= "fm_x<?= $Page->RowIndex ?>_ijazah" value="<?= $Page->ijazah->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_ijazah" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ijazah" data-hidden="1" name="o<?= $Page->RowIndex ?>_ijazah" id="o<?= $Page->RowIndex ?>_ijazah" value="<?= HtmlEncode($Page->ijazah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->sertifikat->Visible) { // sertifikat ?>
        <td data-name="sertifikat">
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_sertifikat" class="form-group pengasuhppwanita_sertifikat">
<div id="fd_x<?= $Page->RowIndex ?>_sertifikat">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->sertifikat->title() ?>" data-table="pengasuhppwanita" data-field="x_sertifikat" name="x<?= $Page->RowIndex ?>_sertifikat" id="x<?= $Page->RowIndex ?>_sertifikat" lang="<?= CurrentLanguageID() ?>"<?= $Page->sertifikat->editAttributes() ?><?= ($Page->sertifikat->ReadOnly || $Page->sertifikat->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_sertifikat"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->sertifikat->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_sertifikat" id= "fn_x<?= $Page->RowIndex ?>_sertifikat" value="<?= $Page->sertifikat->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_sertifikat" id= "fa_x<?= $Page->RowIndex ?>_sertifikat" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_sertifikat" id= "fs_x<?= $Page->RowIndex ?>_sertifikat" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_sertifikat" id= "fx_x<?= $Page->RowIndex ?>_sertifikat" value="<?= $Page->sertifikat->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_sertifikat" id= "fm_x<?= $Page->RowIndex ?>_sertifikat" value="<?= $Page->sertifikat->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_sertifikat" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_sertifikat" data-hidden="1" name="o<?= $Page->RowIndex ?>_sertifikat" id="o<?= $Page->RowIndex ?>_sertifikat" value="<?= HtmlEncode($Page->sertifikat->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["fpengasuhppwanitalist","load"], function() {
    fpengasuhppwanitalist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
$Page->EditRowCount = 0;
if ($Page->isEdit())
    $Page->RowIndex = 1;
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view
        if ($Page->isEdit()) {
            if ($Page->checkInlineEditKey() && $Page->EditRowCount == 0) { // Inline edit
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isEdit() && $Page->RowType == ROWTYPE_EDIT && $Page->EventCancelled) { // Update failed
            $CurrentForm->Index = 1;
            $Page->restoreFormValues(); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_pengasuhppwanita", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pid" class="form-group">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_pid" name="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pid" class="form-group">
<?php
$onchange = $Page->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Page->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_pid" id="sv_x<?= $Page->RowIndex ?>_pid" value="<?= RemoveHtml($Page->pid->EditValue) ?>" size="30"<?= $Page->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="pengasuhppwanita" data-field="x_pid" data-input="sv_x<?= $Page->RowIndex ?>_pid" data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_pid" id="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fpengasuhppwanitalist"], function() {
    fpengasuhppwanitalist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.pengasuhppwanita.fields.pid.autoSuggestOptions));
});
</script>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_pid") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_nama" class="form-group">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nama" name="x<?= $Page->RowIndex ?>_nama" id="x<?= $Page->RowIndex ?>_nama" size="30" maxlength="255" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->nik->Visible) { // nik ?>
        <td data-name="nik" <?= $Page->nik->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_nik" class="form-group">
<input type="<?= $Page->nik->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nik" name="x<?= $Page->RowIndex ?>_nik" id="x<?= $Page->RowIndex ?>_nik" size="30" maxlength="255" value="<?= $Page->nik->EditValue ?>"<?= $Page->nik->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nik->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_nik">
<span<?= $Page->nik->viewAttributes() ?>>
<?= $Page->nik->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->alamat->Visible) { // alamat ?>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_alamat" class="form-group">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_alamat" name="x<?= $Page->RowIndex ?>_alamat" id="x<?= $Page->RowIndex ?>_alamat" size="30" maxlength="255" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->hp->Visible) { // hp ?>
        <td data-name="hp" <?= $Page->hp->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_hp" class="form-group">
<input type="<?= $Page->hp->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_hp" name="x<?= $Page->RowIndex ?>_hp" id="x<?= $Page->RowIndex ?>_hp" size="30" maxlength="255" value="<?= $Page->hp->EditValue ?>"<?= $Page->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->hp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_hp">
<span<?= $Page->hp->viewAttributes() ?>>
<?= $Page->hp->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->md->Visible) { // md ?>
        <td data-name="md" <?= $Page->md->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_md" class="form-group">
<input type="<?= $Page->md->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_md" name="x<?= $Page->RowIndex ?>_md" id="x<?= $Page->RowIndex ?>_md" size="30" maxlength="255" value="<?= $Page->md->EditValue ?>"<?= $Page->md->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->md->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_md">
<span<?= $Page->md->viewAttributes() ?>>
<?= $Page->md->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->mts->Visible) { // mts ?>
        <td data-name="mts" <?= $Page->mts->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_mts" class="form-group">
<input type="<?= $Page->mts->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_mts" name="x<?= $Page->RowIndex ?>_mts" id="x<?= $Page->RowIndex ?>_mts" size="30" maxlength="255" value="<?= $Page->mts->EditValue ?>"<?= $Page->mts->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->mts->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_mts">
<span<?= $Page->mts->viewAttributes() ?>>
<?= $Page->mts->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ma->Visible) { // ma ?>
        <td data-name="ma" <?= $Page->ma->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_ma" class="form-group">
<input type="<?= $Page->ma->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_ma" name="x<?= $Page->RowIndex ?>_ma" id="x<?= $Page->RowIndex ?>_ma" size="30" maxlength="255" value="<?= $Page->ma->EditValue ?>"<?= $Page->ma->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ma->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_ma">
<span<?= $Page->ma->viewAttributes() ?>>
<?= $Page->ma->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->pesantren->Visible) { // pesantren ?>
        <td data-name="pesantren" <?= $Page->pesantren->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pesantren" class="form-group">
<input type="<?= $Page->pesantren->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pesantren" name="x<?= $Page->RowIndex ?>_pesantren" id="x<?= $Page->RowIndex ?>_pesantren" size="30" maxlength="255" value="<?= $Page->pesantren->EditValue ?>"<?= $Page->pesantren->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->pesantren->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pesantren">
<span<?= $Page->pesantren->viewAttributes() ?>>
<?= $Page->pesantren->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->s1->Visible) { // s1 ?>
        <td data-name="s1" <?= $Page->s1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s1" class="form-group">
<input type="<?= $Page->s1->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s1" name="x<?= $Page->RowIndex ?>_s1" id="x<?= $Page->RowIndex ?>_s1" size="30" maxlength="255" value="<?= $Page->s1->EditValue ?>"<?= $Page->s1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->s1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s1">
<span<?= $Page->s1->viewAttributes() ?>>
<?= $Page->s1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->s2->Visible) { // s2 ?>
        <td data-name="s2" <?= $Page->s2->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s2" class="form-group">
<input type="<?= $Page->s2->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s2" name="x<?= $Page->RowIndex ?>_s2" id="x<?= $Page->RowIndex ?>_s2" size="30" maxlength="255" value="<?= $Page->s2->EditValue ?>"<?= $Page->s2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->s2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s2">
<span<?= $Page->s2->viewAttributes() ?>>
<?= $Page->s2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->s3->Visible) { // s3 ?>
        <td data-name="s3" <?= $Page->s3->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s3" class="form-group">
<input type="<?= $Page->s3->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s3" name="x<?= $Page->RowIndex ?>_s3" id="x<?= $Page->RowIndex ?>_s3" size="30" maxlength="255" value="<?= $Page->s3->EditValue ?>"<?= $Page->s3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->s3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_s3">
<span<?= $Page->s3->viewAttributes() ?>>
<?= $Page->s3->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->organisasi->Visible) { // organisasi ?>
        <td data-name="organisasi" <?= $Page->organisasi->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_organisasi" class="form-group">
<input type="<?= $Page->organisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_organisasi" name="x<?= $Page->RowIndex ?>_organisasi" id="x<?= $Page->RowIndex ?>_organisasi" size="30" maxlength="255" value="<?= $Page->organisasi->EditValue ?>"<?= $Page->organisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->organisasi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_organisasi">
<span<?= $Page->organisasi->viewAttributes() ?>>
<?= $Page->organisasi->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <td data-name="jabatandiorganisasi" <?= $Page->jabatandiorganisasi->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_jabatandiorganisasi" class="form-group">
<input type="<?= $Page->jabatandiorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" name="x<?= $Page->RowIndex ?>_jabatandiorganisasi" id="x<?= $Page->RowIndex ?>_jabatandiorganisasi" size="30" maxlength="255" value="<?= $Page->jabatandiorganisasi->EditValue ?>"<?= $Page->jabatandiorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->jabatandiorganisasi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_jabatandiorganisasi">
<span<?= $Page->jabatandiorganisasi->viewAttributes() ?>>
<?= $Page->jabatandiorganisasi->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <td data-name="tglawalorganisasi" <?= $Page->tglawalorganisasi->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_tglawalorganisasi" class="form-group">
<input type="<?= $Page->tglawalorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-format="7" name="x<?= $Page->RowIndex ?>_tglawalorganisasi" id="x<?= $Page->RowIndex ?>_tglawalorganisasi" value="<?= $Page->tglawalorganisasi->EditValue ?>"<?= $Page->tglawalorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tglawalorganisasi->getErrorMessage() ?></div>
<?php if (!$Page->tglawalorganisasi->ReadOnly && !$Page->tglawalorganisasi->Disabled && !isset($Page->tglawalorganisasi->EditAttrs["readonly"]) && !isset($Page->tglawalorganisasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitalist", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitalist", "x<?= $Page->RowIndex ?>_tglawalorganisasi", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_tglawalorganisasi">
<span<?= $Page->tglawalorganisasi->viewAttributes() ?>>
<?= $Page->tglawalorganisasi->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->pemerintah->Visible) { // pemerintah ?>
        <td data-name="pemerintah" <?= $Page->pemerintah->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pemerintah" class="form-group">
<input type="<?= $Page->pemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pemerintah" name="x<?= $Page->RowIndex ?>_pemerintah" id="x<?= $Page->RowIndex ?>_pemerintah" size="30" maxlength="255" value="<?= $Page->pemerintah->EditValue ?>"<?= $Page->pemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->pemerintah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_pemerintah">
<span<?= $Page->pemerintah->viewAttributes() ?>>
<?= $Page->pemerintah->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <td data-name="jabatandipemerintah" <?= $Page->jabatandipemerintah->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_jabatandipemerintah" class="form-group">
<input type="<?= $Page->jabatandipemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" name="x<?= $Page->RowIndex ?>_jabatandipemerintah" id="x<?= $Page->RowIndex ?>_jabatandipemerintah" size="30" maxlength="255" value="<?= $Page->jabatandipemerintah->EditValue ?>"<?= $Page->jabatandipemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->jabatandipemerintah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_jabatandipemerintah">
<span<?= $Page->jabatandipemerintah->viewAttributes() ?>>
<?= $Page->jabatandipemerintah->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->tglmenjabat->Visible) { // tglmenjabat ?>
        <td data-name="tglmenjabat" <?= $Page->tglmenjabat->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_tglmenjabat" class="form-group">
<input type="<?= $Page->tglmenjabat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglmenjabat" name="x<?= $Page->RowIndex ?>_tglmenjabat" id="x<?= $Page->RowIndex ?>_tglmenjabat" value="<?= $Page->tglmenjabat->EditValue ?>"<?= $Page->tglmenjabat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->tglmenjabat->getErrorMessage() ?></div>
<?php if (!$Page->tglmenjabat->ReadOnly && !$Page->tglmenjabat->Disabled && !isset($Page->tglmenjabat->EditAttrs["readonly"]) && !isset($Page->tglmenjabat->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitalist", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitalist", "x<?= $Page->RowIndex ?>_tglmenjabat", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_tglmenjabat">
<span<?= $Page->tglmenjabat->viewAttributes() ?>>
<?= $Page->tglmenjabat->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->foto->Visible) { // foto ?>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_foto" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="pengasuhppwanita" data-field="x_foto" name="x<?= $Page->RowIndex ?>_foto" id="x<?= $Page->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_foto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_foto" id= "fn_x<?= $Page->RowIndex ?>_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_foto" id= "fa_x<?= $Page->RowIndex ?>_foto" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_foto") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_foto" id= "fs_x<?= $Page->RowIndex ?>_foto" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_foto" id= "fx_x<?= $Page->RowIndex ?>_foto" value="<?= $Page->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_foto" id= "fm_x<?= $Page->RowIndex ?>_foto" value="<?= $Page->foto->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Page->RowIndex ?>_foto" id= "fc_x<?= $Page->RowIndex ?>_foto" value="<?= $Page->foto->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->ijazah->Visible) { // ijazah ?>
        <td data-name="ijazah" <?= $Page->ijazah->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_ijazah" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_ijazah">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->ijazah->title() ?>" data-table="pengasuhppwanita" data-field="x_ijazah" name="x<?= $Page->RowIndex ?>_ijazah" id="x<?= $Page->RowIndex ?>_ijazah" lang="<?= CurrentLanguageID() ?>"<?= $Page->ijazah->editAttributes() ?><?= ($Page->ijazah->ReadOnly || $Page->ijazah->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_ijazah"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->ijazah->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_ijazah" id= "fn_x<?= $Page->RowIndex ?>_ijazah" value="<?= $Page->ijazah->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_ijazah" id= "fa_x<?= $Page->RowIndex ?>_ijazah" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_ijazah") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_ijazah" id= "fs_x<?= $Page->RowIndex ?>_ijazah" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_ijazah" id= "fx_x<?= $Page->RowIndex ?>_ijazah" value="<?= $Page->ijazah->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_ijazah" id= "fm_x<?= $Page->RowIndex ?>_ijazah" value="<?= $Page->ijazah->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_ijazah" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_ijazah">
<span<?= $Page->ijazah->viewAttributes() ?>>
<?= GetFileViewTag($Page->ijazah, $Page->ijazah->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->sertifikat->Visible) { // sertifikat ?>
        <td data-name="sertifikat" <?= $Page->sertifikat->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_sertifikat" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_sertifikat">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->sertifikat->title() ?>" data-table="pengasuhppwanita" data-field="x_sertifikat" name="x<?= $Page->RowIndex ?>_sertifikat" id="x<?= $Page->RowIndex ?>_sertifikat" lang="<?= CurrentLanguageID() ?>"<?= $Page->sertifikat->editAttributes() ?><?= ($Page->sertifikat->ReadOnly || $Page->sertifikat->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_sertifikat"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->sertifikat->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_sertifikat" id= "fn_x<?= $Page->RowIndex ?>_sertifikat" value="<?= $Page->sertifikat->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_sertifikat" id= "fa_x<?= $Page->RowIndex ?>_sertifikat" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_sertifikat") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_sertifikat" id= "fs_x<?= $Page->RowIndex ?>_sertifikat" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_sertifikat" id= "fx_x<?= $Page->RowIndex ?>_sertifikat" value="<?= $Page->sertifikat->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_sertifikat" id= "fm_x<?= $Page->RowIndex ?>_sertifikat" value="<?= $Page->sertifikat->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_sertifikat" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_pengasuhppwanita_sertifikat">
<span<?= $Page->sertifikat->viewAttributes() ?>>
<?= GetFileViewTag($Page->sertifikat, $Page->sertifikat->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fpengasuhppwanitalist","load"], function () {
    fpengasuhppwanitalist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isAdd() || $Page->isCopy()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("pengasuhppwanita");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
