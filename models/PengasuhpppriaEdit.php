<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PengasuhpppriaEdit extends Pengasuhpppria
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'pengasuhpppria';

    // Page object name
    public $PageObjName = "PengasuhpppriaEdit";

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

        // Table object (pengasuhpppria)
        if (!isset($GLOBALS["pengasuhpppria"]) || get_class($GLOBALS["pengasuhpppria"]) == PROJECT_NAMESPACE . "pengasuhpppria") {
            $GLOBALS["pengasuhpppria"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'pengasuhpppria');
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
                $doc = new $class(Container("pengasuhpppria"));
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
                    if ($pageName == "PengasuhpppriaView") {
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
        $this->id->setVisibility();
        $this->pid->setVisibility();
        $this->nama->setVisibility();
        $this->nik->setVisibility();
        $this->alamat->setVisibility();
        $this->hp->setVisibility();
        $this->md->setVisibility();
        $this->mts->setVisibility();
        $this->ma->setVisibility();
        $this->pesantren->setVisibility();
        $this->s1->setVisibility();
        $this->s2->setVisibility();
        $this->s3->setVisibility();
        $this->organisasi->setVisibility();
        $this->jabatandiorganisasi->setVisibility();
        $this->tglawalorganisasi->setVisibility();
        $this->tglakhirorganisasi->Visible = false;
        $this->pemerintah->setVisibility();
        $this->jabatandipemerintah->setVisibility();
        $this->tglmenjabat->setVisibility();
        $this->tglakhirjabatan->Visible = false;
        $this->foto->setVisibility();
        $this->ijazah->setVisibility();
        $this->sertifikat->setVisibility();
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

            // Set up master detail parameters
            $this->setupMasterParms();

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
                    $this->terminate("PengasuhpppriaList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "PengasuhpppriaList") {
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
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->foto->CurrentValue = $this->foto->Upload->FileName;
        $this->ijazah->Upload->Index = $CurrentForm->Index;
        $this->ijazah->Upload->uploadFile();
        $this->ijazah->CurrentValue = $this->ijazah->Upload->FileName;
        $this->sertifikat->Upload->Index = $CurrentForm->Index;
        $this->sertifikat->Upload->uploadFile();
        $this->sertifikat->CurrentValue = $this->sertifikat->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'pid' first before field var 'x_pid'
        $val = $CurrentForm->hasValue("pid") ? $CurrentForm->getValue("pid") : $CurrentForm->getValue("x_pid");
        if (!$this->pid->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pid->Visible = false; // Disable update for API request
            } else {
                $this->pid->setFormValue($val);
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

        // Check field name 'nik' first before field var 'x_nik'
        $val = $CurrentForm->hasValue("nik") ? $CurrentForm->getValue("nik") : $CurrentForm->getValue("x_nik");
        if (!$this->nik->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nik->Visible = false; // Disable update for API request
            } else {
                $this->nik->setFormValue($val);
            }
        }

        // Check field name 'alamat' first before field var 'x_alamat'
        $val = $CurrentForm->hasValue("alamat") ? $CurrentForm->getValue("alamat") : $CurrentForm->getValue("x_alamat");
        if (!$this->alamat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alamat->Visible = false; // Disable update for API request
            } else {
                $this->alamat->setFormValue($val);
            }
        }

        // Check field name 'hp' first before field var 'x_hp'
        $val = $CurrentForm->hasValue("hp") ? $CurrentForm->getValue("hp") : $CurrentForm->getValue("x_hp");
        if (!$this->hp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->hp->Visible = false; // Disable update for API request
            } else {
                $this->hp->setFormValue($val);
            }
        }

        // Check field name 'md' first before field var 'x_md'
        $val = $CurrentForm->hasValue("md") ? $CurrentForm->getValue("md") : $CurrentForm->getValue("x_md");
        if (!$this->md->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->md->Visible = false; // Disable update for API request
            } else {
                $this->md->setFormValue($val);
            }
        }

        // Check field name 'mts' first before field var 'x_mts'
        $val = $CurrentForm->hasValue("mts") ? $CurrentForm->getValue("mts") : $CurrentForm->getValue("x_mts");
        if (!$this->mts->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mts->Visible = false; // Disable update for API request
            } else {
                $this->mts->setFormValue($val);
            }
        }

        // Check field name 'ma' first before field var 'x_ma'
        $val = $CurrentForm->hasValue("ma") ? $CurrentForm->getValue("ma") : $CurrentForm->getValue("x_ma");
        if (!$this->ma->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ma->Visible = false; // Disable update for API request
            } else {
                $this->ma->setFormValue($val);
            }
        }

        // Check field name 'pesantren' first before field var 'x_pesantren'
        $val = $CurrentForm->hasValue("pesantren") ? $CurrentForm->getValue("pesantren") : $CurrentForm->getValue("x_pesantren");
        if (!$this->pesantren->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pesantren->Visible = false; // Disable update for API request
            } else {
                $this->pesantren->setFormValue($val);
            }
        }

        // Check field name 's1' first before field var 'x_s1'
        $val = $CurrentForm->hasValue("s1") ? $CurrentForm->getValue("s1") : $CurrentForm->getValue("x_s1");
        if (!$this->s1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->s1->Visible = false; // Disable update for API request
            } else {
                $this->s1->setFormValue($val);
            }
        }

        // Check field name 's2' first before field var 'x_s2'
        $val = $CurrentForm->hasValue("s2") ? $CurrentForm->getValue("s2") : $CurrentForm->getValue("x_s2");
        if (!$this->s2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->s2->Visible = false; // Disable update for API request
            } else {
                $this->s2->setFormValue($val);
            }
        }

        // Check field name 's3' first before field var 'x_s3'
        $val = $CurrentForm->hasValue("s3") ? $CurrentForm->getValue("s3") : $CurrentForm->getValue("x_s3");
        if (!$this->s3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->s3->Visible = false; // Disable update for API request
            } else {
                $this->s3->setFormValue($val);
            }
        }

        // Check field name 'organisasi' first before field var 'x_organisasi'
        $val = $CurrentForm->hasValue("organisasi") ? $CurrentForm->getValue("organisasi") : $CurrentForm->getValue("x_organisasi");
        if (!$this->organisasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->organisasi->Visible = false; // Disable update for API request
            } else {
                $this->organisasi->setFormValue($val);
            }
        }

        // Check field name 'jabatandiorganisasi' first before field var 'x_jabatandiorganisasi'
        $val = $CurrentForm->hasValue("jabatandiorganisasi") ? $CurrentForm->getValue("jabatandiorganisasi") : $CurrentForm->getValue("x_jabatandiorganisasi");
        if (!$this->jabatandiorganisasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jabatandiorganisasi->Visible = false; // Disable update for API request
            } else {
                $this->jabatandiorganisasi->setFormValue($val);
            }
        }

        // Check field name 'tglawalorganisasi' first before field var 'x_tglawalorganisasi'
        $val = $CurrentForm->hasValue("tglawalorganisasi") ? $CurrentForm->getValue("tglawalorganisasi") : $CurrentForm->getValue("x_tglawalorganisasi");
        if (!$this->tglawalorganisasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglawalorganisasi->Visible = false; // Disable update for API request
            } else {
                $this->tglawalorganisasi->setFormValue($val);
            }
            $this->tglawalorganisasi->CurrentValue = UnFormatDateTime($this->tglawalorganisasi->CurrentValue, 7);
        }

        // Check field name 'pemerintah' first before field var 'x_pemerintah'
        $val = $CurrentForm->hasValue("pemerintah") ? $CurrentForm->getValue("pemerintah") : $CurrentForm->getValue("x_pemerintah");
        if (!$this->pemerintah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pemerintah->Visible = false; // Disable update for API request
            } else {
                $this->pemerintah->setFormValue($val);
            }
        }

        // Check field name 'jabatandipemerintah' first before field var 'x_jabatandipemerintah'
        $val = $CurrentForm->hasValue("jabatandipemerintah") ? $CurrentForm->getValue("jabatandipemerintah") : $CurrentForm->getValue("x_jabatandipemerintah");
        if (!$this->jabatandipemerintah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jabatandipemerintah->Visible = false; // Disable update for API request
            } else {
                $this->jabatandipemerintah->setFormValue($val);
            }
        }

        // Check field name 'tglmenjabat' first before field var 'x_tglmenjabat'
        $val = $CurrentForm->hasValue("tglmenjabat") ? $CurrentForm->getValue("tglmenjabat") : $CurrentForm->getValue("x_tglmenjabat");
        if (!$this->tglmenjabat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglmenjabat->Visible = false; // Disable update for API request
            } else {
                $this->tglmenjabat->setFormValue($val);
            }
            $this->tglmenjabat->CurrentValue = UnFormatDateTime($this->tglmenjabat->CurrentValue, 7);
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->pid->CurrentValue = $this->pid->FormValue;
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->nik->CurrentValue = $this->nik->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->hp->CurrentValue = $this->hp->FormValue;
        $this->md->CurrentValue = $this->md->FormValue;
        $this->mts->CurrentValue = $this->mts->FormValue;
        $this->ma->CurrentValue = $this->ma->FormValue;
        $this->pesantren->CurrentValue = $this->pesantren->FormValue;
        $this->s1->CurrentValue = $this->s1->FormValue;
        $this->s2->CurrentValue = $this->s2->FormValue;
        $this->s3->CurrentValue = $this->s3->FormValue;
        $this->organisasi->CurrentValue = $this->organisasi->FormValue;
        $this->jabatandiorganisasi->CurrentValue = $this->jabatandiorganisasi->FormValue;
        $this->tglawalorganisasi->CurrentValue = $this->tglawalorganisasi->FormValue;
        $this->tglawalorganisasi->CurrentValue = UnFormatDateTime($this->tglawalorganisasi->CurrentValue, 7);
        $this->pemerintah->CurrentValue = $this->pemerintah->FormValue;
        $this->jabatandipemerintah->CurrentValue = $this->jabatandipemerintah->FormValue;
        $this->tglmenjabat->CurrentValue = $this->tglmenjabat->FormValue;
        $this->tglmenjabat->CurrentValue = UnFormatDateTime($this->tglmenjabat->CurrentValue, 7);
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
        $this->nama->setDbValue($row['nama']);
        $this->nik->setDbValue($row['nik']);
        $this->alamat->setDbValue($row['alamat']);
        $this->hp->setDbValue($row['hp']);
        $this->md->setDbValue($row['md']);
        $this->mts->setDbValue($row['mts']);
        $this->ma->setDbValue($row['ma']);
        $this->pesantren->setDbValue($row['pesantren']);
        $this->s1->setDbValue($row['s1']);
        $this->s2->setDbValue($row['s2']);
        $this->s3->setDbValue($row['s3']);
        $this->organisasi->setDbValue($row['organisasi']);
        $this->jabatandiorganisasi->setDbValue($row['jabatandiorganisasi']);
        $this->tglawalorganisasi->setDbValue($row['tglawalorganisasi']);
        $this->tglakhirorganisasi->setDbValue($row['tglakhirorganisasi']);
        $this->pemerintah->setDbValue($row['pemerintah']);
        $this->jabatandipemerintah->setDbValue($row['jabatandipemerintah']);
        $this->tglmenjabat->setDbValue($row['tglmenjabat']);
        $this->tglakhirjabatan->setDbValue($row['tglakhirjabatan']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->ijazah->Upload->DbValue = $row['ijazah'];
        $this->ijazah->setDbValue($this->ijazah->Upload->DbValue);
        $this->sertifikat->Upload->DbValue = $row['sertifikat'];
        $this->sertifikat->setDbValue($this->sertifikat->Upload->DbValue);
        $this->dokumen->Upload->DbValue = $row['dokumen'];
        $this->dokumen->setDbValue($this->dokumen->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['pid'] = null;
        $row['nama'] = null;
        $row['nik'] = null;
        $row['alamat'] = null;
        $row['hp'] = null;
        $row['md'] = null;
        $row['mts'] = null;
        $row['ma'] = null;
        $row['pesantren'] = null;
        $row['s1'] = null;
        $row['s2'] = null;
        $row['s3'] = null;
        $row['organisasi'] = null;
        $row['jabatandiorganisasi'] = null;
        $row['tglawalorganisasi'] = null;
        $row['tglakhirorganisasi'] = null;
        $row['pemerintah'] = null;
        $row['jabatandipemerintah'] = null;
        $row['tglmenjabat'] = null;
        $row['tglakhirjabatan'] = null;
        $row['foto'] = null;
        $row['ijazah'] = null;
        $row['sertifikat'] = null;
        $row['dokumen'] = null;
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

        // nama

        // nik

        // alamat

        // hp

        // md

        // mts

        // ma

        // pesantren

        // s1

        // s2

        // s3

        // organisasi

        // jabatandiorganisasi

        // tglawalorganisasi

        // tglakhirorganisasi

        // pemerintah

        // jabatandipemerintah

        // tglmenjabat

        // tglakhirjabatan

        // foto

        // ijazah

        // sertifikat

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

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // nik
            $this->nik->ViewValue = $this->nik->CurrentValue;
            $this->nik->ViewCustomAttributes = "";

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;
            $this->alamat->ViewCustomAttributes = "";

            // hp
            $this->hp->ViewValue = $this->hp->CurrentValue;
            $this->hp->ViewCustomAttributes = "";

            // md
            $this->md->ViewValue = $this->md->CurrentValue;
            $this->md->ViewCustomAttributes = "";

            // mts
            $this->mts->ViewValue = $this->mts->CurrentValue;
            $this->mts->ViewCustomAttributes = "";

            // ma
            $this->ma->ViewValue = $this->ma->CurrentValue;
            $this->ma->ViewCustomAttributes = "";

            // pesantren
            $this->pesantren->ViewValue = $this->pesantren->CurrentValue;
            $this->pesantren->ViewCustomAttributes = "";

            // s1
            $this->s1->ViewValue = $this->s1->CurrentValue;
            $this->s1->ViewCustomAttributes = "";

            // s2
            $this->s2->ViewValue = $this->s2->CurrentValue;
            $this->s2->ViewCustomAttributes = "";

            // s3
            $this->s3->ViewValue = $this->s3->CurrentValue;
            $this->s3->ViewCustomAttributes = "";

            // organisasi
            $this->organisasi->ViewValue = $this->organisasi->CurrentValue;
            $this->organisasi->ViewCustomAttributes = "";

            // jabatandiorganisasi
            $this->jabatandiorganisasi->ViewValue = $this->jabatandiorganisasi->CurrentValue;
            $this->jabatandiorganisasi->ViewCustomAttributes = "";

            // tglawalorganisasi
            $this->tglawalorganisasi->ViewValue = $this->tglawalorganisasi->CurrentValue;
            $this->tglawalorganisasi->ViewValue = FormatDateTime($this->tglawalorganisasi->ViewValue, 7);
            $this->tglawalorganisasi->ViewCustomAttributes = "";

            // pemerintah
            $this->pemerintah->ViewValue = $this->pemerintah->CurrentValue;
            $this->pemerintah->ViewCustomAttributes = "";

            // jabatandipemerintah
            $this->jabatandipemerintah->ViewValue = $this->jabatandipemerintah->CurrentValue;
            $this->jabatandipemerintah->ViewCustomAttributes = "";

            // tglmenjabat
            $this->tglmenjabat->ViewValue = $this->tglmenjabat->CurrentValue;
            $this->tglmenjabat->ViewValue = FormatDateTime($this->tglmenjabat->ViewValue, 7);
            $this->tglmenjabat->ViewCustomAttributes = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }
            $this->foto->ViewCustomAttributes = "";

            // ijazah
            if (!EmptyValue($this->ijazah->Upload->DbValue)) {
                $this->ijazah->ViewValue = $this->ijazah->Upload->DbValue;
            } else {
                $this->ijazah->ViewValue = "";
            }
            $this->ijazah->ViewCustomAttributes = "";

            // sertifikat
            if (!EmptyValue($this->sertifikat->Upload->DbValue)) {
                $this->sertifikat->ViewValue = $this->sertifikat->Upload->DbValue;
            } else {
                $this->sertifikat->ViewValue = "";
            }
            $this->sertifikat->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // pid
            $this->pid->LinkCustomAttributes = "";
            $this->pid->HrefValue = "";
            $this->pid->TooltipValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // nik
            $this->nik->LinkCustomAttributes = "";
            $this->nik->HrefValue = "";
            $this->nik->TooltipValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";
            $this->alamat->TooltipValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";
            $this->hp->TooltipValue = "";

            // md
            $this->md->LinkCustomAttributes = "";
            $this->md->HrefValue = "";
            $this->md->TooltipValue = "";

            // mts
            $this->mts->LinkCustomAttributes = "";
            $this->mts->HrefValue = "";
            $this->mts->TooltipValue = "";

            // ma
            $this->ma->LinkCustomAttributes = "";
            $this->ma->HrefValue = "";
            $this->ma->TooltipValue = "";

            // pesantren
            $this->pesantren->LinkCustomAttributes = "";
            $this->pesantren->HrefValue = "";
            $this->pesantren->TooltipValue = "";

            // s1
            $this->s1->LinkCustomAttributes = "";
            $this->s1->HrefValue = "";
            $this->s1->TooltipValue = "";

            // s2
            $this->s2->LinkCustomAttributes = "";
            $this->s2->HrefValue = "";
            $this->s2->TooltipValue = "";

            // s3
            $this->s3->LinkCustomAttributes = "";
            $this->s3->HrefValue = "";
            $this->s3->TooltipValue = "";

            // organisasi
            $this->organisasi->LinkCustomAttributes = "";
            $this->organisasi->HrefValue = "";
            $this->organisasi->TooltipValue = "";

            // jabatandiorganisasi
            $this->jabatandiorganisasi->LinkCustomAttributes = "";
            $this->jabatandiorganisasi->HrefValue = "";
            $this->jabatandiorganisasi->TooltipValue = "";

            // tglawalorganisasi
            $this->tglawalorganisasi->LinkCustomAttributes = "";
            $this->tglawalorganisasi->HrefValue = "";
            $this->tglawalorganisasi->TooltipValue = "";

            // pemerintah
            $this->pemerintah->LinkCustomAttributes = "";
            $this->pemerintah->HrefValue = "";
            $this->pemerintah->TooltipValue = "";

            // jabatandipemerintah
            $this->jabatandipemerintah->LinkCustomAttributes = "";
            $this->jabatandipemerintah->HrefValue = "";
            $this->jabatandipemerintah->TooltipValue = "";

            // tglmenjabat
            $this->tglmenjabat->LinkCustomAttributes = "";
            $this->tglmenjabat->HrefValue = "";
            $this->tglmenjabat->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";

            // ijazah
            $this->ijazah->LinkCustomAttributes = "";
            $this->ijazah->HrefValue = "";
            $this->ijazah->ExportHrefValue = $this->ijazah->UploadPath . $this->ijazah->Upload->DbValue;
            $this->ijazah->TooltipValue = "";

            // sertifikat
            $this->sertifikat->LinkCustomAttributes = "";
            $this->sertifikat->HrefValue = "";
            $this->sertifikat->ExportHrefValue = $this->sertifikat->UploadPath . $this->sertifikat->Upload->DbValue;
            $this->sertifikat->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

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

            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);

            // nik
            $this->nik->EditAttrs["class"] = "form-control";
            $this->nik->EditCustomAttributes = "";
            if (!$this->nik->Raw) {
                $this->nik->CurrentValue = HtmlDecode($this->nik->CurrentValue);
            }
            $this->nik->EditValue = HtmlEncode($this->nik->CurrentValue);

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            if (!$this->alamat->Raw) {
                $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
            }
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);

            // hp
            $this->hp->EditAttrs["class"] = "form-control";
            $this->hp->EditCustomAttributes = "";
            if (!$this->hp->Raw) {
                $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
            }
            $this->hp->EditValue = HtmlEncode($this->hp->CurrentValue);

            // md
            $this->md->EditAttrs["class"] = "form-control";
            $this->md->EditCustomAttributes = "";
            if (!$this->md->Raw) {
                $this->md->CurrentValue = HtmlDecode($this->md->CurrentValue);
            }
            $this->md->EditValue = HtmlEncode($this->md->CurrentValue);

            // mts
            $this->mts->EditAttrs["class"] = "form-control";
            $this->mts->EditCustomAttributes = "";
            if (!$this->mts->Raw) {
                $this->mts->CurrentValue = HtmlDecode($this->mts->CurrentValue);
            }
            $this->mts->EditValue = HtmlEncode($this->mts->CurrentValue);

            // ma
            $this->ma->EditAttrs["class"] = "form-control";
            $this->ma->EditCustomAttributes = "";
            if (!$this->ma->Raw) {
                $this->ma->CurrentValue = HtmlDecode($this->ma->CurrentValue);
            }
            $this->ma->EditValue = HtmlEncode($this->ma->CurrentValue);

            // pesantren
            $this->pesantren->EditAttrs["class"] = "form-control";
            $this->pesantren->EditCustomAttributes = "";
            if (!$this->pesantren->Raw) {
                $this->pesantren->CurrentValue = HtmlDecode($this->pesantren->CurrentValue);
            }
            $this->pesantren->EditValue = HtmlEncode($this->pesantren->CurrentValue);

            // s1
            $this->s1->EditAttrs["class"] = "form-control";
            $this->s1->EditCustomAttributes = "";
            if (!$this->s1->Raw) {
                $this->s1->CurrentValue = HtmlDecode($this->s1->CurrentValue);
            }
            $this->s1->EditValue = HtmlEncode($this->s1->CurrentValue);

            // s2
            $this->s2->EditAttrs["class"] = "form-control";
            $this->s2->EditCustomAttributes = "";
            if (!$this->s2->Raw) {
                $this->s2->CurrentValue = HtmlDecode($this->s2->CurrentValue);
            }
            $this->s2->EditValue = HtmlEncode($this->s2->CurrentValue);

            // s3
            $this->s3->EditAttrs["class"] = "form-control";
            $this->s3->EditCustomAttributes = "";
            if (!$this->s3->Raw) {
                $this->s3->CurrentValue = HtmlDecode($this->s3->CurrentValue);
            }
            $this->s3->EditValue = HtmlEncode($this->s3->CurrentValue);

            // organisasi
            $this->organisasi->EditAttrs["class"] = "form-control";
            $this->organisasi->EditCustomAttributes = "";
            if (!$this->organisasi->Raw) {
                $this->organisasi->CurrentValue = HtmlDecode($this->organisasi->CurrentValue);
            }
            $this->organisasi->EditValue = HtmlEncode($this->organisasi->CurrentValue);

            // jabatandiorganisasi
            $this->jabatandiorganisasi->EditAttrs["class"] = "form-control";
            $this->jabatandiorganisasi->EditCustomAttributes = "";
            if (!$this->jabatandiorganisasi->Raw) {
                $this->jabatandiorganisasi->CurrentValue = HtmlDecode($this->jabatandiorganisasi->CurrentValue);
            }
            $this->jabatandiorganisasi->EditValue = HtmlEncode($this->jabatandiorganisasi->CurrentValue);

            // tglawalorganisasi
            $this->tglawalorganisasi->EditAttrs["class"] = "form-control";
            $this->tglawalorganisasi->EditCustomAttributes = "";
            $this->tglawalorganisasi->EditValue = HtmlEncode(FormatDateTime($this->tglawalorganisasi->CurrentValue, 7));

            // pemerintah
            $this->pemerintah->EditAttrs["class"] = "form-control";
            $this->pemerintah->EditCustomAttributes = "";
            if (!$this->pemerintah->Raw) {
                $this->pemerintah->CurrentValue = HtmlDecode($this->pemerintah->CurrentValue);
            }
            $this->pemerintah->EditValue = HtmlEncode($this->pemerintah->CurrentValue);

            // jabatandipemerintah
            $this->jabatandipemerintah->EditAttrs["class"] = "form-control";
            $this->jabatandipemerintah->EditCustomAttributes = "";
            if (!$this->jabatandipemerintah->Raw) {
                $this->jabatandipemerintah->CurrentValue = HtmlDecode($this->jabatandipemerintah->CurrentValue);
            }
            $this->jabatandipemerintah->EditValue = HtmlEncode($this->jabatandipemerintah->CurrentValue);

            // tglmenjabat
            $this->tglmenjabat->EditAttrs["class"] = "form-control";
            $this->tglmenjabat->EditCustomAttributes = "";
            $this->tglmenjabat->EditValue = HtmlEncode(FormatDateTime($this->tglmenjabat->CurrentValue, 7));

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
            if ($this->isShow()) {
                RenderUploadField($this->foto);
            }

            // ijazah
            $this->ijazah->EditAttrs["class"] = "form-control";
            $this->ijazah->EditCustomAttributes = "";
            if (!EmptyValue($this->ijazah->Upload->DbValue)) {
                $this->ijazah->EditValue = $this->ijazah->Upload->DbValue;
            } else {
                $this->ijazah->EditValue = "";
            }
            if (!EmptyValue($this->ijazah->CurrentValue)) {
                $this->ijazah->Upload->FileName = $this->ijazah->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->ijazah);
            }

            // sertifikat
            $this->sertifikat->EditAttrs["class"] = "form-control";
            $this->sertifikat->EditCustomAttributes = "";
            if (!EmptyValue($this->sertifikat->Upload->DbValue)) {
                $this->sertifikat->EditValue = $this->sertifikat->Upload->DbValue;
            } else {
                $this->sertifikat->EditValue = "";
            }
            if (!EmptyValue($this->sertifikat->CurrentValue)) {
                $this->sertifikat->Upload->FileName = $this->sertifikat->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->sertifikat);
            }

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // pid
            $this->pid->LinkCustomAttributes = "";
            $this->pid->HrefValue = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // nik
            $this->nik->LinkCustomAttributes = "";
            $this->nik->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // hp
            $this->hp->LinkCustomAttributes = "";
            $this->hp->HrefValue = "";

            // md
            $this->md->LinkCustomAttributes = "";
            $this->md->HrefValue = "";

            // mts
            $this->mts->LinkCustomAttributes = "";
            $this->mts->HrefValue = "";

            // ma
            $this->ma->LinkCustomAttributes = "";
            $this->ma->HrefValue = "";

            // pesantren
            $this->pesantren->LinkCustomAttributes = "";
            $this->pesantren->HrefValue = "";

            // s1
            $this->s1->LinkCustomAttributes = "";
            $this->s1->HrefValue = "";

            // s2
            $this->s2->LinkCustomAttributes = "";
            $this->s2->HrefValue = "";

            // s3
            $this->s3->LinkCustomAttributes = "";
            $this->s3->HrefValue = "";

            // organisasi
            $this->organisasi->LinkCustomAttributes = "";
            $this->organisasi->HrefValue = "";

            // jabatandiorganisasi
            $this->jabatandiorganisasi->LinkCustomAttributes = "";
            $this->jabatandiorganisasi->HrefValue = "";

            // tglawalorganisasi
            $this->tglawalorganisasi->LinkCustomAttributes = "";
            $this->tglawalorganisasi->HrefValue = "";

            // pemerintah
            $this->pemerintah->LinkCustomAttributes = "";
            $this->pemerintah->HrefValue = "";

            // jabatandipemerintah
            $this->jabatandipemerintah->LinkCustomAttributes = "";
            $this->jabatandipemerintah->HrefValue = "";

            // tglmenjabat
            $this->tglmenjabat->LinkCustomAttributes = "";
            $this->tglmenjabat->HrefValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            $this->foto->HrefValue = "";
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;

            // ijazah
            $this->ijazah->LinkCustomAttributes = "";
            $this->ijazah->HrefValue = "";
            $this->ijazah->ExportHrefValue = $this->ijazah->UploadPath . $this->ijazah->Upload->DbValue;

            // sertifikat
            $this->sertifikat->LinkCustomAttributes = "";
            $this->sertifikat->HrefValue = "";
            $this->sertifikat->ExportHrefValue = $this->sertifikat->UploadPath . $this->sertifikat->Upload->DbValue;
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
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->pid->Required) {
            if (!$this->pid->IsDetailKey && EmptyValue($this->pid->FormValue)) {
                $this->pid->addErrorMessage(str_replace("%s", $this->pid->caption(), $this->pid->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->pid->FormValue)) {
            $this->pid->addErrorMessage($this->pid->getErrorMessage(false));
        }
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->nik->Required) {
            if (!$this->nik->IsDetailKey && EmptyValue($this->nik->FormValue)) {
                $this->nik->addErrorMessage(str_replace("%s", $this->nik->caption(), $this->nik->RequiredErrorMessage));
            }
        }
        if ($this->alamat->Required) {
            if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
            }
        }
        if ($this->hp->Required) {
            if (!$this->hp->IsDetailKey && EmptyValue($this->hp->FormValue)) {
                $this->hp->addErrorMessage(str_replace("%s", $this->hp->caption(), $this->hp->RequiredErrorMessage));
            }
        }
        if ($this->md->Required) {
            if (!$this->md->IsDetailKey && EmptyValue($this->md->FormValue)) {
                $this->md->addErrorMessage(str_replace("%s", $this->md->caption(), $this->md->RequiredErrorMessage));
            }
        }
        if ($this->mts->Required) {
            if (!$this->mts->IsDetailKey && EmptyValue($this->mts->FormValue)) {
                $this->mts->addErrorMessage(str_replace("%s", $this->mts->caption(), $this->mts->RequiredErrorMessage));
            }
        }
        if ($this->ma->Required) {
            if (!$this->ma->IsDetailKey && EmptyValue($this->ma->FormValue)) {
                $this->ma->addErrorMessage(str_replace("%s", $this->ma->caption(), $this->ma->RequiredErrorMessage));
            }
        }
        if ($this->pesantren->Required) {
            if (!$this->pesantren->IsDetailKey && EmptyValue($this->pesantren->FormValue)) {
                $this->pesantren->addErrorMessage(str_replace("%s", $this->pesantren->caption(), $this->pesantren->RequiredErrorMessage));
            }
        }
        if ($this->s1->Required) {
            if (!$this->s1->IsDetailKey && EmptyValue($this->s1->FormValue)) {
                $this->s1->addErrorMessage(str_replace("%s", $this->s1->caption(), $this->s1->RequiredErrorMessage));
            }
        }
        if ($this->s2->Required) {
            if (!$this->s2->IsDetailKey && EmptyValue($this->s2->FormValue)) {
                $this->s2->addErrorMessage(str_replace("%s", $this->s2->caption(), $this->s2->RequiredErrorMessage));
            }
        }
        if ($this->s3->Required) {
            if (!$this->s3->IsDetailKey && EmptyValue($this->s3->FormValue)) {
                $this->s3->addErrorMessage(str_replace("%s", $this->s3->caption(), $this->s3->RequiredErrorMessage));
            }
        }
        if ($this->organisasi->Required) {
            if (!$this->organisasi->IsDetailKey && EmptyValue($this->organisasi->FormValue)) {
                $this->organisasi->addErrorMessage(str_replace("%s", $this->organisasi->caption(), $this->organisasi->RequiredErrorMessage));
            }
        }
        if ($this->jabatandiorganisasi->Required) {
            if (!$this->jabatandiorganisasi->IsDetailKey && EmptyValue($this->jabatandiorganisasi->FormValue)) {
                $this->jabatandiorganisasi->addErrorMessage(str_replace("%s", $this->jabatandiorganisasi->caption(), $this->jabatandiorganisasi->RequiredErrorMessage));
            }
        }
        if ($this->tglawalorganisasi->Required) {
            if (!$this->tglawalorganisasi->IsDetailKey && EmptyValue($this->tglawalorganisasi->FormValue)) {
                $this->tglawalorganisasi->addErrorMessage(str_replace("%s", $this->tglawalorganisasi->caption(), $this->tglawalorganisasi->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->tglawalorganisasi->FormValue)) {
            $this->tglawalorganisasi->addErrorMessage($this->tglawalorganisasi->getErrorMessage(false));
        }
        if ($this->pemerintah->Required) {
            if (!$this->pemerintah->IsDetailKey && EmptyValue($this->pemerintah->FormValue)) {
                $this->pemerintah->addErrorMessage(str_replace("%s", $this->pemerintah->caption(), $this->pemerintah->RequiredErrorMessage));
            }
        }
        if ($this->jabatandipemerintah->Required) {
            if (!$this->jabatandipemerintah->IsDetailKey && EmptyValue($this->jabatandipemerintah->FormValue)) {
                $this->jabatandipemerintah->addErrorMessage(str_replace("%s", $this->jabatandipemerintah->caption(), $this->jabatandipemerintah->RequiredErrorMessage));
            }
        }
        if ($this->tglmenjabat->Required) {
            if (!$this->tglmenjabat->IsDetailKey && EmptyValue($this->tglmenjabat->FormValue)) {
                $this->tglmenjabat->addErrorMessage(str_replace("%s", $this->tglmenjabat->caption(), $this->tglmenjabat->RequiredErrorMessage));
            }
        }
        if (!CheckEuroDate($this->tglmenjabat->FormValue)) {
            $this->tglmenjabat->addErrorMessage($this->tglmenjabat->getErrorMessage(false));
        }
        if ($this->foto->Required) {
            if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
            }
        }
        if ($this->ijazah->Required) {
            if ($this->ijazah->Upload->FileName == "" && !$this->ijazah->Upload->KeepFile) {
                $this->ijazah->addErrorMessage(str_replace("%s", $this->ijazah->caption(), $this->ijazah->RequiredErrorMessage));
            }
        }
        if ($this->sertifikat->Required) {
            if ($this->sertifikat->Upload->FileName == "" && !$this->sertifikat->Upload->KeepFile) {
                $this->sertifikat->addErrorMessage(str_replace("%s", $this->sertifikat->caption(), $this->sertifikat->RequiredErrorMessage));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // pid
            if ($this->pid->getSessionValue() != "") {
                $this->pid->ReadOnly = true;
            }
            $this->pid->setDbValueDef($rsnew, $this->pid->CurrentValue, null, $this->pid->ReadOnly);

            // nama
            $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, null, $this->nama->ReadOnly);

            // nik
            $this->nik->setDbValueDef($rsnew, $this->nik->CurrentValue, null, $this->nik->ReadOnly);

            // alamat
            $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, null, $this->alamat->ReadOnly);

            // hp
            $this->hp->setDbValueDef($rsnew, $this->hp->CurrentValue, null, $this->hp->ReadOnly);

            // md
            $this->md->setDbValueDef($rsnew, $this->md->CurrentValue, null, $this->md->ReadOnly);

            // mts
            $this->mts->setDbValueDef($rsnew, $this->mts->CurrentValue, null, $this->mts->ReadOnly);

            // ma
            $this->ma->setDbValueDef($rsnew, $this->ma->CurrentValue, null, $this->ma->ReadOnly);

            // pesantren
            $this->pesantren->setDbValueDef($rsnew, $this->pesantren->CurrentValue, null, $this->pesantren->ReadOnly);

            // s1
            $this->s1->setDbValueDef($rsnew, $this->s1->CurrentValue, null, $this->s1->ReadOnly);

            // s2
            $this->s2->setDbValueDef($rsnew, $this->s2->CurrentValue, null, $this->s2->ReadOnly);

            // s3
            $this->s3->setDbValueDef($rsnew, $this->s3->CurrentValue, null, $this->s3->ReadOnly);

            // organisasi
            $this->organisasi->setDbValueDef($rsnew, $this->organisasi->CurrentValue, null, $this->organisasi->ReadOnly);

            // jabatandiorganisasi
            $this->jabatandiorganisasi->setDbValueDef($rsnew, $this->jabatandiorganisasi->CurrentValue, null, $this->jabatandiorganisasi->ReadOnly);

            // tglawalorganisasi
            $this->tglawalorganisasi->setDbValueDef($rsnew, UnFormatDateTime($this->tglawalorganisasi->CurrentValue, 7), null, $this->tglawalorganisasi->ReadOnly);

            // pemerintah
            $this->pemerintah->setDbValueDef($rsnew, $this->pemerintah->CurrentValue, null, $this->pemerintah->ReadOnly);

            // jabatandipemerintah
            $this->jabatandipemerintah->setDbValueDef($rsnew, $this->jabatandipemerintah->CurrentValue, null, $this->jabatandipemerintah->ReadOnly);

            // tglmenjabat
            $this->tglmenjabat->setDbValueDef($rsnew, UnFormatDateTime($this->tglmenjabat->CurrentValue, 7), null, $this->tglmenjabat->ReadOnly);

            // foto
            if ($this->foto->Visible && !$this->foto->ReadOnly && !$this->foto->Upload->KeepFile) {
                $this->foto->Upload->DbValue = $rsold['foto']; // Get original value
                if ($this->foto->Upload->FileName == "") {
                    $rsnew['foto'] = null;
                } else {
                    $rsnew['foto'] = $this->foto->Upload->FileName;
                }
            }

            // ijazah
            if ($this->ijazah->Visible && !$this->ijazah->ReadOnly && !$this->ijazah->Upload->KeepFile) {
                $this->ijazah->Upload->DbValue = $rsold['ijazah']; // Get original value
                if ($this->ijazah->Upload->FileName == "") {
                    $rsnew['ijazah'] = null;
                } else {
                    $rsnew['ijazah'] = $this->ijazah->Upload->FileName;
                }
            }

            // sertifikat
            if ($this->sertifikat->Visible && !$this->sertifikat->ReadOnly && !$this->sertifikat->Upload->KeepFile) {
                $this->sertifikat->Upload->DbValue = $rsold['sertifikat']; // Get original value
                if ($this->sertifikat->Upload->FileName == "") {
                    $rsnew['sertifikat'] = null;
                } else {
                    $rsnew['sertifikat'] = $this->sertifikat->Upload->FileName;
                }
            }

            // Check referential integrity for master table 'pesantren'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_pesantren();
            $keyValue = $rsnew['pid'] ?? $rsold['pid'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@id@", AdjustSql($keyValue), $masterFilter);
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
            if ($this->ijazah->Visible && !$this->ijazah->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->ijazah->Upload->DbValue) ? [] : [$this->ijazah->htmlDecode($this->ijazah->Upload->DbValue)];
                if (!EmptyValue($this->ijazah->Upload->FileName)) {
                    $newFiles = [$this->ijazah->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->ijazah, $this->ijazah->Upload->Index);
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
                                $file1 = UniqueFilename($this->ijazah->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->ijazah->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->ijazah->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->ijazah->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->ijazah->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->ijazah->setDbValueDef($rsnew, $this->ijazah->Upload->FileName, null, $this->ijazah->ReadOnly);
                }
            }
            if ($this->sertifikat->Visible && !$this->sertifikat->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->sertifikat->Upload->DbValue) ? [] : [$this->sertifikat->htmlDecode($this->sertifikat->Upload->DbValue)];
                if (!EmptyValue($this->sertifikat->Upload->FileName)) {
                    $newFiles = [$this->sertifikat->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->sertifikat, $this->sertifikat->Upload->Index);
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
                                $file1 = UniqueFilename($this->sertifikat->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->sertifikat->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->sertifikat->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->sertifikat->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->sertifikat->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->sertifikat->setDbValueDef($rsnew, $this->sertifikat->Upload->FileName, null, $this->sertifikat->ReadOnly);
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
                    if ($this->ijazah->Visible && !$this->ijazah->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->ijazah->Upload->DbValue) ? [] : [$this->ijazah->htmlDecode($this->ijazah->Upload->DbValue)];
                        if (!EmptyValue($this->ijazah->Upload->FileName)) {
                            $newFiles = [$this->ijazah->Upload->FileName];
                            $newFiles2 = [$this->ijazah->htmlDecode($rsnew['ijazah'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->ijazah, $this->ijazah->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->ijazah->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->ijazah->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->sertifikat->Visible && !$this->sertifikat->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->sertifikat->Upload->DbValue) ? [] : [$this->sertifikat->htmlDecode($this->sertifikat->Upload->DbValue)];
                        if (!EmptyValue($this->sertifikat->Upload->FileName)) {
                            $newFiles = [$this->sertifikat->Upload->FileName];
                            $newFiles2 = [$this->sertifikat->htmlDecode($rsnew['sertifikat'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->sertifikat, $this->sertifikat->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->sertifikat->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->sertifikat->oldPhysicalUploadPath() . $oldFile);
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
            // foto
            CleanUploadTempPath($this->foto, $this->foto->Upload->Index);

            // ijazah
            CleanUploadTempPath($this->ijazah, $this->ijazah->Upload->Index);

            // sertifikat
            CleanUploadTempPath($this->sertifikat, $this->sertifikat->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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
            $this->setSessionWhere($this->getDetailFilter());

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PengasuhpppriaList"), "", $this->TableVar, true);
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
                case "x_pid":
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
