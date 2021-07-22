<?php

namespace PHPMaker2021\nuportal;

// Set up and run Grid object
$Grid = Container("FasilitasusahaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ffasilitasusahagrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    ffasilitasusahagrid = new ew.Form("ffasilitasusahagrid", "grid");
    ffasilitasusahagrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "fasilitasusaha")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.fasilitasusaha)
        ew.vars.tables.fasilitasusaha = currentTable;
    ffasilitasusahagrid.addFields([
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
        var f = ffasilitasusahagrid,
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
    ffasilitasusahagrid.validate = function () {
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
    ffasilitasusahagrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "pid", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "namausaha", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bidangusaha", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "badanhukum", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "siup", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "bpom", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "irt", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "potensiblm", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "aset", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "_modal", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "hasilsetahun", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "kendala", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "fasilitasperlu", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "foto", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffasilitasusahagrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffasilitasusahagrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    ffasilitasusahagrid.lists.pid = <?= $Grid->pid->toClientList($Grid) ?>;
    ffasilitasusahagrid.lists.badanhukum = <?= $Grid->badanhukum->toClientList($Grid) ?>;
    loadjs.done("ffasilitasusahagrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fasilitasusaha">
<div id="ffasilitasusahagrid" class="ew-form ew-list-form form-inline">
<div id="gmp_fasilitasusaha" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fasilitasusahagrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_fasilitasusaha_id" class="fasilitasusaha_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Grid->pid->headerCellClass() ?>"><div id="elh_fasilitasusaha_pid" class="fasilitasusaha_pid"><?= $Grid->renderSort($Grid->pid) ?></div></th>
<?php } ?>
<?php if ($Grid->namausaha->Visible) { // namausaha ?>
        <th data-name="namausaha" class="<?= $Grid->namausaha->headerCellClass() ?>"><div id="elh_fasilitasusaha_namausaha" class="fasilitasusaha_namausaha"><?= $Grid->renderSort($Grid->namausaha) ?></div></th>
<?php } ?>
<?php if ($Grid->bidangusaha->Visible) { // bidangusaha ?>
        <th data-name="bidangusaha" class="<?= $Grid->bidangusaha->headerCellClass() ?>"><div id="elh_fasilitasusaha_bidangusaha" class="fasilitasusaha_bidangusaha"><?= $Grid->renderSort($Grid->bidangusaha) ?></div></th>
<?php } ?>
<?php if ($Grid->badanhukum->Visible) { // badanhukum ?>
        <th data-name="badanhukum" class="<?= $Grid->badanhukum->headerCellClass() ?>"><div id="elh_fasilitasusaha_badanhukum" class="fasilitasusaha_badanhukum"><?= $Grid->renderSort($Grid->badanhukum) ?></div></th>
<?php } ?>
<?php if ($Grid->siup->Visible) { // siup ?>
        <th data-name="siup" class="<?= $Grid->siup->headerCellClass() ?>"><div id="elh_fasilitasusaha_siup" class="fasilitasusaha_siup"><?= $Grid->renderSort($Grid->siup) ?></div></th>
<?php } ?>
<?php if ($Grid->bpom->Visible) { // bpom ?>
        <th data-name="bpom" class="<?= $Grid->bpom->headerCellClass() ?>"><div id="elh_fasilitasusaha_bpom" class="fasilitasusaha_bpom"><?= $Grid->renderSort($Grid->bpom) ?></div></th>
<?php } ?>
<?php if ($Grid->irt->Visible) { // irt ?>
        <th data-name="irt" class="<?= $Grid->irt->headerCellClass() ?>"><div id="elh_fasilitasusaha_irt" class="fasilitasusaha_irt"><?= $Grid->renderSort($Grid->irt) ?></div></th>
<?php } ?>
<?php if ($Grid->potensiblm->Visible) { // potensiblm ?>
        <th data-name="potensiblm" class="<?= $Grid->potensiblm->headerCellClass() ?>"><div id="elh_fasilitasusaha_potensiblm" class="fasilitasusaha_potensiblm"><?= $Grid->renderSort($Grid->potensiblm) ?></div></th>
<?php } ?>
<?php if ($Grid->aset->Visible) { // aset ?>
        <th data-name="aset" class="<?= $Grid->aset->headerCellClass() ?>"><div id="elh_fasilitasusaha_aset" class="fasilitasusaha_aset"><?= $Grid->renderSort($Grid->aset) ?></div></th>
<?php } ?>
<?php if ($Grid->_modal->Visible) { // modal ?>
        <th data-name="_modal" class="<?= $Grid->_modal->headerCellClass() ?>"><div id="elh_fasilitasusaha__modal" class="fasilitasusaha__modal"><?= $Grid->renderSort($Grid->_modal) ?></div></th>
<?php } ?>
<?php if ($Grid->hasilsetahun->Visible) { // hasilsetahun ?>
        <th data-name="hasilsetahun" class="<?= $Grid->hasilsetahun->headerCellClass() ?>"><div id="elh_fasilitasusaha_hasilsetahun" class="fasilitasusaha_hasilsetahun"><?= $Grid->renderSort($Grid->hasilsetahun) ?></div></th>
<?php } ?>
<?php if ($Grid->kendala->Visible) { // kendala ?>
        <th data-name="kendala" class="<?= $Grid->kendala->headerCellClass() ?>"><div id="elh_fasilitasusaha_kendala" class="fasilitasusaha_kendala"><?= $Grid->renderSort($Grid->kendala) ?></div></th>
<?php } ?>
<?php if ($Grid->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <th data-name="fasilitasperlu" class="<?= $Grid->fasilitasperlu->headerCellClass() ?>"><div id="elh_fasilitasusaha_fasilitasperlu" class="fasilitasusaha_fasilitasperlu"><?= $Grid->renderSort($Grid->fasilitasperlu) ?></div></th>
<?php } ?>
<?php if ($Grid->foto->Visible) { // foto ?>
        <th data-name="foto" class="<?= $Grid->foto->headerCellClass() ?>"><div id="elh_fasilitasusaha_foto" class="fasilitasusaha_foto"><?= $Grid->renderSort($Grid->foto) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_fasilitasusaha", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_id" class="form-group"></span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_id" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_id" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Grid->pid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_pid" class="form-group">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="fasilitasusaha" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["ffasilitasusahagrid"], function() {
    ffasilitasusahagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.fasilitasusaha.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_pid" class="form-group">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="fasilitasusaha" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["ffasilitasusahagrid"], function() {
    ffasilitasusahagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.fasilitasusaha.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<?= $Grid->pid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_pid" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_pid" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_pid" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_pid" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->namausaha->Visible) { // namausaha ?>
        <td data-name="namausaha" <?= $Grid->namausaha->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_namausaha" class="form-group">
<input type="<?= $Grid->namausaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_namausaha" name="x<?= $Grid->RowIndex ?>_namausaha" id="x<?= $Grid->RowIndex ?>_namausaha" size="30" maxlength="255" value="<?= $Grid->namausaha->EditValue ?>"<?= $Grid->namausaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namausaha->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_namausaha" data-hidden="1" name="o<?= $Grid->RowIndex ?>_namausaha" id="o<?= $Grid->RowIndex ?>_namausaha" value="<?= HtmlEncode($Grid->namausaha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_namausaha" class="form-group">
<input type="<?= $Grid->namausaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_namausaha" name="x<?= $Grid->RowIndex ?>_namausaha" id="x<?= $Grid->RowIndex ?>_namausaha" size="30" maxlength="255" value="<?= $Grid->namausaha->EditValue ?>"<?= $Grid->namausaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namausaha->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_namausaha">
<span<?= $Grid->namausaha->viewAttributes() ?>>
<?= $Grid->namausaha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_namausaha" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_namausaha" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_namausaha" value="<?= HtmlEncode($Grid->namausaha->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_namausaha" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_namausaha" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_namausaha" value="<?= HtmlEncode($Grid->namausaha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bidangusaha->Visible) { // bidangusaha ?>
        <td data-name="bidangusaha" <?= $Grid->bidangusaha->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_bidangusaha" class="form-group">
<input type="<?= $Grid->bidangusaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bidangusaha" name="x<?= $Grid->RowIndex ?>_bidangusaha" id="x<?= $Grid->RowIndex ?>_bidangusaha" size="30" maxlength="255" value="<?= $Grid->bidangusaha->EditValue ?>"<?= $Grid->bidangusaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bidangusaha->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bidangusaha" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bidangusaha" id="o<?= $Grid->RowIndex ?>_bidangusaha" value="<?= HtmlEncode($Grid->bidangusaha->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_bidangusaha" class="form-group">
<input type="<?= $Grid->bidangusaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bidangusaha" name="x<?= $Grid->RowIndex ?>_bidangusaha" id="x<?= $Grid->RowIndex ?>_bidangusaha" size="30" maxlength="255" value="<?= $Grid->bidangusaha->EditValue ?>"<?= $Grid->bidangusaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bidangusaha->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_bidangusaha">
<span<?= $Grid->bidangusaha->viewAttributes() ?>>
<?= $Grid->bidangusaha->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bidangusaha" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_bidangusaha" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_bidangusaha" value="<?= HtmlEncode($Grid->bidangusaha->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_bidangusaha" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_bidangusaha" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_bidangusaha" value="<?= HtmlEncode($Grid->bidangusaha->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->badanhukum->Visible) { // badanhukum ?>
        <td data-name="badanhukum" <?= $Grid->badanhukum->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_badanhukum" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_badanhukum"
        name="x<?= $Grid->RowIndex ?>_badanhukum"
        class="form-control ew-select<?= $Grid->badanhukum->isInvalidClass() ?>"
        data-select2-id="fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum"
        data-table="fasilitasusaha"
        data-field="x_badanhukum"
        data-value-separator="<?= $Grid->badanhukum->displayValueSeparatorAttribute() ?>"
        <?= $Grid->badanhukum->editAttributes() ?>>
        <?= $Grid->badanhukum->selectOptionListHtml("x{$Grid->RowIndex}_badanhukum") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->badanhukum->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum']"),
        options = { name: "x<?= $Grid->RowIndex ?>_badanhukum", selectId: "fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.fasilitasusaha.fields.badanhukum.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.fasilitasusaha.fields.badanhukum.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_badanhukum" data-hidden="1" name="o<?= $Grid->RowIndex ?>_badanhukum" id="o<?= $Grid->RowIndex ?>_badanhukum" value="<?= HtmlEncode($Grid->badanhukum->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_badanhukum" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_badanhukum"
        name="x<?= $Grid->RowIndex ?>_badanhukum"
        class="form-control ew-select<?= $Grid->badanhukum->isInvalidClass() ?>"
        data-select2-id="fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum"
        data-table="fasilitasusaha"
        data-field="x_badanhukum"
        data-value-separator="<?= $Grid->badanhukum->displayValueSeparatorAttribute() ?>"
        <?= $Grid->badanhukum->editAttributes() ?>>
        <?= $Grid->badanhukum->selectOptionListHtml("x{$Grid->RowIndex}_badanhukum") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->badanhukum->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum']"),
        options = { name: "x<?= $Grid->RowIndex ?>_badanhukum", selectId: "fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.fasilitasusaha.fields.badanhukum.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.fasilitasusaha.fields.badanhukum.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_badanhukum">
<span<?= $Grid->badanhukum->viewAttributes() ?>>
<?= $Grid->badanhukum->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_badanhukum" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_badanhukum" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_badanhukum" value="<?= HtmlEncode($Grid->badanhukum->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_badanhukum" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_badanhukum" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_badanhukum" value="<?= HtmlEncode($Grid->badanhukum->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->siup->Visible) { // siup ?>
        <td data-name="siup" <?= $Grid->siup->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_siup" class="form-group">
<input type="<?= $Grid->siup->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_siup" name="x<?= $Grid->RowIndex ?>_siup" id="x<?= $Grid->RowIndex ?>_siup" size="30" maxlength="255" value="<?= $Grid->siup->EditValue ?>"<?= $Grid->siup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->siup->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_siup" data-hidden="1" name="o<?= $Grid->RowIndex ?>_siup" id="o<?= $Grid->RowIndex ?>_siup" value="<?= HtmlEncode($Grid->siup->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_siup" class="form-group">
<input type="<?= $Grid->siup->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_siup" name="x<?= $Grid->RowIndex ?>_siup" id="x<?= $Grid->RowIndex ?>_siup" size="30" maxlength="255" value="<?= $Grid->siup->EditValue ?>"<?= $Grid->siup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->siup->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_siup">
<span<?= $Grid->siup->viewAttributes() ?>>
<?= $Grid->siup->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_siup" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_siup" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_siup" value="<?= HtmlEncode($Grid->siup->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_siup" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_siup" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_siup" value="<?= HtmlEncode($Grid->siup->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->bpom->Visible) { // bpom ?>
        <td data-name="bpom" <?= $Grid->bpom->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_bpom" class="form-group">
<input type="<?= $Grid->bpom->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bpom" name="x<?= $Grid->RowIndex ?>_bpom" id="x<?= $Grid->RowIndex ?>_bpom" size="30" maxlength="255" value="<?= $Grid->bpom->EditValue ?>"<?= $Grid->bpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bpom->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bpom" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bpom" id="o<?= $Grid->RowIndex ?>_bpom" value="<?= HtmlEncode($Grid->bpom->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_bpom" class="form-group">
<input type="<?= $Grid->bpom->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bpom" name="x<?= $Grid->RowIndex ?>_bpom" id="x<?= $Grid->RowIndex ?>_bpom" size="30" maxlength="255" value="<?= $Grid->bpom->EditValue ?>"<?= $Grid->bpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bpom->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_bpom">
<span<?= $Grid->bpom->viewAttributes() ?>>
<?= $Grid->bpom->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bpom" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_bpom" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_bpom" value="<?= HtmlEncode($Grid->bpom->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_bpom" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_bpom" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_bpom" value="<?= HtmlEncode($Grid->bpom->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->irt->Visible) { // irt ?>
        <td data-name="irt" <?= $Grid->irt->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_irt" class="form-group">
<input type="<?= $Grid->irt->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_irt" name="x<?= $Grid->RowIndex ?>_irt" id="x<?= $Grid->RowIndex ?>_irt" size="30" maxlength="255" value="<?= $Grid->irt->EditValue ?>"<?= $Grid->irt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->irt->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_irt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_irt" id="o<?= $Grid->RowIndex ?>_irt" value="<?= HtmlEncode($Grid->irt->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_irt" class="form-group">
<input type="<?= $Grid->irt->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_irt" name="x<?= $Grid->RowIndex ?>_irt" id="x<?= $Grid->RowIndex ?>_irt" size="30" maxlength="255" value="<?= $Grid->irt->EditValue ?>"<?= $Grid->irt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->irt->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_irt">
<span<?= $Grid->irt->viewAttributes() ?>>
<?= $Grid->irt->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_irt" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_irt" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_irt" value="<?= HtmlEncode($Grid->irt->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_irt" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_irt" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_irt" value="<?= HtmlEncode($Grid->irt->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->potensiblm->Visible) { // potensiblm ?>
        <td data-name="potensiblm" <?= $Grid->potensiblm->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_potensiblm" class="form-group">
<input type="<?= $Grid->potensiblm->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_potensiblm" name="x<?= $Grid->RowIndex ?>_potensiblm" id="x<?= $Grid->RowIndex ?>_potensiblm" size="30" maxlength="255" value="<?= $Grid->potensiblm->EditValue ?>"<?= $Grid->potensiblm->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->potensiblm->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_potensiblm" data-hidden="1" name="o<?= $Grid->RowIndex ?>_potensiblm" id="o<?= $Grid->RowIndex ?>_potensiblm" value="<?= HtmlEncode($Grid->potensiblm->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_potensiblm" class="form-group">
<input type="<?= $Grid->potensiblm->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_potensiblm" name="x<?= $Grid->RowIndex ?>_potensiblm" id="x<?= $Grid->RowIndex ?>_potensiblm" size="30" maxlength="255" value="<?= $Grid->potensiblm->EditValue ?>"<?= $Grid->potensiblm->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->potensiblm->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_potensiblm">
<span<?= $Grid->potensiblm->viewAttributes() ?>>
<?= $Grid->potensiblm->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_potensiblm" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_potensiblm" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_potensiblm" value="<?= HtmlEncode($Grid->potensiblm->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_potensiblm" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_potensiblm" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_potensiblm" value="<?= HtmlEncode($Grid->potensiblm->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->aset->Visible) { // aset ?>
        <td data-name="aset" <?= $Grid->aset->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_aset" class="form-group">
<textarea data-table="fasilitasusaha" data-field="x_aset" name="x<?= $Grid->RowIndex ?>_aset" id="x<?= $Grid->RowIndex ?>_aset" cols="3" rows="4"<?= $Grid->aset->editAttributes() ?>><?= $Grid->aset->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->aset->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_aset" data-hidden="1" name="o<?= $Grid->RowIndex ?>_aset" id="o<?= $Grid->RowIndex ?>_aset" value="<?= HtmlEncode($Grid->aset->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_aset" class="form-group">
<textarea data-table="fasilitasusaha" data-field="x_aset" name="x<?= $Grid->RowIndex ?>_aset" id="x<?= $Grid->RowIndex ?>_aset" cols="3" rows="4"<?= $Grid->aset->editAttributes() ?>><?= $Grid->aset->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->aset->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_aset">
<span<?= $Grid->aset->viewAttributes() ?>>
<?= $Grid->aset->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_aset" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_aset" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_aset" value="<?= HtmlEncode($Grid->aset->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_aset" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_aset" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_aset" value="<?= HtmlEncode($Grid->aset->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_modal->Visible) { // modal ?>
        <td data-name="_modal" <?= $Grid->_modal->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha__modal" class="form-group">
<input type="<?= $Grid->_modal->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x__modal" name="x<?= $Grid->RowIndex ?>__modal" id="x<?= $Grid->RowIndex ?>__modal" size="30" maxlength="255" value="<?= $Grid->_modal->EditValue ?>"<?= $Grid->_modal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_modal->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x__modal" data-hidden="1" name="o<?= $Grid->RowIndex ?>__modal" id="o<?= $Grid->RowIndex ?>__modal" value="<?= HtmlEncode($Grid->_modal->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha__modal" class="form-group">
<input type="<?= $Grid->_modal->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x__modal" name="x<?= $Grid->RowIndex ?>__modal" id="x<?= $Grid->RowIndex ?>__modal" size="30" maxlength="255" value="<?= $Grid->_modal->EditValue ?>"<?= $Grid->_modal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_modal->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha__modal">
<span<?= $Grid->_modal->viewAttributes() ?>>
<?= $Grid->_modal->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x__modal" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>__modal" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>__modal" value="<?= HtmlEncode($Grid->_modal->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x__modal" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>__modal" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>__modal" value="<?= HtmlEncode($Grid->_modal->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->hasilsetahun->Visible) { // hasilsetahun ?>
        <td data-name="hasilsetahun" <?= $Grid->hasilsetahun->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_hasilsetahun" class="form-group">
<input type="<?= $Grid->hasilsetahun->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_hasilsetahun" name="x<?= $Grid->RowIndex ?>_hasilsetahun" id="x<?= $Grid->RowIndex ?>_hasilsetahun" size="30" maxlength="255" value="<?= $Grid->hasilsetahun->EditValue ?>"<?= $Grid->hasilsetahun->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hasilsetahun->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_hasilsetahun" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hasilsetahun" id="o<?= $Grid->RowIndex ?>_hasilsetahun" value="<?= HtmlEncode($Grid->hasilsetahun->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_hasilsetahun" class="form-group">
<input type="<?= $Grid->hasilsetahun->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_hasilsetahun" name="x<?= $Grid->RowIndex ?>_hasilsetahun" id="x<?= $Grid->RowIndex ?>_hasilsetahun" size="30" maxlength="255" value="<?= $Grid->hasilsetahun->EditValue ?>"<?= $Grid->hasilsetahun->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hasilsetahun->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_hasilsetahun">
<span<?= $Grid->hasilsetahun->viewAttributes() ?>>
<?= $Grid->hasilsetahun->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_hasilsetahun" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_hasilsetahun" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_hasilsetahun" value="<?= HtmlEncode($Grid->hasilsetahun->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_hasilsetahun" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_hasilsetahun" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_hasilsetahun" value="<?= HtmlEncode($Grid->hasilsetahun->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->kendala->Visible) { // kendala ?>
        <td data-name="kendala" <?= $Grid->kendala->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_kendala" class="form-group">
<input type="<?= $Grid->kendala->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_kendala" name="x<?= $Grid->RowIndex ?>_kendala" id="x<?= $Grid->RowIndex ?>_kendala" size="30" maxlength="255" value="<?= $Grid->kendala->EditValue ?>"<?= $Grid->kendala->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kendala->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_kendala" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kendala" id="o<?= $Grid->RowIndex ?>_kendala" value="<?= HtmlEncode($Grid->kendala->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_kendala" class="form-group">
<input type="<?= $Grid->kendala->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_kendala" name="x<?= $Grid->RowIndex ?>_kendala" id="x<?= $Grid->RowIndex ?>_kendala" size="30" maxlength="255" value="<?= $Grid->kendala->EditValue ?>"<?= $Grid->kendala->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kendala->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_kendala">
<span<?= $Grid->kendala->viewAttributes() ?>>
<?= $Grid->kendala->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_kendala" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_kendala" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_kendala" value="<?= HtmlEncode($Grid->kendala->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_kendala" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_kendala" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_kendala" value="<?= HtmlEncode($Grid->kendala->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <td data-name="fasilitasperlu" <?= $Grid->fasilitasperlu->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_fasilitasperlu" class="form-group">
<textarea data-table="fasilitasusaha" data-field="x_fasilitasperlu" name="x<?= $Grid->RowIndex ?>_fasilitasperlu" id="x<?= $Grid->RowIndex ?>_fasilitasperlu" cols="3" rows="4"<?= $Grid->fasilitasperlu->editAttributes() ?>><?= $Grid->fasilitasperlu->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->fasilitasperlu->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_fasilitasperlu" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fasilitasperlu" id="o<?= $Grid->RowIndex ?>_fasilitasperlu" value="<?= HtmlEncode($Grid->fasilitasperlu->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_fasilitasperlu" class="form-group">
<textarea data-table="fasilitasusaha" data-field="x_fasilitasperlu" name="x<?= $Grid->RowIndex ?>_fasilitasperlu" id="x<?= $Grid->RowIndex ?>_fasilitasperlu" cols="3" rows="4"<?= $Grid->fasilitasperlu->editAttributes() ?>><?= $Grid->fasilitasperlu->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->fasilitasperlu->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_fasilitasperlu">
<span<?= $Grid->fasilitasperlu->viewAttributes() ?>>
<?= $Grid->fasilitasperlu->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_fasilitasperlu" data-hidden="1" name="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_fasilitasperlu" id="ffasilitasusahagrid$x<?= $Grid->RowIndex ?>_fasilitasperlu" value="<?= HtmlEncode($Grid->fasilitasperlu->FormValue) ?>">
<input type="hidden" data-table="fasilitasusaha" data-field="x_fasilitasperlu" data-hidden="1" name="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_fasilitasperlu" id="ffasilitasusahagrid$o<?= $Grid->RowIndex ?>_fasilitasperlu" value="<?= HtmlEncode($Grid->fasilitasperlu->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->foto->Visible) { // foto ?>
        <td data-name="foto" <?= $Grid->foto->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_foto" class="form-group fasilitasusaha_foto">
<div id="fd_x<?= $Grid->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->foto->title() ?>" data-table="fasilitasusaha" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->foto->editAttributes() ?><?= ($Grid->foto->ReadOnly || $Grid->foto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_foto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_foto" id= "fn_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_foto" id= "fa_x<?= $Grid->RowIndex ?>_foto" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_foto" id= "fs_x<?= $Grid->RowIndex ?>_foto" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_foto" id= "fx_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_foto" id= "fm_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Grid->RowIndex ?>_foto" id= "fc_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_foto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_foto" id="o<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_foto">
<span<?= $Grid->foto->viewAttributes() ?>>
<?= GetFileViewTag($Grid->foto, $Grid->foto->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fasilitasusaha_foto" class="form-group fasilitasusaha_foto">
<div id="fd_x<?= $Grid->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->foto->title() ?>" data-table="fasilitasusaha" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->foto->editAttributes() ?><?= ($Grid->foto->ReadOnly || $Grid->foto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_foto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_foto" id= "fn_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_foto" id= "fa_x<?= $Grid->RowIndex ?>_foto" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_foto") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_foto" id= "fs_x<?= $Grid->RowIndex ?>_foto" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_foto" id= "fx_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_foto" id= "fm_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Grid->RowIndex ?>_foto" id= "fc_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
loadjs.ready(["ffasilitasusahagrid","load"], function () {
    ffasilitasusahagrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fasilitasusaha", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_fasilitasusaha_id" class="form-group fasilitasusaha_id"></span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_id" class="form-group fasilitasusaha_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el$rowindex$_fasilitasusaha_pid" class="form-group fasilitasusaha_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_pid" class="form-group fasilitasusaha_pid">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="fasilitasusaha" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["ffasilitasusahagrid"], function() {
    ffasilitasusahagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.fasilitasusaha.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_pid" class="form-group fasilitasusaha_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_pid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->namausaha->Visible) { // namausaha ?>
        <td data-name="namausaha">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_namausaha" class="form-group fasilitasusaha_namausaha">
<input type="<?= $Grid->namausaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_namausaha" name="x<?= $Grid->RowIndex ?>_namausaha" id="x<?= $Grid->RowIndex ?>_namausaha" size="30" maxlength="255" value="<?= $Grid->namausaha->EditValue ?>"<?= $Grid->namausaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->namausaha->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_namausaha" class="form-group fasilitasusaha_namausaha">
<span<?= $Grid->namausaha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->namausaha->getDisplayValue($Grid->namausaha->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_namausaha" data-hidden="1" name="x<?= $Grid->RowIndex ?>_namausaha" id="x<?= $Grid->RowIndex ?>_namausaha" value="<?= HtmlEncode($Grid->namausaha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_namausaha" data-hidden="1" name="o<?= $Grid->RowIndex ?>_namausaha" id="o<?= $Grid->RowIndex ?>_namausaha" value="<?= HtmlEncode($Grid->namausaha->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bidangusaha->Visible) { // bidangusaha ?>
        <td data-name="bidangusaha">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_bidangusaha" class="form-group fasilitasusaha_bidangusaha">
<input type="<?= $Grid->bidangusaha->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bidangusaha" name="x<?= $Grid->RowIndex ?>_bidangusaha" id="x<?= $Grid->RowIndex ?>_bidangusaha" size="30" maxlength="255" value="<?= $Grid->bidangusaha->EditValue ?>"<?= $Grid->bidangusaha->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bidangusaha->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_bidangusaha" class="form-group fasilitasusaha_bidangusaha">
<span<?= $Grid->bidangusaha->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bidangusaha->getDisplayValue($Grid->bidangusaha->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bidangusaha" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bidangusaha" id="x<?= $Grid->RowIndex ?>_bidangusaha" value="<?= HtmlEncode($Grid->bidangusaha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bidangusaha" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bidangusaha" id="o<?= $Grid->RowIndex ?>_bidangusaha" value="<?= HtmlEncode($Grid->bidangusaha->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->badanhukum->Visible) { // badanhukum ?>
        <td data-name="badanhukum">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_badanhukum" class="form-group fasilitasusaha_badanhukum">
    <select
        id="x<?= $Grid->RowIndex ?>_badanhukum"
        name="x<?= $Grid->RowIndex ?>_badanhukum"
        class="form-control ew-select<?= $Grid->badanhukum->isInvalidClass() ?>"
        data-select2-id="fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum"
        data-table="fasilitasusaha"
        data-field="x_badanhukum"
        data-value-separator="<?= $Grid->badanhukum->displayValueSeparatorAttribute() ?>"
        <?= $Grid->badanhukum->editAttributes() ?>>
        <?= $Grid->badanhukum->selectOptionListHtml("x{$Grid->RowIndex}_badanhukum") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->badanhukum->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum']"),
        options = { name: "x<?= $Grid->RowIndex ?>_badanhukum", selectId: "fasilitasusaha_x<?= $Grid->RowIndex ?>_badanhukum", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.fasilitasusaha.fields.badanhukum.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.fasilitasusaha.fields.badanhukum.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_badanhukum" class="form-group fasilitasusaha_badanhukum">
<span<?= $Grid->badanhukum->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->badanhukum->getDisplayValue($Grid->badanhukum->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_badanhukum" data-hidden="1" name="x<?= $Grid->RowIndex ?>_badanhukum" id="x<?= $Grid->RowIndex ?>_badanhukum" value="<?= HtmlEncode($Grid->badanhukum->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_badanhukum" data-hidden="1" name="o<?= $Grid->RowIndex ?>_badanhukum" id="o<?= $Grid->RowIndex ?>_badanhukum" value="<?= HtmlEncode($Grid->badanhukum->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->siup->Visible) { // siup ?>
        <td data-name="siup">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_siup" class="form-group fasilitasusaha_siup">
<input type="<?= $Grid->siup->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_siup" name="x<?= $Grid->RowIndex ?>_siup" id="x<?= $Grid->RowIndex ?>_siup" size="30" maxlength="255" value="<?= $Grid->siup->EditValue ?>"<?= $Grid->siup->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->siup->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_siup" class="form-group fasilitasusaha_siup">
<span<?= $Grid->siup->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->siup->getDisplayValue($Grid->siup->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_siup" data-hidden="1" name="x<?= $Grid->RowIndex ?>_siup" id="x<?= $Grid->RowIndex ?>_siup" value="<?= HtmlEncode($Grid->siup->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_siup" data-hidden="1" name="o<?= $Grid->RowIndex ?>_siup" id="o<?= $Grid->RowIndex ?>_siup" value="<?= HtmlEncode($Grid->siup->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->bpom->Visible) { // bpom ?>
        <td data-name="bpom">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_bpom" class="form-group fasilitasusaha_bpom">
<input type="<?= $Grid->bpom->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_bpom" name="x<?= $Grid->RowIndex ?>_bpom" id="x<?= $Grid->RowIndex ?>_bpom" size="30" maxlength="255" value="<?= $Grid->bpom->EditValue ?>"<?= $Grid->bpom->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->bpom->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_bpom" class="form-group fasilitasusaha_bpom">
<span<?= $Grid->bpom->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->bpom->getDisplayValue($Grid->bpom->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bpom" data-hidden="1" name="x<?= $Grid->RowIndex ?>_bpom" id="x<?= $Grid->RowIndex ?>_bpom" value="<?= HtmlEncode($Grid->bpom->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_bpom" data-hidden="1" name="o<?= $Grid->RowIndex ?>_bpom" id="o<?= $Grid->RowIndex ?>_bpom" value="<?= HtmlEncode($Grid->bpom->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->irt->Visible) { // irt ?>
        <td data-name="irt">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_irt" class="form-group fasilitasusaha_irt">
<input type="<?= $Grid->irt->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_irt" name="x<?= $Grid->RowIndex ?>_irt" id="x<?= $Grid->RowIndex ?>_irt" size="30" maxlength="255" value="<?= $Grid->irt->EditValue ?>"<?= $Grid->irt->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->irt->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_irt" class="form-group fasilitasusaha_irt">
<span<?= $Grid->irt->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->irt->getDisplayValue($Grid->irt->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_irt" data-hidden="1" name="x<?= $Grid->RowIndex ?>_irt" id="x<?= $Grid->RowIndex ?>_irt" value="<?= HtmlEncode($Grid->irt->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_irt" data-hidden="1" name="o<?= $Grid->RowIndex ?>_irt" id="o<?= $Grid->RowIndex ?>_irt" value="<?= HtmlEncode($Grid->irt->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->potensiblm->Visible) { // potensiblm ?>
        <td data-name="potensiblm">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_potensiblm" class="form-group fasilitasusaha_potensiblm">
<input type="<?= $Grid->potensiblm->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_potensiblm" name="x<?= $Grid->RowIndex ?>_potensiblm" id="x<?= $Grid->RowIndex ?>_potensiblm" size="30" maxlength="255" value="<?= $Grid->potensiblm->EditValue ?>"<?= $Grid->potensiblm->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->potensiblm->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_potensiblm" class="form-group fasilitasusaha_potensiblm">
<span<?= $Grid->potensiblm->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->potensiblm->getDisplayValue($Grid->potensiblm->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_potensiblm" data-hidden="1" name="x<?= $Grid->RowIndex ?>_potensiblm" id="x<?= $Grid->RowIndex ?>_potensiblm" value="<?= HtmlEncode($Grid->potensiblm->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_potensiblm" data-hidden="1" name="o<?= $Grid->RowIndex ?>_potensiblm" id="o<?= $Grid->RowIndex ?>_potensiblm" value="<?= HtmlEncode($Grid->potensiblm->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->aset->Visible) { // aset ?>
        <td data-name="aset">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_aset" class="form-group fasilitasusaha_aset">
<textarea data-table="fasilitasusaha" data-field="x_aset" name="x<?= $Grid->RowIndex ?>_aset" id="x<?= $Grid->RowIndex ?>_aset" cols="3" rows="4"<?= $Grid->aset->editAttributes() ?>><?= $Grid->aset->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->aset->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_aset" class="form-group fasilitasusaha_aset">
<span<?= $Grid->aset->viewAttributes() ?>>
<?= $Grid->aset->ViewValue ?></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_aset" data-hidden="1" name="x<?= $Grid->RowIndex ?>_aset" id="x<?= $Grid->RowIndex ?>_aset" value="<?= HtmlEncode($Grid->aset->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_aset" data-hidden="1" name="o<?= $Grid->RowIndex ?>_aset" id="o<?= $Grid->RowIndex ?>_aset" value="<?= HtmlEncode($Grid->aset->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_modal->Visible) { // modal ?>
        <td data-name="_modal">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha__modal" class="form-group fasilitasusaha__modal">
<input type="<?= $Grid->_modal->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x__modal" name="x<?= $Grid->RowIndex ?>__modal" id="x<?= $Grid->RowIndex ?>__modal" size="30" maxlength="255" value="<?= $Grid->_modal->EditValue ?>"<?= $Grid->_modal->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_modal->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha__modal" class="form-group fasilitasusaha__modal">
<span<?= $Grid->_modal->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_modal->getDisplayValue($Grid->_modal->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x__modal" data-hidden="1" name="x<?= $Grid->RowIndex ?>__modal" id="x<?= $Grid->RowIndex ?>__modal" value="<?= HtmlEncode($Grid->_modal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x__modal" data-hidden="1" name="o<?= $Grid->RowIndex ?>__modal" id="o<?= $Grid->RowIndex ?>__modal" value="<?= HtmlEncode($Grid->_modal->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->hasilsetahun->Visible) { // hasilsetahun ?>
        <td data-name="hasilsetahun">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_hasilsetahun" class="form-group fasilitasusaha_hasilsetahun">
<input type="<?= $Grid->hasilsetahun->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_hasilsetahun" name="x<?= $Grid->RowIndex ?>_hasilsetahun" id="x<?= $Grid->RowIndex ?>_hasilsetahun" size="30" maxlength="255" value="<?= $Grid->hasilsetahun->EditValue ?>"<?= $Grid->hasilsetahun->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hasilsetahun->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_hasilsetahun" class="form-group fasilitasusaha_hasilsetahun">
<span<?= $Grid->hasilsetahun->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->hasilsetahun->getDisplayValue($Grid->hasilsetahun->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_hasilsetahun" data-hidden="1" name="x<?= $Grid->RowIndex ?>_hasilsetahun" id="x<?= $Grid->RowIndex ?>_hasilsetahun" value="<?= HtmlEncode($Grid->hasilsetahun->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_hasilsetahun" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hasilsetahun" id="o<?= $Grid->RowIndex ?>_hasilsetahun" value="<?= HtmlEncode($Grid->hasilsetahun->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->kendala->Visible) { // kendala ?>
        <td data-name="kendala">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_kendala" class="form-group fasilitasusaha_kendala">
<input type="<?= $Grid->kendala->getInputTextType() ?>" data-table="fasilitasusaha" data-field="x_kendala" name="x<?= $Grid->RowIndex ?>_kendala" id="x<?= $Grid->RowIndex ?>_kendala" size="30" maxlength="255" value="<?= $Grid->kendala->EditValue ?>"<?= $Grid->kendala->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->kendala->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_kendala" class="form-group fasilitasusaha_kendala">
<span<?= $Grid->kendala->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->kendala->getDisplayValue($Grid->kendala->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_kendala" data-hidden="1" name="x<?= $Grid->RowIndex ?>_kendala" id="x<?= $Grid->RowIndex ?>_kendala" value="<?= HtmlEncode($Grid->kendala->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_kendala" data-hidden="1" name="o<?= $Grid->RowIndex ?>_kendala" id="o<?= $Grid->RowIndex ?>_kendala" value="<?= HtmlEncode($Grid->kendala->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->fasilitasperlu->Visible) { // fasilitasperlu ?>
        <td data-name="fasilitasperlu">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fasilitasusaha_fasilitasperlu" class="form-group fasilitasusaha_fasilitasperlu">
<textarea data-table="fasilitasusaha" data-field="x_fasilitasperlu" name="x<?= $Grid->RowIndex ?>_fasilitasperlu" id="x<?= $Grid->RowIndex ?>_fasilitasperlu" cols="3" rows="4"<?= $Grid->fasilitasperlu->editAttributes() ?>><?= $Grid->fasilitasperlu->EditValue ?></textarea>
<div class="invalid-feedback"><?= $Grid->fasilitasperlu->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fasilitasusaha_fasilitasperlu" class="form-group fasilitasusaha_fasilitasperlu">
<span<?= $Grid->fasilitasperlu->viewAttributes() ?>>
<?= $Grid->fasilitasperlu->ViewValue ?></span>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_fasilitasperlu" data-hidden="1" name="x<?= $Grid->RowIndex ?>_fasilitasperlu" id="x<?= $Grid->RowIndex ?>_fasilitasperlu" value="<?= HtmlEncode($Grid->fasilitasperlu->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="fasilitasusaha" data-field="x_fasilitasperlu" data-hidden="1" name="o<?= $Grid->RowIndex ?>_fasilitasperlu" id="o<?= $Grid->RowIndex ?>_fasilitasperlu" value="<?= HtmlEncode($Grid->fasilitasperlu->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->foto->Visible) { // foto ?>
        <td data-name="foto">
<span id="el$rowindex$_fasilitasusaha_foto" class="form-group fasilitasusaha_foto">
<div id="fd_x<?= $Grid->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->foto->title() ?>" data-table="fasilitasusaha" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->foto->editAttributes() ?><?= ($Grid->foto->ReadOnly || $Grid->foto->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_foto"><?= $Language->phrase("ChooseFiles") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_foto" id= "fn_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_foto" id= "fa_x<?= $Grid->RowIndex ?>_foto" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_foto" id= "fs_x<?= $Grid->RowIndex ?>_foto" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_foto" id= "fx_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_foto" id= "fm_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?= $Grid->RowIndex ?>_foto" id= "fc_x<?= $Grid->RowIndex ?>_foto" value="<?= $Grid->foto->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="fasilitasusaha" data-field="x_foto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_foto" id="o<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffasilitasusahagrid","load"], function() {
    ffasilitasusahagrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="ffasilitasusahagrid">
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
    ew.addEventHandlers("fasilitasusaha");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
