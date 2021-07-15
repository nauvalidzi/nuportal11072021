<?php

namespace PHPMaker2021\nuportal;

// Set up and run Grid object
$Grid = Container("FasilitaspesantrenGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ffasilitaspesantrengrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    ffasilitaspesantrengrid = new ew.Form("ffasilitaspesantrengrid", "grid");
    ffasilitaspesantrengrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "fasilitaspesantren")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.fasilitaspesantren)
        ew.vars.tables.fasilitaspesantren = currentTable;
    ffasilitaspesantrengrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["namafasilitas", [fields.namafasilitas.visible && fields.namafasilitas.required ? ew.Validators.required(fields.namafasilitas.caption) : null], fields.namafasilitas.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid],
        ["fotofasilitas", [fields.fotofasilitas.visible && fields.fotofasilitas.required ? ew.Validators.fileRequired(fields.fotofasilitas.caption) : null], fields.fotofasilitas.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = ffasilitaspesantrengrid,
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
    ffasilitaspesantrengrid.validate = function () {
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
            var checkrow = (gridinsert) ? !this.emptyRow(rowIndex) : true;
            if (checkrow) {
                addcnt++;

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
            } // End Grid Add checking
        }
        return true;
    }

    // Check empty row
    ffasilitaspesantrengrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "pid", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "namafasilitas", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "keterangan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fotofasilitas", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffasilitaspesantrengrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffasilitaspesantrengrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("ffasilitaspesantrengrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fasilitaspesantren">
<div id="ffasilitaspesantrengrid" class="ew-form ew-list-form form-inline">
<div id="gmp_fasilitaspesantren" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fasilitaspesantrengrid" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_fasilitaspesantren_id" class="fasilitaspesantren_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Grid->pid->headerCellClass() ?>"><div id="elh_fasilitaspesantren_pid" class="fasilitaspesantren_pid"><?= $Grid->renderSort($Grid->pid) ?></div></th>
<?php } ?>
<?php if ($Grid->namafasilitas->Visible) { // namafasilitas ?>
        <th data-name="namafasilitas" class="<?= $Grid->namafasilitas->headerCellClass() ?>"><div id="elh_fasilitaspesantren_namafasilitas" class="fasilitaspesantren_namafasilitas"><?= $Grid->renderSort($Grid->namafasilitas) ?></div></th>
<?php } ?>
<?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Grid->keterangan->headerCellClass() ?>"><div id="elh_fasilitaspesantren_keterangan" class="fasilitaspesantren_keterangan"><?= $Grid->renderSort($Grid->keterangan) ?></div></th>
<?php } ?>
<?php if ($Grid->fotofasilitas->Visible) { // fotofasilitas ?>
        <th data-name="fotofasilitas" class="<?= $Grid->fotofasilitas->headerCellClass() ?>"><div id="elh_fasilitaspesantren_fotofasilitas" class="fasilitaspesantren_fotofasilitas"><?= $Grid->renderSort($Grid->fotofasilitas) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif (!$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
if ($Grid->isGridAdd())
    $Grid->RowIndex = 0;
if ($Grid->isGridEdit())
    $Grid->RowIndex = 0;
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row id / data-rowindex
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_fasilitaspesantren", "data-rowtype" => $Grid->RowType]);

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Grid->RowAction != "delete" && $Grid->RowAction != "insertdelete" && !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow())) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id" <?= $Grid->id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_id" class="form-group"></span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="ffasilitaspesantrengrid$x<?= $Grid->RowIndex ?>_id" id="ffasilitaspesantrengrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="ffasilitaspesantrengrid$o<?= $Grid->RowIndex ?>_id" id="ffasilitaspesantrengrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Grid->pid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_pid" class="form-group">
<input type="<?= $Grid->pid->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_pid" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" size="30" maxlength="11" value="<?= $Grid->pid->EditValue ?>"<?= $Grid->pid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_pid" class="form-group">
<input type="<?= $Grid->pid->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_pid" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" size="30" maxlength="11" value="<?= $Grid->pid->EditValue ?>"<?= $Grid->pid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<?= $Grid->pid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_pid" data-hidden="1" name="ffasilitaspesantrengrid$x<?= $Grid->RowIndex ?>_pid" id="ffasilitaspesantrengrid$x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<input type="hidden" data-table="fasilitaspesantren" data-field="x_pid" data-hidden="1" name="ffasilitaspesantrengrid$o<?= $Grid->RowIndex ?>_pid" id="ffasilitaspesantrengrid$o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->namafasilitas->Visible) { // namafasilitas ?>
        <td data-name="namafasilitas" <?= $Grid->namafasilitas->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_namafasilitas" class="form-group">
<input type="<?= $Grid->namafasilitas->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_namafasilitas" name="x<?= $Grid->RowIndex ?>_namafasilitas" id="x<?= $Grid->RowIndex ?>_namafasilitas" size="30" maxlength="255" value="<?= $Grid->namafasilitas->EditValue ?>"<?= $Grid->namafasilitas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namafasilitas->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_namafasilitas" data-hidden="1" name="o<?= $Grid->RowIndex ?>_namafasilitas" id="o<?= $Grid->RowIndex ?>_namafasilitas" value="<?= HtmlEncode($Grid->namafasilitas->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_namafasilitas" class="form-group">
<input type="<?= $Grid->namafasilitas->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_namafasilitas" name="x<?= $Grid->RowIndex ?>_namafasilitas" id="x<?= $Grid->RowIndex ?>_namafasilitas" size="30" maxlength="255" value="<?= $Grid->namafasilitas->EditValue ?>"<?= $Grid->namafasilitas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namafasilitas->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_namafasilitas">
<span<?= $Grid->namafasilitas->viewAttributes() ?>>
<?= $Grid->namafasilitas->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_namafasilitas" data-hidden="1" name="ffasilitaspesantrengrid$x<?= $Grid->RowIndex ?>_namafasilitas" id="ffasilitaspesantrengrid$x<?= $Grid->RowIndex ?>_namafasilitas" value="<?= HtmlEncode($Grid->namafasilitas->FormValue) ?>">
<input type="hidden" data-table="fasilitaspesantren" data-field="x_namafasilitas" data-hidden="1" name="ffasilitaspesantrengrid$o<?= $Grid->RowIndex ?>_namafasilitas" id="ffasilitaspesantrengrid$o<?= $Grid->RowIndex ?>_namafasilitas" value="<?= HtmlEncode($Grid->namafasilitas->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Grid->keterangan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_keterangan" class="form-group">
<textarea data-table="fasilitaspesantren" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="3" rows="4"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_keterangan" class="form-group">
<textarea data-table="fasilitaspesantren" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="3" rows="4"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_keterangan" data-hidden="1" name="ffasilitaspesantrengrid$x<?= $Grid->RowIndex ?>_keterangan" id="ffasilitaspesantrengrid$x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<input type="hidden" data-table="fasilitaspesantren" data-field="x_keterangan" data-hidden="1" name="ffasilitaspesantrengrid$o<?= $Grid->RowIndex ?>_keterangan" id="ffasilitaspesantrengrid$o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fotofasilitas->Visible) { // fotofasilitas ?>
        <td data-name="fotofasilitas" <?= $Grid->fotofasilitas->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_fotofasilitas" class="form-group fasilitaspesantren_fotofasilitas">
<div id="fd_x<?= $Grid->RowIndex ?>_fotofasilitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->fotofasilitas->title() ?>" data-table="fasilitaspesantren" data-field="x_fotofasilitas" name="x<?= $Grid->RowIndex ?>_fotofasilitas" id="x<?= $Grid->RowIndex ?>_fotofasilitas" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->fotofasilitas->editAttributes() ?><?= ($Grid->fotofasilitas->ReadOnly || $Grid->fotofasilitas->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_fotofasilitas"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->fotofasilitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fn_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fa_x<?= $Grid->RowIndex ?>_fotofasilitas" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fs_x<?= $Grid->RowIndex ?>_fotofasilitas" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fx_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fm_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fc_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_fotofasilitas" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_fotofasilitas" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fotofasilitas" id="o<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= HtmlEncode($Grid->fotofasilitas->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_fotofasilitas">
<span<?= $Grid->fotofasilitas->viewAttributes() ?>>
<?= GetFileViewTag($Grid->fotofasilitas, $Grid->fotofasilitas->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitaspesantren_fotofasilitas" class="form-group fasilitaspesantren_fotofasilitas">
<div id="fd_x<?= $Grid->RowIndex ?>_fotofasilitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->fotofasilitas->title() ?>" data-table="fasilitaspesantren" data-field="x_fotofasilitas" name="x<?= $Grid->RowIndex ?>_fotofasilitas" id="x<?= $Grid->RowIndex ?>_fotofasilitas" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->fotofasilitas->editAttributes() ?><?= ($Grid->fotofasilitas->ReadOnly || $Grid->fotofasilitas->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_fotofasilitas"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->fotofasilitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fn_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fa_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_fotofasilitas") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fs_x<?= $Grid->RowIndex ?>_fotofasilitas" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fx_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fm_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fc_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_fotofasilitas" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["ffasilitaspesantrengrid","load"], function () {
    ffasilitaspesantrengrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
    if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
        $Grid->RowIndex = '$rowindex$';
        $Grid->loadRowValues();

        // Set row properties
        $Grid->resetAttributes();
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fasilitaspesantren", "data-rowtype" => ROWTYPE_ADD]);
        $Grid->RowAttrs->appendClass("ew-template");
        $Grid->RowType = ROWTYPE_ADD;

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();
        $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitaspesantren_id" class="form-group fasilitaspesantren_id"></span>
<?php } else { ?>
<span id="el$rowindex$_fasilitaspesantren_id" class="form-group fasilitaspesantren_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el$rowindex$_fasilitaspesantren_pid" class="form-group fasilitaspesantren_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_fasilitaspesantren_pid" class="form-group fasilitaspesantren_pid">
<input type="<?= $Grid->pid->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_pid" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" size="30" maxlength="11" value="<?= $Grid->pid->EditValue ?>"<?= $Grid->pid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fasilitaspesantren_pid" class="form-group fasilitaspesantren_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_pid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->namafasilitas->Visible) { // namafasilitas ?>
        <td data-name="namafasilitas">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitaspesantren_namafasilitas" class="form-group fasilitaspesantren_namafasilitas">
<input type="<?= $Grid->namafasilitas->getInputTextType() ?>" data-table="fasilitaspesantren" data-field="x_namafasilitas" name="x<?= $Grid->RowIndex ?>_namafasilitas" id="x<?= $Grid->RowIndex ?>_namafasilitas" size="30" maxlength="255" value="<?= $Grid->namafasilitas->EditValue ?>"<?= $Grid->namafasilitas->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namafasilitas->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitaspesantren_namafasilitas" class="form-group fasilitaspesantren_namafasilitas">
<span<?= $Grid->namafasilitas->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->namafasilitas->getDisplayValue($Grid->namafasilitas->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_namafasilitas" data-hidden="1" name="x<?= $Grid->RowIndex ?>_namafasilitas" id="x<?= $Grid->RowIndex ?>_namafasilitas" value="<?= HtmlEncode($Grid->namafasilitas->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_namafasilitas" data-hidden="1" name="o<?= $Grid->RowIndex ?>_namafasilitas" id="o<?= $Grid->RowIndex ?>_namafasilitas" value="<?= HtmlEncode($Grid->namafasilitas->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitaspesantren_keterangan" class="form-group fasilitaspesantren_keterangan">
<textarea data-table="fasilitaspesantren" data-field="x_keterangan" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" cols="3" rows="4"<?= $Grid->keterangan->editAttributes() ?>><?= $Grid->keterangan->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->keterangan->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitaspesantren_keterangan" class="form-group fasilitaspesantren_keterangan">
<span<?= $Grid->keterangan->viewAttributes() ?>>
<?= $Grid->keterangan->ViewValue ?></span>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_keterangan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_keterangan" id="x<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_keterangan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_keterangan" id="o<?= $Grid->RowIndex ?>_keterangan" value="<?= HtmlEncode($Grid->keterangan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fotofasilitas->Visible) { // fotofasilitas ?>
        <td data-name="fotofasilitas">
<span id="el$rowindex$_fasilitaspesantren_fotofasilitas" class="form-group fasilitaspesantren_fotofasilitas">
<div id="fd_x<?= $Grid->RowIndex ?>_fotofasilitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->fotofasilitas->title() ?>" data-table="fasilitaspesantren" data-field="x_fotofasilitas" name="x<?= $Grid->RowIndex ?>_fotofasilitas" id="x<?= $Grid->RowIndex ?>_fotofasilitas" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->fotofasilitas->editAttributes() ?><?= ($Grid->fotofasilitas->ReadOnly || $Grid->fotofasilitas->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_fotofasilitas"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->fotofasilitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fn_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fa_x<?= $Grid->RowIndex ?>_fotofasilitas" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fs_x<?= $Grid->RowIndex ?>_fotofasilitas" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fx_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fm_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Grid->RowIndex ?>_fotofasilitas" id= "fc_x<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= $Grid->fotofasilitas->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_fotofasilitas" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="fasilitaspesantren" data-field="x_fotofasilitas" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fotofasilitas" id="o<?= $Grid->RowIndex ?>_fotofasilitas" value="<?= HtmlEncode($Grid->fotofasilitas->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffasilitaspesantrengrid","load"], function() {
    ffasilitaspesantrengrid.updateLists(<?= $Grid->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ffasilitaspesantrengrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
