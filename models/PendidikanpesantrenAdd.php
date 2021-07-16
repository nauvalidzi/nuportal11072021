<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PendidikanpesantrenAdd extends Pendidikanpesantren
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'pendidikanpesantren';

    // Page object name
    public $PageObjName = "PendidikanpesantrenAdd";

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

        // Table object (pendidikanpesantren)
        if (!isset($GLOBALS["pendidikanpesantren"]) || get_class($GLOBALS["pendidikanpesantren"]) == PROJECT_NAMESPACE . "pendidikanpesantren") {
            $GLOBALS["pendidikanpesantren"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'pendidikanpesantren');
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
                $doc = new $class(Container("pendidikanpesantren"));
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
                    if ($pageName == "PendidikanpesantrenView") {
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
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

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
        $this->pid->setVisibility();
        $this->idjenispp->setVisibility();
        $this->nama->setVisibility();
        $this->ijin->setVisibility();
        $this->tglberdiri->setVisibility();
        $this->ijinakhir->setVisibility();
        $this->jumlahpengajar->setVisibility();
        $this->foto->setVisibility();
        $this->dokumen->setVisibility();
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
        $this->setupLookupOptions($this->pid);
        $this->setupLookupOptions($this->idjenispp);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("PendidikanpesantrenList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "PendidikanpesantrenList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "PendidikanpesantrenView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->pid->CurrentValue = null;
        $this->pid->OldValue = $this->pid->CurrentValue;
        $this->idjenispp->CurrentValue = null;
        $this->idjenispp->OldValue = $this->idjenispp->CurrentValue;
        $this->nama->CurrentValue = null;
        $this->nama->OldValue = $this->nama->CurrentValue;
        $this->ijin->CurrentValue = null;
        $this->ijin->OldValue = $this->ijin->CurrentValue;
        $this->tglberdiri->CurrentValue = null;
        $this->tglberdiri->OldValue = $this->tglberdiri->CurrentValue;
        $this->ijinakhir->CurrentValue = null;
        $this->ijinakhir->OldValue = $this->ijinakhir->CurrentValue;
        $this->jumlahpengajar->CurrentValue = null;
        $this->jumlahpengajar->OldValue = $this->jumlahpengajar->CurrentValue;
        $this->foto->CurrentValue = null;
        $this->foto->OldValue = $this->foto->CurrentValue;
        $this->dokumen->CurrentValue = null;
        $this->dokumen->OldValue = $this->dokumen->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'pid' first before field var 'x_pid'
        $val = $CurrentForm->hasValue("pid") ? $CurrentForm->getValue("pid") : $CurrentForm->getValue("x_pid");
        if (!$this->pid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pid->Visible = false; // Disable update for API request
            } else {
                $this->pid->setFormValue($val);
            }
        }

        // Check field name 'idjenispp' first before field var 'x_idjenispp'
        $val = $CurrentForm->hasValue("idjenispp") ? $CurrentForm->getValue("idjenispp") : $CurrentForm->getValue("x_idjenispp");
        if (!$this->idjenispp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idjenispp->Visible = false; // Disable update for API request
            } else {
                $this->idjenispp->setFormValue($val);
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

        // Check field name 'ijin' first before field var 'x_ijin'
        $val = $CurrentForm->hasValue("ijin") ? $CurrentForm->getValue("ijin") : $CurrentForm->getValue("x_ijin");
        if (!$this->ijin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ijin->Visible = false; // Disable update for API request
            } else {
                $this->ijin->setFormValue($val);
            }
        }

        // Check field name 'tglberdiri' first before field var 'x_tglberdiri'
        $val = $CurrentForm->hasValue("tglberdiri") ? $CurrentForm->getValue("tglberdiri") : $CurrentForm->getValue("x_tglberdiri");
        if (!$this->tglberdiri->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglberdiri->Visible = false; // Disable update for API request
            } else {
                $this->tglberdiri->setFormValue($val);
            }
            $this->tglberdiri->CurrentValue = UnFormatDateTime($this->tglberdiri->CurrentValue, 0);
        }

        // Check field name 'ijinakhir' first before field var 'x_ijinakhir'
        $val = $CurrentForm->hasValue("ijinakhir") ? $CurrentForm->getValue("ijinakhir") : $CurrentForm->getValue("x_ijinakhir");
        if (!$this->ijinakhir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ijinakhir->Visible = false; // Disable update for API request
            } else {
                $this->ijinakhir->setFormValue($val);
            }
            $this->ijinakhir->CurrentValue = UnFormatDateTime($this->ijinakhir->CurrentValue, 0);
        }

        // Check field name 'jumlahpengajar' first before field var 'x_jumlahpengajar'
        $val = $CurrentForm->hasValue("jumlahpengajar") ? $CurrentForm->getValue("jumlahpengajar") : $CurrentForm->getValue("x_jumlahpengajar");
        if (!$this->jumlahpengajar->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlahpengajar->Visible = false; // Disable update for API request
            } else {
                $this->jumlahpengajar->setFormValue($val);
            }
        }

        // Check field name 'foto' first before field var 'x_foto'
        $val = $CurrentForm->hasValue("foto") ? $CurrentForm->getValue("foto") : $CurrentForm->getValue("x_foto");
        if (!$this->foto->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->foto->Visible = false; // Disable update for API request
            } else {
                $this->foto->setFormValue($val);
            }
        }

        // Check field name 'dokumen' first before field var 'x_dokumen'
        $val = $CurrentForm->hasValue("dokumen") ? $CurrentForm->getValue("dokumen") : $CurrentForm->getValue("x_dokumen");
        if (!$this->dokumen->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dokumen->Visible = false; // Disable update for API request
            } else {
                $this->dokumen->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->pid->CurrentValue = $this->pid->FormValue;
        $this->idjenispp->CurrentValue = $this->idjenispp->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->ijin->CurrentValue = $this->ijin->FormValue;
        $this->tglberdiri->CurrentValue = $this->tglberdiri->FormValue;
        $this->tglberdiri->CurrentValue = UnFormatDateTime($this->tglberdiri->CurrentValue, 0);
        $this->ijinakhir->CurrentValue = $this->ijinakhir->FormValue;
        $this->ijinakhir->CurrentValue = UnFormatDateTime($this->ijinakhir->CurrentValue, 0);
        $this->jumlahpengajar->CurrentValue = $this->jumlahpengajar->FormValue;
        $this->foto->CurrentValue = $this->foto->FormValue;
        $this->dokumen->CurrentValue = $this->dokumen->FormValue;
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
        $this->pid->setDbValue($row['pid']);
        $this->idjenispp->setDbValue($row['idjenispp']);
        $this->nama->setDbValue($row['nama']);
        $this->ijin->setDbValue($row['ijin']);
        $this->tglberdiri->setDbValue($row['tglberdiri']);
        $this->ijinakhir->setDbValue($row['ijinakhir']);
        $this->jumlahpengajar->setDbValue($row['jumlahpengajar']);
        $this->foto->setDbValue($row['foto']);
        $this->dokumen->setDbValue($row['dokumen']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['pid'] = $this->pid->CurrentValue;
        $row['idjenispp'] = $this->idjenispp->CurrentValue;
        $row['nama'] = $this->nama->CurrentValue;
        $row['ijin'] = $this->ijin->CurrentValue;
        $row['tglberdiri'] = $this->tglberdiri->CurrentValue;
        $row['ijinakhir'] = $this->ijinakhir->CurrentValue;
        $row['jumlahpengajar'] = $this->jumlahpengajar->CurrentValue;
        $row['foto'] = $this->foto->CurrentValue;
        $row['dokumen'] = $this->dokumen->CurrentValue;
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

        // pid

        // idjenispp

        // nama

        // ijin

        // tglberdiri

        // ijinakhir

        // jumlahpengajar

        // foto

        // dokumen
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // pid
            $curVal = trim(strval($this->pid->CurrentValue));
            if ($curVal != "") {
                $this->pid->ViewValue = $this->pid->lookupCacheOption($curVal);
                if ($this->pid->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->pid->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->pid->Lookup->renderViewRow($rswrk[0]);
                        $this->pid->ViewValue = $this->pid->displayValue($arwrk);
                    } else {
                        $this->pid->ViewValue = $this->pid->CurrentValue;
                    }
                }
            } else {
                $this->pid->ViewValue = null;
            }
            $this->pid->ViewCustomAttributes = "";

            // idjenispp
            $curVal = trim(strval($this->idjenispp->CurrentValue));
            if ($curVal != "") {
                $this->idjenispp->ViewValue = $this->idjenispp->lookupCacheOption($curVal);
                if ($this->idjenispp->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idjenispp->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idjenispp->Lookup->renderViewRow($rswrk[0]);
                        $this->idjenispp->ViewValue = $this->idjenispp->displayValue($arwrk);
                    } else {
                        $this->idjenispp->ViewValue = $this->idjenispp->CurrentValue;
                    }
                }
            } else {
                $this->idjenispp->ViewValue = null;
            }
            $this->idjenispp->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // ijin
            $this->ijin->ViewValue = $this->ijin->CurrentValue;
            $this->ijin->ViewCustomAttributes = "";

            // tglberdiri
            $this->tglberdiri->ViewValue = $this->tglberdiri->CurrentValue;
            $this->tglberdiri->ViewValue = FormatDateTime($this->tglberdiri->ViewValue, 0);
            $this->tglberdiri->ViewCustomAttributes = "";

            // ijinakhir
            $this->ijinakhir->ViewValue = $this->ijinakhir->CurrentValue;
            $this->ijinakhir->ViewValue = FormatDateTime($this->ijinakhir->ViewValue, 0);
            $this->ijinakhir->ViewCustomAttributes = "";

            // jumlahpengajar
            $this->jumlahpengajar->ViewValue = $this->jumlahpengajar->CurrentValue;
            $this->jumlahpengajar->ViewCustomAttributes = "";

            // foto
            $this->foto->ViewValue = $this->foto->CurrentValue;
            $this->foto->ImageAlt = $this->foto->alt();
            $this->foto->ViewCustomAttributes = "";

            // dokumen
            $this->dokumen->ViewValue = $this->dokumen->CurrentValue;
            $this->dokumen->ViewCustomAttributes = "";

            // pid
            $this->pid->LinkCustomAttributes = "";
            $this->pid->HrefValue = "";
            $this->pid->TooltipValue = "";

            // idjenispp
            $this->idjenispp->LinkCustomAttributes = "";
            $this->idjenispp->HrefValue = "";
            $this->idjenispp->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // ijin
            $this->ijin->LinkCustomAttributes = "";
            $this->ijin->HrefValue = "";
            $this->ijin->TooltipValue = "";

            // tglberdiri
            $this->tglberdiri->LinkCustomAttributes = "";
            $this->tglberdiri->HrefValue = "";
            $this->tglberdiri->TooltipValue = "";

            // ijinakhir
            $this->ijinakhir->LinkCustomAttributes = "";
            $this->ijinakhir->HrefValue = "";
            $this->ijinakhir->TooltipValue = "";

            // jumlahpengajar
            $this->jumlahpengajar->LinkCustomAttributes = "";
            $this->jumlahpengajar->HrefValue = "";
            $this->jumlahpengajar->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->TooltipValue = "";

            // dokumen
            $this->dokumen->LinkCustomAttributes = "";
            $this->dokumen->HrefValue = "";
            $this->dokumen->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // pid
            $this->pid->EditAttrs["class"] = "form-control";
            $this->pid->EditCustomAttributes = "";
            if ($this->pid->getSessionValue() != "") {
                $this->pid->CurrentValue = GetForeignKeyValue($this->pid->getSessionValue());
                $curVal = trim(strval($this->pid->CurrentValue));
                if ($curVal != "") {
                    $this->pid->ViewValue = $this->pid->lookupCacheOption($curVal);
                    if ($this->pid->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->pid->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->pid->Lookup->renderViewRow($rswrk[0]);
                            $this->pid->ViewValue = $this->pid->displayValue($arwrk);
                        } else {
                            $this->pid->ViewValue = $this->pid->CurrentValue;
                        }
                    }
                } else {
                    $this->pid->ViewValue = null;
                }
                $this->pid->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->pid->CurrentValue));
                if ($curVal != "") {
                    $this->pid->ViewValue = $this->pid->lookupCacheOption($curVal);
                } else {
                    $this->pid->ViewValue = $this->pid->Lookup !== null && is_array($this->pid->Lookup->Options) ? $curVal : null;
                }
                if ($this->pid->ViewValue !== null) { // Load from cache
                    $this->pid->EditValue = array_values($this->pid->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->pid->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->pid->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->pid->EditValue = $arwrk;
                }
            }

            // idjenispp
            $this->idjenispp->EditAttrs["class"] = "form-control";
            $this->idjenispp->EditCustomAttributes = "";
            if ($this->idjenispp->getSessionValue() != "") {
                $this->idjenispp->CurrentValue = GetForeignKeyValue($this->idjenispp->getSessionValue());
                $curVal = trim(strval($this->idjenispp->CurrentValue));
                if ($curVal != "") {
                    $this->idjenispp->ViewValue = $this->idjenispp->lookupCacheOption($curVal);
                    if ($this->idjenispp->ViewValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->idjenispp->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->idjenispp->Lookup->renderViewRow($rswrk[0]);
                            $this->idjenispp->ViewValue = $this->idjenispp->displayValue($arwrk);
                        } else {
                            $this->idjenispp->ViewValue = $this->idjenispp->CurrentValue;
                        }
                    }
                } else {
                    $this->idjenispp->ViewValue = null;
                }
                $this->idjenispp->ViewCustomAttributes = "";
            } else {
                $curVal = trim(strval($this->idjenispp->CurrentValue));
                if ($curVal != "") {
                    $this->idjenispp->ViewValue = $this->idjenispp->lookupCacheOption($curVal);
                } else {
                    $this->idjenispp->ViewValue = $this->idjenispp->Lookup !== null && is_array($this->idjenispp->Lookup->Options) ? $curVal : null;
                }
                if ($this->idjenispp->ViewValue !== null) { // Load from cache
                    $this->idjenispp->EditValue = array_values($this->idjenispp->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id`" . SearchString("=", $this->idjenispp->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->idjenispp->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->idjenispp->EditValue = $arwrk;
                }
            }

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);

            // ijin
            $this->ijin->EditAttrs["class"] = "form-control";
            $this->ijin->EditCustomAttributes = "";
            if (!$this->ijin->Raw) {
                $this->ijin->CurrentValue = HtmlDecode($this->ijin->CurrentValue);
            }
            $this->ijin->EditValue = HtmlEncode($this->ijin->CurrentValue);

            // tglberdiri
            $this->tglberdiri->EditAttrs["class"] = "form-control";
            $this->tglberdiri->EditCustomAttributes = "";
            $this->tglberdiri->EditValue = HtmlEncode(FormatDateTime($this->tglberdiri->CurrentValue, 8));

            // ijinakhir
            $this->ijinakhir->EditAttrs["class"] = "form-control";
            $this->ijinakhir->EditCustomAttributes = "";
            $this->ijinakhir->EditValue = HtmlEncode(FormatDateTime($this->ijinakhir->CurrentValue, 8));

            // jumlahpengajar
            $this->jumlahpengajar->EditAttrs["class"] = "form-control";
            $this->jumlahpengajar->EditCustomAttributes = "";
            if (!$this->jumlahpengajar->Raw) {
                $this->jumlahpengajar->CurrentValue = HtmlDecode($this->jumlahpengajar->CurrentValue);
            }
            $this->jumlahpengajar->EditValue = HtmlEncode($this->jumlahpengajar->CurrentValue);

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!$this->foto->Raw) {
                $this->foto->CurrentValue = HtmlDecode($this->foto->CurrentValue);
            }
            $this->foto->EditValue = HtmlEncode($this->foto->CurrentValue);

            // dokumen
            $this->dokumen->EditAttrs["class"] = "form-control";
            $this->dokumen->EditCustomAttributes = "";
            if (!$this->dokumen->Raw) {
                $this->dokumen->CurrentValue = HtmlDecode($this->dokumen->CurrentValue);
            }
            $this->dokumen->EditValue = HtmlEncode($this->dokumen->CurrentValue);

            // Add refer script

            // pid
            $this->pid->LinkCustomAttributes = "";
            $this->pid->HrefValue = "";

            // idjenispp
            $this->idjenispp->LinkCustomAttributes = "";
            $this->idjenispp->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // ijin
            $this->ijin->LinkCustomAttributes = "";
            $this->ijin->HrefValue = "";

            // tglberdiri
            $this->tglberdiri->LinkCustomAttributes = "";
            $this->tglberdiri->HrefValue = "";

            // ijinakhir
            $this->ijinakhir->LinkCustomAttributes = "";
            $this->ijinakhir->HrefValue = "";

            // jumlahpengajar
            $this->jumlahpengajar->LinkCustomAttributes = "";
            $this->jumlahpengajar->HrefValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";

            // dokumen
            $this->dokumen->LinkCustomAttributes = "";
            $this->dokumen->HrefValue = "";
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
        if ($this->pid->Required) {
            if (!$this->pid->IsDetailKey && EmptyValue($this->pid->FormValue)) {
                $this->pid->addErrorMessage(str_replace("%s", $this->pid->caption(), $this->pid->RequiredErrorMessage));
            }
        }
        if ($this->idjenispp->Required) {
            if (!$this->idjenispp->IsDetailKey && EmptyValue($this->idjenispp->FormValue)) {
                $this->idjenispp->addErrorMessage(str_replace("%s", $this->idjenispp->caption(), $this->idjenispp->RequiredErrorMessage));
            }
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->ijin->Required) {
            if (!$this->ijin->IsDetailKey && EmptyValue($this->ijin->FormValue)) {
                $this->ijin->addErrorMessage(str_replace("%s", $this->ijin->caption(), $this->ijin->RequiredErrorMessage));
            }
        }
        if ($this->tglberdiri->Required) {
            if (!$this->tglberdiri->IsDetailKey && EmptyValue($this->tglberdiri->FormValue)) {
                $this->tglberdiri->addErrorMessage(str_replace("%s", $this->tglberdiri->caption(), $this->tglberdiri->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglberdiri->FormValue)) {
            $this->tglberdiri->addErrorMessage($this->tglberdiri->getErrorMessage(false));
        }
        if ($this->ijinakhir->Required) {
            if (!$this->ijinakhir->IsDetailKey && EmptyValue($this->ijinakhir->FormValue)) {
                $this->ijinakhir->addErrorMessage(str_replace("%s", $this->ijinakhir->caption(), $this->ijinakhir->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->ijinakhir->FormValue)) {
            $this->ijinakhir->addErrorMessage($this->ijinakhir->getErrorMessage(false));
        }
        if ($this->jumlahpengajar->Required) {
            if (!$this->jumlahpengajar->IsDetailKey && EmptyValue($this->jumlahpengajar->FormValue)) {
                $this->jumlahpengajar->addErrorMessage(str_replace("%s", $this->jumlahpengajar->caption(), $this->jumlahpengajar->RequiredErrorMessage));
            }
        }
        if ($this->foto->Required) {
            if (!$this->foto->IsDetailKey && EmptyValue($this->foto->FormValue)) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
            }
        }
        if ($this->dokumen->Required) {
            if (!$this->dokumen->IsDetailKey && EmptyValue($this->dokumen->FormValue)) {
                $this->dokumen->addErrorMessage(str_replace("%s", $this->dokumen->caption(), $this->dokumen->RequiredErrorMessage));
            }
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check if valid key values for master user
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $masterFilter = $this->sqlMasterFilter_pesantren();
            if (strval($this->pid->CurrentValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($this->pid->CurrentValue, "DB"), $masterFilter);
            } else {
                $masterFilter = "";
            }
            if ($masterFilter != "") {
                $rsmaster = Container("pesantren")->loadRs($masterFilter)->fetch(\PDO::FETCH_ASSOC);
                $masterRecordExists = $rsmaster !== false;
                $validMasterKey = true;
                if ($masterRecordExists) {
                    $validMasterKey = $Security->isValidUserID($rsmaster['userid']);
                } elseif ($this->getCurrentMasterTable() == "pesantren") {
                    $validMasterKey = false;
                }
                if (!$validMasterKey) {
                    $masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
                    $masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
                    $this->setFailureMessage($masterUserIdMsg);
                    return false;
                }
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // pid
        $this->pid->setDbValueDef($rsnew, $this->pid->CurrentValue, null, false);

        // idjenispp
        $this->idjenispp->setDbValueDef($rsnew, $this->idjenispp->CurrentValue, null, false);

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, null, false);

        // ijin
        $this->ijin->setDbValueDef($rsnew, $this->ijin->CurrentValue, null, false);

        // tglberdiri
        $this->tglberdiri->setDbValueDef($rsnew, UnFormatDateTime($this->tglberdiri->CurrentValue, 0), null, false);

        // ijinakhir
        $this->ijinakhir->setDbValueDef($rsnew, UnFormatDateTime($this->ijinakhir->CurrentValue, 0), null, false);

        // jumlahpengajar
        $this->jumlahpengajar->setDbValueDef($rsnew, $this->jumlahpengajar->CurrentValue, null, false);

        // foto
        $this->foto->setDbValueDef($rsnew, $this->foto->CurrentValue, null, false);

        // dokumen
        $this->dokumen->setDbValueDef($rsnew, $this->dokumen->CurrentValue, null, false);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "pesantren") {
                $validMaster = true;
                $masterTbl = Container("pesantren");
                if (($parm = Get("fk_id", Get("pid"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->pid->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->pid->setSessionValue($this->pid->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "jenispendidikanpesantren") {
                $validMaster = true;
                $masterTbl = Container("jenispendidikanpesantren");
                if (($parm = Get("fk_id", Get("idjenispp"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idjenispp->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idjenispp->setSessionValue($this->idjenispp->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "pesantren") {
                $validMaster = true;
                $masterTbl = Container("pesantren");
                if (($parm = Post("fk_id", Post("pid"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->pid->setFormValue($masterTbl->id->FormValue);
                    $this->pid->setSessionValue($this->pid->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
            if ($masterTblVar == "jenispendidikanpesantren") {
                $validMaster = true;
                $masterTbl = Container("jenispendidikanpesantren");
                if (($parm = Post("fk_id", Post("idjenispp"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idjenispp->setFormValue($masterTbl->id->FormValue);
                    $this->idjenispp->setSessionValue($this->idjenispp->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "pesantren") {
                if ($this->pid->CurrentValue == "") {
                    $this->pid->setSessionValue("");
                }
            }
            if ($masterTblVar != "jenispendidikanpesantren") {
                if ($this->idjenispp->CurrentValue == "") {
                    $this->idjenispp->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PendidikanpesantrenList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_pid":
                    break;
                case "x_idjenispp":
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
