<?php

namespace PHPMaker2021\nuportal;

// Page object
$FasilitaspesantrenList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ffasilitaspesantrenlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    ffasilitaspesantrenlist = currentForm = new ew.Form("ffasilitaspesantrenlist", "list");
    ffasilitaspesantrenlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "fasilitaspesantren")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.fasilitaspesantren)
        ew.vars.tables.fasilitaspesantren = currentTable;
    ffasilitaspesantrenlist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["namafasilitas", [fields.namafasilitas.visible && fields.namafasilitas.required ? ew.Validators.required(fields.namafasilitas.caption) : null], fields.namafasilitas.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["fotofasilitas", [fields.fotofasilitas.visible && fields.fotofasilitas.required ? ew.Validators.fileRequired(fields.fotofasilitas.caption) : null], fields.fotofasilitas.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ffasilitaspesantrenlist,
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
    ffasilitaspesantrenlist.validate = function () {
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
    ffasilitaspesantrenlist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffasilitaspesantrenlist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ffasilitaspesantrenlist");
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fasilitaspesantren">
<form name="ffasilitaspesantrenlist" id="ffasilitaspesantrenlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fasilitaspesantren">
<?php if ($Page->getCurrentMasterTable() == "pesantren" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="pesantren">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->pid->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_fasilitaspesantren" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isAdd() || $Page->isCopy() || $Page->isGridEdit()) { ?>
<table id="tbl_fasilitaspesantrenlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_fasilitaspesantren_id" class="fasilitaspesantren_id"><?= $Page->renderSort($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Page->pid->headerCellClass() ?>"><div id="elh_fasilitaspesantren_pid" class="fasilitaspesantren_pid"><?= $Page->renderSort($Page->pid) ?></div></th>
<?php } ?>
<?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
        <th data-name="namafasilitas" class="<?= $Page->namafasilitas->headerCellClass() ?>"><div id="elh_fasilitaspesantren_namafasilitas" class="fasilitaspesantren_namafasilitas"><?= $Page->renderSort($Page->namafasilitas) ?></div></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Page->keterangan->headerCellClass() ?>"><div id="elh_fasilitaspesantren_keterangan" class="fasilitaspesantren_keterangan"><?= $Page->renderSort($Page->keterangan) ?></div></th>
<?php } ?>
<?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
        <th data-name="fotofasilitas" class="<?= $Page->fotofasilitas->headerCellClass() ?>"><div id="elh_fasilitaspesantren_fotofasilitas" class="fasilitaspesantren_fotofasilitas"><?= $Page->renderSort($Page->fotofasilitas) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => 0, "id" => "r0_fasilitaspesantren", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_id" class="form-group fasilitaspesantren_id"></span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->pid->Visible) { // pid ?>
        <td data-name="pid">
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_pid" class="form-group fasilitaspesantren_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_pid" name="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_pid" class="form-group fasilitaspesantren_pid">
<input type="<?= $Page->pid->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_pid" name="x<?= $Page->RowIndex ?>_pid" id="x<?= $Page->RowIndex ?>_pid" size="30" maxlength="11" value="<?= $Page->pid->EditValue ?>"<?= $Page->pid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_pid" data-hidden="1" name="o<?= $Page->RowIndex ?>_pid" id="o<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
        <td data-name="namafasilitas">
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_namafasilitas" class="form-group fasilitaspesantren_namafasilitas">
<input type="<?= $Page->namafasilitas->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_namafasilitas" name="x<?= $Page->RowIndex ?>_namafasilitas" id="x<?= $Page->RowIndex ?>_namafasilitas" size="30" maxlength="255" value="<?= $Page->namafasilitas->EditValue ?>"<?= $Page->namafasilitas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->namafasilitas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_namafasilitas" data-hidden="1" name="o<?= $Page->RowIndex ?>_namafasilitas" id="o<?= $Page->RowIndex ?>_namafasilitas" value="<?= HtmlEncode($Page->namafasilitas->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan">
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_keterangan" class="form-group fasilitaspesantren_keterangan">
<textarea data-table="fasilitaspesantren" data-field="x_keterangan" name="x<?= $Page->RowIndex ?>_keterangan" id="x<?= $Page->RowIndex ?>_keterangan" cols="3" rows="4"<?= $Page->keterangan->editAttributes() ?>><?= $Page->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_keterangan" data-hidden="1" name="o<?= $Page->RowIndex ?>_keterangan" id="o<?= $Page->RowIndex ?>_keterangan" value="<?= HtmlEncode($Page->keterangan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
        <td data-name="fotofasilitas">
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_fotofasilitas" class="form-group fasilitaspesantren_fotofasilitas">
<div id="fd_x<?= $Page->RowIndex ?>_fotofasilitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->fotofasilitas->title() ?>" data-table="fasilitaspesantren" data-field="x_fotofasilitas" name="x<?= $Page->RowIndex ?>_fotofasilitas" id="x<?= $Page->RowIndex ?>_fotofasilitas" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->fotofasilitas->editAttributes() ?><?= ($Page->fotofasilitas->ReadOnly || $Page->fotofasilitas->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_fotofasilitas"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->fotofasilitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fn_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= $Page->fotofasilitas->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fa_x<?= $Page->RowIndex ?>_fotofasilitas" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fs_x<?= $Page->RowIndex ?>_fotofasilitas" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fx_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= $Page->fotofasilitas->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fm_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= $Page->fotofasilitas->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fc_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= $Page->fotofasilitas->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_fotofasilitas" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_fotofasilitas" data-hidden="1" name="o<?= $Page->RowIndex ?>_fotofasilitas" id="o<?= $Page->RowIndex ?>_fotofasilitas" value="<?= HtmlEncode($Page->fotofasilitas->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
<script>
loadjs.ready(["ffasilitaspesantrenlist","load"], function() {
    ffasilitaspesantrenlist.updateLists(<?= $Page->RowIndex ?>);
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_fasilitaspesantren", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_id" class="form-group">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Page->pid->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Page->pid->getSessionValue() != "") { ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_pid" class="form-group">
<span<?= $Page->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->pid->getDisplayValue($Page->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Page->RowIndex ?>_pid" name="x<?= $Page->RowIndex ?>_pid" value="<?= HtmlEncode($Page->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_pid" class="form-group">
<input type="<?= $Page->pid->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_pid" name="x<?= $Page->RowIndex ?>_pid" id="x<?= $Page->RowIndex ?>_pid" size="30" maxlength="11" value="<?= $Page->pid->EditValue ?>"<?= $Page->pid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->pid->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_pid">
<span<?= $Page->pid->viewAttributes() ?>>
<?= $Page->pid->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->namafasilitas->Visible) { // namafasilitas ?>
        <td data-name="namafasilitas" <?= $Page->namafasilitas->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_namafasilitas" class="form-group">
<input type="<?= $Page->namafasilitas->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_namafasilitas" name="x<?= $Page->RowIndex ?>_namafasilitas" id="x<?= $Page->RowIndex ?>_namafasilitas" size="30" maxlength="255" value="<?= $Page->namafasilitas->EditValue ?>"<?= $Page->namafasilitas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->namafasilitas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_namafasilitas">
<span<?= $Page->namafasilitas->viewAttributes() ?>>
<?= $Page->namafasilitas->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_keterangan" class="form-group">
<textarea data-table="fasilitaspesantren" data-field="x_keterangan" name="x<?= $Page->RowIndex ?>_keterangan" id="x<?= $Page->RowIndex ?>_keterangan" cols="3" rows="4"<?= $Page->keterangan->editAttributes() ?>><?= $Page->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->fotofasilitas->Visible) { // fotofasilitas ?>
        <td data-name="fotofasilitas" <?= $Page->fotofasilitas->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_fotofasilitas" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_fotofasilitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->fotofasilitas->title() ?>" data-table="fasilitaspesantren" data-field="x_fotofasilitas" name="x<?= $Page->RowIndex ?>_fotofasilitas" id="x<?= $Page->RowIndex ?>_fotofasilitas" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->fotofasilitas->editAttributes() ?><?= ($Page->fotofasilitas->ReadOnly || $Page->fotofasilitas->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_fotofasilitas"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->fotofasilitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fn_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= $Page->fotofasilitas->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fa_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_fotofasilitas") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fs_x<?= $Page->RowIndex ?>_fotofasilitas" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fx_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= $Page->fotofasilitas->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fm_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= $Page->fotofasilitas->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Page->RowIndex ?>_fotofasilitas" id= "fc_x<?= $Page->RowIndex ?>_fotofasilitas" value="<?= $Page->fotofasilitas->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_fotofasilitas" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_fasilitaspesantren_fotofasilitas">
<span<?= $Page->fotofasilitas->viewAttributes() ?>>
<?= GetFileViewTag($Page->fotofasilitas, $Page->fotofasilitas->getViewValue(), false) ?>
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
loadjs.ready(["ffasilitaspesantrenlist","load"], function () {
    ffasilitaspesantrenlist.updateLists(<?= $Page->RowIndex ?>);
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
    ew.addEventHandlers("fasilitaspesantren");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
