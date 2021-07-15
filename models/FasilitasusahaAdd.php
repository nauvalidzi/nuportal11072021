<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class FasilitasusahaAdd extends Fasilitasusaha
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fasilitasusaha';

    // Page object name
    public $PageObjName = "FasilitasusahaAdd";

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

        // Table object (fasilitasusaha)
        if (!isset($GLOBALS["fasilitasusaha"]) || get_class($GLOBALS["fasilitasusaha"]) == PROJECT_NAMESPACE . "fasilitasusaha") {
            $GLOBALS["fasilitasusaha"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fasilitasusaha');
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
                $doc = new $class(Container("fasilitasusaha"));
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
                    if ($pageName == "FasilitasusahaView") {
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
        $this->namausaha->setVisibility();
        $this->bidangusaha->setVisibility();
        $this->badanhukum->setVisibility();
        $this->siup->setVisibility();
        $this->bpom->setVisibility();
        $this->irt->setVisibility();
        $this->potensiblm->setVisibility();
        $this->aset->setVisibility();
        $this->_modal->setVisibility();
        $this->hasilsetahun->setVisibility();
        $this->kendala->setVisibility();
        $this->fasilitasperlu->setVisibility();
        $this->foto->setVisibility();
        $this->dokumen->Visible = false;
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
                    $this->terminate("FasilitasusahaList"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "FasilitasusahaList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "FasilitasusahaView") {
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
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->foto->CurrentValue = $this->foto->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->pid->CurrentValue = null;
        $this->pid->OldValue = $this->pid->CurrentValue;
        $this->namausaha->CurrentValue = null;
        $this->namausaha->OldValue = $this->namausaha->CurrentValue;
        $this->bidangusaha->CurrentValue = null;
        $this->bidangusaha->OldValue = $this->bidangusaha->CurrentValue;
        $this->badanhukum->CurrentValue = null;
        $this->badanhukum->OldValue = $this->badanhukum->CurrentValue;
        $this->siup->CurrentValue = null;
        $this->siup->OldValue = $this->siup->CurrentValue;
        $this->bpom->CurrentValue = null;
        $this->bpom->OldValue = $this->bpom->CurrentValue;
        $this->irt->CurrentValue = null;
        $this->irt->OldValue = $this->irt->CurrentValue;
        $this->potensiblm->CurrentValue = null;
        $this->potensiblm->OldValue = $this->potensiblm->CurrentValue;
        $this->aset->CurrentValue = null;
        $this->aset->OldValue = $this->aset->CurrentValue;
        $this->_modal->CurrentValue = null;
        $this->_modal->OldValue = $this->_modal->CurrentValue;
        $this->hasilsetahun->CurrentValue = null;
        $this->hasilsetahun->OldValue = $this->hasilsetahun->CurrentValue;
        $this->kendala->CurrentValue = null;
        $this->kendala->OldValue = $this->kendala->CurrentValue;
        $this->fasilitasperlu->CurrentValue = null;
        $this->fasilitasperlu->OldValue = $this->fasilitasperlu->CurrentValue;
        $this->foto->Upload->DbValue = null;
        $this->foto->OldValue = $this->foto->Upload->DbValue;
        $this->foto->CurrentValue = null; // Clear file related field
        $this->dokumen->Upload->DbValue = null;
        $this->dokumen->OldValue = $this->dokumen->Upload->DbValue;
        $this->dokumen->CurrentValue = null; // Clear file related field
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

        // Check field name 'namausaha' first before field var 'x_namausaha'
        $val = $CurrentForm->hasValue("namausaha") ? $CurrentForm->getValue("namausaha") : $CurrentForm->getValue("x_namausaha");
        if (!$this->namausaha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->namausaha->Visible = false; // Disable update for API request
            } else {
                $this->namausaha->setFormValue($val);
            }
        }

        // Check field name 'bidangusaha' first before field var 'x_bidangusaha'
        $val = $CurrentForm->hasValue("bidangusaha") ? $CurrentForm->getValue("bidangusaha") : $CurrentForm->getValue("x_bidangusaha");
        if (!$this->bidangusaha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bidangusaha->Visible = false; // Disable update for API request
            } else {
                $this->bidangusaha->setFormValue($val);
            }
        }

        // Check field name 'badanhukum' first before field var 'x_badanhukum'
        $val = $CurrentForm->hasValue("badanhukum") ? $CurrentForm->getValue("badanhukum") : $CurrentForm->getValue("x_badanhukum");
        if (!$this->badanhukum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->badanhukum->Visible = false; // Disable update for API request
            } else {
                $this->badanhukum->setFormValue($val);
            }
        }

        // Check field name 'siup' first before field var 'x_siup'
        $val = $CurrentForm->hasValue("siup") ? $CurrentForm->getValue("siup") : $CurrentForm->getValue("x_siup");
        if (!$this->siup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->siup->Visible = false; // Disable update for API request
            } else {
                $this->siup->setFormValue($val);
            }
        }

        // Check field name 'bpom' first before field var 'x_bpom'
        $val = $CurrentForm->hasValue("bpom") ? $CurrentForm->getValue("bpom") : $CurrentForm->getValue("x_bpom");
        if (!$this->bpom->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->bpom->Visible = false; // Disable update for API request
            } else {
                $this->bpom->setFormValue($val);
            }
        }

        // Check field name 'irt' first before field var 'x_irt'
        $val = $CurrentForm->hasValue("irt") ? $CurrentForm->getValue("irt") : $CurrentForm->getValue("x_irt");
        if (!$this->irt->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->irt->Visible = false; // Disable update for API request
            } else {
                $this->irt->setFormValue($val);
            }
        }

        // Check field name 'potensiblm' first before field var 'x_potensiblm'
        $val = $CurrentForm->hasValue("potensiblm") ? $CurrentForm->getValue("potensiblm") : $CurrentForm->getValue("x_potensiblm");
        if (!$this->potensiblm->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->potensiblm->Visible = false; // Disable update for API request
            } else {
                $this->potensiblm->setFormValue($val);
            }
        }

        // Check field name 'aset' first before field var 'x_aset'
        $val = $CurrentForm->hasValue("aset") ? $CurrentForm->getValue("aset") : $CurrentForm->getValue("x_aset");
        if (!$this->aset->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->aset->Visible = false; // Disable update for API request
            } else {
                $this->aset->setFormValue($val);
            }
        }

        // Check field name '_modal' first before field var 'x__modal'
        $val = $CurrentForm->hasValue("_modal") ? $CurrentForm->getValue("_modal") : $CurrentForm->getValue("x__modal");
        if (!$this->_modal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_modal->Visible = false; // Disable update for API request
            } else {
                $this->_modal->setFormValue($val);
            }
        }

        // Check field name 'hasilsetahun' first before field var 'x_hasilsetahun'
        $val = $CurrentForm->hasValue("hasilsetahun") ? $CurrentForm->getValue("hasilsetahun") : $CurrentForm->getValue("x_hasilsetahun");
        if (!$this->hasilsetahun->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hasilsetahun->Visible = false; // Disable update for API request
            } else {
                $this->hasilsetahun->setFormValue($val);
            }
        }

        // Check field name 'kendala' first before field var 'x_kendala'
        $val = $CurrentForm->hasValue("kendala") ? $CurrentForm->getValue("kendala") : $CurrentForm->getValue("x_kendala");
        if (!$this->kendala->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kendala->Visible = false; // Disable update for API request
            } else {
                $this->kendala->setFormValue($val);
            }
        }

        // Check field name 'fasilitasperlu' first before field var 'x_fasilitasperlu'
        $val = $CurrentForm->hasValue("fasilitasperlu") ? $CurrentForm->getValue("fasilitasperlu") : $CurrentForm->getValue("x_fasilitasperlu");
        if (!$this->fasilitasperlu->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fasilitasperlu->Visible = false; // Disable update for API request
            } else {
                $this->fasilitasperlu->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->pid->CurrentValue = $this->pid->FormValue;
        $this->namausaha->CurrentValue = $this->namausaha->FormValue;
        $this->bidangusaha->CurrentValue = $this->bidangusaha->FormValue;
        $this->badanhukum->CurrentValue = $this->badanhukum->FormValue;
        $this->siup->CurrentValue = $this->siup->FormValue;
        $this->bpom->CurrentValue = $this->bpom->FormValue;
        $this->irt->CurrentValue = $this->irt->FormValue;
        $this->potensiblm->CurrentValue = $this->potensiblm->FormValue;
        $this->aset->CurrentValue = $this->aset->FormValue;
        $this->_modal->CurrentValue = $this->_modal->FormValue;
        $this->hasilsetahun->CurrentValue = $this->hasilsetahun->FormValue;
        $this->kendala->CurrentValue = $this->kendala->FormValue;
        $this->fasilitasperlu->CurrentValue = $this->fasilitasperlu->FormValue;
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
        $this->namausaha->setDbValue($row['namausaha']);
        $this->bidangusaha->setDbValue($row['bidangusaha']);
        $this->badanhukum->setDbValue($row['badanhukum']);
        $this->siup->setDbValue($row['siup']);
        $this->bpom->setDbValue($row['bpom']);
        $this->irt->setDbValue($row['irt']);
        $this->potensiblm->setDbValue($row['potensiblm']);
        $this->aset->setDbValue($row['aset']);
        $this->_modal->setDbValue($row['modal']);
        $this->hasilsetahun->setDbValue($row['hasilsetahun']);
        $this->kendala->setDbValue($row['kendala']);
        $this->fasilitasperlu->setDbValue($row['fasilitasperlu']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->dokumen->Upload->DbValue = $row['dokumen'];
        $this->dokumen->setDbValue($this->dokumen->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['pid'] = $this->pid->CurrentValue;
        $row['namausaha'] = $this->namausaha->CurrentValue;
        $row['bidangusaha'] = $this->bidangusaha->CurrentValue;
        $row['badanhukum'] = $this->badanhukum->CurrentValue;
        $row['siup'] = $this->siup->CurrentValue;
        $row['bpom'] = $this->bpom->CurrentValue;
        $row['irt'] = $this->irt->CurrentValue;
        $row['potensiblm'] = $this->potensiblm->CurrentValue;
        $row['aset'] = $this->aset->CurrentValue;
        $row['modal'] = $this->_modal->CurrentValue;
        $row['hasilsetahun'] = $this->hasilsetahun->CurrentValue;
        $row['kendala'] = $this->kendala->CurrentValue;
        $row['fasilitasperlu'] = $this->fasilitasperlu->CurrentValue;
        $row['foto'] = $this->foto->Upload->DbValue;
        $row['dokumen'] = $this->dokumen->Upload->DbValue;
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

        // namausaha

        // bidangusaha

        // badanhukum

        // siup

        // bpom

        // irt

        // potensiblm

        // aset

        // modal

        // hasilsetahun

        // kendala

        // fasilitasperlu

        // foto

        // dokumen
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // pid
            $this->pid->ViewValue = $this->pid->CurrentValue;
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

            // namausaha
            $this->namausaha->ViewValue = $this->namausaha->CurrentValue;
            $this->namausaha->ViewCustomAttributes = "";

            // bidangusaha
            $this->bidangusaha->ViewValue = $this->bidangusaha->CurrentValue;
            $this->bidangusaha->ViewCustomAttributes = "";

            // badanhukum
            if (strval($this->badanhukum->CurrentValue) != "") {
                $this->badanhukum->ViewValue = $this->badanhukum->optionCaption($this->badanhukum->CurrentValue);
            } else {
                $this->badanhukum->ViewValue = null;
            }
            $this->badanhukum->ViewCustomAttributes = "";

            // siup
            $this->siup->ViewValue = $this->siup->CurrentValue;
            $this->siup->ViewCustomAttributes = "";

            // bpom
            $this->bpom->ViewValue = $this->bpom->CurrentValue;
            $this->bpom->ViewCustomAttributes = "";

            // irt
            $this->irt->ViewValue = $this->irt->CurrentValue;
            $this->irt->ViewCustomAttributes = "";

            // potensiblm
            $this->potensiblm->ViewValue = $this->potensiblm->CurrentValue;
            $this->potensiblm->ViewCustomAttributes = "";

            // aset
            $this->aset->ViewValue = $this->aset->CurrentValue;
            $this->aset->ViewCustomAttributes = "";

            // modal
            $this->_modal->ViewValue = $this->_modal->CurrentValue;
            $this->_modal->ViewCustomAttributes = "";

            // hasilsetahun
            $this->hasilsetahun->ViewValue = $this->hasilsetahun->CurrentValue;
            $this->hasilsetahun->ViewCustomAttributes = "";

            // kendala
            $this->kendala->ViewValue = $this->kendala->CurrentValue;
            $this->kendala->ViewCustomAttributes = "";

            // fasilitasperlu
            $this->fasilitasperlu->ViewValue = $this->fasilitasperlu->CurrentValue;
            $this->fasilitasperlu->ViewCustomAttributes = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }
            $this->foto->ViewCustomAttributes = "";

            // pid
            $this->pid->LinkCustomAttributes = "";
            $this->pid->HrefValue = "";
            $this->pid->TooltipValue = "";

            // namausaha
            $this->namausaha->LinkCustomAttributes = "";
            $this->namausaha->HrefValue = "";
            $this->namausaha->TooltipValue = "";

            // bidangusaha
            $this->bidangusaha->LinkCustomAttributes = "";
            $this->bidangusaha->HrefValue = "";
            $this->bidangusaha->TooltipValue = "";

            // badanhukum
            $this->badanhukum->LinkCustomAttributes = "";
            $this->badanhukum->HrefValue = "";
            $this->badanhukum->TooltipValue = "";

            // siup
            $this->siup->LinkCustomAttributes = "";
            $this->siup->HrefValue = "";
            $this->siup->TooltipValue = "";

            // bpom
            $this->bpom->LinkCustomAttributes = "";
            $this->bpom->HrefValue = "";
            $this->bpom->TooltipValue = "";

            // irt
            $this->irt->LinkCustomAttributes = "";
            $this->irt->HrefValue = "";
            $this->irt->TooltipValue = "";

            // potensiblm
            $this->potensiblm->LinkCustomAttributes = "";
            $this->potensiblm->HrefValue = "";
            $this->potensiblm->TooltipValue = "";

            // aset
            $this->aset->LinkCustomAttributes = "";
            $this->aset->HrefValue = "";
            $this->aset->TooltipValue = "";

            // modal
            $this->_modal->LinkCustomAttributes = "";
            $this->_modal->HrefValue = "";
            $this->_modal->TooltipValue = "";

            // hasilsetahun
            $this->hasilsetahun->LinkCustomAttributes = "";
            $this->hasilsetahun->HrefValue = "";
            $this->hasilsetahun->TooltipValue = "";

            // kendala
            $this->kendala->LinkCustomAttributes = "";
            $this->kendala->HrefValue = "";
            $this->kendala->TooltipValue = "";

            // fasilitasperlu
            $this->fasilitasperlu->LinkCustomAttributes = "";
            $this->fasilitasperlu->HrefValue = "";
            $this->fasilitasperlu->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // pid
            $this->pid->EditAttrs["class"] = "form-control";
            $this->pid->EditCustomAttributes = "";
            if ($this->pid->getSessionValue() != "") {
                $this->pid->CurrentValue = GetForeignKeyValue($this->pid->getSessionValue());
                $this->pid->ViewValue = $this->pid->CurrentValue;
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
                $this->pid->EditValue = HtmlEncode($this->pid->CurrentValue);
                $curVal = trim(strval($this->pid->CurrentValue));
                if ($curVal != "") {
                    $this->pid->EditValue = $this->pid->lookupCacheOption($curVal);
                    if ($this->pid->EditValue === null) { // Lookup from database
                        $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->pid->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->pid->Lookup->renderViewRow($rswrk[0]);
                            $this->pid->EditValue = $this->pid->displayValue($arwrk);
                        } else {
                            $this->pid->EditValue = HtmlEncode($this->pid->CurrentValue);
                        }
                    }
                } else {
                    $this->pid->EditValue = null;
                }
            }

            // namausaha
            $this->namausaha->EditAttrs["class"] = "form-control";
            $this->namausaha->EditCustomAttributes = "";
            if (!$this->namausaha->Raw) {
                $this->namausaha->CurrentValue = HtmlDecode($this->namausaha->CurrentValue);
            }
            $this->namausaha->EditValue = HtmlEncode($this->namausaha->CurrentValue);

            // bidangusaha
            $this->bidangusaha->EditAttrs["class"] = "form-control";
            $this->bidangusaha->EditCustomAttributes = "";
            if (!$this->bidangusaha->Raw) {
                $this->bidangusaha->CurrentValue = HtmlDecode($this->bidangusaha->CurrentValue);
            }
            $this->bidangusaha->EditValue = HtmlEncode($this->bidangusaha->CurrentValue);

            // badanhukum
            $this->badanhukum->EditAttrs["class"] = "form-control";
            $this->badanhukum->EditCustomAttributes = "";
            $this->badanhukum->EditValue = $this->badanhukum->options(true);

            // siup
            $this->siup->EditAttrs["class"] = "form-control";
            $this->siup->EditCustomAttributes = "";
            if (!$this->siup->Raw) {
                $this->siup->CurrentValue = HtmlDecode($this->siup->CurrentValue);
            }
            $this->siup->EditValue = HtmlEncode($this->siup->CurrentValue);

            // bpom
            $this->bpom->EditAttrs["class"] = "form-control";
            $this->bpom->EditCustomAttributes = "";
            if (!$this->bpom->Raw) {
                $this->bpom->CurrentValue = HtmlDecode($this->bpom->CurrentValue);
            }
            $this->bpom->EditValue = HtmlEncode($this->bpom->CurrentValue);

            // irt
            $this->irt->EditAttrs["class"] = "form-control";
            $this->irt->EditCustomAttributes = "";
            if (!$this->irt->Raw) {
                $this->irt->CurrentValue = HtmlDecode($this->irt->CurrentValue);
            }
            $this->irt->EditValue = HtmlEncode($this->irt->CurrentValue);

            // potensiblm
            $this->potensiblm->EditAttrs["class"] = "form-control";
            $this->potensiblm->EditCustomAttributes = "";
            if (!$this->potensiblm->Raw) {
                $this->potensiblm->CurrentValue = HtmlDecode($this->potensiblm->CurrentValue);
            }
            $this->potensiblm->EditValue = HtmlEncode($this->potensiblm->CurrentValue);

            // aset
            $this->aset->EditAttrs["class"] = "form-control";
            $this->aset->EditCustomAttributes = "";
            if (!$this->aset->Raw) {
                $this->aset->CurrentValue = HtmlDecode($this->aset->CurrentValue);
            }
            $this->aset->EditValue = HtmlEncode($this->aset->CurrentValue);

            // modal
            $this->_modal->EditAttrs["class"] = "form-control";
            $this->_modal->EditCustomAttributes = "";
            if (!$this->_modal->Raw) {
                $this->_modal->CurrentValue = HtmlDecode($this->_modal->CurrentValue);
            }
            $this->_modal->EditValue = HtmlEncode($this->_modal->CurrentValue);

            // hasilsetahun
            $this->hasilsetahun->EditAttrs["class"] = "form-control";
            $this->hasilsetahun->EditCustomAttributes = "";
            if (!$this->hasilsetahun->Raw) {
                $this->hasilsetahun->CurrentValue = HtmlDecode($this->hasilsetahun->CurrentValue);
            }
            $this->hasilsetahun->EditValue = HtmlEncode($this->hasilsetahun->CurrentValue);

            // kendala
            $this->kendala->EditAttrs["class"] = "form-control";
            $this->kendala->EditCustomAttributes = "";
            if (!$this->kendala->Raw) {
                $this->kendala->CurrentValue = HtmlDecode($this->kendala->CurrentValue);
            }
            $this->kendala->EditValue = HtmlEncode($this->kendala->CurrentValue);

            // fasilitasperlu
            $this->fasilitasperlu->EditAttrs["class"] = "form-control";
            $this->fasilitasperlu->EditCustomAttributes = "";
            $this->fasilitasperlu->EditValue = HtmlEncode($this->fasilitasperlu->CurrentValue);

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->EditValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->EditValue = "";
            }
            if (!EmptyValue($this->foto->CurrentValue)) {
                $this->foto->Upload->FileName = $this->foto->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->foto);
            }

            // Add refer script

            // pid
            $this->pid->LinkCustomAttributes = "";
            $this->pid->HrefValue = "";

            // namausaha
            $this->namausaha->LinkCustomAttributes = "";
            $this->namausaha->HrefValue = "";

            // bidangusaha
            $this->bidangusaha->LinkCustomAttributes = "";
            $this->bidangusaha->HrefValue = "";

            // badanhukum
            $this->badanhukum->LinkCustomAttributes = "";
            $this->badanhukum->HrefValue = "";

            // siup
            $this->siup->LinkCustomAttributes = "";
            $this->siup->HrefValue = "";

            // bpom
            $this->bpom->LinkCustomAttributes = "";
            $this->bpom->HrefValue = "";

            // irt
            $this->irt->LinkCustomAttributes = "";
            $this->irt->HrefValue = "";

            // potensiblm
            $this->potensiblm->LinkCustomAttributes = "";
            $this->potensiblm->HrefValue = "";

            // aset
            $this->aset->LinkCustomAttributes = "";
            $this->aset->HrefValue = "";

            // modal
            $this->_modal->LinkCustomAttributes = "";
            $this->_modal->HrefValue = "";

            // hasilsetahun
            $this->hasilsetahun->LinkCustomAttributes = "";
            $this->hasilsetahun->HrefValue = "";

            // kendala
            $this->kendala->LinkCustomAttributes = "";
            $this->kendala->HrefValue = "";

            // fasilitasperlu
            $this->fasilitasperlu->LinkCustomAttributes = "";
            $this->fasilitasperlu->HrefValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
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
        if (!CheckInteger($this->pid->FormValue)) {
            $this->pid->addErrorMessage($this->pid->getErrorMessage(false));
        }
        if ($this->namausaha->Required) {
            if (!$this->namausaha->IsDetailKey && EmptyValue($this->namausaha->FormValue)) {
                $this->namausaha->addErrorMessage(str_replace("%s", $this->namausaha->caption(), $this->namausaha->RequiredErrorMessage));
            }
        }
        if ($this->bidangusaha->Required) {
            if (!$this->bidangusaha->IsDetailKey && EmptyValue($this->bidangusaha->FormValue)) {
                $this->bidangusaha->addErrorMessage(str_replace("%s", $this->bidangusaha->caption(), $this->bidangusaha->RequiredErrorMessage));
            }
        }
        if ($this->badanhukum->Required) {
            if (!$this->badanhukum->IsDetailKey && EmptyValue($this->badanhukum->FormValue)) {
                $this->badanhukum->addErrorMessage(str_replace("%s", $this->badanhukum->caption(), $this->badanhukum->RequiredErrorMessage));
            }
        }
        if ($this->siup->Required) {
            if (!$this->siup->IsDetailKey && EmptyValue($this->siup->FormValue)) {
                $this->siup->addErrorMessage(str_replace("%s", $this->siup->caption(), $this->siup->RequiredErrorMessage));
            }
        }
        if ($this->bpom->Required) {
            if (!$this->bpom->IsDetailKey && EmptyValue($this->bpom->FormValue)) {
                $this->bpom->addErrorMessage(str_replace("%s", $this->bpom->caption(), $this->bpom->RequiredErrorMessage));
            }
        }
        if ($this->irt->Required) {
            if (!$this->irt->IsDetailKey && EmptyValue($this->irt->FormValue)) {
                $this->irt->addErrorMessage(str_replace("%s", $this->irt->caption(), $this->irt->RequiredErrorMessage));
            }
        }
        if ($this->potensiblm->Required) {
            if (!$this->potensiblm->IsDetailKey && EmptyValue($this->potensiblm->FormValue)) {
                $this->potensiblm->addErrorMessage(str_replace("%s", $this->potensiblm->caption(), $this->potensiblm->RequiredErrorMessage));
            }
        }
        if ($this->aset->Required) {
            if (!$this->aset->IsDetailKey && EmptyValue($this->aset->FormValue)) {
                $this->aset->addErrorMessage(str_replace("%s", $this->aset->caption(), $this->aset->RequiredErrorMessage));
            }
        }
        if ($this->_modal->Required) {
            if (!$this->_modal->IsDetailKey && EmptyValue($this->_modal->FormValue)) {
                $this->_modal->addErrorMessage(str_replace("%s", $this->_modal->caption(), $this->_modal->RequiredErrorMessage));
            }
        }
        if ($this->hasilsetahun->Required) {
            if (!$this->hasilsetahun->IsDetailKey && EmptyValue($this->hasilsetahun->FormValue)) {
                $this->hasilsetahun->addErrorMessage(str_replace("%s", $this->hasilsetahun->caption(), $this->hasilsetahun->RequiredErrorMessage));
            }
        }
        if ($this->kendala->Required) {
            if (!$this->kendala->IsDetailKey && EmptyValue($this->kendala->FormValue)) {
                $this->kendala->addErrorMessage(str_replace("%s", $this->kendala->caption(), $this->kendala->RequiredErrorMessage));
            }
        }
        if ($this->fasilitasperlu->Required) {
            if (!$this->fasilitasperlu->IsDetailKey && EmptyValue($this->fasilitasperlu->FormValue)) {
                $this->fasilitasperlu->addErrorMessage(str_replace("%s", $this->fasilitasperlu->caption(), $this->fasilitasperlu->RequiredErrorMessage));
            }
        }
        if ($this->foto->Required) {
            if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
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

        // Check referential integrity for master table 'fasilitasusaha'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_pesantren();
        if (strval($this->pid->CurrentValue) != "") {
            $masterFilter = str_replace("@id@", AdjustSql($this->pid->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("pesantren")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "pesantren", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // pid
        $this->pid->setDbValueDef($rsnew, $this->pid->CurrentValue, null, false);

        // namausaha
        $this->namausaha->setDbValueDef($rsnew, $this->namausaha->CurrentValue, null, false);

        // bidangusaha
        $this->bidangusaha->setDbValueDef($rsnew, $this->bidangusaha->CurrentValue, null, false);

        // badanhukum
        $this->badanhukum->setDbValueDef($rsnew, $this->badanhukum->CurrentValue, null, false);

        // siup
        $this->siup->setDbValueDef($rsnew, $this->siup->CurrentValue, null, false);

        // bpom
        $this->bpom->setDbValueDef($rsnew, $this->bpom->CurrentValue, null, false);

        // irt
        $this->irt->setDbValueDef($rsnew, $this->irt->CurrentValue, null, false);

        // potensiblm
        $this->potensiblm->setDbValueDef($rsnew, $this->potensiblm->CurrentValue, null, false);

        // aset
        $this->aset->setDbValueDef($rsnew, $this->aset->CurrentValue, null, false);

        // modal
        $this->_modal->setDbValueDef($rsnew, $this->_modal->CurrentValue, null, false);

        // hasilsetahun
        $this->hasilsetahun->setDbValueDef($rsnew, $this->hasilsetahun->CurrentValue, null, false);

        // kendala
        $this->kendala->setDbValueDef($rsnew, $this->kendala->CurrentValue, null, false);

        // fasilitasperlu
        $this->fasilitasperlu->setDbValueDef($rsnew, $this->fasilitasperlu->CurrentValue, null, false);

        // foto
        if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
            $this->foto->Upload->DbValue = ""; // No need to delete old file
            if ($this->foto->Upload->FileName == "") {
                $rsnew['foto'] = null;
            } else {
                $rsnew['foto'] = $this->foto->Upload->FileName;
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
                $this->foto->setDbValueDef($rsnew, $this->foto->Upload->FileName, null, false);
            }
        }

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
            // foto
            CleanUploadTempPath($this->foto, $this->foto->Upload->Index);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FasilitasusahaList"), "", $this->TableVar, true);
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
                case "x_badanhukum":
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
