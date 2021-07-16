<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PesantrenEdit extends Pesantren
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'pesantren';

    // Page object name
    public $PageObjName = "PesantrenEdit";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (pesantren)
        if (!isset($GLOBALS["pesantren"]) || get_class($GLOBALS["pesantren"]) == PROJECT_NAMESPACE . "pesantren") {
            $GLOBALS["pesantren"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'pesantren');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("pesantren"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "PesantrenView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->kode->setVisibility();
        $this->nama->setVisibility();
        $this->deskripsi->setVisibility();
        $this->jalan->setVisibility();
        $this->propinsi->setVisibility();
        $this->kabupaten->setVisibility();
        $this->kecamatan->setVisibility();
        $this->desa->setVisibility();
        $this->kodepos->setVisibility();
        $this->latitude->Visible = false;
        $this->longitude->Visible = false;
        $this->telpon->setVisibility();
        $this->web->setVisibility();
        $this->_email->setVisibility();
        $this->nspp->setVisibility();
        $this->nspptglmulai->setVisibility();
        $this->nspptglakhir->setVisibility();
        $this->dokumennspp->setVisibility();
        $this->yayasan->setVisibility();
        $this->noakta->setVisibility();
        $this->tglakta->setVisibility();
        $this->namanotaris->setVisibility();
        $this->alamatnotaris->setVisibility();
        $this->noaktaperubahan->Visible = false;
        $this->tglubah->Visible = false;
        $this->namanotarisubah->Visible = false;
        $this->alamatnotarisubah->Visible = false;
        $this->_userid->Visible = false;
        $this->foto->setVisibility();
        $this->ktp->setVisibility();
        $this->dokumen->setVisibility();
        $this->validasi->setVisibility();
        $this->validator->setVisibility();
        $this->validasi_pusat->setVisibility();
        $this->validator_pusat->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->tgl_validasi_cabang->Visible = false;
        $this->tgl_validasi_pusat->Visible = false;
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->propinsi);
        $this->setupLookupOptions($this->kabupaten);
        $this->setupLookupOptions($this->kecamatan);
        $this->setupLookupOptions($this->desa);
        $this->setupLookupOptions($this->_userid);
        $this->setupLookupOptions($this->validator);
        $this->setupLookupOptions($this->validator_pusat);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("PesantrenList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "PesantrenList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->dokumennspp->Upload->Index = $CurrentForm->Index;
        $this->dokumennspp->Upload->uploadFile();
        $this->dokumennspp->CurrentValue = $this->dokumennspp->Upload->FileName;
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->foto->CurrentValue = $this->foto->Upload->FileName;
        $this->ktp->Upload->Index = $CurrentForm->Index;
        $this->ktp->Upload->uploadFile();
        $this->ktp->CurrentValue = $this->ktp->Upload->FileName;
        $this->dokumen->Upload->Index = $CurrentForm->Index;
        $this->dokumen->Upload->uploadFile();
        $this->dokumen->CurrentValue = $this->dokumen->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'kode' first before field var 'x_kode'
        $val = $CurrentForm->hasValue("kode") ? $CurrentForm->getValue("kode") : $CurrentForm->getValue("x_kode");
        if (!$this->kode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kode->Visible = false; // Disable update for API request
            } else {
                $this->kode->setFormValue($val);
            }
        }

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'deskripsi' first before field var 'x_deskripsi'
        $val = $CurrentForm->hasValue("deskripsi") ? $CurrentForm->getValue("deskripsi") : $CurrentForm->getValue("x_deskripsi");
        if (!$this->deskripsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deskripsi->Visible = false; // Disable update for API request
            } else {
                $this->deskripsi->setFormValue($val);
            }
        }

        // Check field name 'jalan' first before field var 'x_jalan'
        $val = $CurrentForm->hasValue("jalan") ? $CurrentForm->getValue("jalan") : $CurrentForm->getValue("x_jalan");
        if (!$this->jalan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jalan->Visible = false; // Disable update for API request
            } else {
                $this->jalan->setFormValue($val);
            }
        }

        // Check field name 'propinsi' first before field var 'x_propinsi'
        $val = $CurrentForm->hasValue("propinsi") ? $CurrentForm->getValue("propinsi") : $CurrentForm->getValue("x_propinsi");
        if (!$this->propinsi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->propinsi->Visible = false; // Disable update for API request
            } else {
                $this->propinsi->setFormValue($val);
            }
        }

        // Check field name 'kabupaten' first before field var 'x_kabupaten'
        $val = $CurrentForm->hasValue("kabupaten") ? $CurrentForm->getValue("kabupaten") : $CurrentForm->getValue("x_kabupaten");
        if (!$this->kabupaten->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kabupaten->Visible = false; // Disable update for API request
            } else {
                $this->kabupaten->setFormValue($val);
            }
        }

        // Check field name 'kecamatan' first before field var 'x_kecamatan'
        $val = $CurrentForm->hasValue("kecamatan") ? $CurrentForm->getValue("kecamatan") : $CurrentForm->getValue("x_kecamatan");
        if (!$this->kecamatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kecamatan->Visible = false; // Disable update for API request
            } else {
                $this->kecamatan->setFormValue($val);
            }
        }

        // Check field name 'desa' first before field var 'x_desa'
        $val = $CurrentForm->hasValue("desa") ? $CurrentForm->getValue("desa") : $CurrentForm->getValue("x_desa");
        if (!$this->desa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desa->Visible = false; // Disable update for API request
            } else {
                $this->desa->setFormValue($val);
            }
        }

        // Check field name 'kodepos' first before field var 'x_kodepos'
        $val = $CurrentForm->hasValue("kodepos") ? $CurrentForm->getValue("kodepos") : $CurrentForm->getValue("x_kodepos");
        if (!$this->kodepos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kodepos->Visible = false; // Disable update for API request
            } else {
                $this->kodepos->setFormValue($val);
            }
        }

        // Check field name 'telpon' first before field var 'x_telpon'
        $val = $CurrentForm->hasValue("telpon") ? $CurrentForm->getValue("telpon") : $CurrentForm->getValue("x_telpon");
        if (!$this->telpon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telpon->Visible = false; // Disable update for API request
            } else {
                $this->telpon->setFormValue($val);
            }
        }

        // Check field name 'web' first before field var 'x_web'
        $val = $CurrentForm->hasValue("web") ? $CurrentForm->getValue("web") : $CurrentForm->getValue("x_web");
        if (!$this->web->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->web->Visible = false; // Disable update for API request
            } else {
                $this->web->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'nspp' first before field var 'x_nspp'
        $val = $CurrentForm->hasValue("nspp") ? $CurrentForm->getValue("nspp") : $CurrentForm->getValue("x_nspp");
        if (!$this->nspp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nspp->Visible = false; // Disable update for API request
            } else {
                $this->nspp->setFormValue($val);
            }
        }

        // Check field name 'nspptglmulai' first before field var 'x_nspptglmulai'
        $val = $CurrentForm->hasValue("nspptglmulai") ? $CurrentForm->getValue("nspptglmulai") : $CurrentForm->getValue("x_nspptglmulai");
        if (!$this->nspptglmulai->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nspptglmulai->Visible = false; // Disable update for API request
            } else {
                $this->nspptglmulai->setFormValue($val);
            }
            $this->nspptglmulai->CurrentValue = UnFormatDateTime($this->nspptglmulai->CurrentValue, 7);
        }

        // Check field name 'nspptglakhir' first before field var 'x_nspptglakhir'
        $val = $CurrentForm->hasValue("nspptglakhir") ? $CurrentForm->getValue("nspptglakhir") : $CurrentForm->getValue("x_nspptglakhir");
        if (!$this->nspptglakhir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nspptglakhir->Visible = false; // Disable update for API request
            } else {
                $this->nspptglakhir->setFormValue($val);
            }
            $this->nspptglakhir->CurrentValue = UnFormatDateTime($this->nspptglakhir->CurrentValue, 7);
        }

        // Check field name 'yayasan' first before field var 'x_yayasan'
        $val = $CurrentForm->hasValue("yayasan") ? $CurrentForm->getValue("yayasan") : $CurrentForm->getValue("x_yayasan");
        if (!$this->yayasan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->yayasan->Visible = false; // Disable update for API request
            } else {
                $this->yayasan->setFormValue($val);
            }
        }

        // Check field name 'noakta' first before field var 'x_noakta'
        $val = $CurrentForm->hasValue("noakta") ? $CurrentForm->getValue("noakta") : $CurrentForm->getValue("x_noakta");
        if (!$this->noakta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->noakta->Visible = false; // Disable update for API request
            } else {
                $this->noakta->setFormValue($val);
            }
        }

        // Check field name 'tglakta' first before field var 'x_tglakta'
        $val = $CurrentForm->hasValue("tglakta") ? $CurrentForm->getValue("tglakta") : $CurrentForm->getValue("x_tglakta");
        if (!$this->tglakta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglakta->Visible = false; // Disable update for API request
            } else {
                $this->tglakta->setFormValue($val);
            }
            $this->tglakta->CurrentValue = UnFormatDateTime($this->tglakta->CurrentValue, 7);
        }

        // Check field name 'namanotaris' first before field var 'x_namanotaris'
        $val = $CurrentForm->hasValue("namanotaris") ? $CurrentForm->getValue("namanotaris") : $CurrentForm->getValue("x_namanotaris");
        if (!$this->namanotaris->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->namanotaris->Visible = false; // Disable update for API request
            } else {
                $this->namanotaris->setFormValue($val);
            }
        }

        // Check field name 'alamatnotaris' first before field var 'x_alamatnotaris'
        $val = $CurrentForm->hasValue("alamatnotaris") ? $CurrentForm->getValue("alamatnotaris") : $CurrentForm->getValue("x_alamatnotaris");
        if (!$this->alamatnotaris->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alamatnotaris->Visible = false; // Disable update for API request
            } else {
                $this->alamatnotaris->setFormValue($val);
            }
        }

        // Check field name 'validasi' first before field var 'x_validasi'
        $val = $CurrentForm->hasValue("validasi") ? $CurrentForm->getValue("validasi") : $CurrentForm->getValue("x_validasi");
        if (!$this->validasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->validasi->Visible = false; // Disable update for API request
            } else {
                $this->validasi->setFormValue($val);
            }
        }

        // Check field name 'validator' first before field var 'x_validator'
        $val = $CurrentForm->hasValue("validator") ? $CurrentForm->getValue("validator") : $CurrentForm->getValue("x_validator");
        if (!$this->validator->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->validator->Visible = false; // Disable update for API request
            } else {
                $this->validator->setFormValue($val);
            }
        }

        // Check field name 'validasi_pusat' first before field var 'x_validasi_pusat'
        $val = $CurrentForm->hasValue("validasi_pusat") ? $CurrentForm->getValue("validasi_pusat") : $CurrentForm->getValue("x_validasi_pusat");
        if (!$this->validasi_pusat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->validasi_pusat->Visible = false; // Disable update for API request
            } else {
                $this->validasi_pusat->setFormValue($val);
            }
        }

        // Check field name 'validator_pusat' first before field var 'x_validator_pusat'
        $val = $CurrentForm->hasValue("validator_pusat") ? $CurrentForm->getValue("validator_pusat") : $CurrentForm->getValue("x_validator_pusat");
        if (!$this->validator_pusat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->validator_pusat->Visible = false; // Disable update for API request
            } else {
                $this->validator_pusat->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->kode->CurrentValue = $this->kode->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->deskripsi->CurrentValue = $this->deskripsi->FormValue;
        $this->jalan->CurrentValue = $this->jalan->FormValue;
        $this->propinsi->CurrentValue = $this->propinsi->FormValue;
        $this->kabupaten->CurrentValue = $this->kabupaten->FormValue;
        $this->kecamatan->CurrentValue = $this->kecamatan->FormValue;
        $this->desa->CurrentValue = $this->desa->FormValue;
        $this->kodepos->CurrentValue = $this->kodepos->FormValue;
        $this->telpon->CurrentValue = $this->telpon->FormValue;
        $this->web->CurrentValue = $this->web->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->nspp->CurrentValue = $this->nspp->FormValue;
        $this->nspptglmulai->CurrentValue = $this->nspptglmulai->FormValue;
        $this->nspptglmulai->CurrentValue = UnFormatDateTime($this->nspptglmulai->CurrentValue, 7);
        $this->nspptglakhir->CurrentValue = $this->nspptglakhir->FormValue;
        $this->nspptglakhir->CurrentValue = UnFormatDateTime($this->nspptglakhir->CurrentValue, 7);
        $this->yayasan->CurrentValue = $this->yayasan->FormValue;
        $this->noakta->CurrentValue = $this->noakta->FormValue;
        $this->tglakta->CurrentValue = $this->tglakta->FormValue;
        $this->tglakta->CurrentValue = UnFormatDateTime($this->tglakta->CurrentValue, 7);
        $this->namanotaris->CurrentValue = $this->namanotaris->FormValue;
        $this->alamatnotaris->CurrentValue = $this->alamatnotaris->FormValue;
        $this->validasi->CurrentValue = $this->validasi->FormValue;
        $this->validator->CurrentValue = $this->validator->FormValue;
        $this->validasi_pusat->CurrentValue = $this->validasi_pusat->FormValue;
        $this->validator_pusat->CurrentValue = $this->validator_pusat->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("edit");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->kode->setDbValue($row['kode']);
        $this->nama->setDbValue($row['nama']);
        $this->deskripsi->setDbValue($row['deskripsi']);
        $this->jalan->setDbValue($row['jalan']);
        $this->propinsi->setDbValue($row['propinsi']);
        $this->kabupaten->setDbValue($row['kabupaten']);
        $this->kecamatan->setDbValue($row['kecamatan']);
        $this->desa->setDbValue($row['desa']);
        $this->kodepos->setDbValue($row['kodepos']);
        $this->latitude->setDbValue($row['latitude']);
        $this->longitude->setDbValue($row['longitude']);
        $this->telpon->setDbValue($row['telpon']);
        $this->web->setDbValue($row['web']);
        $this->_email->setDbValue($row['email']);
        $this->nspp->setDbValue($row['nspp']);
        $this->nspptglmulai->setDbValue($row['nspptglmulai']);
        $this->nspptglakhir->setDbValue($row['nspptglakhir']);
        $this->dokumennspp->Upload->DbValue = $row['dokumennspp'];
        $this->dokumennspp->setDbValue($this->dokumennspp->Upload->DbValue);
        $this->yayasan->setDbValue($row['yayasan']);
        $this->noakta->setDbValue($row['noakta']);
        $this->tglakta->setDbValue($row['tglakta']);
        $this->namanotaris->setDbValue($row['namanotaris']);
        $this->alamatnotaris->setDbValue($row['alamatnotaris']);
        $this->noaktaperubahan->setDbValue($row['noaktaperubahan']);
        $this->tglubah->setDbValue($row['tglubah']);
        $this->namanotarisubah->setDbValue($row['namanotarisubah']);
        $this->alamatnotarisubah->setDbValue($row['alamatnotarisubah']);
        $this->_userid->setDbValue($row['userid']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->ktp->Upload->DbValue = $row['ktp'];
        $this->ktp->setDbValue($this->ktp->Upload->DbValue);
        $this->dokumen->Upload->DbValue = $row['dokumen'];
        $this->dokumen->setDbValue($this->dokumen->Upload->DbValue);
        $this->validasi->setDbValue($row['validasi']);
        $this->validator->setDbValue($row['validator']);
        $this->validasi_pusat->setDbValue($row['validasi_pusat']);
        $this->validator_pusat->setDbValue($row['validator_pusat']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->tgl_validasi_cabang->setDbValue($row['tgl_validasi_cabang']);
        $this->tgl_validasi_pusat->setDbValue($row['tgl_validasi_pusat']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['kode'] = null;
        $row['nama'] = null;
        $row['deskripsi'] = null;
        $row['jalan'] = null;
        $row['propinsi'] = null;
        $row['kabupaten'] = null;
        $row['kecamatan'] = null;
        $row['desa'] = null;
        $row['kodepos'] = null;
        $row['latitude'] = null;
        $row['longitude'] = null;
        $row['telpon'] = null;
        $row['web'] = null;
        $row['email'] = null;
        $row['nspp'] = null;
        $row['nspptglmulai'] = null;
        $row['nspptglakhir'] = null;
        $row['dokumennspp'] = null;
        $row['yayasan'] = null;
        $row['noakta'] = null;
        $row['tglakta'] = null;
        $row['namanotaris'] = null;
        $row['alamatnotaris'] = null;
        $row['noaktaperubahan'] = null;
        $row['tglubah'] = null;
        $row['namanotarisubah'] = null;
        $row['alamatnotarisubah'] = null;
        $row['userid'] = null;
        $row['foto'] = null;
        $row['ktp'] = null;
        $row['dokumen'] = null;
        $row['validasi'] = null;
        $row['validator'] = null;
        $row['validasi_pusat'] = null;
        $row['validator_pusat'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['tgl_validasi_cabang'] = null;
        $row['tgl_validasi_pusat'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // kode

        // nama

        // deskripsi

        // jalan

        // propinsi

        // kabupaten

        // kecamatan

        // desa

        // kodepos

        // latitude

        // longitude

        // telpon

        // web

        // email

        // nspp

        // nspptglmulai

        // nspptglakhir

        // dokumennspp

        // yayasan

        // noakta

        // tglakta

        // namanotaris

        // alamatnotaris

        // noaktaperubahan

        // tglubah

        // namanotarisubah

        // alamatnotarisubah

        // userid

        // foto

        // ktp

        // dokumen

        // validasi

        // validator

        // validasi_pusat

        // validator_pusat

        // created_at

        // updated_at

        // tgl_validasi_cabang

        // tgl_validasi_pusat
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // kode
            $this->kode->ViewValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // deskripsi
            $this->deskripsi->ViewValue = $this->deskripsi->CurrentValue;
            $this->deskripsi->ViewCustomAttributes = "";

            // jalan
            $this->jalan->ViewValue = $this->jalan->CurrentValue;
            $this->jalan->ViewCustomAttributes = "";

            // propinsi
            $curVal = trim(strval($this->propinsi->CurrentValue));
            if ($curVal != "") {
                $this->propinsi->ViewValue = $this->propinsi->lookupCacheOption($curVal);
                if ($this->propinsi->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->propinsi->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->propinsi->Lookup->renderViewRow($rswrk[0]);
                        $this->propinsi->ViewValue = $this->propinsi->displayValue($arwrk);
                    } else {
                        $this->propinsi->ViewValue = $this->propinsi->CurrentValue;
                    }
                }
            } else {
                $this->propinsi->ViewValue = null;
            }
            $this->propinsi->ViewCustomAttributes = "";

            // kabupaten
            $curVal = trim(strval($this->kabupaten->CurrentValue));
            if ($curVal != "") {
                $this->kabupaten->ViewValue = $this->kabupaten->lookupCacheOption($curVal);
                if ($this->kabupaten->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kabupaten->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kabupaten->Lookup->renderViewRow($rswrk[0]);
                        $this->kabupaten->ViewValue = $this->kabupaten->displayValue($arwrk);
                    } else {
                        $this->kabupaten->ViewValue = $this->kabupaten->CurrentValue;
                    }
                }
            } else {
                $this->kabupaten->ViewValue = null;
            }
            $this->kabupaten->ViewCustomAttributes = "";

            // kecamatan
            $curVal = trim(strval($this->kecamatan->CurrentValue));
            if ($curVal != "") {
                $this->kecamatan->ViewValue = $this->kecamatan->lookupCacheOption($curVal);
                if ($this->kecamatan->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->kecamatan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->kecamatan->Lookup->renderViewRow($rswrk[0]);
                        $this->kecamatan->ViewValue = $this->kecamatan->displayValue($arwrk);
                    } else {
                        $this->kecamatan->ViewValue = $this->kecamatan->CurrentValue;
                    }
                }
            } else {
                $this->kecamatan->ViewValue = null;
            }
            $this->kecamatan->ViewCustomAttributes = "";

            // desa
            $curVal = trim(strval($this->desa->CurrentValue));
            if ($curVal != "") {
                $this->desa->ViewValue = $this->desa->lookupCacheOption($curVal);
                if ($this->desa->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->desa->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->desa->Lookup->renderViewRow($rswrk[0]);
                        $this->desa->ViewValue = $this->desa->displayValue($arwrk);
                    } else {
                        $this->desa->ViewValue = $this->desa->CurrentValue;
                    }
                }
            } else {
                $this->desa->ViewValue = null;
            }
            $this->desa->ViewCustomAttributes = "";

            // kodepos
            $this->kodepos->ViewValue = $this->kodepos->CurrentValue;
            $this->kodepos->ViewCustomAttributes = "";

            // telpon
            $this->telpon->ViewValue = $this->telpon->CurrentValue;
            $this->telpon->ViewCustomAttributes = "";

            // web
            $this->web->ViewValue = $this->web->CurrentValue;
            $this->web->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

            // nspp
            $this->nspp->ViewValue = $this->nspp->CurrentValue;
            $this->nspp->ViewCustomAttributes = "";

            // nspptglmulai
            $this->nspptglmulai->ViewValue = $this->nspptglmulai->CurrentValue;
            $this->nspptglmulai->ViewValue = FormatDateTime($this->nspptglmulai->ViewValue, 7);
            $this->nspptglmulai->ViewCustomAttributes = "";

            // nspptglakhir
            $this->nspptglakhir->ViewValue = $this->nspptglakhir->CurrentValue;
            $this->nspptglakhir->ViewValue = FormatDateTime($this->nspptglakhir->ViewValue, 7);
            $this->nspptglakhir->ViewCustomAttributes = "";

            // dokumennspp
            if (!EmptyValue($this->dokumennspp->Upload->DbValue)) {
                $this->dokumennspp->ViewValue = $this->dokumennspp->Upload->DbValue;
            } else {
                $this->dokumennspp->ViewValue = "";
            }
            $this->dokumennspp->ViewCustomAttributes = "";

            // yayasan
            $this->yayasan->ViewValue = $this->yayasan->CurrentValue;
            $this->yayasan->ViewCustomAttributes = "";

            // noakta
            $this->noakta->ViewValue = $this->noakta->CurrentValue;
            $this->noakta->ViewCustomAttributes = "";

            // tglakta
            $this->tglakta->ViewValue = $this->tglakta->CurrentValue;
            $this->tglakta->ViewValue = FormatDateTime($this->tglakta->ViewValue, 7);
            $this->tglakta->ViewCustomAttributes = "";

            // namanotaris
            $this->namanotaris->ViewValue = $this->namanotaris->CurrentValue;
            $this->namanotaris->ViewCustomAttributes = "";

            // alamatnotaris
            $this->alamatnotaris->ViewValue = $this->alamatnotaris->CurrentValue;
            $this->alamatnotaris->ViewCustomAttributes = "";

            // userid
            $curVal = trim(strval($this->_userid->CurrentValue));
            if ($curVal != "") {
                $this->_userid->ViewValue = $this->_userid->lookupCacheOption($curVal);
                if ($this->_userid->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->_userid->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->_userid->Lookup->renderViewRow($rswrk[0]);
                        $this->_userid->ViewValue = $this->_userid->displayValue($arwrk);
                    } else {
                        $this->_userid->ViewValue = $this->_userid->CurrentValue;
                    }
                }
            } else {
                $this->_userid->ViewValue = null;
            }
            $this->_userid->ViewCustomAttributes = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageWidth = 50;
                $this->foto->ImageHeight = 50;
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }
            $this->foto->ViewCustomAttributes = "";

            // ktp
            if (!EmptyValue($this->ktp->Upload->DbValue)) {
                $this->ktp->ImageAlt = $this->ktp->alt();
                $this->ktp->ViewValue = $this->ktp->Upload->DbValue;
            } else {
                $this->ktp->ViewValue = "";
            }
            $this->ktp->ViewCustomAttributes = "";

            // dokumen
            if (!EmptyValue($this->dokumen->Upload->DbValue)) {
                $this->dokumen->ImageWidth = 50;
                $this->dokumen->ImageHeight = 50;
                $this->dokumen->ImageAlt = $this->dokumen->alt();
                $this->dokumen->ViewValue = $this->dokumen->Upload->DbValue;
            } else {
                $this->dokumen->ViewValue = "";
            }
            $this->dokumen->ViewCustomAttributes = "";

            // validasi
            if (strval($this->validasi->CurrentValue) != "") {
                $this->validasi->ViewValue = $this->validasi->optionCaption($this->validasi->CurrentValue);
            } else {
                $this->validasi->ViewValue = null;
            }
            $this->validasi->ViewCustomAttributes = "";

            // validator
            $curVal = trim(strval($this->validator->CurrentValue));
            if ($curVal != "") {
                $this->validator->ViewValue = $this->validator->lookupCacheOption($curVal);
                if ($this->validator->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "grup = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->validator->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->validator->Lookup->renderViewRow($rswrk[0]);
                        $this->validator->ViewValue = $this->validator->displayValue($arwrk);
                    } else {
                        $this->validator->ViewValue = $this->validator->CurrentValue;
                    }
                }
            } else {
                $this->validator->ViewValue = null;
            }
            $this->validator->ViewCustomAttributes = "";

            // validasi_pusat
            if (strval($this->validasi_pusat->CurrentValue) != "") {
                $this->validasi_pusat->ViewValue = $this->validasi_pusat->optionCaption($this->validasi_pusat->CurrentValue);
            } else {
                $this->validasi_pusat->ViewValue = null;
            }
            $this->validasi_pusat->ViewCustomAttributes = "";

            // validator_pusat
            $curVal = trim(strval($this->validator_pusat->CurrentValue));
            if ($curVal != "") {
                $this->validator_pusat->ViewValue = $this->validator_pusat->lookupCacheOption($curVal);
                if ($this->validator_pusat->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "grup = 3";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->validator_pusat->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->validator_pusat->Lookup->renderViewRow($rswrk[0]);
                        $this->validator_pusat->ViewValue = $this->validator_pusat->displayValue($arwrk);
                    } else {
                        $this->validator_pusat->ViewValue = $this->validator_pusat->CurrentValue;
                    }
                }
            } else {
                $this->validator_pusat->ViewValue = null;
            }
            $this->validator_pusat->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // tgl_validasi_cabang
            $this->tgl_validasi_cabang->ViewValue = $this->tgl_validasi_cabang->CurrentValue;
            $this->tgl_validasi_cabang->ViewValue = FormatDateTime($this->tgl_validasi_cabang->ViewValue, 0);
            $this->tgl_validasi_cabang->ViewCustomAttributes = "";

            // tgl_validasi_pusat
            $this->tgl_validasi_pusat->ViewValue = $this->tgl_validasi_pusat->CurrentValue;
            $this->tgl_validasi_pusat->ViewValue = FormatDateTime($this->tgl_validasi_pusat->ViewValue, 0);
            $this->tgl_validasi_pusat->ViewCustomAttributes = "";

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // deskripsi
            $this->deskripsi->LinkCustomAttributes = "";
            $this->deskripsi->HrefValue = "";
            $this->deskripsi->TooltipValue = "";

            // jalan
            $this->jalan->LinkCustomAttributes = "";
            $this->jalan->HrefValue = "";
            $this->jalan->TooltipValue = "";

            // propinsi
            $this->propinsi->LinkCustomAttributes = "";
            $this->propinsi->HrefValue = "";
            $this->propinsi->TooltipValue = "";

            // kabupaten
            $this->kabupaten->LinkCustomAttributes = "";
            $this->kabupaten->HrefValue = "";
            $this->kabupaten->TooltipValue = "";

            // kecamatan
            $this->kecamatan->LinkCustomAttributes = "";
            $this->kecamatan->HrefValue = "";
            $this->kecamatan->TooltipValue = "";

            // desa
            $this->desa->LinkCustomAttributes = "";
            $this->desa->HrefValue = "";
            $this->desa->TooltipValue = "";

            // kodepos
            $this->kodepos->LinkCustomAttributes = "";
            $this->kodepos->HrefValue = "";
            $this->kodepos->TooltipValue = "";

            // telpon
            $this->telpon->LinkCustomAttributes = "";
            $this->telpon->HrefValue = "";
            $this->telpon->TooltipValue = "";

            // web
            $this->web->LinkCustomAttributes = "";
            $this->web->HrefValue = "";
            $this->web->TooltipValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

            // nspp
            $this->nspp->LinkCustomAttributes = "";
            $this->nspp->HrefValue = "";
            $this->nspp->TooltipValue = "";

            // nspptglmulai
            $this->nspptglmulai->LinkCustomAttributes = "";
            $this->nspptglmulai->HrefValue = "";
            $this->nspptglmulai->TooltipValue = "";

            // nspptglakhir
            $this->nspptglakhir->LinkCustomAttributes = "";
            $this->nspptglakhir->HrefValue = "";
            $this->nspptglakhir->TooltipValue = "";

            // dokumennspp
            $this->dokumennspp->LinkCustomAttributes = "";
            $this->dokumennspp->HrefValue = "";
            $this->dokumennspp->ExportHrefValue = $this->dokumennspp->UploadPath . $this->dokumennspp->Upload->DbValue;
            $this->dokumennspp->TooltipValue = "";

            // yayasan
            $this->yayasan->LinkCustomAttributes = "";
            $this->yayasan->HrefValue = "";
            $this->yayasan->TooltipValue = "";

            // noakta
            $this->noakta->LinkCustomAttributes = "";
            $this->noakta->HrefValue = "";
            $this->noakta->TooltipValue = "";

            // tglakta
            $this->tglakta->LinkCustomAttributes = "";
            $this->tglakta->HrefValue = "";
            $this->tglakta->TooltipValue = "";

            // namanotaris
            $this->namanotaris->LinkCustomAttributes = "";
            $this->namanotaris->HrefValue = "";
            $this->namanotaris->TooltipValue = "";

            // alamatnotaris
            $this->alamatnotaris->LinkCustomAttributes = "";
            $this->alamatnotaris->HrefValue = "";
            $this->alamatnotaris->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->HrefValue = "%u"; // Add prefix/suffix
                $this->foto->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
                }
            } else {
                $this->foto->HrefValue = "";
            }
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";
            if ($this->foto->UseColorbox) {
                if (EmptyValue($this->foto->TooltipValue)) {
                    $this->foto->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->foto->LinkAttrs["data-rel"] = "pesantren_x_foto";
                $this->foto->LinkAttrs->appendClass("ew-lightbox");
            }

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            if (!EmptyValue($this->ktp->Upload->DbValue)) {
                $this->ktp->HrefValue = GetFileUploadUrl($this->ktp, $this->ktp->htmlDecode($this->ktp->Upload->DbValue)); // Add prefix/suffix
                $this->ktp->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->ktp->HrefValue = FullUrl($this->ktp->HrefValue, "href");
                }
            } else {
                $this->ktp->HrefValue = "";
            }
            $this->ktp->ExportHrefValue = $this->ktp->UploadPath . $this->ktp->Upload->DbValue;
            $this->ktp->TooltipValue = "";
            if ($this->ktp->UseColorbox) {
                if (EmptyValue($this->ktp->TooltipValue)) {
                    $this->ktp->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->ktp->LinkAttrs["data-rel"] = "pesantren_x_ktp";
                $this->ktp->LinkAttrs->appendClass("ew-lightbox");
            }

            // dokumen
            $this->dokumen->LinkCustomAttributes = "";
            if (!EmptyValue($this->dokumen->Upload->DbValue)) {
                $this->dokumen->HrefValue = GetFileUploadUrl($this->dokumen, $this->dokumen->htmlDecode($this->dokumen->Upload->DbValue)); // Add prefix/suffix
                $this->dokumen->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->dokumen->HrefValue = FullUrl($this->dokumen->HrefValue, "href");
                }
            } else {
                $this->dokumen->HrefValue = "";
            }
            $this->dokumen->ExportHrefValue = $this->dokumen->UploadPath . $this->dokumen->Upload->DbValue;
            $this->dokumen->TooltipValue = "";
            if ($this->dokumen->UseColorbox) {
                if (EmptyValue($this->dokumen->TooltipValue)) {
                    $this->dokumen->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->dokumen->LinkAttrs["data-rel"] = "pesantren_x_dokumen";
                $this->dokumen->LinkAttrs->appendClass("ew-lightbox");
            }

            // validasi
            $this->validasi->LinkCustomAttributes = "";
            $this->validasi->HrefValue = "";
            $this->validasi->TooltipValue = "";

            // validator
            $this->validator->LinkCustomAttributes = "";
            $this->validator->HrefValue = "";
            $this->validator->TooltipValue = "";

            // validasi_pusat
            $this->validasi_pusat->LinkCustomAttributes = "";
            $this->validasi_pusat->HrefValue = "";
            $this->validasi_pusat->TooltipValue = "";

            // validator_pusat
            $this->validator_pusat->LinkCustomAttributes = "";
            $this->validator_pusat->HrefValue = "";
            $this->validator_pusat->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // kode
            $this->kode->EditAttrs["class"] = "form-control";
            $this->kode->EditCustomAttributes = "readonly";
            $this->kode->EditValue = $this->kode->CurrentValue;
            $this->kode->ViewCustomAttributes = "";

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);

            // deskripsi
            $this->deskripsi->EditAttrs["class"] = "form-control";
            $this->deskripsi->EditCustomAttributes = "";
            $this->deskripsi->EditValue = HtmlEncode($this->deskripsi->CurrentValue);

            // jalan
            $this->jalan->EditAttrs["class"] = "form-control";
            $this->jalan->EditCustomAttributes = "";
            if (!$this->jalan->Raw) {
                $this->jalan->CurrentValue = HtmlDecode($this->jalan->CurrentValue);
            }
            $this->jalan->EditValue = HtmlEncode($this->jalan->CurrentValue);

            // propinsi
            $this->propinsi->EditAttrs["class"] = "form-control";
            $this->propinsi->EditCustomAttributes = "";
            $curVal = trim(strval($this->propinsi->CurrentValue));
            if ($curVal != "") {
                $this->propinsi->ViewValue = $this->propinsi->lookupCacheOption($curVal);
            } else {
                $this->propinsi->ViewValue = $this->propinsi->Lookup !== null && is_array($this->propinsi->Lookup->Options) ? $curVal : null;
            }
            if ($this->propinsi->ViewValue !== null) { // Load from cache
                $this->propinsi->EditValue = array_values($this->propinsi->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->propinsi->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->propinsi->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->propinsi->EditValue = $arwrk;
            }

            // kabupaten
            $this->kabupaten->EditAttrs["class"] = "form-control";
            $this->kabupaten->EditCustomAttributes = "";
            $curVal = trim(strval($this->kabupaten->CurrentValue));
            if ($curVal != "") {
                $this->kabupaten->ViewValue = $this->kabupaten->lookupCacheOption($curVal);
            } else {
                $this->kabupaten->ViewValue = $this->kabupaten->Lookup !== null && is_array($this->kabupaten->Lookup->Options) ? $curVal : null;
            }
            if ($this->kabupaten->ViewValue !== null) { // Load from cache
                $this->kabupaten->EditValue = array_values($this->kabupaten->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->kabupaten->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kabupaten->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kabupaten->EditValue = $arwrk;
            }

            // kecamatan
            $this->kecamatan->EditAttrs["class"] = "form-control";
            $this->kecamatan->EditCustomAttributes = "";
            $curVal = trim(strval($this->kecamatan->CurrentValue));
            if ($curVal != "") {
                $this->kecamatan->ViewValue = $this->kecamatan->lookupCacheOption($curVal);
            } else {
                $this->kecamatan->ViewValue = $this->kecamatan->Lookup !== null && is_array($this->kecamatan->Lookup->Options) ? $curVal : null;
            }
            if ($this->kecamatan->ViewValue !== null) { // Load from cache
                $this->kecamatan->EditValue = array_values($this->kecamatan->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->kecamatan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->kecamatan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->kecamatan->EditValue = $arwrk;
            }

            // desa
            $this->desa->EditAttrs["class"] = "form-control";
            $this->desa->EditCustomAttributes = "";
            $curVal = trim(strval($this->desa->CurrentValue));
            if ($curVal != "") {
                $this->desa->ViewValue = $this->desa->lookupCacheOption($curVal);
            } else {
                $this->desa->ViewValue = $this->desa->Lookup !== null && is_array($this->desa->Lookup->Options) ? $curVal : null;
            }
            if ($this->desa->ViewValue !== null) { // Load from cache
                $this->desa->EditValue = array_values($this->desa->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->desa->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->desa->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->desa->EditValue = $arwrk;
            }

            // kodepos
            $this->kodepos->EditAttrs["class"] = "form-control";
            $this->kodepos->EditCustomAttributes = "";
            if (!$this->kodepos->Raw) {
                $this->kodepos->CurrentValue = HtmlDecode($this->kodepos->CurrentValue);
            }
            $this->kodepos->EditValue = HtmlEncode($this->kodepos->CurrentValue);

            // telpon
            $this->telpon->EditAttrs["class"] = "form-control";
            $this->telpon->EditCustomAttributes = "";
            if (!$this->telpon->Raw) {
                $this->telpon->CurrentValue = HtmlDecode($this->telpon->CurrentValue);
            }
            $this->telpon->EditValue = HtmlEncode($this->telpon->CurrentValue);

            // web
            $this->web->EditAttrs["class"] = "form-control";
            $this->web->EditCustomAttributes = "";
            if (!$this->web->Raw) {
                $this->web->CurrentValue = HtmlDecode($this->web->CurrentValue);
            }
            $this->web->EditValue = HtmlEncode($this->web->CurrentValue);

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);

            // nspp
            $this->nspp->EditAttrs["class"] = "form-control";
            $this->nspp->EditCustomAttributes = "";
            if (!$this->nspp->Raw) {
                $this->nspp->CurrentValue = HtmlDecode($this->nspp->CurrentValue);
            }
            $this->nspp->EditValue = HtmlEncode($this->nspp->CurrentValue);

            // nspptglmulai
            $this->nspptglmulai->EditAttrs["class"] = "form-control";
            $this->nspptglmulai->EditCustomAttributes = "";
            $this->nspptglmulai->EditValue = HtmlEncode(FormatDateTime($this->nspptglmulai->CurrentValue, 7));

            // nspptglakhir
            $this->nspptglakhir->EditAttrs["class"] = "form-control";
            $this->nspptglakhir->EditCustomAttributes = "";
            $this->nspptglakhir->EditValue = HtmlEncode(FormatDateTime($this->nspptglakhir->CurrentValue, 7));

            // dokumennspp
            $this->dokumennspp->EditAttrs["class"] = "form-control";
            $this->dokumennspp->EditCustomAttributes = "";
            if (!EmptyValue($this->dokumennspp->Upload->DbValue)) {
                $this->dokumennspp->EditValue = $this->dokumennspp->Upload->DbValue;
            } else {
                $this->dokumennspp->EditValue = "";
            }
            if (!EmptyValue($this->dokumennspp->CurrentValue)) {
                $this->dokumennspp->Upload->FileName = $this->dokumennspp->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->dokumennspp);
            }

            // yayasan
            $this->yayasan->EditAttrs["class"] = "form-control";
            $this->yayasan->EditCustomAttributes = "";
            if (!$this->yayasan->Raw) {
                $this->yayasan->CurrentValue = HtmlDecode($this->yayasan->CurrentValue);
            }
            $this->yayasan->EditValue = HtmlEncode($this->yayasan->CurrentValue);

            // noakta
            $this->noakta->EditAttrs["class"] = "form-control";
            $this->noakta->EditCustomAttributes = "";
            if (!$this->noakta->Raw) {
                $this->noakta->CurrentValue = HtmlDecode($this->noakta->CurrentValue);
            }
            $this->noakta->EditValue = HtmlEncode($this->noakta->CurrentValue);

            // tglakta
            $this->tglakta->EditAttrs["class"] = "form-control";
            $this->tglakta->EditCustomAttributes = "";
            $this->tglakta->EditValue = HtmlEncode(FormatDateTime($this->tglakta->CurrentValue, 7));

            // namanotaris
            $this->namanotaris->EditAttrs["class"] = "form-control";
            $this->namanotaris->EditCustomAttributes = "";
            if (!$this->namanotaris->Raw) {
                $this->namanotaris->CurrentValue = HtmlDecode($this->namanotaris->CurrentValue);
            }
            $this->namanotaris->EditValue = HtmlEncode($this->namanotaris->CurrentValue);

            // alamatnotaris
            $this->alamatnotaris->EditAttrs["class"] = "form-control";
            $this->alamatnotaris->EditCustomAttributes = "";
            if (!$this->alamatnotaris->Raw) {
                $this->alamatnotaris->CurrentValue = HtmlDecode($this->alamatnotaris->CurrentValue);
            }
            $this->alamatnotaris->EditValue = HtmlEncode($this->alamatnotaris->CurrentValue);

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageWidth = 50;
                $this->foto->ImageHeight = 50;
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->EditValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->EditValue = "";
            }
            if (!EmptyValue($this->foto->CurrentValue)) {
                $this->foto->Upload->FileName = $this->foto->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->foto);
            }

            // ktp
            $this->ktp->EditAttrs["class"] = "form-control";
            $this->ktp->EditCustomAttributes = "";
            if (!EmptyValue($this->ktp->Upload->DbValue)) {
                $this->ktp->ImageAlt = $this->ktp->alt();
                $this->ktp->EditValue = $this->ktp->Upload->DbValue;
            } else {
                $this->ktp->EditValue = "";
            }
            if (!EmptyValue($this->ktp->CurrentValue)) {
                $this->ktp->Upload->FileName = $this->ktp->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->ktp);
            }

            // dokumen
            $this->dokumen->EditAttrs["class"] = "form-control";
            $this->dokumen->EditCustomAttributes = "";
            if (!EmptyValue($this->dokumen->Upload->DbValue)) {
                $this->dokumen->ImageWidth = 50;
                $this->dokumen->ImageHeight = 50;
                $this->dokumen->ImageAlt = $this->dokumen->alt();
                $this->dokumen->EditValue = $this->dokumen->Upload->DbValue;
            } else {
                $this->dokumen->EditValue = "";
            }
            if (!EmptyValue($this->dokumen->CurrentValue)) {
                $this->dokumen->Upload->FileName = $this->dokumen->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->dokumen);
            }

            // validasi
            $this->validasi->EditAttrs["class"] = "form-control";
            $this->validasi->EditCustomAttributes = "";
            $this->validasi->EditValue = $this->validasi->options(true);

            // validator
            $this->validator->EditAttrs["class"] = "form-control";
            $this->validator->EditCustomAttributes = "";
            $curVal = trim(strval($this->validator->CurrentValue));
            if ($curVal != "") {
                $this->validator->ViewValue = $this->validator->lookupCacheOption($curVal);
            } else {
                $this->validator->ViewValue = $this->validator->Lookup !== null && is_array($this->validator->Lookup->Options) ? $curVal : null;
            }
            if ($this->validator->ViewValue !== null) { // Load from cache
                $this->validator->EditValue = array_values($this->validator->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->validator->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "grup = 1";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->validator->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->validator->EditValue = $arwrk;
            }

            // validasi_pusat
            $this->validasi_pusat->EditAttrs["class"] = "form-control";
            $this->validasi_pusat->EditCustomAttributes = "";
            $this->validasi_pusat->EditValue = $this->validasi_pusat->options(true);

            // validator_pusat
            $this->validator_pusat->EditAttrs["class"] = "form-control";
            $this->validator_pusat->EditCustomAttributes = "";
            $curVal = trim(strval($this->validator_pusat->CurrentValue));
            if ($curVal != "") {
                $this->validator_pusat->ViewValue = $this->validator_pusat->lookupCacheOption($curVal);
            } else {
                $this->validator_pusat->ViewValue = $this->validator_pusat->Lookup !== null && is_array($this->validator_pusat->Lookup->Options) ? $curVal : null;
            }
            if ($this->validator_pusat->ViewValue !== null) { // Load from cache
                $this->validator_pusat->EditValue = array_values($this->validator_pusat->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id`" . SearchString("=", $this->validator_pusat->CurrentValue, DATATYPE_NUMBER, "");
                }
                $lookupFilter = function() {
                    return "grup = 3";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->validator_pusat->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->validator_pusat->EditValue = $arwrk;
            }

            // Edit refer script

            // kode
            $this->kode->LinkCustomAttributes = "";
            $this->kode->HrefValue = "";
            $this->kode->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // deskripsi
            $this->deskripsi->LinkCustomAttributes = "";
            $this->deskripsi->HrefValue = "";

            // jalan
            $this->jalan->LinkCustomAttributes = "";
            $this->jalan->HrefValue = "";

            // propinsi
            $this->propinsi->LinkCustomAttributes = "";
            $this->propinsi->HrefValue = "";

            // kabupaten
            $this->kabupaten->LinkCustomAttributes = "";
            $this->kabupaten->HrefValue = "";

            // kecamatan
            $this->kecamatan->LinkCustomAttributes = "";
            $this->kecamatan->HrefValue = "";

            // desa
            $this->desa->LinkCustomAttributes = "";
            $this->desa->HrefValue = "";

            // kodepos
            $this->kodepos->LinkCustomAttributes = "";
            $this->kodepos->HrefValue = "";

            // telpon
            $this->telpon->LinkCustomAttributes = "";
            $this->telpon->HrefValue = "";

            // web
            $this->web->LinkCustomAttributes = "";
            $this->web->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // nspp
            $this->nspp->LinkCustomAttributes = "";
            $this->nspp->HrefValue = "";

            // nspptglmulai
            $this->nspptglmulai->LinkCustomAttributes = "";
            $this->nspptglmulai->HrefValue = "";

            // nspptglakhir
            $this->nspptglakhir->LinkCustomAttributes = "";
            $this->nspptglakhir->HrefValue = "";

            // dokumennspp
            $this->dokumennspp->LinkCustomAttributes = "";
            $this->dokumennspp->HrefValue = "";
            $this->dokumennspp->ExportHrefValue = $this->dokumennspp->UploadPath . $this->dokumennspp->Upload->DbValue;

            // yayasan
            $this->yayasan->LinkCustomAttributes = "";
            $this->yayasan->HrefValue = "";

            // noakta
            $this->noakta->LinkCustomAttributes = "";
            $this->noakta->HrefValue = "";

            // tglakta
            $this->tglakta->LinkCustomAttributes = "";
            $this->tglakta->HrefValue = "";

            // namanotaris
            $this->namanotaris->LinkCustomAttributes = "";
            $this->namanotaris->HrefValue = "";

            // alamatnotaris
            $this->alamatnotaris->LinkCustomAttributes = "";
            $this->alamatnotaris->HrefValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->HrefValue = "%u"; // Add prefix/suffix
                $this->foto->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
                }
            } else {
                $this->foto->HrefValue = "";
            }
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;

            // ktp
            $this->ktp->LinkCustomAttributes = "";
            if (!EmptyValue($this->ktp->Upload->DbValue)) {
                $this->ktp->HrefValue = GetFileUploadUrl($this->ktp, $this->ktp->htmlDecode($this->ktp->Upload->DbValue)); // Add prefix/suffix
                $this->ktp->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->ktp->HrefValue = FullUrl($this->ktp->HrefValue, "href");
                }
            } else {
                $this->ktp->HrefValue = "";
            }
            $this->ktp->ExportHrefValue = $this->ktp->UploadPath . $this->ktp->Upload->DbValue;

            // dokumen
            $this->dokumen->LinkCustomAttributes = "";
            if (!EmptyValue($this->dokumen->Upload->DbValue)) {
                $this->dokumen->HrefValue = GetFileUploadUrl($this->dokumen, $this->dokumen->htmlDecode($this->dokumen->Upload->DbValue)); // Add prefix/suffix
                $this->dokumen->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->dokumen->HrefValue = FullUrl($this->dokumen->HrefValue, "href");
                }
            } else {
                $this->dokumen->HrefValue = "";
            }
            $this->dokumen->ExportHrefValue = $this->dokumen->UploadPath . $this->dokumen->Upload->DbValue;

            // validasi
            $this->validasi->LinkCustomAttributes = "";
            $this->validasi->HrefValue = "";

            // validator
            $this->validator->LinkCustomAttributes = "";
            $this->validator->HrefValue = "";

            // validasi_pusat
            $this->validasi_pusat->LinkCustomAttributes = "";
            $this->validasi_pusat->HrefValue = "";

            // validator_pusat
            $this->validator_pusat->LinkCustomAttributes = "";
            $this->validator_pusat->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->kode->Required) {
            if (!$this->kode->IsDetailKey && EmptyValue($this->kode->FormValue)) {
                $this->kode->addErrorMessage(str_replace("%s", $this->kode->caption(), $this->kode->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->deskripsi->Required) {
            if (!$this->deskripsi->IsDetailKey && EmptyValue($this->deskripsi->FormValue)) {
                $this->deskripsi->addErrorMessage(str_replace("%s", $this->deskripsi->caption(), $this->deskripsi->RequiredErrorMessage));
            }
        }
        if ($this->jalan->Required) {
            if (!$this->jalan->IsDetailKey && EmptyValue($this->jalan->FormValue)) {
                $this->jalan->addErrorMessage(str_replace("%s", $this->jalan->caption(), $this->jalan->RequiredErrorMessage));
            }
        }
        if ($this->propinsi->Required) {
            if (!$this->propinsi->IsDetailKey && EmptyValue($this->propinsi->FormValue)) {
                $this->propinsi->addErrorMessage(str_replace("%s", $this->propinsi->caption(), $this->propinsi->RequiredErrorMessage));
            }
        }
        if ($this->kabupaten->Required) {
            if (!$this->kabupaten->IsDetailKey && EmptyValue($this->kabupaten->FormValue)) {
                $this->kabupaten->addErrorMessage(str_replace("%s", $this->kabupaten->caption(), $this->kabupaten->RequiredErrorMessage));
            }
        }
        if ($this->kecamatan->Required) {
            if (!$this->kecamatan->IsDetailKey && EmptyValue($this->kecamatan->FormValue)) {
                $this->kecamatan->addErrorMessage(str_replace("%s", $this->kecamatan->caption(), $this->kecamatan->RequiredErrorMessage));
            }
        }
        if ($this->desa->Required) {
            if (!$this->desa->IsDetailKey && EmptyValue($this->desa->FormValue)) {
                $this->desa->addErrorMessage(str_replace("%s", $this->desa->caption(), $this->desa->RequiredErrorMessage));
            }
        }
        if ($this->kodepos->Required) {
            if (!$this->kodepos->IsDetailKey && EmptyValue($this->kodepos->FormValue)) {
                $this->kodepos->addErrorMessage(str_replace("%s", $this->kodepos->caption(), $this->kodepos->RequiredErrorMessage));
            }
        }
        if ($this->telpon->Required) {
            if (!$this->telpon->IsDetailKey && EmptyValue($this->telpon->FormValue)) {
                $this->telpon->addErrorMessage(str_replace("%s", $this->telpon->caption(), $this->telpon->RequiredErrorMessage));
            }
        }
        if ($this->web->Required) {
            if (!$this->web->IsDetailKey && EmptyValue($this->web->FormValue)) {
                $this->web->addErrorMessage(str_replace("%s", $this->web->caption(), $this->web->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if ($this->nspp->Required) {
            if (!$this->nspp->IsDetailKey && EmptyValue($this->nspp->FormValue)) {
                $this->nspp->addErrorMessage(str_replace("%s", $this->nspp->caption(), $this->nspp->RequiredErrorMessage));
            }
        }
        if ($this->nspptglmulai->Required) {
            if (!$this->nspptglmulai->IsDetailKey && EmptyValue($this->nspptglmulai->FormValue)) {
                $this->nspptglmulai->addErrorMessage(str_replace("%s", $this->nspptglmulai->caption(), $this->nspptglmulai->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->nspptglmulai->FormValue)) {
            $this->nspptglmulai->addErrorMessage($this->nspptglmulai->getErrorMessage(false));
        }
        if ($this->nspptglakhir->Required) {
            if (!$this->nspptglakhir->IsDetailKey && EmptyValue($this->nspptglakhir->FormValue)) {
                $this->nspptglakhir->addErrorMessage(str_replace("%s", $this->nspptglakhir->caption(), $this->nspptglakhir->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->nspptglakhir->FormValue)) {
            $this->nspptglakhir->addErrorMessage($this->nspptglakhir->getErrorMessage(false));
        }
        if ($this->dokumennspp->Required) {
            if ($this->dokumennspp->Upload->FileName == "" && !$this->dokumennspp->Upload->KeepFile) {
                $this->dokumennspp->addErrorMessage(str_replace("%s", $this->dokumennspp->caption(), $this->dokumennspp->RequiredErrorMessage));
            }
        }
        if ($this->yayasan->Required) {
            if (!$this->yayasan->IsDetailKey && EmptyValue($this->yayasan->FormValue)) {
                $this->yayasan->addErrorMessage(str_replace("%s", $this->yayasan->caption(), $this->yayasan->RequiredErrorMessage));
            }
        }
        if ($this->noakta->Required) {
            if (!$this->noakta->IsDetailKey && EmptyValue($this->noakta->FormValue)) {
                $this->noakta->addErrorMessage(str_replace("%s", $this->noakta->caption(), $this->noakta->RequiredErrorMessage));
            }
        }
        if ($this->tglakta->Required) {
            if (!$this->tglakta->IsDetailKey && EmptyValue($this->tglakta->FormValue)) {
                $this->tglakta->addErrorMessage(str_replace("%s", $this->tglakta->caption(), $this->tglakta->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->tglakta->FormValue)) {
            $this->tglakta->addErrorMessage($this->tglakta->getErrorMessage(false));
        }
        if ($this->namanotaris->Required) {
            if (!$this->namanotaris->IsDetailKey && EmptyValue($this->namanotaris->FormValue)) {
                $this->namanotaris->addErrorMessage(str_replace("%s", $this->namanotaris->caption(), $this->namanotaris->RequiredErrorMessage));
            }
        }
        if ($this->alamatnotaris->Required) {
            if (!$this->alamatnotaris->IsDetailKey && EmptyValue($this->alamatnotaris->FormValue)) {
                $this->alamatnotaris->addErrorMessage(str_replace("%s", $this->alamatnotaris->caption(), $this->alamatnotaris->RequiredErrorMessage));
            }
        }
        if ($this->foto->Required) {
            if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
            }
        }
        if ($this->ktp->Required) {
            if ($this->ktp->Upload->FileName == "" && !$this->ktp->Upload->KeepFile) {
                $this->ktp->addErrorMessage(str_replace("%s", $this->ktp->caption(), $this->ktp->RequiredErrorMessage));
            }
        }
        if ($this->dokumen->Required) {
            if ($this->dokumen->Upload->FileName == "" && !$this->dokumen->Upload->KeepFile) {
                $this->dokumen->addErrorMessage(str_replace("%s", $this->dokumen->caption(), $this->dokumen->RequiredErrorMessage));
            }
        }
        if ($this->validasi->Required) {
            if (!$this->validasi->IsDetailKey && EmptyValue($this->validasi->FormValue)) {
                $this->validasi->addErrorMessage(str_replace("%s", $this->validasi->caption(), $this->validasi->RequiredErrorMessage));
            }
        }
        if ($this->validator->Required) {
            if (!$this->validator->IsDetailKey && EmptyValue($this->validator->FormValue)) {
                $this->validator->addErrorMessage(str_replace("%s", $this->validator->caption(), $this->validator->RequiredErrorMessage));
            }
        }
        if ($this->validasi_pusat->Required) {
            if (!$this->validasi_pusat->IsDetailKey && EmptyValue($this->validasi_pusat->FormValue)) {
                $this->validasi_pusat->addErrorMessage(str_replace("%s", $this->validasi_pusat->caption(), $this->validasi_pusat->RequiredErrorMessage));
            }
        }
        if ($this->validator_pusat->Required) {
            if (!$this->validator_pusat->IsDetailKey && EmptyValue($this->validator_pusat->FormValue)) {
                $this->validator_pusat->addErrorMessage(str_replace("%s", $this->validator_pusat->caption(), $this->validator_pusat->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("FasilitasusahaGrid");
        if (in_array("fasilitasusaha", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("PendidikanumumGrid");
        if (in_array("pendidikanumum", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("PengasuhpppriaGrid");
        if (in_array("pengasuhpppria", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("PengasuhppwanitaGrid");
        if (in_array("pengasuhppwanita", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("KitabkuningGrid");
        if (in_array("kitabkuning", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("FasilitaspesantrenGrid");
        if (in_array("fasilitaspesantren", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("PendidikanpesantrenGrid");
        if (in_array("pendidikanpesantren", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        if ($this->kode->CurrentValue != "") { // Check field with unique index
            $filterChk = "(`kode` = '" . AdjustSql($this->kode->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->kode->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->kode->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                $rsChk->closeCursor();
                return false;
            }
        }
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // nama
            $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, null, $this->nama->ReadOnly);

            // deskripsi
            $this->deskripsi->setDbValueDef($rsnew, $this->deskripsi->CurrentValue, null, $this->deskripsi->ReadOnly);

            // jalan
            $this->jalan->setDbValueDef($rsnew, $this->jalan->CurrentValue, null, $this->jalan->ReadOnly);

            // propinsi
            $this->propinsi->setDbValueDef($rsnew, $this->propinsi->CurrentValue, null, $this->propinsi->ReadOnly);

            // kabupaten
            $this->kabupaten->setDbValueDef($rsnew, $this->kabupaten->CurrentValue, null, $this->kabupaten->ReadOnly);

            // kecamatan
            $this->kecamatan->setDbValueDef($rsnew, $this->kecamatan->CurrentValue, null, $this->kecamatan->ReadOnly);

            // desa
            $this->desa->setDbValueDef($rsnew, $this->desa->CurrentValue, null, $this->desa->ReadOnly);

            // kodepos
            $this->kodepos->setDbValueDef($rsnew, $this->kodepos->CurrentValue, null, $this->kodepos->ReadOnly);

            // telpon
            $this->telpon->setDbValueDef($rsnew, $this->telpon->CurrentValue, null, $this->telpon->ReadOnly);

            // web
            $this->web->setDbValueDef($rsnew, $this->web->CurrentValue, null, $this->web->ReadOnly);

            // email
            $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, $this->_email->ReadOnly);

            // nspp
            $this->nspp->setDbValueDef($rsnew, $this->nspp->CurrentValue, null, $this->nspp->ReadOnly);

            // nspptglmulai
            $this->nspptglmulai->setDbValueDef($rsnew, UnFormatDateTime($this->nspptglmulai->CurrentValue, 7), null, $this->nspptglmulai->ReadOnly);

            // nspptglakhir
            $this->nspptglakhir->setDbValueDef($rsnew, UnFormatDateTime($this->nspptglakhir->CurrentValue, 7), null, $this->nspptglakhir->ReadOnly);

            // dokumennspp
            if ($this->dokumennspp->Visible && !$this->dokumennspp->ReadOnly && !$this->dokumennspp->Upload->KeepFile) {
                $this->dokumennspp->Upload->DbValue = $rsold['dokumennspp']; // Get original value
                if ($this->dokumennspp->Upload->FileName == "") {
                    $rsnew['dokumennspp'] = null;
                } else {
                    $rsnew['dokumennspp'] = $this->dokumennspp->Upload->FileName;
                }
            }

            // yayasan
            $this->yayasan->setDbValueDef($rsnew, $this->yayasan->CurrentValue, null, $this->yayasan->ReadOnly);

            // noakta
            $this->noakta->setDbValueDef($rsnew, $this->noakta->CurrentValue, null, $this->noakta->ReadOnly);

            // tglakta
            $this->tglakta->setDbValueDef($rsnew, UnFormatDateTime($this->tglakta->CurrentValue, 7), null, $this->tglakta->ReadOnly);

            // namanotaris
            $this->namanotaris->setDbValueDef($rsnew, $this->namanotaris->CurrentValue, null, $this->namanotaris->ReadOnly);

            // alamatnotaris
            $this->alamatnotaris->setDbValueDef($rsnew, $this->alamatnotaris->CurrentValue, null, $this->alamatnotaris->ReadOnly);

            // foto
            if ($this->foto->Visible && !$this->foto->ReadOnly && !$this->foto->Upload->KeepFile) {
                $this->foto->Upload->DbValue = $rsold['foto']; // Get original value
                if ($this->foto->Upload->FileName == "") {
                    $rsnew['foto'] = null;
                } else {
                    $rsnew['foto'] = $this->foto->Upload->FileName;
                }
            }

            // ktp
            if ($this->ktp->Visible && !$this->ktp->ReadOnly && !$this->ktp->Upload->KeepFile) {
                $this->ktp->Upload->DbValue = $rsold['ktp']; // Get original value
                if ($this->ktp->Upload->FileName == "") {
                    $rsnew['ktp'] = null;
                } else {
                    $rsnew['ktp'] = $this->ktp->Upload->FileName;
                }
            }

            // dokumen
            if ($this->dokumen->Visible && !$this->dokumen->ReadOnly && !$this->dokumen->Upload->KeepFile) {
                $this->dokumen->Upload->DbValue = $rsold['dokumen']; // Get original value
                if ($this->dokumen->Upload->FileName == "") {
                    $rsnew['dokumen'] = null;
                } else {
                    $rsnew['dokumen'] = $this->dokumen->Upload->FileName;
                }
            }

            // validasi
            $this->validasi->setDbValueDef($rsnew, $this->validasi->CurrentValue, null, $this->validasi->ReadOnly);

            // validator
            $this->validator->setDbValueDef($rsnew, $this->validator->CurrentValue, null, $this->validator->ReadOnly);

            // validasi_pusat
            $this->validasi_pusat->setDbValueDef($rsnew, $this->validasi_pusat->CurrentValue, null, $this->validasi_pusat->ReadOnly);

            // validator_pusat
            $this->validator_pusat->setDbValueDef($rsnew, $this->validator_pusat->CurrentValue, null, $this->validator_pusat->ReadOnly);
            if ($this->dokumennspp->Visible && !$this->dokumennspp->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->dokumennspp->Upload->DbValue) ? [] : [$this->dokumennspp->htmlDecode($this->dokumennspp->Upload->DbValue)];
                if (!EmptyValue($this->dokumennspp->Upload->FileName)) {
                    $newFiles = [$this->dokumennspp->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->dokumennspp, $this->dokumennspp->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->dokumennspp->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->dokumennspp->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->dokumennspp->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->dokumennspp->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->dokumennspp->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->dokumennspp->setDbValueDef($rsnew, $this->dokumennspp->Upload->FileName, null, $this->dokumennspp->ReadOnly);
                }
            }
            if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode(strval($this->foto->Upload->DbValue)));
                if (!EmptyValue($this->foto->Upload->FileName)) {
                    $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), strval($this->foto->Upload->FileName));
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->foto, $this->foto->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->foto->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->foto->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->foto->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->foto->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->foto->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->foto->setDbValueDef($rsnew, $this->foto->Upload->FileName, null, $this->foto->ReadOnly);
                }
            }
            if ($this->ktp->Visible && !$this->ktp->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->ktp->Upload->DbValue) ? [] : [$this->ktp->htmlDecode($this->ktp->Upload->DbValue)];
                if (!EmptyValue($this->ktp->Upload->FileName)) {
                    $newFiles = [$this->ktp->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->ktp, $this->ktp->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->ktp->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->ktp->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->ktp->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->ktp->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->ktp->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->ktp->setDbValueDef($rsnew, $this->ktp->Upload->FileName, null, $this->ktp->ReadOnly);
                }
            }
            if ($this->dokumen->Visible && !$this->dokumen->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->dokumen->Upload->DbValue) ? [] : [$this->dokumen->htmlDecode($this->dokumen->Upload->DbValue)];
                if (!EmptyValue($this->dokumen->Upload->FileName)) {
                    $newFiles = [$this->dokumen->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->dokumen, $this->dokumen->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->dokumen->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->dokumen->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->dokumen->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->dokumen->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->dokumen->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->dokumen->setDbValueDef($rsnew, $this->dokumen->Upload->FileName, null, $this->dokumen->ReadOnly);
                }
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                    if ($this->dokumennspp->Visible && !$this->dokumennspp->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->dokumennspp->Upload->DbValue) ? [] : [$this->dokumennspp->htmlDecode($this->dokumennspp->Upload->DbValue)];
                        if (!EmptyValue($this->dokumennspp->Upload->FileName)) {
                            $newFiles = [$this->dokumennspp->Upload->FileName];
                            $newFiles2 = [$this->dokumennspp->htmlDecode($rsnew['dokumennspp'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->dokumennspp, $this->dokumennspp->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->dokumennspp->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->dokumennspp->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode(strval($this->foto->Upload->DbValue)));
                        if (!EmptyValue($this->foto->Upload->FileName)) {
                            $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->Upload->FileName);
                            $newFiles2 = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->foto->htmlDecode($rsnew['foto']));
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->foto, $this->foto->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->foto->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->ktp->Visible && !$this->ktp->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->ktp->Upload->DbValue) ? [] : [$this->ktp->htmlDecode($this->ktp->Upload->DbValue)];
                        if (!EmptyValue($this->ktp->Upload->FileName)) {
                            $newFiles = [$this->ktp->Upload->FileName];
                            $newFiles2 = [$this->ktp->htmlDecode($rsnew['ktp'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->ktp, $this->ktp->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->ktp->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->ktp->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->dokumen->Visible && !$this->dokumen->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->dokumen->Upload->DbValue) ? [] : [$this->dokumen->htmlDecode($this->dokumen->Upload->DbValue)];
                        if (!EmptyValue($this->dokumen->Upload->FileName)) {
                            $newFiles = [$this->dokumen->Upload->FileName];
                            $newFiles2 = [$this->dokumen->htmlDecode($rsnew['dokumen'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->dokumen, $this->dokumen->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->dokumen->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->dokumen->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("FasilitasusahaGrid");
                    if (in_array("fasilitasusaha", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "fasilitasusaha"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("PendidikanumumGrid");
                    if (in_array("pendidikanumum", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "pendidikanumum"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("PengasuhpppriaGrid");
                    if (in_array("pengasuhpppria", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "pengasuhpppria"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("PengasuhppwanitaGrid");
                    if (in_array("pengasuhppwanita", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "pengasuhppwanita"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("KitabkuningGrid");
                    if (in_array("kitabkuning", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "kitabkuning"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("FasilitaspesantrenGrid");
                    if (in_array("fasilitaspesantren", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "fasilitaspesantren"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("PendidikanpesantrenGrid");
                    if (in_array("pendidikanpesantren", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "pendidikanpesantren"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
                    }
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
            // dokumennspp
            CleanUploadTempPath($this->dokumennspp, $this->dokumennspp->Upload->Index);

            // foto
            CleanUploadTempPath($this->foto, $this->foto->Upload->Index);

            // ktp
            CleanUploadTempPath($this->ktp, $this->ktp->Upload->Index);

            // dokumen
            CleanUploadTempPath($this->dokumen, $this->dokumen->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->_userid->CurrentValue);
        }
        return true;
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("fasilitasusaha", $detailTblVar)) {
                $detailPageObj = Container("FasilitasusahaGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid->IsDetailKey = true;
                    $detailPageObj->pid->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->pid->setSessionValue($detailPageObj->pid->CurrentValue);
                }
            }
            if (in_array("pendidikanumum", $detailTblVar)) {
                $detailPageObj = Container("PendidikanumumGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid->IsDetailKey = true;
                    $detailPageObj->pid->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->pid->setSessionValue($detailPageObj->pid->CurrentValue);
                }
            }
            if (in_array("pengasuhpppria", $detailTblVar)) {
                $detailPageObj = Container("PengasuhpppriaGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid->IsDetailKey = true;
                    $detailPageObj->pid->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->pid->setSessionValue($detailPageObj->pid->CurrentValue);
                }
            }
            if (in_array("pengasuhppwanita", $detailTblVar)) {
                $detailPageObj = Container("PengasuhppwanitaGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid->IsDetailKey = true;
                    $detailPageObj->pid->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->pid->setSessionValue($detailPageObj->pid->CurrentValue);
                }
            }
            if (in_array("kitabkuning", $detailTblVar)) {
                $detailPageObj = Container("KitabkuningGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid->IsDetailKey = true;
                    $detailPageObj->pid->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->pid->setSessionValue($detailPageObj->pid->CurrentValue);
                }
            }
            if (in_array("fasilitaspesantren", $detailTblVar)) {
                $detailPageObj = Container("FasilitaspesantrenGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid->IsDetailKey = true;
                    $detailPageObj->pid->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->pid->setSessionValue($detailPageObj->pid->CurrentValue);
                }
            }
            if (in_array("pendidikanpesantren", $detailTblVar)) {
                $detailPageObj = Container("PendidikanpesantrenGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->pid->IsDetailKey = true;
                    $detailPageObj->pid->CurrentValue = $this->id->CurrentValue;
                    $detailPageObj->pid->setSessionValue($detailPageObj->pid->CurrentValue);
                    $detailPageObj->idjenispp->setSessionValue(""); // Clear session key
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PesantrenList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_propinsi":
                    break;
                case "x_kabupaten":
                    break;
                case "x_kecamatan":
                    break;
                case "x_desa":
                    break;
                case "x__userid":
                    break;
                case "x_validasi":
                    break;
                case "x_validator":
                    $lookupFilter = function () {
                        return "grup = 1";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_validasi_pusat":
                    break;
                case "x_validator_pusat":
                    $lookupFilter = function () {
                        return "grup = 3";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
        if (CurrentUserLevel() == 1) {
        	$this->kode->ReadOnly = true;
        	$this->nama->ReadOnly = true;
        	$this->deskripsi->ReadOnly = true;
        	$this->jalan->ReadOnly = true;
        	$this->propinsi->ReadOnly = true;
        	$this->kabupaten->ReadOnly = true;
        	$this->kecamatan->ReadOnly = true;
        	$this->desa->ReadOnly = true;
        	$this->kodepos->ReadOnly = true;
        	$this->latitude->ReadOnly = true;
        	$this->longitude->ReadOnly = true;
        	$this->telpon->ReadOnly = true;
        	$this->web->ReadOnly = true;
        	$this->nspp->ReadOnly = true;
        	$this->nspptglmulai->ReadOnly = true;
        	$this->nspptglakhir->ReadOnly = true;
        	$this->dokumennspp->ReadOnly = true;
        	$this->yayasan->ReadOnly = true;
        	$this->noakta->ReadOnly = true;
        	$this->tglakta->ReadOnly = true;
        	$this->namanotaris->ReadOnly = true;
        	$this->alamatnotaris->ReadOnly = true;
        	$this->foto->ReadOnly = true;
        	$this->ktp->ReadOnly = true;
        	$this->dokumen->ReadOnly = true;
        	$this->validator->Visible = false;
        	$this->validasi_pusat->Visible = false;
        	$this->validator_pusat->Visible = false;
        } elseif (CurrentUserLevel() == 3){
        	$this->kode->ReadOnly = true;
        	$this->nama->ReadOnly = true;
        	$this->deskripsi->ReadOnly = true;
        	$this->jalan->ReadOnly = true;
        	$this->propinsi->ReadOnly = true;
        	$this->kabupaten->ReadOnly = true;
        	$this->kecamatan->ReadOnly = true;
        	$this->desa->ReadOnly = true;
        	$this->kodepos->ReadOnly = true;
        	$this->latitude->ReadOnly = true;
        	$this->longitude->ReadOnly = true;
        	$this->telpon->ReadOnly = true;
        	$this->web->ReadOnly = true;
        	$this->nspp->ReadOnly = true;
        	$this->nspptglmulai->ReadOnly = true;
        	$this->nspptglakhir->ReadOnly = true;
        	$this->dokumennspp->ReadOnly = true;
        	$this->yayasan->ReadOnly = true;
        	$this->noakta->ReadOnly = true;
        	$this->tglakta->ReadOnly = true;
        	$this->namanotaris->ReadOnly = true;
        	$this->alamatnotaris->ReadOnly = true;
        	$this->foto->ReadOnly = true;
        	$this->ktp->ReadOnly = true;
        	$this->dokumen->ReadOnly = true;
        	$this->validasi->ReadOnly = true;    	
        	$this->validator->ReadOnly = true;
        	$this->validator_pusat->Visible = false;
        } elseif (CurrentUserLevel() == 2) {
        	$this->validasi->Visible = false;
        	$this->validator->Visible = false;
        	$this->validasi_pusat->Visible = false;
        	$this->validator_pusat->Visible = false;
        }
       // $this->validator_pusat->Visible = false;
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
