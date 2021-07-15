<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitasusahaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ffasilitasusahalist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    ffasilitasusahalist = currentForm = new ew.Form("ffasilitasusahalist", "list");
    ffasilitasusahalist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "fasilitasusaha")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.fasilitasusaha)
        ew.vars.tables.fasilitasusaha = currentTable;
    ffasilitasusahalist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
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
        var f = ffasilitasusahalist,
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
    ffasilitasusahalist.validate = function () {
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
    ffasilitasusahalist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffasilitasusahalist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ffasilitasusahalist.lists.pid = <?= $Page->pid->toClientList($Page) ?>;
    ffasilitasusahalist.lists.badanhukum = <?= $Page->badanhukum->toClientList($Page) ?>;
    loadjs.done("ffasilitasusahalist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fasilitasusaha">
<form name="ffasilitasusahalist" id="ffasilitasusahalist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fasilitasusaha">
<?php if ($Page->getCurrentMasterTable() == "pesantren" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pesantren">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_fasilitasusaha" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_fasilitasusahalist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_fasilitasusaha_id" class="fasilitasusaha_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Page->pid->headerCellClass() ?>"><div id="elh_fasilitasusaha_pid" class="fasilitasusaha_pid"><?= $Page->renderSort($Page->pid) ?></div></th>
<?php } ?>
<?php if ($Page->namausaha->Visible) { // namausaha ?>
        <th data-name="namausaha" class="<?= $Page->namausaha->headerCellClass() ?>"><div id="elh_fasilitasusaha_namausaha" class="fasilitasusaha_namausaha"><?= $Page->renderSort($Page->namausaha) ?></div></th>
<?php } ?>
<?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
        <th data-name="bidangusaha" class="<?= $Page->bidangusaha->headerCellClass() ?>"><div id="elh_fasilitasusaha_bidangusaha" class="fasilitasusaha_bidangusaha"><?= $Page->renderSort($Page->bidangusaha) ?></div></th>
<?php } ?>
<?php if ($Page->badanhukum->Visible) { // badanhukum ?>
        <th data-name="badanhukum" class="<?= $Page->badanhukum->headerCellClass() ?>"><div id="elh_fasilitasusaha_badanhukum" class="fasilitasusaha_badanhukum"><?= $Page->renderSort($Page->badanhukum) ?></div></th>
<?php } ?>
<?php if ($Page->siup->Visible) { // siup ?>
        <th data-name="siup" class="<?= $Page->siup->headerCellClass() ?>"><div id="elh_fasilitasusaha_siup" class="fasilitasusaha_siup"><?= $Page->renderSort($Page->siup) ?></div></th>
<?php } ?>
<?php if ($Page->bpom->Visible) { // bpom ?>
        <th data-name="bpom" class="<?= $Page->bpom->headerCellClass() ?>"><div id="elh_fasilitasusaha_bpom" class="fasilitasusaha_bpom"><?= $Page->renderSort($Page->bpom) ?></div></th>
<?php } ?>
<?php if ($Page->irt->Visible) { // irt ?>
        <th data-name="irt" class="<?= $Page->irt->headerCellClass() ?>"><div id="elh_fasilitasusaha_irt" class="fasilitasusaha_irt"><?= $Page->renderSort($Page->irt) ?></div></th>
<?php } ?>
<?php if ($Page->potensiblm->Visible) { // potensiblm ?>
        <th data-name="potensiblm" class="<?= $Page->potensiblm->headerCellClass() ?>"><div id="elh_fasilitasusaha_potensiblm" class="fasilitasusaha_potensiblm"><?= $Page->renderSort($Page->potensiblm) ?></div></th>
<?php } ?>
<?php if ($Page->aset->Visible) { // aset ?>
        <th data-name="aset" class="<?= $Page->aset->headerCellClass() ?>"><div id="elh_fasilitasusaha_aset" class="fasilitasusaha_aset"><?= $Page->renderSort($Page->aset) ?></div></th>
<?php } ?>
<?php if ($Page->_modal->Visible) { // modal ?>
        <th data-name="_modal" class="<?= $Page->_modal->headerCellClass() ?>"><div id="elh_fasilitasusaha__modal" class="fasilitasusaha__modal"><?= $Page->renderSort($Page->_modal) ?></div></th>
<?php } ?>
<?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
        <th data-name="hasilsetahun" class="<?= $Page->hasilsetahun->headerCellClass() ?>"><div id="elh_fasilitasusaha_hasilsetahun" class="fasilitasusaha_hasilsetahun"><?= $Page->renderSort($Page->hasilsetahun) ?></div></th>
<?php } ?>
<?php if ($Page->kendala->Visible) { // kendala ?>
        <th data-name="kendala" class="<?= $Page->kendala->headerCellClass() ?>"><div id="elh_fasilitasusaha_kendala" class="fasilitasusaha_kendala"><?= $Page->renderSort($Page->kendala) ?></div></th>
<?php } ?>
<?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <th data-name="fasilitasperlu" class="<?= $Page->fasilitasperlu->headerCellClass() ?>"><div id="elh_fasilitasusaha_fasilitasperlu" class="fasilitasusaha_fasilitasperlu"><?= $Page->renderSort($Page->fasilitasperlu) ?></div></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th data-name="foto" class="<?= $Page->foto->headerCellClass() ?>"><div id="elh_fasilitasusaha_foto" class="fasilitasusaha_foto"><?= $Page->renderSort($Page->foto) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_fasilitasusaha", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_id" class="form-group fasilitasusaha_id"></span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->pid->Visible) { // pid ?>
        <td data-name="pid">
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_pid" class="form-group fasilitasusaha_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_pid" name="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_pid" class="form-group fasilitasusaha_pid">
<?php
$onchange = $Page->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Page->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_pid" id="sv_x<?= $Page->RowIndex ?>_pid" value="<?= RemoveHtml($Page->pid->EditValue) ?>" size="30"<?= $Page->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="fasilitasusaha" data-field="x_pid" data-input="sv_x<?= $Page->RowIndex ?>_pid" data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_pid" id="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["ffasilitasusahalist"], function() {
    ffasilitasusahalist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.fasilitasusaha.fields.pid.autoSuggestOptions));
});
</script>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_pid") ?>
</span>
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_pid" data-hidden="1" name="o<?= $Page->RowIndex ?>_pid" id="o<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->namausaha->Visible) { // namausaha ?>
        <td data-name="namausaha">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_namausaha" class="form-group fasilitasusaha_namausaha">
<input type="<?= $Page->namausaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_namausaha" name="x<?= $Page->RowIndex ?>_namausaha" id="x<?= $Page->RowIndex ?>_namausaha" size="30" maxlength="255" value="<?= $Page->namausaha->EditValue ?>"<?= $Page->namausaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->namausaha->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_namausaha" data-hidden="1" name="o<?= $Page->RowIndex ?>_namausaha" id="o<?= $Page->RowIndex ?>_namausaha" value="<?= HtmlEncode($Page->namausaha->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
        <td data-name="bidangusaha">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_bidangusaha" class="form-group fasilitasusaha_bidangusaha">
<input type="<?= $Page->bidangusaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bidangusaha" name="x<?= $Page->RowIndex ?>_bidangusaha" id="x<?= $Page->RowIndex ?>_bidangusaha" size="30" maxlength="255" value="<?= $Page->bidangusaha->EditValue ?>"<?= $Page->bidangusaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bidangusaha->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bidangusaha" data-hidden="1" name="o<?= $Page->RowIndex ?>_bidangusaha" id="o<?= $Page->RowIndex ?>_bidangusaha" value="<?= HtmlEncode($Page->bidangusaha->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->badanhukum->Visible) { // badanhukum ?>
        <td data-name="badanhukum">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_badanhukum" class="form-group fasilitasusaha_badanhukum">
    <select
        id="x<?= $Page->RowIndex ?>_badanhukum"
        name="x<?= $Page->RowIndex ?>_badanhukum"
        class="form-control ew-select<?= $Page->badanhukum->isInvalidClass() ?>"
        data-select2-id="fasilitasusaha_x<?= $Page->RowIndex ?>_badanhukum"
        data-table="fasilitasusaha"
        data-field="x_badanhukum"
        data-value-separator="<?= $Page->badanhukum->displayValueSeparatorAttribute() ?>"
        <?= $Page->badanhukum->editAttributes() ?>>
        <?= $Page->badanhukum->selectOptionListHtml("x{$Page->RowIndex}_badanhukum") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->badanhukum->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='fasilitasusaha_x<?= $Page->RowIndex ?>_badanhukum']"),
        options = { name: "x<?= $Page->RowIndex ?>_badanhukum", selectId: "fasilitasusaha_x<?= $Page->RowIndex ?>_badanhukum", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.fasilitasusaha.fields.badanhukum.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.fasilitasusaha.fields.badanhukum.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_badanhukum" data-hidden="1" name="o<?= $Page->RowIndex ?>_badanhukum" id="o<?= $Page->RowIndex ?>_badanhukum" value="<?= HtmlEncode($Page->badanhukum->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->siup->Visible) { // siup ?>
        <td data-name="siup">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_siup" class="form-group fasilitasusaha_siup">
<input type="<?= $Page->siup->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_siup" name="x<?= $Page->RowIndex ?>_siup" id="x<?= $Page->RowIndex ?>_siup" size="30" maxlength="255" value="<?= $Page->siup->EditValue ?>"<?= $Page->siup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->siup->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_siup" data-hidden="1" name="o<?= $Page->RowIndex ?>_siup" id="o<?= $Page->RowIndex ?>_siup" value="<?= HtmlEncode($Page->siup->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->bpom->Visible) { // bpom ?>
        <td data-name="bpom">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_bpom" class="form-group fasilitasusaha_bpom">
<input type="<?= $Page->bpom->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bpom" name="x<?= $Page->RowIndex ?>_bpom" id="x<?= $Page->RowIndex ?>_bpom" size="30" maxlength="255" value="<?= $Page->bpom->EditValue ?>"<?= $Page->bpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bpom->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bpom" data-hidden="1" name="o<?= $Page->RowIndex ?>_bpom" id="o<?= $Page->RowIndex ?>_bpom" value="<?= HtmlEncode($Page->bpom->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->irt->Visible) { // irt ?>
        <td data-name="irt">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_irt" class="form-group fasilitasusaha_irt">
<input type="<?= $Page->irt->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_irt" name="x<?= $Page->RowIndex ?>_irt" id="x<?= $Page->RowIndex ?>_irt" size="30" maxlength="255" value="<?= $Page->irt->EditValue ?>"<?= $Page->irt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->irt->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_irt" data-hidden="1" name="o<?= $Page->RowIndex ?>_irt" id="o<?= $Page->RowIndex ?>_irt" value="<?= HtmlEncode($Page->irt->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->potensiblm->Visible) { // potensiblm ?>
        <td data-name="potensiblm">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_potensiblm" class="form-group fasilitasusaha_potensiblm">
<input type="<?= $Page->potensiblm->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_potensiblm" name="x<?= $Page->RowIndex ?>_potensiblm" id="x<?= $Page->RowIndex ?>_potensiblm" size="30" maxlength="255" value="<?= $Page->potensiblm->EditValue ?>"<?= $Page->potensiblm->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->potensiblm->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_potensiblm" data-hidden="1" name="o<?= $Page->RowIndex ?>_potensiblm" id="o<?= $Page->RowIndex ?>_potensiblm" value="<?= HtmlEncode($Page->potensiblm->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->aset->Visible) { // aset ?>
        <td data-name="aset">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_aset" class="form-group fasilitasusaha_aset">
<input type="<?= $Page->aset->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_aset" name="x<?= $Page->RowIndex ?>_aset" id="x<?= $Page->RowIndex ?>_aset" size="30" maxlength="255" value="<?= $Page->aset->EditValue ?>"<?= $Page->aset->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->aset->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_aset" data-hidden="1" name="o<?= $Page->RowIndex ?>_aset" id="o<?= $Page->RowIndex ?>_aset" value="<?= HtmlEncode($Page->aset->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_modal->Visible) { // modal ?>
        <td data-name="_modal">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha__modal" class="form-group fasilitasusaha__modal">
<input type="<?= $Page->_modal->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x__modal" name="x<?= $Page->RowIndex ?>__modal" id="x<?= $Page->RowIndex ?>__modal" size="30" maxlength="255" value="<?= $Page->_modal->EditValue ?>"<?= $Page->_modal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_modal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x__modal" data-hidden="1" name="o<?= $Page->RowIndex ?>__modal" id="o<?= $Page->RowIndex ?>__modal" value="<?= HtmlEncode($Page->_modal->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
        <td data-name="hasilsetahun">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_hasilsetahun" class="form-group fasilitasusaha_hasilsetahun">
<input type="<?= $Page->hasilsetahun->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_hasilsetahun" name="x<?= $Page->RowIndex ?>_hasilsetahun" id="x<?= $Page->RowIndex ?>_hasilsetahun" size="30" maxlength="255" value="<?= $Page->hasilsetahun->EditValue ?>"<?= $Page->hasilsetahun->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->hasilsetahun->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_hasilsetahun" data-hidden="1" name="o<?= $Page->RowIndex ?>_hasilsetahun" id="o<?= $Page->RowIndex ?>_hasilsetahun" value="<?= HtmlEncode($Page->hasilsetahun->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->kendala->Visible) { // kendala ?>
        <td data-name="kendala">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_kendala" class="form-group fasilitasusaha_kendala">
<input type="<?= $Page->kendala->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_kendala" name="x<?= $Page->RowIndex ?>_kendala" id="x<?= $Page->RowIndex ?>_kendala" size="30" maxlength="255" value="<?= $Page->kendala->EditValue ?>"<?= $Page->kendala->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->kendala->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_kendala" data-hidden="1" name="o<?= $Page->RowIndex ?>_kendala" id="o<?= $Page->RowIndex ?>_kendala" value="<?= HtmlEncode($Page->kendala->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <td data-name="fasilitasperlu">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_fasilitasperlu" class="form-group fasilitasusaha_fasilitasperlu">
<textarea data-table="fasilitasusaha" data-field="x_fasilitasperlu" name="x<?= $Page->RowIndex ?>_fasilitasperlu" id="x<?= $Page->RowIndex ?>_fasilitasperlu" cols="3" rows="4"<?= $Page->fasilitasperlu->editAttributes() ?>><?= $Page->fasilitasperlu->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->fasilitasperlu->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_fasilitasperlu" data-hidden="1" name="o<?= $Page->RowIndex ?>_fasilitasperlu" id="o<?= $Page->RowIndex ?>_fasilitasperlu" value="<?= HtmlEncode($Page->fasilitasperlu->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->foto->Visible) { // foto ?>
        <td data-name="foto">
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_foto" class="form-group fasilitasusaha_foto">
<div id="fd_x<?= $Page->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="fasilitasusaha" data-field="x_foto" name="x<?= $Page->RowIndex ?>_foto" id="x<?= $Page->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?>>
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
<input type="hidden" data-table="fasilitasusaha" data-field="x_foto" data-hidden="1" name="o<?= $Page->RowIndex ?>_foto" id="o<?= $Page->RowIndex ?>_foto" value="<?= HtmlEncode($Page->foto->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["ffasilitasusahalist","load"], function() {
    ffasilitasusahalist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_fasilitasusaha", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_pid" class="form-group">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_pid" name="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_pid" class="form-group">
<?php
$onchange = $Page->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Page->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Page->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_pid" id="sv_x<?= $Page->RowIndex ?>_pid" value="<?= RemoveHtml($Page->pid->EditValue) ?>" size="30"<?= $Page->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="fasilitasusaha" data-field="x_pid" data-input="sv_x<?= $Page->RowIndex ?>_pid" data-value-separator="<?= $Page->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_pid" id="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["ffasilitasusahalist"], function() {
    ffasilitasusahalist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.fasilitasusaha.fields.pid.autoSuggestOptions));
});
</script>
<?= $Page->pid->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_pid") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->namausaha->Visible) { // namausaha ?>
        <td data-name="namausaha" <?= $Page->namausaha->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_namausaha" class="form-group">
<input type="<?= $Page->namausaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_namausaha" name="x<?= $Page->RowIndex ?>_namausaha" id="x<?= $Page->RowIndex ?>_namausaha" size="30" maxlength="255" value="<?= $Page->namausaha->EditValue ?>"<?= $Page->namausaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->namausaha->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_namausaha">
<span<?= $Page->namausaha->viewAttributes() ?>>
<?= $Page->namausaha->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->bidangusaha->Visible) { // bidangusaha ?>
        <td data-name="bidangusaha" <?= $Page->bidangusaha->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_bidangusaha" class="form-group">
<input type="<?= $Page->bidangusaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bidangusaha" name="x<?= $Page->RowIndex ?>_bidangusaha" id="x<?= $Page->RowIndex ?>_bidangusaha" size="30" maxlength="255" value="<?= $Page->bidangusaha->EditValue ?>"<?= $Page->bidangusaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bidangusaha->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_bidangusaha">
<span<?= $Page->bidangusaha->viewAttributes() ?>>
<?= $Page->bidangusaha->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->badanhukum->Visible) { // badanhukum ?>
        <td data-name="badanhukum" <?= $Page->badanhukum->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_badanhukum" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_badanhukum"
        name="x<?= $Page->RowIndex ?>_badanhukum"
        class="form-control ew-select<?= $Page->badanhukum->isInvalidClass() ?>"
        data-select2-id="fasilitasusaha_x<?= $Page->RowIndex ?>_badanhukum"
        data-table="fasilitasusaha"
        data-field="x_badanhukum"
        data-value-separator="<?= $Page->badanhukum->displayValueSeparatorAttribute() ?>"
        <?= $Page->badanhukum->editAttributes() ?>>
        <?= $Page->badanhukum->selectOptionListHtml("x{$Page->RowIndex}_badanhukum") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->badanhukum->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='fasilitasusaha_x<?= $Page->RowIndex ?>_badanhukum']"),
        options = { name: "x<?= $Page->RowIndex ?>_badanhukum", selectId: "fasilitasusaha_x<?= $Page->RowIndex ?>_badanhukum", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.fasilitasusaha.fields.badanhukum.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.fasilitasusaha.fields.badanhukum.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_badanhukum">
<span<?= $Page->badanhukum->viewAttributes() ?>>
<?= $Page->badanhukum->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->siup->Visible) { // siup ?>
        <td data-name="siup" <?= $Page->siup->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_siup" class="form-group">
<input type="<?= $Page->siup->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_siup" name="x<?= $Page->RowIndex ?>_siup" id="x<?= $Page->RowIndex ?>_siup" size="30" maxlength="255" value="<?= $Page->siup->EditValue ?>"<?= $Page->siup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->siup->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_siup">
<span<?= $Page->siup->viewAttributes() ?>>
<?= $Page->siup->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->bpom->Visible) { // bpom ?>
        <td data-name="bpom" <?= $Page->bpom->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_bpom" class="form-group">
<input type="<?= $Page->bpom->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bpom" name="x<?= $Page->RowIndex ?>_bpom" id="x<?= $Page->RowIndex ?>_bpom" size="30" maxlength="255" value="<?= $Page->bpom->EditValue ?>"<?= $Page->bpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->bpom->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_bpom">
<span<?= $Page->bpom->viewAttributes() ?>>
<?= $Page->bpom->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->irt->Visible) { // irt ?>
        <td data-name="irt" <?= $Page->irt->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_irt" class="form-group">
<input type="<?= $Page->irt->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_irt" name="x<?= $Page->RowIndex ?>_irt" id="x<?= $Page->RowIndex ?>_irt" size="30" maxlength="255" value="<?= $Page->irt->EditValue ?>"<?= $Page->irt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->irt->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_irt">
<span<?= $Page->irt->viewAttributes() ?>>
<?= $Page->irt->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->potensiblm->Visible) { // potensiblm ?>
        <td data-name="potensiblm" <?= $Page->potensiblm->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_potensiblm" class="form-group">
<input type="<?= $Page->potensiblm->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_potensiblm" name="x<?= $Page->RowIndex ?>_potensiblm" id="x<?= $Page->RowIndex ?>_potensiblm" size="30" maxlength="255" value="<?= $Page->potensiblm->EditValue ?>"<?= $Page->potensiblm->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->potensiblm->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_potensiblm">
<span<?= $Page->potensiblm->viewAttributes() ?>>
<?= $Page->potensiblm->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->aset->Visible) { // aset ?>
        <td data-name="aset" <?= $Page->aset->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_aset" class="form-group">
<input type="<?= $Page->aset->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_aset" name="x<?= $Page->RowIndex ?>_aset" id="x<?= $Page->RowIndex ?>_aset" size="30" maxlength="255" value="<?= $Page->aset->EditValue ?>"<?= $Page->aset->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->aset->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_aset">
<span<?= $Page->aset->viewAttributes() ?>>
<?= $Page->aset->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_modal->Visible) { // modal ?>
        <td data-name="_modal" <?= $Page->_modal->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha__modal" class="form-group">
<input type="<?= $Page->_modal->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x__modal" name="x<?= $Page->RowIndex ?>__modal" id="x<?= $Page->RowIndex ?>__modal" size="30" maxlength="255" value="<?= $Page->_modal->EditValue ?>"<?= $Page->_modal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_modal->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha__modal">
<span<?= $Page->_modal->viewAttributes() ?>>
<?= $Page->_modal->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->hasilsetahun->Visible) { // hasilsetahun ?>
        <td data-name="hasilsetahun" <?= $Page->hasilsetahun->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_hasilsetahun" class="form-group">
<input type="<?= $Page->hasilsetahun->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_hasilsetahun" name="x<?= $Page->RowIndex ?>_hasilsetahun" id="x<?= $Page->RowIndex ?>_hasilsetahun" size="30" maxlength="255" value="<?= $Page->hasilsetahun->EditValue ?>"<?= $Page->hasilsetahun->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->hasilsetahun->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_hasilsetahun">
<span<?= $Page->hasilsetahun->viewAttributes() ?>>
<?= $Page->hasilsetahun->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->kendala->Visible) { // kendala ?>
        <td data-name="kendala" <?= $Page->kendala->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_kendala" class="form-group">
<input type="<?= $Page->kendala->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_kendala" name="x<?= $Page->RowIndex ?>_kendala" id="x<?= $Page->RowIndex ?>_kendala" size="30" maxlength="255" value="<?= $Page->kendala->EditValue ?>"<?= $Page->kendala->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->kendala->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_kendala">
<span<?= $Page->kendala->viewAttributes() ?>>
<?= $Page->kendala->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <td data-name="fasilitasperlu" <?= $Page->fasilitasperlu->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_fasilitasperlu" class="form-group">
<textarea data-table="fasilitasusaha" data-field="x_fasilitasperlu" name="x<?= $Page->RowIndex ?>_fasilitasperlu" id="x<?= $Page->RowIndex ?>_fasilitasperlu" cols="3" rows="4"<?= $Page->fasilitasperlu->editAttributes() ?>><?= $Page->fasilitasperlu->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->fasilitasperlu->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_fasilitasperlu">
<span<?= $Page->fasilitasperlu->viewAttributes() ?>>
<?= $Page->fasilitasperlu->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->foto->Visible) { // foto ?>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_foto" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="fasilitasusaha" data-field="x_foto" name="x<?= $Page->RowIndex ?>_foto" id="x<?= $Page->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?>>
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
<span id="el<?= $Page->RowCount ?>_fasilitasusaha_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= GetFileViewTag($Page->foto, $Page->foto->getViewValue(), false) ?>
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
loadjs.ready(["ffasilitasusahalist","load"], function () {
    ffasilitasusahalist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("fasilitasusaha");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
