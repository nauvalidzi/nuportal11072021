<?php

namespace PHPMaker2021\nuportal;

// Set up and run Grid object
$Grid = Container("WilayahGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fwilayahgrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fwilayahgrid = new ew.Form("fwilayahgrid", "grid");
    fwilayahgrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "wilayah")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.wilayah)
        ew.vars.tables.wilayah = currentTable;
    fwilayahgrid.addFields([
        ["iduser", [fields.iduser.visible && fields.iduser.required ? ew.Validators.required(fields.iduser.caption) : null], fields.iduser.isInvalid],
        ["idprovinsis", [fields.idprovinsis.visible && fields.idprovinsis.required ? ew.Validators.required(fields.idprovinsis.caption) : null], fields.idprovinsis.isInvalid],
        ["idkabupatens", [fields.idkabupatens.visible && fields.idkabupatens.required ? ew.Validators.required(fields.idkabupatens.caption) : null], fields.idkabupatens.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fwilayahgrid,
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
    fwilayahgrid.validate = function () {
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
    fwilayahgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "iduser", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idprovinsis", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idkabupatens", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fwilayahgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fwilayahgrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fwilayahgrid.lists.iduser = <?= $Grid->iduser->toClientList($Grid) ?>;
    fwilayahgrid.lists.idprovinsis = <?= $Grid->idprovinsis->toClientList($Grid) ?>;
    fwilayahgrid.lists.idkabupatens = <?= $Grid->idkabupatens->toClientList($Grid) ?>;
    loadjs.done("fwilayahgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> wilayah">
<div id="fwilayahgrid" class="ew-form ew-list-form form-inline">
<div id="gmp_wilayah" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_wilayahgrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->iduser->Visible) { // iduser ?>
        <th data-name="iduser" class="<?= $Grid->iduser->headerCellClass() ?>"><div id="elh_wilayah_iduser" class="wilayah_iduser"><?= $Grid->renderSort($Grid->iduser) ?></div></th>
<?php } ?>
<?php if ($Grid->idprovinsis->Visible) { // idprovinsis ?>
        <th data-name="idprovinsis" class="<?= $Grid->idprovinsis->headerCellClass() ?>"><div id="elh_wilayah_idprovinsis" class="wilayah_idprovinsis"><?= $Grid->renderSort($Grid->idprovinsis) ?></div></th>
<?php } ?>
<?php if ($Grid->idkabupatens->Visible) { // idkabupatens ?>
        <th data-name="idkabupatens" class="<?= $Grid->idkabupatens->headerCellClass() ?>"><div id="elh_wilayah_idkabupatens" class="wilayah_idkabupatens"><?= $Grid->renderSort($Grid->idkabupatens) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_wilayah", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->iduser->Visible) { // iduser ?>
        <td data-name="iduser" <?= $Grid->iduser->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->iduser->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_iduser" class="form-group">
<span<?= $Grid->iduser->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->iduser->getDisplayValue($Grid->iduser->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_iduser" name="x<?= $Grid->RowIndex ?>_iduser" value="<?= HtmlEncode($Grid->iduser->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_iduser" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_iduser"
        name="x<?= $Grid->RowIndex ?>_iduser"
        class="form-control ew-select<?= $Grid->iduser->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_iduser"
        data-table="wilayah"
        data-field="x_iduser"
        data-value-separator="<?= $Grid->iduser->displayValueSeparatorAttribute() ?>"
        <?= $Grid->iduser->editAttributes() ?>>
        <?= $Grid->iduser->selectOptionListHtml("x{$Grid->RowIndex}_iduser") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->iduser->getErrorMessage() ?></div>
<?= $Grid->iduser->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_iduser") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_iduser']"),
        options = { name: "x<?= $Grid->RowIndex ?>_iduser", selectId: "wilayah_x<?= $Grid->RowIndex ?>_iduser", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.iduser.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="wilayah" data-field="x_iduser" data-hidden="1" name="o<?= $Grid->RowIndex ?>_iduser" id="o<?= $Grid->RowIndex ?>_iduser" value="<?= HtmlEncode($Grid->iduser->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->iduser->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_iduser" class="form-group">
<span<?= $Grid->iduser->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->iduser->getDisplayValue($Grid->iduser->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_iduser" name="x<?= $Grid->RowIndex ?>_iduser" value="<?= HtmlEncode($Grid->iduser->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_iduser" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_iduser"
        name="x<?= $Grid->RowIndex ?>_iduser"
        class="form-control ew-select<?= $Grid->iduser->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_iduser"
        data-table="wilayah"
        data-field="x_iduser"
        data-value-separator="<?= $Grid->iduser->displayValueSeparatorAttribute() ?>"
        <?= $Grid->iduser->editAttributes() ?>>
        <?= $Grid->iduser->selectOptionListHtml("x{$Grid->RowIndex}_iduser") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->iduser->getErrorMessage() ?></div>
<?= $Grid->iduser->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_iduser") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_iduser']"),
        options = { name: "x<?= $Grid->RowIndex ?>_iduser", selectId: "wilayah_x<?= $Grid->RowIndex ?>_iduser", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.iduser.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_iduser">
<span<?= $Grid->iduser->viewAttributes() ?>>
<?= $Grid->iduser->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="wilayah" data-field="x_iduser" data-hidden="1" name="fwilayahgrid$x<?= $Grid->RowIndex ?>_iduser" id="fwilayahgrid$x<?= $Grid->RowIndex ?>_iduser" value="<?= HtmlEncode($Grid->iduser->FormValue) ?>">
<input type="hidden" data-table="wilayah" data-field="x_iduser" data-hidden="1" name="fwilayahgrid$o<?= $Grid->RowIndex ?>_iduser" id="fwilayahgrid$o<?= $Grid->RowIndex ?>_iduser" value="<?= HtmlEncode($Grid->iduser->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idprovinsis->Visible) { // idprovinsis ?>
        <td data-name="idprovinsis" <?= $Grid->idprovinsis->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_idprovinsis" class="form-group">
<?php $Grid->idprovinsis->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idprovinsis"
        name="x<?= $Grid->RowIndex ?>_idprovinsis"
        class="form-control ew-select<?= $Grid->idprovinsis->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_idprovinsis"
        data-table="wilayah"
        data-field="x_idprovinsis"
        data-value-separator="<?= $Grid->idprovinsis->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idprovinsis->editAttributes() ?>>
        <?= $Grid->idprovinsis->selectOptionListHtml("x{$Grid->RowIndex}_idprovinsis") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idprovinsis->getErrorMessage() ?></div>
<?= $Grid->idprovinsis->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idprovinsis") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_idprovinsis']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idprovinsis", selectId: "wilayah_x<?= $Grid->RowIndex ?>_idprovinsis", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.idprovinsis.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="wilayah" data-field="x_idprovinsis" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idprovinsis" id="o<?= $Grid->RowIndex ?>_idprovinsis" value="<?= HtmlEncode($Grid->idprovinsis->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_idprovinsis" class="form-group">
<?php $Grid->idprovinsis->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idprovinsis"
        name="x<?= $Grid->RowIndex ?>_idprovinsis"
        class="form-control ew-select<?= $Grid->idprovinsis->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_idprovinsis"
        data-table="wilayah"
        data-field="x_idprovinsis"
        data-value-separator="<?= $Grid->idprovinsis->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idprovinsis->editAttributes() ?>>
        <?= $Grid->idprovinsis->selectOptionListHtml("x{$Grid->RowIndex}_idprovinsis") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idprovinsis->getErrorMessage() ?></div>
<?= $Grid->idprovinsis->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idprovinsis") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_idprovinsis']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idprovinsis", selectId: "wilayah_x<?= $Grid->RowIndex ?>_idprovinsis", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.idprovinsis.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_idprovinsis">
<span<?= $Grid->idprovinsis->viewAttributes() ?>>
<?= $Grid->idprovinsis->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="wilayah" data-field="x_idprovinsis" data-hidden="1" name="fwilayahgrid$x<?= $Grid->RowIndex ?>_idprovinsis" id="fwilayahgrid$x<?= $Grid->RowIndex ?>_idprovinsis" value="<?= HtmlEncode($Grid->idprovinsis->FormValue) ?>">
<input type="hidden" data-table="wilayah" data-field="x_idprovinsis" data-hidden="1" name="fwilayahgrid$o<?= $Grid->RowIndex ?>_idprovinsis" id="fwilayahgrid$o<?= $Grid->RowIndex ?>_idprovinsis" value="<?= HtmlEncode($Grid->idprovinsis->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idkabupatens->Visible) { // idkabupatens ?>
        <td data-name="idkabupatens" <?= $Grid->idkabupatens->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_idkabupatens" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idkabupatens"
        name="x<?= $Grid->RowIndex ?>_idkabupatens"
        class="form-control ew-select<?= $Grid->idkabupatens->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_idkabupatens"
        data-table="wilayah"
        data-field="x_idkabupatens"
        data-value-separator="<?= $Grid->idkabupatens->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idkabupatens->editAttributes() ?>>
        <?= $Grid->idkabupatens->selectOptionListHtml("x{$Grid->RowIndex}_idkabupatens") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkabupatens->getErrorMessage() ?></div>
<?= $Grid->idkabupatens->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkabupatens") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_idkabupatens']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkabupatens", selectId: "wilayah_x<?= $Grid->RowIndex ?>_idkabupatens", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.idkabupatens.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="wilayah" data-field="x_idkabupatens" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idkabupatens" id="o<?= $Grid->RowIndex ?>_idkabupatens" value="<?= HtmlEncode($Grid->idkabupatens->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_idkabupatens" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idkabupatens"
        name="x<?= $Grid->RowIndex ?>_idkabupatens"
        class="form-control ew-select<?= $Grid->idkabupatens->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_idkabupatens"
        data-table="wilayah"
        data-field="x_idkabupatens"
        data-value-separator="<?= $Grid->idkabupatens->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idkabupatens->editAttributes() ?>>
        <?= $Grid->idkabupatens->selectOptionListHtml("x{$Grid->RowIndex}_idkabupatens") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkabupatens->getErrorMessage() ?></div>
<?= $Grid->idkabupatens->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkabupatens") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_idkabupatens']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkabupatens", selectId: "wilayah_x<?= $Grid->RowIndex ?>_idkabupatens", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.idkabupatens.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_wilayah_idkabupatens">
<span<?= $Grid->idkabupatens->viewAttributes() ?>>
<?= $Grid->idkabupatens->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="wilayah" data-field="x_idkabupatens" data-hidden="1" name="fwilayahgrid$x<?= $Grid->RowIndex ?>_idkabupatens" id="fwilayahgrid$x<?= $Grid->RowIndex ?>_idkabupatens" value="<?= HtmlEncode($Grid->idkabupatens->FormValue) ?>">
<input type="hidden" data-table="wilayah" data-field="x_idkabupatens" data-hidden="1" name="fwilayahgrid$o<?= $Grid->RowIndex ?>_idkabupatens" id="fwilayahgrid$o<?= $Grid->RowIndex ?>_idkabupatens" value="<?= HtmlEncode($Grid->idkabupatens->OldValue) ?>">
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
loadjs.ready(["fwilayahgrid","load"], function () {
    fwilayahgrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_wilayah", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->iduser->Visible) { // iduser ?>
        <td data-name="iduser">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->iduser->getSessionValue() != "") { ?>
<span id="el$rowindex$_wilayah_iduser" class="form-group wilayah_iduser">
<span<?= $Grid->iduser->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->iduser->getDisplayValue($Grid->iduser->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_iduser" name="x<?= $Grid->RowIndex ?>_iduser" value="<?= HtmlEncode($Grid->iduser->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_wilayah_iduser" class="form-group wilayah_iduser">
    <select
        id="x<?= $Grid->RowIndex ?>_iduser"
        name="x<?= $Grid->RowIndex ?>_iduser"
        class="form-control ew-select<?= $Grid->iduser->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_iduser"
        data-table="wilayah"
        data-field="x_iduser"
        data-value-separator="<?= $Grid->iduser->displayValueSeparatorAttribute() ?>"
        <?= $Grid->iduser->editAttributes() ?>>
        <?= $Grid->iduser->selectOptionListHtml("x{$Grid->RowIndex}_iduser") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->iduser->getErrorMessage() ?></div>
<?= $Grid->iduser->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_iduser") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_iduser']"),
        options = { name: "x<?= $Grid->RowIndex ?>_iduser", selectId: "wilayah_x<?= $Grid->RowIndex ?>_iduser", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.iduser.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_wilayah_iduser" class="form-group wilayah_iduser">
<span<?= $Grid->iduser->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->iduser->getDisplayValue($Grid->iduser->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="wilayah" data-field="x_iduser" data-hidden="1" name="x<?= $Grid->RowIndex ?>_iduser" id="x<?= $Grid->RowIndex ?>_iduser" value="<?= HtmlEncode($Grid->iduser->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="wilayah" data-field="x_iduser" data-hidden="1" name="o<?= $Grid->RowIndex ?>_iduser" id="o<?= $Grid->RowIndex ?>_iduser" value="<?= HtmlEncode($Grid->iduser->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idprovinsis->Visible) { // idprovinsis ?>
        <td data-name="idprovinsis">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_wilayah_idprovinsis" class="form-group wilayah_idprovinsis">
<?php $Grid->idprovinsis->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_idprovinsis"
        name="x<?= $Grid->RowIndex ?>_idprovinsis"
        class="form-control ew-select<?= $Grid->idprovinsis->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_idprovinsis"
        data-table="wilayah"
        data-field="x_idprovinsis"
        data-value-separator="<?= $Grid->idprovinsis->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idprovinsis->editAttributes() ?>>
        <?= $Grid->idprovinsis->selectOptionListHtml("x{$Grid->RowIndex}_idprovinsis") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idprovinsis->getErrorMessage() ?></div>
<?= $Grid->idprovinsis->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idprovinsis") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_idprovinsis']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idprovinsis", selectId: "wilayah_x<?= $Grid->RowIndex ?>_idprovinsis", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.idprovinsis.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_wilayah_idprovinsis" class="form-group wilayah_idprovinsis">
<span<?= $Grid->idprovinsis->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idprovinsis->getDisplayValue($Grid->idprovinsis->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="wilayah" data-field="x_idprovinsis" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idprovinsis" id="x<?= $Grid->RowIndex ?>_idprovinsis" value="<?= HtmlEncode($Grid->idprovinsis->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="wilayah" data-field="x_idprovinsis" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idprovinsis" id="o<?= $Grid->RowIndex ?>_idprovinsis" value="<?= HtmlEncode($Grid->idprovinsis->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idkabupatens->Visible) { // idkabupatens ?>
        <td data-name="idkabupatens">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_wilayah_idkabupatens" class="form-group wilayah_idkabupatens">
    <select
        id="x<?= $Grid->RowIndex ?>_idkabupatens"
        name="x<?= $Grid->RowIndex ?>_idkabupatens"
        class="form-control ew-select<?= $Grid->idkabupatens->isInvalidClass() ?>"
        data-select2-id="wilayah_x<?= $Grid->RowIndex ?>_idkabupatens"
        data-table="wilayah"
        data-field="x_idkabupatens"
        data-value-separator="<?= $Grid->idkabupatens->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idkabupatens->editAttributes() ?>>
        <?= $Grid->idkabupatens->selectOptionListHtml("x{$Grid->RowIndex}_idkabupatens") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idkabupatens->getErrorMessage() ?></div>
<?= $Grid->idkabupatens->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idkabupatens") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='wilayah_x<?= $Grid->RowIndex ?>_idkabupatens']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idkabupatens", selectId: "wilayah_x<?= $Grid->RowIndex ?>_idkabupatens", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.wilayah.fields.idkabupatens.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_wilayah_idkabupatens" class="form-group wilayah_idkabupatens">
<span<?= $Grid->idkabupatens->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idkabupatens->getDisplayValue($Grid->idkabupatens->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="wilayah" data-field="x_idkabupatens" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idkabupatens" id="x<?= $Grid->RowIndex ?>_idkabupatens" value="<?= HtmlEncode($Grid->idkabupatens->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="wilayah" data-field="x_idkabupatens" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idkabupatens" id="o<?= $Grid->RowIndex ?>_idkabupatens" value="<?= HtmlEncode($Grid->idkabupatens->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fwilayahgrid","load"], function() {
    fwilayahgrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fwilayahgrid">
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
    ew.addEventHandlers("wilayah");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
