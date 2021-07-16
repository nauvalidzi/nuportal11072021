<?php

namespace PHPMaker2021\nuportal;

// Set up and run Grid object
$Grid = Container("PendidikanpesantrenGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpendidikanpesantrengrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fpendidikanpesantrengrid = new ew.Form("fpendidikanpesantrengrid", "grid");
    fpendidikanpesantrengrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pendidikanpesantren")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pendidikanpesantren)
        ew.vars.tables.pendidikanpesantren = currentTable;
    fpendidikanpesantrengrid.addFields([
        ["pid", [fields.pid.visible && fields.pid.required ? ew.Validators.required(fields.pid.caption) : null], fields.pid.isInvalid],
        ["idjenispp", [fields.idjenispp.visible && fields.idjenispp.required ? ew.Validators.required(fields.idjenispp.caption) : null], fields.idjenispp.isInvalid],
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["ijin", [fields.ijin.visible && fields.ijin.required ? ew.Validators.required(fields.ijin.caption) : null], fields.ijin.isInvalid],
        ["tglberdiri", [fields.tglberdiri.visible && fields.tglberdiri.required ? ew.Validators.required(fields.tglberdiri.caption) : null, ew.Validators.datetime(0)], fields.tglberdiri.isInvalid],
        ["ijinakhir", [fields.ijinakhir.visible && fields.ijinakhir.required ? ew.Validators.required(fields.ijinakhir.caption) : null, ew.Validators.datetime(0)], fields.ijinakhir.isInvalid],
        ["jumlahpengajar", [fields.jumlahpengajar.visible && fields.jumlahpengajar.required ? ew.Validators.required(fields.jumlahpengajar.caption) : null], fields.jumlahpengajar.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.required(fields.foto.caption) : null], fields.foto.isInvalid],
        ["dokumen", [fields.dokumen.visible && fields.dokumen.required ? ew.Validators.required(fields.dokumen.caption) : null], fields.dokumen.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpendidikanpesantrengrid,
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
    fpendidikanpesantrengrid.validate = function () {
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
    fpendidikanpesantrengrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "pid", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "idjenispp", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ijin", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglberdiri", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ijinakhir", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jumlahpengajar", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "foto", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "dokumen", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fpendidikanpesantrengrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpendidikanpesantrengrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpendidikanpesantrengrid.lists.pid = <?= $Grid->pid->toClientList($Grid) ?>;
    fpendidikanpesantrengrid.lists.idjenispp = <?= $Grid->idjenispp->toClientList($Grid) ?>;
    loadjs.done("fpendidikanpesantrengrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pendidikanpesantren">
<div id="fpendidikanpesantrengrid" class="ew-form ew-list-form form-inline">
<div id="gmp_pendidikanpesantren" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_pendidikanpesantrengrid" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Grid->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Grid->pid->headerCellClass() ?>"><div id="elh_pendidikanpesantren_pid" class="pendidikanpesantren_pid"><?= $Grid->renderSort($Grid->pid) ?></div></th>
<?php } ?>
<?php if ($Grid->idjenispp->Visible) { // idjenispp ?>
        <th data-name="idjenispp" class="<?= $Grid->idjenispp->headerCellClass() ?>"><div id="elh_pendidikanpesantren_idjenispp" class="pendidikanpesantren_idjenispp"><?= $Grid->renderSort($Grid->idjenispp) ?></div></th>
<?php } ?>
<?php if ($Grid->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Grid->nama->headerCellClass() ?>"><div id="elh_pendidikanpesantren_nama" class="pendidikanpesantren_nama"><?= $Grid->renderSort($Grid->nama) ?></div></th>
<?php } ?>
<?php if ($Grid->ijin->Visible) { // ijin ?>
        <th data-name="ijin" class="<?= $Grid->ijin->headerCellClass() ?>"><div id="elh_pendidikanpesantren_ijin" class="pendidikanpesantren_ijin"><?= $Grid->renderSort($Grid->ijin) ?></div></th>
<?php } ?>
<?php if ($Grid->tglberdiri->Visible) { // tglberdiri ?>
        <th data-name="tglberdiri" class="<?= $Grid->tglberdiri->headerCellClass() ?>"><div id="elh_pendidikanpesantren_tglberdiri" class="pendidikanpesantren_tglberdiri"><?= $Grid->renderSort($Grid->tglberdiri) ?></div></th>
<?php } ?>
<?php if ($Grid->ijinakhir->Visible) { // ijinakhir ?>
        <th data-name="ijinakhir" class="<?= $Grid->ijinakhir->headerCellClass() ?>"><div id="elh_pendidikanpesantren_ijinakhir" class="pendidikanpesantren_ijinakhir"><?= $Grid->renderSort($Grid->ijinakhir) ?></div></th>
<?php } ?>
<?php if ($Grid->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <th data-name="jumlahpengajar" class="<?= $Grid->jumlahpengajar->headerCellClass() ?>"><div id="elh_pendidikanpesantren_jumlahpengajar" class="pendidikanpesantren_jumlahpengajar"><?= $Grid->renderSort($Grid->jumlahpengajar) ?></div></th>
<?php } ?>
<?php if ($Grid->foto->Visible) { // foto ?>
        <th data-name="foto" class="<?= $Grid->foto->headerCellClass() ?>"><div id="elh_pendidikanpesantren_foto" class="pendidikanpesantren_foto"><?= $Grid->renderSort($Grid->foto) ?></div></th>
<?php } ?>
<?php if ($Grid->dokumen->Visible) { // dokumen ?>
        <th data-name="dokumen" class="<?= $Grid->dokumen->headerCellClass() ?>"><div id="elh_pendidikanpesantren_dokumen" class="pendidikanpesantren_dokumen"><?= $Grid->renderSort($Grid->dokumen) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_pendidikanpesantren", "data-rowtype" => $Grid->RowType]);

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
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Grid->pid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_pid" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_pid"
        name="x<?= $Grid->RowIndex ?>_pid"
        class="form-control ew-select<?= $Grid->pid->isInvalidClass() ?>"
        data-select2-id="pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid"
        data-table="pendidikanpesantren"
        data-field="x_pid"
        data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>"
        <?= $Grid->pid->editAttributes() ?>>
        <?= $Grid->pid->selectOptionListHtml("x{$Grid->RowIndex}_pid") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pid", selectId: "pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanpesantren.fields.pid.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_pid" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_pid"
        name="x<?= $Grid->RowIndex ?>_pid"
        class="form-control ew-select<?= $Grid->pid->isInvalidClass() ?>"
        data-select2-id="pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid"
        data-table="pendidikanpesantren"
        data-field="x_pid"
        data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>"
        <?= $Grid->pid->editAttributes() ?>>
        <?= $Grid->pid->selectOptionListHtml("x{$Grid->RowIndex}_pid") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pid", selectId: "pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanpesantren.fields.pid.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<?= $Grid->pid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_pid" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_pid" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_pid" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_pid" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->idjenispp->Visible) { // idjenispp ?>
        <td data-name="idjenispp" <?= $Grid->idjenispp->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->idjenispp->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_idjenispp" class="form-group">
<span<?= $Grid->idjenispp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idjenispp->getDisplayValue($Grid->idjenispp->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idjenispp" name="x<?= $Grid->RowIndex ?>_idjenispp" value="<?= HtmlEncode($Grid->idjenispp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_idjenispp" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idjenispp"
        name="x<?= $Grid->RowIndex ?>_idjenispp"
        class="form-control ew-select<?= $Grid->idjenispp->isInvalidClass() ?>"
        data-select2-id="pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp"
        data-table="pendidikanpesantren"
        data-field="x_idjenispp"
        data-value-separator="<?= $Grid->idjenispp->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idjenispp->editAttributes() ?>>
        <?= $Grid->idjenispp->selectOptionListHtml("x{$Grid->RowIndex}_idjenispp") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idjenispp->getErrorMessage() ?></div>
<?= $Grid->idjenispp->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idjenispp") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idjenispp", selectId: "pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanpesantren.fields.idjenispp.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_idjenispp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idjenispp" id="o<?= $Grid->RowIndex ?>_idjenispp" value="<?= HtmlEncode($Grid->idjenispp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->idjenispp->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_idjenispp" class="form-group">
<span<?= $Grid->idjenispp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idjenispp->getDisplayValue($Grid->idjenispp->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idjenispp" name="x<?= $Grid->RowIndex ?>_idjenispp" value="<?= HtmlEncode($Grid->idjenispp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_idjenispp" class="form-group">
    <select
        id="x<?= $Grid->RowIndex ?>_idjenispp"
        name="x<?= $Grid->RowIndex ?>_idjenispp"
        class="form-control ew-select<?= $Grid->idjenispp->isInvalidClass() ?>"
        data-select2-id="pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp"
        data-table="pendidikanpesantren"
        data-field="x_idjenispp"
        data-value-separator="<?= $Grid->idjenispp->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idjenispp->editAttributes() ?>>
        <?= $Grid->idjenispp->selectOptionListHtml("x{$Grid->RowIndex}_idjenispp") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idjenispp->getErrorMessage() ?></div>
<?= $Grid->idjenispp->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idjenispp") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idjenispp", selectId: "pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanpesantren.fields.idjenispp.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_idjenispp">
<span<?= $Grid->idjenispp->viewAttributes() ?>>
<?= $Grid->idjenispp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_idjenispp" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_idjenispp" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_idjenispp" value="<?= HtmlEncode($Grid->idjenispp->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_idjenispp" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_idjenispp" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_idjenispp" value="<?= HtmlEncode($Grid->idjenispp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Grid->nama->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<?= $Grid->nama->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_nama" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_nama" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_nama" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_nama" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ijin->Visible) { // ijin ?>
        <td data-name="ijin" <?= $Grid->ijin->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_ijin" class="form-group">
<input type="<?= $Grid->ijin->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_ijin" name="x<?= $Grid->RowIndex ?>_ijin" id="x<?= $Grid->RowIndex ?>_ijin" size="30" maxlength="255" value="<?= $Grid->ijin->EditValue ?>"<?= $Grid->ijin->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijin->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijin" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijin" id="o<?= $Grid->RowIndex ?>_ijin" value="<?= HtmlEncode($Grid->ijin->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_ijin" class="form-group">
<input type="<?= $Grid->ijin->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_ijin" name="x<?= $Grid->RowIndex ?>_ijin" id="x<?= $Grid->RowIndex ?>_ijin" size="30" maxlength="255" value="<?= $Grid->ijin->EditValue ?>"<?= $Grid->ijin->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijin->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_ijin">
<span<?= $Grid->ijin->viewAttributes() ?>>
<?= $Grid->ijin->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijin" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_ijin" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_ijin" value="<?= HtmlEncode($Grid->ijin->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijin" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_ijin" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_ijin" value="<?= HtmlEncode($Grid->ijin->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglberdiri->Visible) { // tglberdiri ?>
        <td data-name="tglberdiri" <?= $Grid->tglberdiri->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_tglberdiri" class="form-group">
<input type="<?= $Grid->tglberdiri->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_tglberdiri" name="x<?= $Grid->RowIndex ?>_tglberdiri" id="x<?= $Grid->RowIndex ?>_tglberdiri" value="<?= $Grid->tglberdiri->EditValue ?>"<?= $Grid->tglberdiri->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglberdiri->getErrorMessage() ?></div>
<?php if (!$Grid->tglberdiri->ReadOnly && !$Grid->tglberdiri->Disabled && !isset($Grid->tglberdiri->EditAttrs["readonly"]) && !isset($Grid->tglberdiri->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanpesantrengrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanpesantrengrid", "x<?= $Grid->RowIndex ?>_tglberdiri", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_tglberdiri" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglberdiri" id="o<?= $Grid->RowIndex ?>_tglberdiri" value="<?= HtmlEncode($Grid->tglberdiri->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_tglberdiri" class="form-group">
<input type="<?= $Grid->tglberdiri->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_tglberdiri" name="x<?= $Grid->RowIndex ?>_tglberdiri" id="x<?= $Grid->RowIndex ?>_tglberdiri" value="<?= $Grid->tglberdiri->EditValue ?>"<?= $Grid->tglberdiri->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglberdiri->getErrorMessage() ?></div>
<?php if (!$Grid->tglberdiri->ReadOnly && !$Grid->tglberdiri->Disabled && !isset($Grid->tglberdiri->EditAttrs["readonly"]) && !isset($Grid->tglberdiri->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanpesantrengrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanpesantrengrid", "x<?= $Grid->RowIndex ?>_tglberdiri", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_tglberdiri">
<span<?= $Grid->tglberdiri->viewAttributes() ?>>
<?= $Grid->tglberdiri->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_tglberdiri" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_tglberdiri" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_tglberdiri" value="<?= HtmlEncode($Grid->tglberdiri->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_tglberdiri" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_tglberdiri" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_tglberdiri" value="<?= HtmlEncode($Grid->tglberdiri->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ijinakhir->Visible) { // ijinakhir ?>
        <td data-name="ijinakhir" <?= $Grid->ijinakhir->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_ijinakhir" class="form-group">
<input type="<?= $Grid->ijinakhir->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_ijinakhir" name="x<?= $Grid->RowIndex ?>_ijinakhir" id="x<?= $Grid->RowIndex ?>_ijinakhir" value="<?= $Grid->ijinakhir->EditValue ?>"<?= $Grid->ijinakhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinakhir->getErrorMessage() ?></div>
<?php if (!$Grid->ijinakhir->ReadOnly && !$Grid->ijinakhir->Disabled && !isset($Grid->ijinakhir->EditAttrs["readonly"]) && !isset($Grid->ijinakhir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanpesantrengrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanpesantrengrid", "x<?= $Grid->RowIndex ?>_ijinakhir", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijinakhir" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijinakhir" id="o<?= $Grid->RowIndex ?>_ijinakhir" value="<?= HtmlEncode($Grid->ijinakhir->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_ijinakhir" class="form-group">
<input type="<?= $Grid->ijinakhir->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_ijinakhir" name="x<?= $Grid->RowIndex ?>_ijinakhir" id="x<?= $Grid->RowIndex ?>_ijinakhir" value="<?= $Grid->ijinakhir->EditValue ?>"<?= $Grid->ijinakhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinakhir->getErrorMessage() ?></div>
<?php if (!$Grid->ijinakhir->ReadOnly && !$Grid->ijinakhir->Disabled && !isset($Grid->ijinakhir->EditAttrs["readonly"]) && !isset($Grid->ijinakhir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanpesantrengrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanpesantrengrid", "x<?= $Grid->RowIndex ?>_ijinakhir", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_ijinakhir">
<span<?= $Grid->ijinakhir->viewAttributes() ?>>
<?= $Grid->ijinakhir->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijinakhir" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_ijinakhir" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_ijinakhir" value="<?= HtmlEncode($Grid->ijinakhir->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijinakhir" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_ijinakhir" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_ijinakhir" value="<?= HtmlEncode($Grid->ijinakhir->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <td data-name="jumlahpengajar" <?= $Grid->jumlahpengajar->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_jumlahpengajar" class="form-group">
<input type="<?= $Grid->jumlahpengajar->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" name="x<?= $Grid->RowIndex ?>_jumlahpengajar" id="x<?= $Grid->RowIndex ?>_jumlahpengajar" size="30" maxlength="255" value="<?= $Grid->jumlahpengajar->EditValue ?>"<?= $Grid->jumlahpengajar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahpengajar->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahpengajar" id="o<?= $Grid->RowIndex ?>_jumlahpengajar" value="<?= HtmlEncode($Grid->jumlahpengajar->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_jumlahpengajar" class="form-group">
<input type="<?= $Grid->jumlahpengajar->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" name="x<?= $Grid->RowIndex ?>_jumlahpengajar" id="x<?= $Grid->RowIndex ?>_jumlahpengajar" size="30" maxlength="255" value="<?= $Grid->jumlahpengajar->EditValue ?>"<?= $Grid->jumlahpengajar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahpengajar->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_jumlahpengajar">
<span<?= $Grid->jumlahpengajar->viewAttributes() ?>>
<?= $Grid->jumlahpengajar->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_jumlahpengajar" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_jumlahpengajar" value="<?= HtmlEncode($Grid->jumlahpengajar->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_jumlahpengajar" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_jumlahpengajar" value="<?= HtmlEncode($Grid->jumlahpengajar->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->foto->Visible) { // foto ?>
        <td data-name="foto" <?= $Grid->foto->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_foto" class="form-group">
<input type="<?= $Grid->foto->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" size="30" maxlength="255" value="<?= $Grid->foto->EditValue ?>"<?= $Grid->foto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->foto->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_foto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_foto" id="o<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_foto" class="form-group">
<input type="<?= $Grid->foto->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" size="30" maxlength="255" value="<?= $Grid->foto->EditValue ?>"<?= $Grid->foto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->foto->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_foto">
<span>
<?= GetImageViewTag($Grid->foto, $Grid->foto->getViewValue()) ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_foto" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_foto" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_foto" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_foto" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dokumen->Visible) { // dokumen ?>
        <td data-name="dokumen" <?= $Grid->dokumen->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_dokumen" class="form-group">
<input type="<?= $Grid->dokumen->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_dokumen" name="x<?= $Grid->RowIndex ?>_dokumen" id="x<?= $Grid->RowIndex ?>_dokumen" size="30" maxlength="255" value="<?= $Grid->dokumen->EditValue ?>"<?= $Grid->dokumen->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dokumen->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_dokumen" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dokumen" id="o<?= $Grid->RowIndex ?>_dokumen" value="<?= HtmlEncode($Grid->dokumen->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_dokumen" class="form-group">
<input type="<?= $Grid->dokumen->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_dokumen" name="x<?= $Grid->RowIndex ?>_dokumen" id="x<?= $Grid->RowIndex ?>_dokumen" size="30" maxlength="255" value="<?= $Grid->dokumen->EditValue ?>"<?= $Grid->dokumen->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dokumen->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pendidikanpesantren_dokumen">
<span<?= $Grid->dokumen->viewAttributes() ?>>
<?= $Grid->dokumen->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_dokumen" data-hidden="1" name="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_dokumen" id="fpendidikanpesantrengrid$x<?= $Grid->RowIndex ?>_dokumen" value="<?= HtmlEncode($Grid->dokumen->FormValue) ?>">
<input type="hidden" data-table="pendidikanpesantren" data-field="x_dokumen" data-hidden="1" name="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_dokumen" id="fpendidikanpesantrengrid$o<?= $Grid->RowIndex ?>_dokumen" value="<?= HtmlEncode($Grid->dokumen->OldValue) ?>">
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
loadjs.ready(["fpendidikanpesantrengrid","load"], function () {
    fpendidikanpesantrengrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_pendidikanpesantren", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el$rowindex$_pendidikanpesantren_pid" class="form-group pendidikanpesantren_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_pid" class="form-group pendidikanpesantren_pid">
    <select
        id="x<?= $Grid->RowIndex ?>_pid"
        name="x<?= $Grid->RowIndex ?>_pid"
        class="form-control ew-select<?= $Grid->pid->isInvalidClass() ?>"
        data-select2-id="pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid"
        data-table="pendidikanpesantren"
        data-field="x_pid"
        data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>"
        <?= $Grid->pid->editAttributes() ?>>
        <?= $Grid->pid->selectOptionListHtml("x{$Grid->RowIndex}_pid") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid']"),
        options = { name: "x<?= $Grid->RowIndex ?>_pid", selectId: "pendidikanpesantren_x<?= $Grid->RowIndex ?>_pid", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanpesantren.fields.pid.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_pid" class="form-group pendidikanpesantren_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_pid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->idjenispp->Visible) { // idjenispp ?>
        <td data-name="idjenispp">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->idjenispp->getSessionValue() != "") { ?>
<span id="el$rowindex$_pendidikanpesantren_idjenispp" class="form-group pendidikanpesantren_idjenispp">
<span<?= $Grid->idjenispp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idjenispp->getDisplayValue($Grid->idjenispp->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_idjenispp" name="x<?= $Grid->RowIndex ?>_idjenispp" value="<?= HtmlEncode($Grid->idjenispp->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_idjenispp" class="form-group pendidikanpesantren_idjenispp">
    <select
        id="x<?= $Grid->RowIndex ?>_idjenispp"
        name="x<?= $Grid->RowIndex ?>_idjenispp"
        class="form-control ew-select<?= $Grid->idjenispp->isInvalidClass() ?>"
        data-select2-id="pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp"
        data-table="pendidikanpesantren"
        data-field="x_idjenispp"
        data-value-separator="<?= $Grid->idjenispp->displayValueSeparatorAttribute() ?>"
        <?= $Grid->idjenispp->editAttributes() ?>>
        <?= $Grid->idjenispp->selectOptionListHtml("x{$Grid->RowIndex}_idjenispp") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->idjenispp->getErrorMessage() ?></div>
<?= $Grid->idjenispp->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_idjenispp") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp']"),
        options = { name: "x<?= $Grid->RowIndex ?>_idjenispp", selectId: "pendidikanpesantren_x<?= $Grid->RowIndex ?>_idjenispp", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pendidikanpesantren.fields.idjenispp.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_idjenispp" class="form-group pendidikanpesantren_idjenispp">
<span<?= $Grid->idjenispp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->idjenispp->getDisplayValue($Grid->idjenispp->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_idjenispp" data-hidden="1" name="x<?= $Grid->RowIndex ?>_idjenispp" id="x<?= $Grid->RowIndex ?>_idjenispp" value="<?= HtmlEncode($Grid->idjenispp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_idjenispp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_idjenispp" id="o<?= $Grid->RowIndex ?>_idjenispp" value="<?= HtmlEncode($Grid->idjenispp->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pendidikanpesantren_nama" class="form-group pendidikanpesantren_nama">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_nama" class="form-group pendidikanpesantren_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nama->getDisplayValue($Grid->nama->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_nama" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ijin->Visible) { // ijin ?>
        <td data-name="ijin">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pendidikanpesantren_ijin" class="form-group pendidikanpesantren_ijin">
<input type="<?= $Grid->ijin->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_ijin" name="x<?= $Grid->RowIndex ?>_ijin" id="x<?= $Grid->RowIndex ?>_ijin" size="30" maxlength="255" value="<?= $Grid->ijin->EditValue ?>"<?= $Grid->ijin->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijin->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_ijin" class="form-group pendidikanpesantren_ijin">
<span<?= $Grid->ijin->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ijin->getDisplayValue($Grid->ijin->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijin" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ijin" id="x<?= $Grid->RowIndex ?>_ijin" value="<?= HtmlEncode($Grid->ijin->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijin" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijin" id="o<?= $Grid->RowIndex ?>_ijin" value="<?= HtmlEncode($Grid->ijin->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglberdiri->Visible) { // tglberdiri ?>
        <td data-name="tglberdiri">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pendidikanpesantren_tglberdiri" class="form-group pendidikanpesantren_tglberdiri">
<input type="<?= $Grid->tglberdiri->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_tglberdiri" name="x<?= $Grid->RowIndex ?>_tglberdiri" id="x<?= $Grid->RowIndex ?>_tglberdiri" value="<?= $Grid->tglberdiri->EditValue ?>"<?= $Grid->tglberdiri->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglberdiri->getErrorMessage() ?></div>
<?php if (!$Grid->tglberdiri->ReadOnly && !$Grid->tglberdiri->Disabled && !isset($Grid->tglberdiri->EditAttrs["readonly"]) && !isset($Grid->tglberdiri->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanpesantrengrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanpesantrengrid", "x<?= $Grid->RowIndex ?>_tglberdiri", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_tglberdiri" class="form-group pendidikanpesantren_tglberdiri">
<span<?= $Grid->tglberdiri->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglberdiri->getDisplayValue($Grid->tglberdiri->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_tglberdiri" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglberdiri" id="x<?= $Grid->RowIndex ?>_tglberdiri" value="<?= HtmlEncode($Grid->tglberdiri->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_tglberdiri" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglberdiri" id="o<?= $Grid->RowIndex ?>_tglberdiri" value="<?= HtmlEncode($Grid->tglberdiri->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ijinakhir->Visible) { // ijinakhir ?>
        <td data-name="ijinakhir">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pendidikanpesantren_ijinakhir" class="form-group pendidikanpesantren_ijinakhir">
<input type="<?= $Grid->ijinakhir->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_ijinakhir" name="x<?= $Grid->RowIndex ?>_ijinakhir" id="x<?= $Grid->RowIndex ?>_ijinakhir" value="<?= $Grid->ijinakhir->EditValue ?>"<?= $Grid->ijinakhir->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ijinakhir->getErrorMessage() ?></div>
<?php if (!$Grid->ijinakhir->ReadOnly && !$Grid->ijinakhir->Disabled && !isset($Grid->ijinakhir->EditAttrs["readonly"]) && !isset($Grid->ijinakhir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendidikanpesantrengrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendidikanpesantrengrid", "x<?= $Grid->RowIndex ?>_ijinakhir", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_ijinakhir" class="form-group pendidikanpesantren_ijinakhir">
<span<?= $Grid->ijinakhir->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ijinakhir->getDisplayValue($Grid->ijinakhir->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijinakhir" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ijinakhir" id="x<?= $Grid->RowIndex ?>_ijinakhir" value="<?= HtmlEncode($Grid->ijinakhir->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_ijinakhir" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijinakhir" id="o<?= $Grid->RowIndex ?>_ijinakhir" value="<?= HtmlEncode($Grid->ijinakhir->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jumlahpengajar->Visible) { // jumlahpengajar ?>
        <td data-name="jumlahpengajar">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pendidikanpesantren_jumlahpengajar" class="form-group pendidikanpesantren_jumlahpengajar">
<input type="<?= $Grid->jumlahpengajar->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" name="x<?= $Grid->RowIndex ?>_jumlahpengajar" id="x<?= $Grid->RowIndex ?>_jumlahpengajar" size="30" maxlength="255" value="<?= $Grid->jumlahpengajar->EditValue ?>"<?= $Grid->jumlahpengajar->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jumlahpengajar->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_jumlahpengajar" class="form-group pendidikanpesantren_jumlahpengajar">
<span<?= $Grid->jumlahpengajar->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jumlahpengajar->getDisplayValue($Grid->jumlahpengajar->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jumlahpengajar" id="x<?= $Grid->RowIndex ?>_jumlahpengajar" value="<?= HtmlEncode($Grid->jumlahpengajar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_jumlahpengajar" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jumlahpengajar" id="o<?= $Grid->RowIndex ?>_jumlahpengajar" value="<?= HtmlEncode($Grid->jumlahpengajar->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->foto->Visible) { // foto ?>
        <td data-name="foto">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pendidikanpesantren_foto" class="form-group pendidikanpesantren_foto">
<input type="<?= $Grid->foto->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" size="30" maxlength="255" value="<?= $Grid->foto->EditValue ?>"<?= $Grid->foto->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->foto->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_foto" class="form-group pendidikanpesantren_foto">
<span>
<?= GetImageViewTag($Grid->foto, $Grid->foto->ViewValue) ?></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_foto" data-hidden="1" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_foto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_foto" id="o<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->dokumen->Visible) { // dokumen ?>
        <td data-name="dokumen">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pendidikanpesantren_dokumen" class="form-group pendidikanpesantren_dokumen">
<input type="<?= $Grid->dokumen->getInputTextType() ?>" data-table="pendidikanpesantren" data-field="x_dokumen" name="x<?= $Grid->RowIndex ?>_dokumen" id="x<?= $Grid->RowIndex ?>_dokumen" size="30" maxlength="255" value="<?= $Grid->dokumen->EditValue ?>"<?= $Grid->dokumen->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dokumen->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pendidikanpesantren_dokumen" class="form-group pendidikanpesantren_dokumen">
<span<?= $Grid->dokumen->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dokumen->getDisplayValue($Grid->dokumen->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_dokumen" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dokumen" id="x<?= $Grid->RowIndex ?>_dokumen" value="<?= HtmlEncode($Grid->dokumen->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pendidikanpesantren" data-field="x_dokumen" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dokumen" id="o<?= $Grid->RowIndex ?>_dokumen" value="<?= HtmlEncode($Grid->dokumen->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fpendidikanpesantrengrid","load"], function() {
    fpendidikanpesantrengrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fpendidikanpesantrengrid">
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
    ew.addEventHandlers("pendidikanpesantren");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
