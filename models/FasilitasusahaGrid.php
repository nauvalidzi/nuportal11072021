<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class FasilitasusahaGrid extends Fasilitasusaha
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fasilitasusaha';

    // Page object name
    public $PageObjName = "FasilitasusahaGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "ffasilitasusahagrid";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

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
        $this->AddUrl = "FasilitasusahaAdd";

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

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $ShowOtherOptions = false;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id->setVisibility();
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

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->pid);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Set up sorting order
            $this->setupSortOrder();
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter
        $this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter

        // Add master User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
                if ($this->getCurrentMasterTable() == "pesantren") {
                    $this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "pesantren"); // Add master User ID filter
                }
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "pesantren") {
            $masterTbl = Container("pesantren");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("PesantrenList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAll();
            $rs->closeCursor();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->id->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_pid") && $CurrentForm->hasValue("o_pid") && $this->pid->CurrentValue != $this->pid->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_namausaha") && $CurrentForm->hasValue("o_namausaha") && $this->namausaha->CurrentValue != $this->namausaha->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_bidangusaha") && $CurrentForm->hasValue("o_bidangusaha") && $this->bidangusaha->CurrentValue != $this->bidangusaha->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_badanhukum") && $CurrentForm->hasValue("o_badanhukum") && $this->badanhukum->CurrentValue != $this->badanhukum->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_siup") && $CurrentForm->hasValue("o_siup") && $this->siup->CurrentValue != $this->siup->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_bpom") && $CurrentForm->hasValue("o_bpom") && $this->bpom->CurrentValue != $this->bpom->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_irt") && $CurrentForm->hasValue("o_irt") && $this->irt->CurrentValue != $this->irt->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_potensiblm") && $CurrentForm->hasValue("o_potensiblm") && $this->potensiblm->CurrentValue != $this->potensiblm->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_aset") && $CurrentForm->hasValue("o_aset") && $this->aset->CurrentValue != $this->aset->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x__modal") && $CurrentForm->hasValue("o__modal") && $this->_modal->CurrentValue != $this->_modal->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_hasilsetahun") && $CurrentForm->hasValue("o_hasilsetahun") && $this->hasilsetahun->CurrentValue != $this->hasilsetahun->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_kendala") && $CurrentForm->hasValue("o_kendala") && $this->kendala->CurrentValue != $this->kendala->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_fasilitasperlu") && $CurrentForm->hasValue("o_fasilitasperlu") && $this->fasilitasperlu->CurrentValue != $this->fasilitasperlu->OldValue) {
            return false;
        }
        if (!EmptyValue($this->foto->Upload->Value)) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->id->clearErrorMessage();
        $this->pid->clearErrorMessage();
        $this->namausaha->clearErrorMessage();
        $this->bidangusaha->clearErrorMessage();
        $this->badanhukum->clearErrorMessage();
        $this->siup->clearErrorMessage();
        $this->bpom->clearErrorMessage();
        $this->irt->clearErrorMessage();
        $this->potensiblm->clearErrorMessage();
        $this->aset->clearErrorMessage();
        $this->_modal->clearErrorMessage();
        $this->hasilsetahun->clearErrorMessage();
        $this->kendala->clearErrorMessage();
        $this->fasilitasperlu->clearErrorMessage();
        $this->foto->clearErrorMessage();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->pid->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $option = $this->OtherOptions["addedit"];
        $option->UseDropDownButton = false;
        $option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $option->UseButtonGroup = true;
        //$option->ButtonClass = ""; // Class for button group
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
            if ($this->AllowAddDeleteRow) {
                $option = $options["addedit"];
                $option->UseDropDownButton = false;
                $item = &$option->add("addblankrow");
                $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                $item->Visible = $Security->canAdd();
                $this->ShowOtherOptions = $item->Visible;
            }
        }
        if ($this->CurrentMode == "view") { // Check view mode
            $option = $options["addedit"];
            $item = $option["add"];
            $this->ShowOtherOptions = $item && $item->Visible;
        }
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
        // Hide detail items for dropdown if necessary
        $this->ListOptions->hideDetailItemsForDropDown();
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
        global $Security, $Language;
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
        $this->foto->Upload->Index = $this->RowIndex;
        $this->dokumen->Upload->DbValue = null;
        $this->dokumen->OldValue = $this->dokumen->Upload->DbValue;
        $this->dokumen->Upload->Index = $this->RowIndex;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
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
        if ($CurrentForm->hasValue("o_pid")) {
            $this->pid->setOldValue($CurrentForm->getValue("o_pid"));
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
        if ($CurrentForm->hasValue("o_namausaha")) {
            $this->namausaha->setOldValue($CurrentForm->getValue("o_namausaha"));
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
        if ($CurrentForm->hasValue("o_bidangusaha")) {
            $this->bidangusaha->setOldValue($CurrentForm->getValue("o_bidangusaha"));
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
        if ($CurrentForm->hasValue("o_badanhukum")) {
            $this->badanhukum->setOldValue($CurrentForm->getValue("o_badanhukum"));
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
        if ($CurrentForm->hasValue("o_siup")) {
            $this->siup->setOldValue($CurrentForm->getValue("o_siup"));
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
        if ($CurrentForm->hasValue("o_bpom")) {
            $this->bpom->setOldValue($CurrentForm->getValue("o_bpom"));
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
        if ($CurrentForm->hasValue("o_irt")) {
            $this->irt->setOldValue($CurrentForm->getValue("o_irt"));
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
        if ($CurrentForm->hasValue("o_potensiblm")) {
            $this->potensiblm->setOldValue($CurrentForm->getValue("o_potensiblm"));
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
        if ($CurrentForm->hasValue("o_aset")) {
            $this->aset->setOldValue($CurrentForm->getValue("o_aset"));
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
        if ($CurrentForm->hasValue("o__modal")) {
            $this->_modal->setOldValue($CurrentForm->getValue("o__modal"));
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
        if ($CurrentForm->hasValue("o_hasilsetahun")) {
            $this->hasilsetahun->setOldValue($CurrentForm->getValue("o_hasilsetahun"));
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
        if ($CurrentForm->hasValue("o_kendala")) {
            $this->kendala->setOldValue($CurrentForm->getValue("o_kendala"));
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
        if ($CurrentForm->hasValue("o_fasilitasperlu")) {
            $this->fasilitasperlu->setOldValue($CurrentForm->getValue("o_fasilitasperlu"));
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id->CurrentValue = $this->id->FormValue;
        }
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

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
        $this->foto->Upload->Index = $this->RowIndex;
        $this->dokumen->Upload->DbValue = $row['dokumen'];
        $this->dokumen->setDbValue($this->dokumen->Upload->DbValue);
        $this->dokumen->Upload->Index = $this->RowIndex;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

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
        $this->dokumen->CellCssStyle = "white-space: nowrap;";
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

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

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
            // id

            // pid
            $this->pid->EditAttrs["class"] = "form-control";
            $this->pid->EditCustomAttributes = "";
            if ($this->pid->getSessionValue() != "") {
                $this->pid->CurrentValue = GetForeignKeyValue($this->pid->getSessionValue());
                $this->pid->OldValue = $this->pid->CurrentValue;
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
                if ($this->RowIndex == '$rowindex$') {
                    $this->foto->Upload->FileName = "";
                } else {
                    $this->foto->Upload->FileName = $this->foto->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->foto, $this->RowIndex);
            }

            // Add refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

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
                $this->pid->OldValue = $this->pid->CurrentValue;
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
                if ($this->RowIndex == '$rowindex$') {
                    $this->foto->Upload->FileName = "";
                } else {
                    $this->foto->Upload->FileName = $this->foto->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->foto, $this->RowIndex);
            }

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['id'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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

            // namausaha
            $this->namausaha->setDbValueDef($rsnew, $this->namausaha->CurrentValue, null, $this->namausaha->ReadOnly);

            // bidangusaha
            $this->bidangusaha->setDbValueDef($rsnew, $this->bidangusaha->CurrentValue, null, $this->bidangusaha->ReadOnly);

            // badanhukum
            $this->badanhukum->setDbValueDef($rsnew, $this->badanhukum->CurrentValue, null, $this->badanhukum->ReadOnly);

            // siup
            $this->siup->setDbValueDef($rsnew, $this->siup->CurrentValue, null, $this->siup->ReadOnly);

            // bpom
            $this->bpom->setDbValueDef($rsnew, $this->bpom->CurrentValue, null, $this->bpom->ReadOnly);

            // irt
            $this->irt->setDbValueDef($rsnew, $this->irt->CurrentValue, null, $this->irt->ReadOnly);

            // potensiblm
            $this->potensiblm->setDbValueDef($rsnew, $this->potensiblm->CurrentValue, null, $this->potensiblm->ReadOnly);

            // aset
            $this->aset->setDbValueDef($rsnew, $this->aset->CurrentValue, null, $this->aset->ReadOnly);

            // modal
            $this->_modal->setDbValueDef($rsnew, $this->_modal->CurrentValue, null, $this->_modal->ReadOnly);

            // hasilsetahun
            $this->hasilsetahun->setDbValueDef($rsnew, $this->hasilsetahun->CurrentValue, null, $this->hasilsetahun->ReadOnly);

            // kendala
            $this->kendala->setDbValueDef($rsnew, $this->kendala->CurrentValue, null, $this->kendala->ReadOnly);

            // fasilitasperlu
            $this->fasilitasperlu->setDbValueDef($rsnew, $this->fasilitasperlu->CurrentValue, null, $this->fasilitasperlu->ReadOnly);

            // foto
            if ($this->foto->Visible && !$this->foto->ReadOnly && !$this->foto->Upload->KeepFile) {
                $this->foto->Upload->DbValue = $rsold['foto']; // Get original value
                if ($this->foto->Upload->FileName == "") {
                    $rsnew['foto'] = null;
                } else {
                    $rsnew['foto'] = $this->foto->Upload->FileName;
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
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "pesantren") {
            $this->pid->CurrentValue = $this->pid->getSessionValue();
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
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "pesantren") {
            $masterTbl = Container("pesantren");
            $this->pid->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }
}
