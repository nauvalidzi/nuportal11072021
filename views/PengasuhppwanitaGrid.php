<?php

namespace PHPMaker2021\nuportal;

// Set up and run Grid object
$Grid = Container("PengasuhppwanitaGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpengasuhppwanitagrid;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    fpengasuhppwanitagrid = new ew.Form("fpengasuhppwanitagrid", "grid");
    fpengasuhppwanitagrid.formKeyCountName = '<?= $Grid->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pengasuhppwanita")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pengasuhppwanita)
        ew.vars.tables.pengasuhppwanita = currentTable;
    fpengasuhppwanitagrid.addFields([
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
        var f = fpengasuhppwanitagrid,
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
    fpengasuhppwanitagrid.validate = function () {
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
    fpengasuhppwanitagrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm();
        if (ew.valueChanged(fobj, rowIndex, "pid", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nama", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "nik", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "alamat", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "hp", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "md", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "mts", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ma", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "pesantren", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "s1", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "s2", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "s3", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "organisasi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jabatandiorganisasi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglawalorganisasi", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "pemerintah", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "jabatandipemerintah", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "tglmenjabat", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "foto", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "ijazah", false))
            return false;
        if (ew.valueChanged(fobj, rowIndex, "sertifikat", false))
            return false;
        return true;
    }

    // Form_CustomValidate
    fpengasuhppwanitagrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpengasuhppwanitagrid.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpengasuhppwanitagrid.lists.pid = <?= $Grid->pid->toClientList($Grid) ?>;
    loadjs.done("fpengasuhppwanitagrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pengasuhppwanita">
<div id="fpengasuhppwanitagrid" class="ew-form ew-list-form form-inline">
<div id="gmp_pengasuhppwanita" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_pengasuhppwanitagrid" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_pengasuhppwanita_id" class="pengasuhppwanita_id"><?= $Grid->renderSort($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->pid->Visible) { // pid ?>
        <th data-name="pid" class="<?= $Grid->pid->headerCellClass() ?>"><div id="elh_pengasuhppwanita_pid" class="pengasuhppwanita_pid"><?= $Grid->renderSort($Grid->pid) ?></div></th>
<?php } ?>
<?php if ($Grid->nama->Visible) { // nama ?>
        <th data-name="nama" class="<?= $Grid->nama->headerCellClass() ?>"><div id="elh_pengasuhppwanita_nama" class="pengasuhppwanita_nama"><?= $Grid->renderSort($Grid->nama) ?></div></th>
<?php } ?>
<?php if ($Grid->nik->Visible) { // nik ?>
        <th data-name="nik" class="<?= $Grid->nik->headerCellClass() ?>"><div id="elh_pengasuhppwanita_nik" class="pengasuhppwanita_nik"><?= $Grid->renderSort($Grid->nik) ?></div></th>
<?php } ?>
<?php if ($Grid->alamat->Visible) { // alamat ?>
        <th data-name="alamat" class="<?= $Grid->alamat->headerCellClass() ?>"><div id="elh_pengasuhppwanita_alamat" class="pengasuhppwanita_alamat"><?= $Grid->renderSort($Grid->alamat) ?></div></th>
<?php } ?>
<?php if ($Grid->hp->Visible) { // hp ?>
        <th data-name="hp" class="<?= $Grid->hp->headerCellClass() ?>"><div id="elh_pengasuhppwanita_hp" class="pengasuhppwanita_hp"><?= $Grid->renderSort($Grid->hp) ?></div></th>
<?php } ?>
<?php if ($Grid->md->Visible) { // md ?>
        <th data-name="md" class="<?= $Grid->md->headerCellClass() ?>"><div id="elh_pengasuhppwanita_md" class="pengasuhppwanita_md"><?= $Grid->renderSort($Grid->md) ?></div></th>
<?php } ?>
<?php if ($Grid->mts->Visible) { // mts ?>
        <th data-name="mts" class="<?= $Grid->mts->headerCellClass() ?>"><div id="elh_pengasuhppwanita_mts" class="pengasuhppwanita_mts"><?= $Grid->renderSort($Grid->mts) ?></div></th>
<?php } ?>
<?php if ($Grid->ma->Visible) { // ma ?>
        <th data-name="ma" class="<?= $Grid->ma->headerCellClass() ?>"><div id="elh_pengasuhppwanita_ma" class="pengasuhppwanita_ma"><?= $Grid->renderSort($Grid->ma) ?></div></th>
<?php } ?>
<?php if ($Grid->pesantren->Visible) { // pesantren ?>
        <th data-name="pesantren" class="<?= $Grid->pesantren->headerCellClass() ?>"><div id="elh_pengasuhppwanita_pesantren" class="pengasuhppwanita_pesantren"><?= $Grid->renderSort($Grid->pesantren) ?></div></th>
<?php } ?>
<?php if ($Grid->s1->Visible) { // s1 ?>
        <th data-name="s1" class="<?= $Grid->s1->headerCellClass() ?>"><div id="elh_pengasuhppwanita_s1" class="pengasuhppwanita_s1"><?= $Grid->renderSort($Grid->s1) ?></div></th>
<?php } ?>
<?php if ($Grid->s2->Visible) { // s2 ?>
        <th data-name="s2" class="<?= $Grid->s2->headerCellClass() ?>"><div id="elh_pengasuhppwanita_s2" class="pengasuhppwanita_s2"><?= $Grid->renderSort($Grid->s2) ?></div></th>
<?php } ?>
<?php if ($Grid->s3->Visible) { // s3 ?>
        <th data-name="s3" class="<?= $Grid->s3->headerCellClass() ?>"><div id="elh_pengasuhppwanita_s3" class="pengasuhppwanita_s3"><?= $Grid->renderSort($Grid->s3) ?></div></th>
<?php } ?>
<?php if ($Grid->organisasi->Visible) { // organisasi ?>
        <th data-name="organisasi" class="<?= $Grid->organisasi->headerCellClass() ?>"><div id="elh_pengasuhppwanita_organisasi" class="pengasuhppwanita_organisasi"><?= $Grid->renderSort($Grid->organisasi) ?></div></th>
<?php } ?>
<?php if ($Grid->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <th data-name="jabatandiorganisasi" class="<?= $Grid->jabatandiorganisasi->headerCellClass() ?>"><div id="elh_pengasuhppwanita_jabatandiorganisasi" class="pengasuhppwanita_jabatandiorganisasi"><?= $Grid->renderSort($Grid->jabatandiorganisasi) ?></div></th>
<?php } ?>
<?php if ($Grid->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <th data-name="tglawalorganisasi" class="<?= $Grid->tglawalorganisasi->headerCellClass() ?>"><div id="elh_pengasuhppwanita_tglawalorganisasi" class="pengasuhppwanita_tglawalorganisasi"><?= $Grid->renderSort($Grid->tglawalorganisasi) ?></div></th>
<?php } ?>
<?php if ($Grid->pemerintah->Visible) { // pemerintah ?>
        <th data-name="pemerintah" class="<?= $Grid->pemerintah->headerCellClass() ?>"><div id="elh_pengasuhppwanita_pemerintah" class="pengasuhppwanita_pemerintah"><?= $Grid->renderSort($Grid->pemerintah) ?></div></th>
<?php } ?>
<?php if ($Grid->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <th data-name="jabatandipemerintah" class="<?= $Grid->jabatandipemerintah->headerCellClass() ?>"><div id="elh_pengasuhppwanita_jabatandipemerintah" class="pengasuhppwanita_jabatandipemerintah"><?= $Grid->renderSort($Grid->jabatandipemerintah) ?></div></th>
<?php } ?>
<?php if ($Grid->tglmenjabat->Visible) { // tglmenjabat ?>
        <th data-name="tglmenjabat" class="<?= $Grid->tglmenjabat->headerCellClass() ?>"><div id="elh_pengasuhppwanita_tglmenjabat" class="pengasuhppwanita_tglmenjabat"><?= $Grid->renderSort($Grid->tglmenjabat) ?></div></th>
<?php } ?>
<?php if ($Grid->foto->Visible) { // foto ?>
        <th data-name="foto" class="<?= $Grid->foto->headerCellClass() ?>"><div id="elh_pengasuhppwanita_foto" class="pengasuhppwanita_foto"><?= $Grid->renderSort($Grid->foto) ?></div></th>
<?php } ?>
<?php if ($Grid->ijazah->Visible) { // ijazah ?>
        <th data-name="ijazah" class="<?= $Grid->ijazah->headerCellClass() ?>"><div id="elh_pengasuhppwanita_ijazah" class="pengasuhppwanita_ijazah"><?= $Grid->renderSort($Grid->ijazah) ?></div></th>
<?php } ?>
<?php if ($Grid->sertifikat->Visible) { // sertifikat ?>
        <th data-name="sertifikat" class="<?= $Grid->sertifikat->headerCellClass() ?>"><div id="elh_pengasuhppwanita_sertifikat" class="pengasuhppwanita_sertifikat"><?= $Grid->renderSort($Grid->sertifikat) ?></div></th>
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowCount, "id" => "r" . $Grid->RowCount . "_pengasuhppwanita", "data-rowtype" => $Grid->RowType]);

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
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_id" class="form-group"></span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_id" class="form-group">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_id" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_id" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid" <?= $Grid->pid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pid" class="form-group">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="pengasuhppwanita" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fpengasuhppwanitagrid"], function() {
    fpengasuhppwanitagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.pengasuhppwanita.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pid" class="form-group">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pid" class="form-group">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="pengasuhppwanita" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fpengasuhppwanitagrid"], function() {
    fpengasuhppwanitagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.pengasuhppwanita.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<?= $Grid->pid->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pid" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_pid" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pid" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_pid" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama" <?= $Grid->nama->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_nama" class="form-group">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<?= $Grid->nama->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nama" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_nama" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nama" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_nama" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nik->Visible) { // nik ?>
        <td data-name="nik" <?= $Grid->nik->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_nik" class="form-group">
<input type="<?= $Grid->nik->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nik" name="x<?= $Grid->RowIndex ?>_nik" id="x<?= $Grid->RowIndex ?>_nik" size="30" maxlength="255" value="<?= $Grid->nik->EditValue ?>"<?= $Grid->nik->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nik->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nik" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nik" id="o<?= $Grid->RowIndex ?>_nik" value="<?= HtmlEncode($Grid->nik->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_nik" class="form-group">
<input type="<?= $Grid->nik->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nik" name="x<?= $Grid->RowIndex ?>_nik" id="x<?= $Grid->RowIndex ?>_nik" size="30" maxlength="255" value="<?= $Grid->nik->EditValue ?>"<?= $Grid->nik->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nik->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_nik">
<span<?= $Grid->nik->viewAttributes() ?>>
<?= $Grid->nik->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nik" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_nik" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_nik" value="<?= HtmlEncode($Grid->nik->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nik" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_nik" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_nik" value="<?= HtmlEncode($Grid->nik->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->alamat->Visible) { // alamat ?>
        <td data-name="alamat" <?= $Grid->alamat->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_alamat" class="form-group">
<input type="<?= $Grid->alamat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_alamat" name="x<?= $Grid->RowIndex ?>_alamat" id="x<?= $Grid->RowIndex ?>_alamat" size="30" maxlength="255" value="<?= $Grid->alamat->EditValue ?>"<?= $Grid->alamat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->alamat->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_alamat" data-hidden="1" name="o<?= $Grid->RowIndex ?>_alamat" id="o<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_alamat" class="form-group">
<input type="<?= $Grid->alamat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_alamat" name="x<?= $Grid->RowIndex ?>_alamat" id="x<?= $Grid->RowIndex ?>_alamat" size="30" maxlength="255" value="<?= $Grid->alamat->EditValue ?>"<?= $Grid->alamat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->alamat->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_alamat">
<span<?= $Grid->alamat->viewAttributes() ?>>
<?= $Grid->alamat->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_alamat" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_alamat" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_alamat" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_alamat" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->hp->Visible) { // hp ?>
        <td data-name="hp" <?= $Grid->hp->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_hp" class="form-group">
<input type="<?= $Grid->hp->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_hp" name="x<?= $Grid->RowIndex ?>_hp" id="x<?= $Grid->RowIndex ?>_hp" size="30" maxlength="255" value="<?= $Grid->hp->EditValue ?>"<?= $Grid->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hp->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_hp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hp" id="o<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_hp" class="form-group">
<input type="<?= $Grid->hp->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_hp" name="x<?= $Grid->RowIndex ?>_hp" id="x<?= $Grid->RowIndex ?>_hp" size="30" maxlength="255" value="<?= $Grid->hp->EditValue ?>"<?= $Grid->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_hp">
<span<?= $Grid->hp->viewAttributes() ?>>
<?= $Grid->hp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_hp" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_hp" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_hp" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_hp" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->md->Visible) { // md ?>
        <td data-name="md" <?= $Grid->md->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_md" class="form-group">
<input type="<?= $Grid->md->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_md" name="x<?= $Grid->RowIndex ?>_md" id="x<?= $Grid->RowIndex ?>_md" size="30" maxlength="255" value="<?= $Grid->md->EditValue ?>"<?= $Grid->md->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->md->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_md" data-hidden="1" name="o<?= $Grid->RowIndex ?>_md" id="o<?= $Grid->RowIndex ?>_md" value="<?= HtmlEncode($Grid->md->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_md" class="form-group">
<input type="<?= $Grid->md->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_md" name="x<?= $Grid->RowIndex ?>_md" id="x<?= $Grid->RowIndex ?>_md" size="30" maxlength="255" value="<?= $Grid->md->EditValue ?>"<?= $Grid->md->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->md->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_md">
<span<?= $Grid->md->viewAttributes() ?>>
<?= $Grid->md->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_md" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_md" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_md" value="<?= HtmlEncode($Grid->md->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_md" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_md" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_md" value="<?= HtmlEncode($Grid->md->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->mts->Visible) { // mts ?>
        <td data-name="mts" <?= $Grid->mts->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_mts" class="form-group">
<input type="<?= $Grid->mts->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_mts" name="x<?= $Grid->RowIndex ?>_mts" id="x<?= $Grid->RowIndex ?>_mts" size="30" maxlength="255" value="<?= $Grid->mts->EditValue ?>"<?= $Grid->mts->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->mts->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_mts" data-hidden="1" name="o<?= $Grid->RowIndex ?>_mts" id="o<?= $Grid->RowIndex ?>_mts" value="<?= HtmlEncode($Grid->mts->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_mts" class="form-group">
<input type="<?= $Grid->mts->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_mts" name="x<?= $Grid->RowIndex ?>_mts" id="x<?= $Grid->RowIndex ?>_mts" size="30" maxlength="255" value="<?= $Grid->mts->EditValue ?>"<?= $Grid->mts->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->mts->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_mts">
<span<?= $Grid->mts->viewAttributes() ?>>
<?= $Grid->mts->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_mts" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_mts" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_mts" value="<?= HtmlEncode($Grid->mts->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_mts" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_mts" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_mts" value="<?= HtmlEncode($Grid->mts->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ma->Visible) { // ma ?>
        <td data-name="ma" <?= $Grid->ma->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_ma" class="form-group">
<input type="<?= $Grid->ma->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_ma" name="x<?= $Grid->RowIndex ?>_ma" id="x<?= $Grid->RowIndex ?>_ma" size="30" maxlength="255" value="<?= $Grid->ma->EditValue ?>"<?= $Grid->ma->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ma->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ma" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ma" id="o<?= $Grid->RowIndex ?>_ma" value="<?= HtmlEncode($Grid->ma->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_ma" class="form-group">
<input type="<?= $Grid->ma->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_ma" name="x<?= $Grid->RowIndex ?>_ma" id="x<?= $Grid->RowIndex ?>_ma" size="30" maxlength="255" value="<?= $Grid->ma->EditValue ?>"<?= $Grid->ma->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ma->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_ma">
<span<?= $Grid->ma->viewAttributes() ?>>
<?= $Grid->ma->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ma" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_ma" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_ma" value="<?= HtmlEncode($Grid->ma->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ma" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_ma" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_ma" value="<?= HtmlEncode($Grid->ma->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->pesantren->Visible) { // pesantren ?>
        <td data-name="pesantren" <?= $Grid->pesantren->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pesantren" class="form-group">
<input type="<?= $Grid->pesantren->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pesantren" name="x<?= $Grid->RowIndex ?>_pesantren" id="x<?= $Grid->RowIndex ?>_pesantren" size="30" maxlength="255" value="<?= $Grid->pesantren->EditValue ?>"<?= $Grid->pesantren->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pesantren->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pesantren" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pesantren" id="o<?= $Grid->RowIndex ?>_pesantren" value="<?= HtmlEncode($Grid->pesantren->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pesantren" class="form-group">
<input type="<?= $Grid->pesantren->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pesantren" name="x<?= $Grid->RowIndex ?>_pesantren" id="x<?= $Grid->RowIndex ?>_pesantren" size="30" maxlength="255" value="<?= $Grid->pesantren->EditValue ?>"<?= $Grid->pesantren->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pesantren->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pesantren">
<span<?= $Grid->pesantren->viewAttributes() ?>>
<?= $Grid->pesantren->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pesantren" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_pesantren" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_pesantren" value="<?= HtmlEncode($Grid->pesantren->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pesantren" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_pesantren" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_pesantren" value="<?= HtmlEncode($Grid->pesantren->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->s1->Visible) { // s1 ?>
        <td data-name="s1" <?= $Grid->s1->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s1" class="form-group">
<input type="<?= $Grid->s1->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s1" name="x<?= $Grid->RowIndex ?>_s1" id="x<?= $Grid->RowIndex ?>_s1" size="30" maxlength="255" value="<?= $Grid->s1->EditValue ?>"<?= $Grid->s1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_s1" id="o<?= $Grid->RowIndex ?>_s1" value="<?= HtmlEncode($Grid->s1->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s1" class="form-group">
<input type="<?= $Grid->s1->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s1" name="x<?= $Grid->RowIndex ?>_s1" id="x<?= $Grid->RowIndex ?>_s1" size="30" maxlength="255" value="<?= $Grid->s1->EditValue ?>"<?= $Grid->s1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s1">
<span<?= $Grid->s1->viewAttributes() ?>>
<?= $Grid->s1->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s1" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_s1" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_s1" value="<?= HtmlEncode($Grid->s1->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s1" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_s1" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_s1" value="<?= HtmlEncode($Grid->s1->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->s2->Visible) { // s2 ?>
        <td data-name="s2" <?= $Grid->s2->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s2" class="form-group">
<input type="<?= $Grid->s2->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s2" name="x<?= $Grid->RowIndex ?>_s2" id="x<?= $Grid->RowIndex ?>_s2" size="30" maxlength="255" value="<?= $Grid->s2->EditValue ?>"<?= $Grid->s2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_s2" id="o<?= $Grid->RowIndex ?>_s2" value="<?= HtmlEncode($Grid->s2->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s2" class="form-group">
<input type="<?= $Grid->s2->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s2" name="x<?= $Grid->RowIndex ?>_s2" id="x<?= $Grid->RowIndex ?>_s2" size="30" maxlength="255" value="<?= $Grid->s2->EditValue ?>"<?= $Grid->s2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s2">
<span<?= $Grid->s2->viewAttributes() ?>>
<?= $Grid->s2->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s2" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_s2" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_s2" value="<?= HtmlEncode($Grid->s2->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s2" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_s2" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_s2" value="<?= HtmlEncode($Grid->s2->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->s3->Visible) { // s3 ?>
        <td data-name="s3" <?= $Grid->s3->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s3" class="form-group">
<input type="<?= $Grid->s3->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s3" name="x<?= $Grid->RowIndex ?>_s3" id="x<?= $Grid->RowIndex ?>_s3" size="30" maxlength="255" value="<?= $Grid->s3->EditValue ?>"<?= $Grid->s3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s3" data-hidden="1" name="o<?= $Grid->RowIndex ?>_s3" id="o<?= $Grid->RowIndex ?>_s3" value="<?= HtmlEncode($Grid->s3->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s3" class="form-group">
<input type="<?= $Grid->s3->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s3" name="x<?= $Grid->RowIndex ?>_s3" id="x<?= $Grid->RowIndex ?>_s3" size="30" maxlength="255" value="<?= $Grid->s3->EditValue ?>"<?= $Grid->s3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_s3">
<span<?= $Grid->s3->viewAttributes() ?>>
<?= $Grid->s3->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s3" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_s3" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_s3" value="<?= HtmlEncode($Grid->s3->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s3" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_s3" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_s3" value="<?= HtmlEncode($Grid->s3->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->organisasi->Visible) { // organisasi ?>
        <td data-name="organisasi" <?= $Grid->organisasi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_organisasi" class="form-group">
<input type="<?= $Grid->organisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_organisasi" name="x<?= $Grid->RowIndex ?>_organisasi" id="x<?= $Grid->RowIndex ?>_organisasi" size="30" maxlength="255" value="<?= $Grid->organisasi->EditValue ?>"<?= $Grid->organisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->organisasi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_organisasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_organisasi" id="o<?= $Grid->RowIndex ?>_organisasi" value="<?= HtmlEncode($Grid->organisasi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_organisasi" class="form-group">
<input type="<?= $Grid->organisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_organisasi" name="x<?= $Grid->RowIndex ?>_organisasi" id="x<?= $Grid->RowIndex ?>_organisasi" size="30" maxlength="255" value="<?= $Grid->organisasi->EditValue ?>"<?= $Grid->organisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->organisasi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_organisasi">
<span<?= $Grid->organisasi->viewAttributes() ?>>
<?= $Grid->organisasi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_organisasi" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_organisasi" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_organisasi" value="<?= HtmlEncode($Grid->organisasi->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_organisasi" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_organisasi" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_organisasi" value="<?= HtmlEncode($Grid->organisasi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <td data-name="jabatandiorganisasi" <?= $Grid->jabatandiorganisasi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_jabatandiorganisasi" class="form-group">
<input type="<?= $Grid->jabatandiorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" name="x<?= $Grid->RowIndex ?>_jabatandiorganisasi" id="x<?= $Grid->RowIndex ?>_jabatandiorganisasi" size="30" maxlength="255" value="<?= $Grid->jabatandiorganisasi->EditValue ?>"<?= $Grid->jabatandiorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jabatandiorganisasi->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jabatandiorganisasi" id="o<?= $Grid->RowIndex ?>_jabatandiorganisasi" value="<?= HtmlEncode($Grid->jabatandiorganisasi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_jabatandiorganisasi" class="form-group">
<input type="<?= $Grid->jabatandiorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" name="x<?= $Grid->RowIndex ?>_jabatandiorganisasi" id="x<?= $Grid->RowIndex ?>_jabatandiorganisasi" size="30" maxlength="255" value="<?= $Grid->jabatandiorganisasi->EditValue ?>"<?= $Grid->jabatandiorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jabatandiorganisasi->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_jabatandiorganisasi">
<span<?= $Grid->jabatandiorganisasi->viewAttributes() ?>>
<?= $Grid->jabatandiorganisasi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_jabatandiorganisasi" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_jabatandiorganisasi" value="<?= HtmlEncode($Grid->jabatandiorganisasi->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_jabatandiorganisasi" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_jabatandiorganisasi" value="<?= HtmlEncode($Grid->jabatandiorganisasi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <td data-name="tglawalorganisasi" <?= $Grid->tglawalorganisasi->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_tglawalorganisasi" class="form-group">
<input type="<?= $Grid->tglawalorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-format="7" name="x<?= $Grid->RowIndex ?>_tglawalorganisasi" id="x<?= $Grid->RowIndex ?>_tglawalorganisasi" value="<?= $Grid->tglawalorganisasi->EditValue ?>"<?= $Grid->tglawalorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglawalorganisasi->getErrorMessage() ?></div>
<?php if (!$Grid->tglawalorganisasi->ReadOnly && !$Grid->tglawalorganisasi->Disabled && !isset($Grid->tglawalorganisasi->EditAttrs["readonly"]) && !isset($Grid->tglawalorganisasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitagrid", "x<?= $Grid->RowIndex ?>_tglawalorganisasi", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglawalorganisasi" id="o<?= $Grid->RowIndex ?>_tglawalorganisasi" value="<?= HtmlEncode($Grid->tglawalorganisasi->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_tglawalorganisasi" class="form-group">
<input type="<?= $Grid->tglawalorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-format="7" name="x<?= $Grid->RowIndex ?>_tglawalorganisasi" id="x<?= $Grid->RowIndex ?>_tglawalorganisasi" value="<?= $Grid->tglawalorganisasi->EditValue ?>"<?= $Grid->tglawalorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglawalorganisasi->getErrorMessage() ?></div>
<?php if (!$Grid->tglawalorganisasi->ReadOnly && !$Grid->tglawalorganisasi->Disabled && !isset($Grid->tglawalorganisasi->EditAttrs["readonly"]) && !isset($Grid->tglawalorganisasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitagrid", "x<?= $Grid->RowIndex ?>_tglawalorganisasi", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_tglawalorganisasi">
<span<?= $Grid->tglawalorganisasi->viewAttributes() ?>>
<?= $Grid->tglawalorganisasi->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_tglawalorganisasi" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_tglawalorganisasi" value="<?= HtmlEncode($Grid->tglawalorganisasi->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_tglawalorganisasi" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_tglawalorganisasi" value="<?= HtmlEncode($Grid->tglawalorganisasi->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->pemerintah->Visible) { // pemerintah ?>
        <td data-name="pemerintah" <?= $Grid->pemerintah->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pemerintah" class="form-group">
<input type="<?= $Grid->pemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pemerintah" name="x<?= $Grid->RowIndex ?>_pemerintah" id="x<?= $Grid->RowIndex ?>_pemerintah" size="30" maxlength="255" value="<?= $Grid->pemerintah->EditValue ?>"<?= $Grid->pemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pemerintah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pemerintah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pemerintah" id="o<?= $Grid->RowIndex ?>_pemerintah" value="<?= HtmlEncode($Grid->pemerintah->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pemerintah" class="form-group">
<input type="<?= $Grid->pemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pemerintah" name="x<?= $Grid->RowIndex ?>_pemerintah" id="x<?= $Grid->RowIndex ?>_pemerintah" size="30" maxlength="255" value="<?= $Grid->pemerintah->EditValue ?>"<?= $Grid->pemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pemerintah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_pemerintah">
<span<?= $Grid->pemerintah->viewAttributes() ?>>
<?= $Grid->pemerintah->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pemerintah" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_pemerintah" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_pemerintah" value="<?= HtmlEncode($Grid->pemerintah->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pemerintah" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_pemerintah" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_pemerintah" value="<?= HtmlEncode($Grid->pemerintah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <td data-name="jabatandipemerintah" <?= $Grid->jabatandipemerintah->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_jabatandipemerintah" class="form-group">
<input type="<?= $Grid->jabatandipemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" name="x<?= $Grid->RowIndex ?>_jabatandipemerintah" id="x<?= $Grid->RowIndex ?>_jabatandipemerintah" size="30" maxlength="255" value="<?= $Grid->jabatandipemerintah->EditValue ?>"<?= $Grid->jabatandipemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jabatandipemerintah->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jabatandipemerintah" id="o<?= $Grid->RowIndex ?>_jabatandipemerintah" value="<?= HtmlEncode($Grid->jabatandipemerintah->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_jabatandipemerintah" class="form-group">
<input type="<?= $Grid->jabatandipemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" name="x<?= $Grid->RowIndex ?>_jabatandipemerintah" id="x<?= $Grid->RowIndex ?>_jabatandipemerintah" size="30" maxlength="255" value="<?= $Grid->jabatandipemerintah->EditValue ?>"<?= $Grid->jabatandipemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jabatandipemerintah->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_jabatandipemerintah">
<span<?= $Grid->jabatandipemerintah->viewAttributes() ?>>
<?= $Grid->jabatandipemerintah->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_jabatandipemerintah" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_jabatandipemerintah" value="<?= HtmlEncode($Grid->jabatandipemerintah->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_jabatandipemerintah" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_jabatandipemerintah" value="<?= HtmlEncode($Grid->jabatandipemerintah->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->tglmenjabat->Visible) { // tglmenjabat ?>
        <td data-name="tglmenjabat" <?= $Grid->tglmenjabat->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_tglmenjabat" class="form-group">
<input type="<?= $Grid->tglmenjabat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglmenjabat" name="x<?= $Grid->RowIndex ?>_tglmenjabat" id="x<?= $Grid->RowIndex ?>_tglmenjabat" value="<?= $Grid->tglmenjabat->EditValue ?>"<?= $Grid->tglmenjabat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglmenjabat->getErrorMessage() ?></div>
<?php if (!$Grid->tglmenjabat->ReadOnly && !$Grid->tglmenjabat->Disabled && !isset($Grid->tglmenjabat->EditAttrs["readonly"]) && !isset($Grid->tglmenjabat->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitagrid", "x<?= $Grid->RowIndex ?>_tglmenjabat", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglmenjabat" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglmenjabat" id="o<?= $Grid->RowIndex ?>_tglmenjabat" value="<?= HtmlEncode($Grid->tglmenjabat->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_tglmenjabat" class="form-group">
<input type="<?= $Grid->tglmenjabat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglmenjabat" name="x<?= $Grid->RowIndex ?>_tglmenjabat" id="x<?= $Grid->RowIndex ?>_tglmenjabat" value="<?= $Grid->tglmenjabat->EditValue ?>"<?= $Grid->tglmenjabat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglmenjabat->getErrorMessage() ?></div>
<?php if (!$Grid->tglmenjabat->ReadOnly && !$Grid->tglmenjabat->Disabled && !isset($Grid->tglmenjabat->EditAttrs["readonly"]) && !isset($Grid->tglmenjabat->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitagrid", "x<?= $Grid->RowIndex ?>_tglmenjabat", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_tglmenjabat">
<span<?= $Grid->tglmenjabat->viewAttributes() ?>>
<?= $Grid->tglmenjabat->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglmenjabat" data-hidden="1" name="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_tglmenjabat" id="fpengasuhppwanitagrid$x<?= $Grid->RowIndex ?>_tglmenjabat" value="<?= HtmlEncode($Grid->tglmenjabat->FormValue) ?>">
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglmenjabat" data-hidden="1" name="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_tglmenjabat" id="fpengasuhppwanitagrid$o<?= $Grid->RowIndex ?>_tglmenjabat" value="<?= HtmlEncode($Grid->tglmenjabat->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->foto->Visible) { // foto ?>
        <td data-name="foto" <?= $Grid->foto->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_foto" class="form-group pengasuhppwanita_foto">
<div id="fd_x<?= $Grid->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->foto->title() ?>" data-table="pengasuhppwanita" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->foto->editAttributes() ?><?= ($Grid->foto->ReadOnly || $Grid->foto->Disabled) ? " disabled" : "" ?>>
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
<input type="hidden" data-table="pengasuhppwanita" data-field="x_foto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_foto" id="o<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_foto">
<span<?= $Grid->foto->viewAttributes() ?>>
<?= GetFileViewTag($Grid->foto, $Grid->foto->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_foto" class="form-group pengasuhppwanita_foto">
<div id="fd_x<?= $Grid->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->foto->title() ?>" data-table="pengasuhppwanita" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->foto->editAttributes() ?><?= ($Grid->foto->ReadOnly || $Grid->foto->Disabled) ? " disabled" : "" ?>>
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
    <?php if ($Grid->ijazah->Visible) { // ijazah ?>
        <td data-name="ijazah" <?= $Grid->ijazah->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_ijazah" class="form-group pengasuhppwanita_ijazah">
<div id="fd_x<?= $Grid->RowIndex ?>_ijazah">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->ijazah->title() ?>" data-table="pengasuhppwanita" data-field="x_ijazah" name="x<?= $Grid->RowIndex ?>_ijazah" id="x<?= $Grid->RowIndex ?>_ijazah" lang="<?= CurrentLanguageID() ?>"<?= $Grid->ijazah->editAttributes() ?><?= ($Grid->ijazah->ReadOnly || $Grid->ijazah->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_ijazah"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->ijazah->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_ijazah" id= "fn_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_ijazah" id= "fa_x<?= $Grid->RowIndex ?>_ijazah" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_ijazah" id= "fs_x<?= $Grid->RowIndex ?>_ijazah" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_ijazah" id= "fx_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_ijazah" id= "fm_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_ijazah" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ijazah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijazah" id="o<?= $Grid->RowIndex ?>_ijazah" value="<?= HtmlEncode($Grid->ijazah->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_ijazah">
<span<?= $Grid->ijazah->viewAttributes() ?>>
<?= GetFileViewTag($Grid->ijazah, $Grid->ijazah->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_ijazah" class="form-group pengasuhppwanita_ijazah">
<div id="fd_x<?= $Grid->RowIndex ?>_ijazah">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->ijazah->title() ?>" data-table="pengasuhppwanita" data-field="x_ijazah" name="x<?= $Grid->RowIndex ?>_ijazah" id="x<?= $Grid->RowIndex ?>_ijazah" lang="<?= CurrentLanguageID() ?>"<?= $Grid->ijazah->editAttributes() ?><?= ($Grid->ijazah->ReadOnly || $Grid->ijazah->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_ijazah"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->ijazah->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_ijazah" id= "fn_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_ijazah" id= "fa_x<?= $Grid->RowIndex ?>_ijazah" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_ijazah") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_ijazah" id= "fs_x<?= $Grid->RowIndex ?>_ijazah" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_ijazah" id= "fx_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_ijazah" id= "fm_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_ijazah" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->sertifikat->Visible) { // sertifikat ?>
        <td data-name="sertifikat" <?= $Grid->sertifikat->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_sertifikat" class="form-group pengasuhppwanita_sertifikat">
<div id="fd_x<?= $Grid->RowIndex ?>_sertifikat">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->sertifikat->title() ?>" data-table="pengasuhppwanita" data-field="x_sertifikat" name="x<?= $Grid->RowIndex ?>_sertifikat" id="x<?= $Grid->RowIndex ?>_sertifikat" lang="<?= CurrentLanguageID() ?>"<?= $Grid->sertifikat->editAttributes() ?><?= ($Grid->sertifikat->ReadOnly || $Grid->sertifikat->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_sertifikat"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->sertifikat->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_sertifikat" id= "fn_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_sertifikat" id= "fa_x<?= $Grid->RowIndex ?>_sertifikat" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_sertifikat" id= "fs_x<?= $Grid->RowIndex ?>_sertifikat" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_sertifikat" id= "fx_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_sertifikat" id= "fm_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_sertifikat" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_sertifikat" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sertifikat" id="o<?= $Grid->RowIndex ?>_sertifikat" value="<?= HtmlEncode($Grid->sertifikat->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_sertifikat">
<span<?= $Grid->sertifikat->viewAttributes() ?>>
<?= GetFileViewTag($Grid->sertifikat, $Grid->sertifikat->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_pengasuhppwanita_sertifikat" class="form-group pengasuhppwanita_sertifikat">
<div id="fd_x<?= $Grid->RowIndex ?>_sertifikat">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->sertifikat->title() ?>" data-table="pengasuhppwanita" data-field="x_sertifikat" name="x<?= $Grid->RowIndex ?>_sertifikat" id="x<?= $Grid->RowIndex ?>_sertifikat" lang="<?= CurrentLanguageID() ?>"<?= $Grid->sertifikat->editAttributes() ?><?= ($Grid->sertifikat->ReadOnly || $Grid->sertifikat->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_sertifikat"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->sertifikat->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_sertifikat" id= "fn_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_sertifikat" id= "fa_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_sertifikat") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_sertifikat" id= "fs_x<?= $Grid->RowIndex ?>_sertifikat" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_sertifikat" id= "fx_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_sertifikat" id= "fm_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_sertifikat" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
loadjs.ready(["fpengasuhppwanitagrid","load"], function () {
    fpengasuhppwanitagrid.updateLists(<?= $Grid->RowIndex ?>);
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
        $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_pengasuhppwanita", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_pengasuhppwanita_id" class="form-group pengasuhppwanita_id"></span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_id" class="form-group pengasuhppwanita_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pid->Visible) { // pid ?>
        <td data-name="pid">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->pid->getSessionValue() != "") { ?>
<span id="el$rowindex$_pengasuhppwanita_pid" class="form-group pengasuhppwanita_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_pid" name="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_pid" class="form-group pengasuhppwanita_pid">
<?php
$onchange = $Grid->pid->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->pid->EditAttrs["onchange"] = "";
?>
<span id="as_x<?= $Grid->RowIndex ?>_pid" class="ew-auto-suggest">
    <input type="<?= $Grid->pid->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_pid" id="sv_x<?= $Grid->RowIndex ?>_pid" value="<?= RemoveHtml($Grid->pid->EditValue) ?>" size="30"<?= $Grid->pid->editAttributes() ?>>
</span>
<input type="hidden" is="selection-list" class="form-control" data-table="pengasuhppwanita" data-field="x_pid" data-input="sv_x<?= $Grid->RowIndex ?>_pid" data-value-separator="<?= $Grid->pid->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->CurrentValue) ?>"<?= $onchange ?>>
<div class="invalid-feedback"><?= $Grid->pid->getErrorMessage() ?></div>
<script>
loadjs.ready(["fpengasuhppwanitagrid"], function() {
    fpengasuhppwanitagrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_pid","forceSelect":false}, ew.vars.tables.pengasuhppwanita.fields.pid.autoSuggestOptions));
});
</script>
<?= $Grid->pid->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_pid") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_pid" class="form-group pengasuhppwanita_pid">
<span<?= $Grid->pid->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pid->getDisplayValue($Grid->pid->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pid" id="x<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pid" id="o<?= $Grid->RowIndex ?>_pid" value="<?= HtmlEncode($Grid->pid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nama->Visible) { // nama ?>
        <td data-name="nama">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_nama" class="form-group pengasuhppwanita_nama">
<input type="<?= $Grid->nama->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nama" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" size="30" maxlength="255" value="<?= $Grid->nama->EditValue ?>"<?= $Grid->nama->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nama->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_nama" class="form-group pengasuhppwanita_nama">
<span<?= $Grid->nama->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nama->getDisplayValue($Grid->nama->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nama" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nama" id="x<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nama" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nama" id="o<?= $Grid->RowIndex ?>_nama" value="<?= HtmlEncode($Grid->nama->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nik->Visible) { // nik ?>
        <td data-name="nik">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_nik" class="form-group pengasuhppwanita_nik">
<input type="<?= $Grid->nik->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_nik" name="x<?= $Grid->RowIndex ?>_nik" id="x<?= $Grid->RowIndex ?>_nik" size="30" maxlength="255" value="<?= $Grid->nik->EditValue ?>"<?= $Grid->nik->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->nik->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_nik" class="form-group pengasuhppwanita_nik">
<span<?= $Grid->nik->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->nik->getDisplayValue($Grid->nik->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nik" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nik" id="x<?= $Grid->RowIndex ?>_nik" value="<?= HtmlEncode($Grid->nik->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_nik" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nik" id="o<?= $Grid->RowIndex ?>_nik" value="<?= HtmlEncode($Grid->nik->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->alamat->Visible) { // alamat ?>
        <td data-name="alamat">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_alamat" class="form-group pengasuhppwanita_alamat">
<input type="<?= $Grid->alamat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_alamat" name="x<?= $Grid->RowIndex ?>_alamat" id="x<?= $Grid->RowIndex ?>_alamat" size="30" maxlength="255" value="<?= $Grid->alamat->EditValue ?>"<?= $Grid->alamat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->alamat->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_alamat" class="form-group pengasuhppwanita_alamat">
<span<?= $Grid->alamat->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->alamat->getDisplayValue($Grid->alamat->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_alamat" data-hidden="1" name="x<?= $Grid->RowIndex ?>_alamat" id="x<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_alamat" data-hidden="1" name="o<?= $Grid->RowIndex ?>_alamat" id="o<?= $Grid->RowIndex ?>_alamat" value="<?= HtmlEncode($Grid->alamat->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->hp->Visible) { // hp ?>
        <td data-name="hp">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_hp" class="form-group pengasuhppwanita_hp">
<input type="<?= $Grid->hp->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_hp" name="x<?= $Grid->RowIndex ?>_hp" id="x<?= $Grid->RowIndex ?>_hp" size="30" maxlength="255" value="<?= $Grid->hp->EditValue ?>"<?= $Grid->hp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->hp->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_hp" class="form-group pengasuhppwanita_hp">
<span<?= $Grid->hp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->hp->getDisplayValue($Grid->hp->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_hp" data-hidden="1" name="x<?= $Grid->RowIndex ?>_hp" id="x<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_hp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_hp" id="o<?= $Grid->RowIndex ?>_hp" value="<?= HtmlEncode($Grid->hp->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->md->Visible) { // md ?>
        <td data-name="md">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_md" class="form-group pengasuhppwanita_md">
<input type="<?= $Grid->md->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_md" name="x<?= $Grid->RowIndex ?>_md" id="x<?= $Grid->RowIndex ?>_md" size="30" maxlength="255" value="<?= $Grid->md->EditValue ?>"<?= $Grid->md->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->md->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_md" class="form-group pengasuhppwanita_md">
<span<?= $Grid->md->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->md->getDisplayValue($Grid->md->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_md" data-hidden="1" name="x<?= $Grid->RowIndex ?>_md" id="x<?= $Grid->RowIndex ?>_md" value="<?= HtmlEncode($Grid->md->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_md" data-hidden="1" name="o<?= $Grid->RowIndex ?>_md" id="o<?= $Grid->RowIndex ?>_md" value="<?= HtmlEncode($Grid->md->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->mts->Visible) { // mts ?>
        <td data-name="mts">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_mts" class="form-group pengasuhppwanita_mts">
<input type="<?= $Grid->mts->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_mts" name="x<?= $Grid->RowIndex ?>_mts" id="x<?= $Grid->RowIndex ?>_mts" size="30" maxlength="255" value="<?= $Grid->mts->EditValue ?>"<?= $Grid->mts->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->mts->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_mts" class="form-group pengasuhppwanita_mts">
<span<?= $Grid->mts->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->mts->getDisplayValue($Grid->mts->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_mts" data-hidden="1" name="x<?= $Grid->RowIndex ?>_mts" id="x<?= $Grid->RowIndex ?>_mts" value="<?= HtmlEncode($Grid->mts->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_mts" data-hidden="1" name="o<?= $Grid->RowIndex ?>_mts" id="o<?= $Grid->RowIndex ?>_mts" value="<?= HtmlEncode($Grid->mts->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ma->Visible) { // ma ?>
        <td data-name="ma">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_ma" class="form-group pengasuhppwanita_ma">
<input type="<?= $Grid->ma->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_ma" name="x<?= $Grid->RowIndex ?>_ma" id="x<?= $Grid->RowIndex ?>_ma" size="30" maxlength="255" value="<?= $Grid->ma->EditValue ?>"<?= $Grid->ma->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ma->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_ma" class="form-group pengasuhppwanita_ma">
<span<?= $Grid->ma->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ma->getDisplayValue($Grid->ma->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ma" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ma" id="x<?= $Grid->RowIndex ?>_ma" value="<?= HtmlEncode($Grid->ma->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ma" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ma" id="o<?= $Grid->RowIndex ?>_ma" value="<?= HtmlEncode($Grid->ma->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pesantren->Visible) { // pesantren ?>
        <td data-name="pesantren">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_pesantren" class="form-group pengasuhppwanita_pesantren">
<input type="<?= $Grid->pesantren->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pesantren" name="x<?= $Grid->RowIndex ?>_pesantren" id="x<?= $Grid->RowIndex ?>_pesantren" size="30" maxlength="255" value="<?= $Grid->pesantren->EditValue ?>"<?= $Grid->pesantren->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pesantren->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_pesantren" class="form-group pengasuhppwanita_pesantren">
<span<?= $Grid->pesantren->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pesantren->getDisplayValue($Grid->pesantren->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pesantren" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pesantren" id="x<?= $Grid->RowIndex ?>_pesantren" value="<?= HtmlEncode($Grid->pesantren->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pesantren" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pesantren" id="o<?= $Grid->RowIndex ?>_pesantren" value="<?= HtmlEncode($Grid->pesantren->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->s1->Visible) { // s1 ?>
        <td data-name="s1">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_s1" class="form-group pengasuhppwanita_s1">
<input type="<?= $Grid->s1->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s1" name="x<?= $Grid->RowIndex ?>_s1" id="x<?= $Grid->RowIndex ?>_s1" size="30" maxlength="255" value="<?= $Grid->s1->EditValue ?>"<?= $Grid->s1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s1->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_s1" class="form-group pengasuhppwanita_s1">
<span<?= $Grid->s1->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->s1->getDisplayValue($Grid->s1->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s1" data-hidden="1" name="x<?= $Grid->RowIndex ?>_s1" id="x<?= $Grid->RowIndex ?>_s1" value="<?= HtmlEncode($Grid->s1->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s1" data-hidden="1" name="o<?= $Grid->RowIndex ?>_s1" id="o<?= $Grid->RowIndex ?>_s1" value="<?= HtmlEncode($Grid->s1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->s2->Visible) { // s2 ?>
        <td data-name="s2">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_s2" class="form-group pengasuhppwanita_s2">
<input type="<?= $Grid->s2->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s2" name="x<?= $Grid->RowIndex ?>_s2" id="x<?= $Grid->RowIndex ?>_s2" size="30" maxlength="255" value="<?= $Grid->s2->EditValue ?>"<?= $Grid->s2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s2->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_s2" class="form-group pengasuhppwanita_s2">
<span<?= $Grid->s2->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->s2->getDisplayValue($Grid->s2->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s2" data-hidden="1" name="x<?= $Grid->RowIndex ?>_s2" id="x<?= $Grid->RowIndex ?>_s2" value="<?= HtmlEncode($Grid->s2->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s2" data-hidden="1" name="o<?= $Grid->RowIndex ?>_s2" id="o<?= $Grid->RowIndex ?>_s2" value="<?= HtmlEncode($Grid->s2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->s3->Visible) { // s3 ?>
        <td data-name="s3">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_s3" class="form-group pengasuhppwanita_s3">
<input type="<?= $Grid->s3->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_s3" name="x<?= $Grid->RowIndex ?>_s3" id="x<?= $Grid->RowIndex ?>_s3" size="30" maxlength="255" value="<?= $Grid->s3->EditValue ?>"<?= $Grid->s3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->s3->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_s3" class="form-group pengasuhppwanita_s3">
<span<?= $Grid->s3->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->s3->getDisplayValue($Grid->s3->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s3" data-hidden="1" name="x<?= $Grid->RowIndex ?>_s3" id="x<?= $Grid->RowIndex ?>_s3" value="<?= HtmlEncode($Grid->s3->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_s3" data-hidden="1" name="o<?= $Grid->RowIndex ?>_s3" id="o<?= $Grid->RowIndex ?>_s3" value="<?= HtmlEncode($Grid->s3->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->organisasi->Visible) { // organisasi ?>
        <td data-name="organisasi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_organisasi" class="form-group pengasuhppwanita_organisasi">
<input type="<?= $Grid->organisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_organisasi" name="x<?= $Grid->RowIndex ?>_organisasi" id="x<?= $Grid->RowIndex ?>_organisasi" size="30" maxlength="255" value="<?= $Grid->organisasi->EditValue ?>"<?= $Grid->organisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->organisasi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_organisasi" class="form-group pengasuhppwanita_organisasi">
<span<?= $Grid->organisasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->organisasi->getDisplayValue($Grid->organisasi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_organisasi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_organisasi" id="x<?= $Grid->RowIndex ?>_organisasi" value="<?= HtmlEncode($Grid->organisasi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_organisasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_organisasi" id="o<?= $Grid->RowIndex ?>_organisasi" value="<?= HtmlEncode($Grid->organisasi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jabatandiorganisasi->Visible) { // jabatandiorganisasi ?>
        <td data-name="jabatandiorganisasi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_jabatandiorganisasi" class="form-group pengasuhppwanita_jabatandiorganisasi">
<input type="<?= $Grid->jabatandiorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" name="x<?= $Grid->RowIndex ?>_jabatandiorganisasi" id="x<?= $Grid->RowIndex ?>_jabatandiorganisasi" size="30" maxlength="255" value="<?= $Grid->jabatandiorganisasi->EditValue ?>"<?= $Grid->jabatandiorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jabatandiorganisasi->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_jabatandiorganisasi" class="form-group pengasuhppwanita_jabatandiorganisasi">
<span<?= $Grid->jabatandiorganisasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jabatandiorganisasi->getDisplayValue($Grid->jabatandiorganisasi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jabatandiorganisasi" id="x<?= $Grid->RowIndex ?>_jabatandiorganisasi" value="<?= HtmlEncode($Grid->jabatandiorganisasi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandiorganisasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jabatandiorganisasi" id="o<?= $Grid->RowIndex ?>_jabatandiorganisasi" value="<?= HtmlEncode($Grid->jabatandiorganisasi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglawalorganisasi->Visible) { // tglawalorganisasi ?>
        <td data-name="tglawalorganisasi">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_tglawalorganisasi" class="form-group pengasuhppwanita_tglawalorganisasi">
<input type="<?= $Grid->tglawalorganisasi->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-format="7" name="x<?= $Grid->RowIndex ?>_tglawalorganisasi" id="x<?= $Grid->RowIndex ?>_tglawalorganisasi" value="<?= $Grid->tglawalorganisasi->EditValue ?>"<?= $Grid->tglawalorganisasi->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglawalorganisasi->getErrorMessage() ?></div>
<?php if (!$Grid->tglawalorganisasi->ReadOnly && !$Grid->tglawalorganisasi->Disabled && !isset($Grid->tglawalorganisasi->EditAttrs["readonly"]) && !isset($Grid->tglawalorganisasi->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitagrid", "x<?= $Grid->RowIndex ?>_tglawalorganisasi", {"ignoreReadonly":true,"useCurrent":false,"format":7});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_tglawalorganisasi" class="form-group pengasuhppwanita_tglawalorganisasi">
<span<?= $Grid->tglawalorganisasi->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglawalorganisasi->getDisplayValue($Grid->tglawalorganisasi->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglawalorganisasi" id="x<?= $Grid->RowIndex ?>_tglawalorganisasi" value="<?= HtmlEncode($Grid->tglawalorganisasi->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglawalorganisasi" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglawalorganisasi" id="o<?= $Grid->RowIndex ?>_tglawalorganisasi" value="<?= HtmlEncode($Grid->tglawalorganisasi->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->pemerintah->Visible) { // pemerintah ?>
        <td data-name="pemerintah">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_pemerintah" class="form-group pengasuhppwanita_pemerintah">
<input type="<?= $Grid->pemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_pemerintah" name="x<?= $Grid->RowIndex ?>_pemerintah" id="x<?= $Grid->RowIndex ?>_pemerintah" size="30" maxlength="255" value="<?= $Grid->pemerintah->EditValue ?>"<?= $Grid->pemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->pemerintah->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_pemerintah" class="form-group pengasuhppwanita_pemerintah">
<span<?= $Grid->pemerintah->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->pemerintah->getDisplayValue($Grid->pemerintah->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pemerintah" data-hidden="1" name="x<?= $Grid->RowIndex ?>_pemerintah" id="x<?= $Grid->RowIndex ?>_pemerintah" value="<?= HtmlEncode($Grid->pemerintah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_pemerintah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_pemerintah" id="o<?= $Grid->RowIndex ?>_pemerintah" value="<?= HtmlEncode($Grid->pemerintah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->jabatandipemerintah->Visible) { // jabatandipemerintah ?>
        <td data-name="jabatandipemerintah">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_jabatandipemerintah" class="form-group pengasuhppwanita_jabatandipemerintah">
<input type="<?= $Grid->jabatandipemerintah->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" name="x<?= $Grid->RowIndex ?>_jabatandipemerintah" id="x<?= $Grid->RowIndex ?>_jabatandipemerintah" size="30" maxlength="255" value="<?= $Grid->jabatandipemerintah->EditValue ?>"<?= $Grid->jabatandipemerintah->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->jabatandipemerintah->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_jabatandipemerintah" class="form-group pengasuhppwanita_jabatandipemerintah">
<span<?= $Grid->jabatandipemerintah->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->jabatandipemerintah->getDisplayValue($Grid->jabatandipemerintah->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" data-hidden="1" name="x<?= $Grid->RowIndex ?>_jabatandipemerintah" id="x<?= $Grid->RowIndex ?>_jabatandipemerintah" value="<?= HtmlEncode($Grid->jabatandipemerintah->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_jabatandipemerintah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_jabatandipemerintah" id="o<?= $Grid->RowIndex ?>_jabatandipemerintah" value="<?= HtmlEncode($Grid->jabatandipemerintah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->tglmenjabat->Visible) { // tglmenjabat ?>
        <td data-name="tglmenjabat">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_pengasuhppwanita_tglmenjabat" class="form-group pengasuhppwanita_tglmenjabat">
<input type="<?= $Grid->tglmenjabat->getInputTextType() ?>" data-table="pengasuhppwanita" data-field="x_tglmenjabat" name="x<?= $Grid->RowIndex ?>_tglmenjabat" id="x<?= $Grid->RowIndex ?>_tglmenjabat" value="<?= $Grid->tglmenjabat->EditValue ?>"<?= $Grid->tglmenjabat->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->tglmenjabat->getErrorMessage() ?></div>
<?php if (!$Grid->tglmenjabat->ReadOnly && !$Grid->tglmenjabat->Disabled && !isset($Grid->tglmenjabat->EditAttrs["readonly"]) && !isset($Grid->tglmenjabat->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpengasuhppwanitagrid", "datetimepicker"], function() {
    ew.createDateTimePicker("fpengasuhppwanitagrid", "x<?= $Grid->RowIndex ?>_tglmenjabat", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_pengasuhppwanita_tglmenjabat" class="form-group pengasuhppwanita_tglmenjabat">
<span<?= $Grid->tglmenjabat->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->tglmenjabat->getDisplayValue($Grid->tglmenjabat->ViewValue))) ?>"></span>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglmenjabat" data-hidden="1" name="x<?= $Grid->RowIndex ?>_tglmenjabat" id="x<?= $Grid->RowIndex ?>_tglmenjabat" value="<?= HtmlEncode($Grid->tglmenjabat->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_tglmenjabat" data-hidden="1" name="o<?= $Grid->RowIndex ?>_tglmenjabat" id="o<?= $Grid->RowIndex ?>_tglmenjabat" value="<?= HtmlEncode($Grid->tglmenjabat->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->foto->Visible) { // foto ?>
        <td data-name="foto">
<span id="el$rowindex$_pengasuhppwanita_foto" class="form-group pengasuhppwanita_foto">
<div id="fd_x<?= $Grid->RowIndex ?>_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->foto->title() ?>" data-table="pengasuhppwanita" data-field="x_foto" name="x<?= $Grid->RowIndex ?>_foto" id="x<?= $Grid->RowIndex ?>_foto" lang="<?= CurrentLanguageID() ?>" multiple<?= $Grid->foto->editAttributes() ?><?= ($Grid->foto->ReadOnly || $Grid->foto->Disabled) ? " disabled" : "" ?>>
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
<input type="hidden" data-table="pengasuhppwanita" data-field="x_foto" data-hidden="1" name="o<?= $Grid->RowIndex ?>_foto" id="o<?= $Grid->RowIndex ?>_foto" value="<?= HtmlEncode($Grid->foto->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ijazah->Visible) { // ijazah ?>
        <td data-name="ijazah">
<span id="el$rowindex$_pengasuhppwanita_ijazah" class="form-group pengasuhppwanita_ijazah">
<div id="fd_x<?= $Grid->RowIndex ?>_ijazah">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->ijazah->title() ?>" data-table="pengasuhppwanita" data-field="x_ijazah" name="x<?= $Grid->RowIndex ?>_ijazah" id="x<?= $Grid->RowIndex ?>_ijazah" lang="<?= CurrentLanguageID() ?>"<?= $Grid->ijazah->editAttributes() ?><?= ($Grid->ijazah->ReadOnly || $Grid->ijazah->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_ijazah"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->ijazah->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_ijazah" id= "fn_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_ijazah" id= "fa_x<?= $Grid->RowIndex ?>_ijazah" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_ijazah" id= "fs_x<?= $Grid->RowIndex ?>_ijazah" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_ijazah" id= "fx_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_ijazah" id= "fm_x<?= $Grid->RowIndex ?>_ijazah" value="<?= $Grid->ijazah->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_ijazah" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_ijazah" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ijazah" id="o<?= $Grid->RowIndex ?>_ijazah" value="<?= HtmlEncode($Grid->ijazah->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->sertifikat->Visible) { // sertifikat ?>
        <td data-name="sertifikat">
<span id="el$rowindex$_pengasuhppwanita_sertifikat" class="form-group pengasuhppwanita_sertifikat">
<div id="fd_x<?= $Grid->RowIndex ?>_sertifikat">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Grid->sertifikat->title() ?>" data-table="pengasuhppwanita" data-field="x_sertifikat" name="x<?= $Grid->RowIndex ?>_sertifikat" id="x<?= $Grid->RowIndex ?>_sertifikat" lang="<?= CurrentLanguageID() ?>"<?= $Grid->sertifikat->editAttributes() ?><?= ($Grid->sertifikat->ReadOnly || $Grid->sertifikat->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Grid->RowIndex ?>_sertifikat"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Grid->sertifikat->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_sertifikat" id= "fn_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_sertifikat" id= "fa_x<?= $Grid->RowIndex ?>_sertifikat" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_sertifikat" id= "fs_x<?= $Grid->RowIndex ?>_sertifikat" value="255">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_sertifikat" id= "fx_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_sertifikat" id= "fm_x<?= $Grid->RowIndex ?>_sertifikat" value="<?= $Grid->sertifikat->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Grid->RowIndex ?>_sertifikat" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="pengasuhppwanita" data-field="x_sertifikat" data-hidden="1" name="o<?= $Grid->RowIndex ?>_sertifikat" id="o<?= $Grid->RowIndex ?>_sertifikat" value="<?= HtmlEncode($Grid->sertifikat->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fpengasuhppwanitagrid","load"], function() {
    fpengasuhppwanitagrid.updateLists(<?= $Grid->RowIndex ?>);
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
<input type="hidden" name="detailpage" value="fpengasuhppwanitagrid">
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
    ew.addEventHandlers("pengasuhppwanita");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
