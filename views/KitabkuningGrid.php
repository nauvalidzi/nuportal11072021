<?php

namespace PHPMaker2021\nuportal;

// Set up and run Grid object
$Grid = Container("KitabkuningGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fkitabkuninggrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fkitabkuninggrid = new ew.Form("fkitabkuninggrid", "grid");
    fkitabkuninggrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "kitabkuning")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.kitabkuning)
        ew.vars.tables.kitabkuning = currentTable;
    fkitabkuninggrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null, ew.Validators.integer], fields.pid.isInvalid],
        ["pelaksanaan", [fields.pelaksanaan.visible && fields.pelaksanaan.required ? ew.Validators.required(fields.pelaksanaan.caption) : null], fields.pelaksanaan.isInvalid],
        ["metode", [fields.metode.visible && fields.metode.required ? ew.Validators.required(fields.metode.caption) : null], fields.metode.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fkitabkuninggrid,
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
    fkitabkuninggrid.validate = function () {
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
    fkitabkuninggrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "pid", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "pelaksanaan", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "metode", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fkitabkuninggrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fkitabkuninggrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fkitabkuninggrid.lists.pid = <?= $Grid->pid->toClientList($Grid) ?>;
    fkitabkuninggrid.lists.pelaksanaan = <?= $Grid->pelaksanaan->toClientList($Grid) ?>;
    fkitabkuninggrid.lists.metode = <?= $Grid->metode->toClientList($Grid) ?>;
    loadjs.done("fkitabkuninggrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> kitabkuning">
<div id="fkitabkuninggrid" class="ew-form ew-list-form form-inline">
<div id="gmp_kitabkuning" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_kitabkuninggrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_kitabkuning_id" class="kitabkuning_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Grid->pid->headerCellClass() ?>"><div id="elh_kitabkuning_pid" class="kitabkuning_pid"><?= $Grid->renderSort($Grid->pid) ?></div></th>
<?php } ?>
<?php if ($Grid->pelaksanaan->Visible) { // pelaksanaan ?>
        <th data-name="pelaksanaan" class="<?= $Grid->pelaksanaan->headerCellClass() ?>"><div id="elh_kitabkuning_pelaksanaan" class="kitabkuning_pelaksanaan"><?= $Grid->renderSort($Grid->pelaksanaan) ?></div></th>
<?php } ?>
<?php if ($Grid->metode->Visible) { // metode ?>
        <th data-name="metode" class="<?= $Grid->metode->headerCellClass() ?>"><div id="elh_kitabkuning_metode" class="kitabkuning_metode"><?= $Grid->renderSort($Grid->metode) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_kitabkuning", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_kitabkuning_id" class="form-group"></span>
<input type="hidden" data-table="kitabkuning" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="kitabkuning" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="kitabkuning" data-field="x_id" data-hidden="1" name="fkitabkuninggrid$x<?= $Grid->RowIndex ?>_id" id="fkitabkuninggrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="kitabkuning" data-field="x_id" data-hidden="1" name="fkitabkuninggrid$o<?= $Grid->RowIndex ?>_id" id="fkitabkuninggrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="kitabkuning" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Grid->pid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_pid" class="form-group">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="kitabkuning" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fkitabkuninggrid"], function() {
    fkitabkuninggrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.kitabkuning.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<input type="hidden" data-table="kitabkuning" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_pid" class="form-group">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="kitabkuning" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fkitabkuninggrid"], function() {
    fkitabkuninggrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.kitabkuning.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<?= $Grid->pid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="kitabkuning" data-field="x_pid" data-hidden="1" name="fkitabkuninggrid$x<?= $Grid->RowIndex ?>_pid" id="fkitabkuninggrid$x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<input type="hidden" data-table="kitabkuning" data-field="x_pid" data-hidden="1" name="fkitabkuninggrid$o<?= $Grid->RowIndex ?>_pid" id="fkitabkuninggrid$o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->pelaksanaan->Visible) { // pelaksanaan ?>
        <td data-name="pelaksanaan" <?= $Grid->pelaksanaan->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_pelaksanaan" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_pelaksanaan"
        name="x<?= $Grid->RowIndex ?>_pelaksanaan"
        class="form-control ew-select<?= $Grid->pelaksanaan->isInvalidClass() ?>"
        data-select2-id="kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan"
        data-table="kitabkuning"
        data-field="x_pelaksanaan"
        data-value-separator="<?= $Grid->pelaksanaan->displayValueSeparatorAttribute() ?>"
        <?= $Grid->pelaksanaan->editAttributes() ?>>
        <?= $Grid->pelaksanaan->selectOptionListHtml("x{$Grid->RowIndex}_pelaksanaan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pelaksanaan->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pelaksanaan", selectId: "kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.kitabkuning.fields.pelaksanaan.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kitabkuning.fields.pelaksanaan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="kitabkuning" data-field="x_pelaksanaan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pelaksanaan" id="o<?= $Grid->RowIndex ?>_pelaksanaan" value="<?= HtmlEncode($Grid->pelaksanaan->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_pelaksanaan" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_pelaksanaan"
        name="x<?= $Grid->RowIndex ?>_pelaksanaan"
        class="form-control ew-select<?= $Grid->pelaksanaan->isInvalidClass() ?>"
        data-select2-id="kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan"
        data-table="kitabkuning"
        data-field="x_pelaksanaan"
        data-value-separator="<?= $Grid->pelaksanaan->displayValueSeparatorAttribute() ?>"
        <?= $Grid->pelaksanaan->editAttributes() ?>>
        <?= $Grid->pelaksanaan->selectOptionListHtml("x{$Grid->RowIndex}_pelaksanaan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pelaksanaan->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pelaksanaan", selectId: "kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.kitabkuning.fields.pelaksanaan.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kitabkuning.fields.pelaksanaan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_pelaksanaan">
<span<?= $Grid->pelaksanaan->viewAttributes() ?>>
<?= $Grid->pelaksanaan->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="kitabkuning" data-field="x_pelaksanaan" data-hidden="1" name="fkitabkuninggrid$x<?= $Grid->RowIndex ?>_pelaksanaan" id="fkitabkuninggrid$x<?= $Grid->RowIndex ?>_pelaksanaan" value="<?= HtmlEncode($Grid->pelaksanaan->FormValue) ?>">
<input type="hidden" data-table="kitabkuning" data-field="x_pelaksanaan" data-hidden="1" name="fkitabkuninggrid$o<?= $Grid->RowIndex ?>_pelaksanaan" id="fkitabkuninggrid$o<?= $Grid->RowIndex ?>_pelaksanaan" value="<?= HtmlEncode($Grid->pelaksanaan->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->metode->Visible) { // metode ?>
        <td data-name="metode" <?= $Grid->metode->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_metode" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_metode"
        name="x<?= $Grid->RowIndex ?>_metode"
        class="form-control ew-select<?= $Grid->metode->isInvalidClass() ?>"
        data-select2-id="kitabkuning_x<?= $Grid->RowIndex ?>_metode"
        data-table="kitabkuning"
        data-field="x_metode"
        data-value-separator="<?= $Grid->metode->displayValueSeparatorAttribute() ?>"
        <?= $Grid->metode->editAttributes() ?>>
        <?= $Grid->metode->selectOptionListHtml("x{$Grid->RowIndex}_metode") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->metode->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='kitabkuning_x<?= $Grid->RowIndex ?>_metode']"),
        options = { name: "x<?= $Grid->RowIndex ?>_metode", selectId: "kitabkuning_x<?= $Grid->RowIndex ?>_metode", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.kitabkuning.fields.metode.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kitabkuning.fields.metode.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="kitabkuning" data-field="x_metode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_metode" id="o<?= $Grid->RowIndex ?>_metode" value="<?= HtmlEncode($Grid->metode->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_metode" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_metode"
        name="x<?= $Grid->RowIndex ?>_metode"
        class="form-control ew-select<?= $Grid->metode->isInvalidClass() ?>"
        data-select2-id="kitabkuning_x<?= $Grid->RowIndex ?>_metode"
        data-table="kitabkuning"
        data-field="x_metode"
        data-value-separator="<?= $Grid->metode->displayValueSeparatorAttribute() ?>"
        <?= $Grid->metode->editAttributes() ?>>
        <?= $Grid->metode->selectOptionListHtml("x{$Grid->RowIndex}_metode") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->metode->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='kitabkuning_x<?= $Grid->RowIndex ?>_metode']"),
        options = { name: "x<?= $Grid->RowIndex ?>_metode", selectId: "kitabkuning_x<?= $Grid->RowIndex ?>_metode", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.kitabkuning.fields.metode.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kitabkuning.fields.metode.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_kitabkuning_metode">
<span<?= $Grid->metode->viewAttributes() ?>>
<?= $Grid->metode->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="kitabkuning" data-field="x_metode" data-hidden="1" name="fkitabkuninggrid$x<?= $Grid->RowIndex ?>_metode" id="fkitabkuninggrid$x<?= $Grid->RowIndex ?>_metode" value="<?= HtmlEncode($Grid->metode->FormValue) ?>">
<input type="hidden" data-table="kitabkuning" data-field="x_metode" data-hidden="1" name="fkitabkuninggrid$o<?= $Grid->RowIndex ?>_metode" id="fkitabkuninggrid$o<?= $Grid->RowIndex ?>_metode" value="<?= HtmlEncode($Grid->metode->OldValue) ?>">
<?php } ?>
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
loadjs.ready(["fkitabkuninggrid","load"], function () {
    fkitabkuninggrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_kitabkuning", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_kitabkuning_id" class="form-group kitabkuning_id"></span>
<?php } else { ?>
<span id="el$rowindex$_kitabkuning_id" class="form-group kitabkuning_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="kitabkuning" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="kitabkuning" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el$rowindex$_kitabkuning_pid" class="form-group kitabkuning_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_kitabkuning_pid" class="form-group kitabkuning_pid">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="kitabkuning" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fkitabkuninggrid"], function() {
    fkitabkuninggrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.kitabkuning.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_kitabkuning_pid" class="form-group kitabkuning_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="kitabkuning" data-field="x_pid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="kitabkuning" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pelaksanaan->Visible) { // pelaksanaan ?>
        <td data-name="pelaksanaan">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_kitabkuning_pelaksanaan" class="form-group kitabkuning_pelaksanaan">
    <select
        id="x<?= $Grid->RowIndex ?>_pelaksanaan"
        name="x<?= $Grid->RowIndex ?>_pelaksanaan"
        class="form-control ew-select<?= $Grid->pelaksanaan->isInvalidClass() ?>"
        data-select2-id="kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan"
        data-table="kitabkuning"
        data-field="x_pelaksanaan"
        data-value-separator="<?= $Grid->pelaksanaan->displayValueSeparatorAttribute() ?>"
        <?= $Grid->pelaksanaan->editAttributes() ?>>
        <?= $Grid->pelaksanaan->selectOptionListHtml("x{$Grid->RowIndex}_pelaksanaan") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pelaksanaan->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pelaksanaan", selectId: "kitabkuning_x<?= $Grid->RowIndex ?>_pelaksanaan", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.kitabkuning.fields.pelaksanaan.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kitabkuning.fields.pelaksanaan.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_kitabkuning_pelaksanaan" class="form-group kitabkuning_pelaksanaan">
<span<?= $Grid->pelaksanaan->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pelaksanaan->getDisplayValue($Grid->pelaksanaan->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="kitabkuning" data-field="x_pelaksanaan" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pelaksanaan" id="x<?= $Grid->RowIndex ?>_pelaksanaan" value="<?= HtmlEncode($Grid->pelaksanaan->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="kitabkuning" data-field="x_pelaksanaan" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pelaksanaan" id="o<?= $Grid->RowIndex ?>_pelaksanaan" value="<?= HtmlEncode($Grid->pelaksanaan->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->metode->Visible) { // metode ?>
        <td data-name="metode">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_kitabkuning_metode" class="form-group kitabkuning_metode">
    <select
        id="x<?= $Grid->RowIndex ?>_metode"
        name="x<?= $Grid->RowIndex ?>_metode"
        class="form-control ew-select<?= $Grid->metode->isInvalidClass() ?>"
        data-select2-id="kitabkuning_x<?= $Grid->RowIndex ?>_metode"
        data-table="kitabkuning"
        data-field="x_metode"
        data-value-separator="<?= $Grid->metode->displayValueSeparatorAttribute() ?>"
        <?= $Grid->metode->editAttributes() ?>>
        <?= $Grid->metode->selectOptionListHtml("x{$Grid->RowIndex}_metode") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->metode->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='kitabkuning_x<?= $Grid->RowIndex ?>_metode']"),
        options = { name: "x<?= $Grid->RowIndex ?>_metode", selectId: "kitabkuning_x<?= $Grid->RowIndex ?>_metode", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.kitabkuning.fields.metode.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.kitabkuning.fields.metode.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_kitabkuning_metode" class="form-group kitabkuning_metode">
<span<?= $Grid->metode->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->metode->getDisplayValue($Grid->metode->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="kitabkuning" data-field="x_metode" data-hidden="1" name="x<?= $Grid->RowIndex ?>_metode" id="x<?= $Grid->RowIndex ?>_metode" value="<?= HtmlEncode($Grid->metode->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="kitabkuning" data-field="x_metode" data-hidden="1" name="o<?= $Grid->RowIndex ?>_metode" id="o<?= $Grid->RowIndex ?>_metode" value="<?= HtmlEncode($Grid->metode->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fkitabkuninggrid","load"], function() {
    fkitabkuninggrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fkitabkuninggrid">
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
    ew.addEventHandlers("kitabkuning");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
