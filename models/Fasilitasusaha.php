<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for fasilitasusaha
 */
class Fasilitasusaha extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $pid;
    public $namausaha;
    public $bidangusaha;
    public $badanhukum;
    public $siup;
    public $bpom;
    public $irt;
    public $potensiblm;
    public $aset;
    public $_modal;
    public $hasilsetahun;
    public $kendala;
    public $fasilitasperlu;
    public $foto;
    public $dokumen;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'fasilitasusaha';
        $this->TableName = 'fasilitasusaha';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`fasilitasusaha`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = true; // Allow detail add
        $this->DetailEdit = true; // Allow detail edit
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // pid
        $this->pid = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_pid', 'pid', '`pid`', '`pid`', 3, 11, -1, false, '`pid`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pid->IsForeignKey = true; // Foreign key field
        $this->pid->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->pid->Lookup = new Lookup('pid', 'pesantren', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->pid->Lookup = new Lookup('pid', 'pesantren', false, 'id', ["nama","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->pid->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pid->Param, "CustomMsg");
        $this->Fields['pid'] = &$this->pid;

        // namausaha
        $this->namausaha = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_namausaha', 'namausaha', '`namausaha`', '`namausaha`', 200, 255, -1, false, '`namausaha`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namausaha->Sortable = true; // Allow sort
        $this->namausaha->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namausaha->Param, "CustomMsg");
        $this->Fields['namausaha'] = &$this->namausaha;

        // bidangusaha
        $this->bidangusaha = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_bidangusaha', 'bidangusaha', '`bidangusaha`', '`bidangusaha`', 200, 255, -1, false, '`bidangusaha`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bidangusaha->Sortable = true; // Allow sort
        $this->bidangusaha->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bidangusaha->Param, "CustomMsg");
        $this->Fields['bidangusaha'] = &$this->bidangusaha;

        // badanhukum
        $this->badanhukum = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_badanhukum', 'badanhukum', '`badanhukum`', '`badanhukum`', 200, 255, -1, false, '`badanhukum`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->badanhukum->Sortable = true; // Allow sort
        $this->badanhukum->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->badanhukum->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->badanhukum->Lookup = new Lookup('badanhukum', 'fasilitasusaha', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->badanhukum->Lookup = new Lookup('badanhukum', 'fasilitasusaha', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->badanhukum->OptionCount = 4;
        $this->badanhukum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->badanhukum->Param, "CustomMsg");
        $this->Fields['badanhukum'] = &$this->badanhukum;

        // siup
        $this->siup = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_siup', 'siup', '`siup`', '`siup`', 200, 255, -1, false, '`siup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->siup->Sortable = true; // Allow sort
        $this->siup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->siup->Param, "CustomMsg");
        $this->Fields['siup'] = &$this->siup;

        // bpom
        $this->bpom = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_bpom', 'bpom', '`bpom`', '`bpom`', 200, 255, -1, false, '`bpom`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->bpom->Sortable = true; // Allow sort
        $this->bpom->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->bpom->Param, "CustomMsg");
        $this->Fields['bpom'] = &$this->bpom;

        // irt
        $this->irt = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_irt', 'irt', '`irt`', '`irt`', 200, 255, -1, false, '`irt`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->irt->Sortable = true; // Allow sort
        $this->irt->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->irt->Param, "CustomMsg");
        $this->Fields['irt'] = &$this->irt;

        // potensiblm
        $this->potensiblm = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_potensiblm', 'potensiblm', '`potensiblm`', '`potensiblm`', 200, 255, -1, false, '`potensiblm`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->potensiblm->Sortable = true; // Allow sort
        $this->potensiblm->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->potensiblm->Param, "CustomMsg");
        $this->Fields['potensiblm'] = &$this->potensiblm;

        // aset
        $this->aset = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_aset', 'aset', '`aset`', '`aset`', 200, 255, -1, false, '`aset`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->aset->Sortable = true; // Allow sort
        $this->aset->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->aset->Param, "CustomMsg");
        $this->Fields['aset'] = &$this->aset;

        // modal
        $this->_modal = new DbField('fasilitasusaha', 'fasilitasusaha', 'x__modal', 'modal', '`modal`', '`modal`', 200, 255, -1, false, '`modal`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_modal->Sortable = true; // Allow sort
        $this->_modal->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_modal->Param, "CustomMsg");
        $this->Fields['modal'] = &$this->_modal;

        // hasilsetahun
        $this->hasilsetahun = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_hasilsetahun', 'hasilsetahun', '`hasilsetahun`', '`hasilsetahun`', 200, 255, -1, false, '`hasilsetahun`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hasilsetahun->Sortable = true; // Allow sort
        $this->hasilsetahun->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hasilsetahun->Param, "CustomMsg");
        $this->Fields['hasilsetahun'] = &$this->hasilsetahun;

        // kendala
        $this->kendala = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_kendala', 'kendala', '`kendala`', '`kendala`', 200, 255, -1, false, '`kendala`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kendala->Sortable = true; // Allow sort
        $this->kendala->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kendala->Param, "CustomMsg");
        $this->Fields['kendala'] = &$this->kendala;

        // fasilitasperlu
        $this->fasilitasperlu = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_fasilitasperlu', 'fasilitasperlu', '`fasilitasperlu`', '`fasilitasperlu`', 200, 255, -1, false, '`fasilitasperlu`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->fasilitasperlu->Sortable = true; // Allow sort
        $this->fasilitasperlu->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fasilitasperlu->Param, "CustomMsg");
        $this->Fields['fasilitasperlu'] = &$this->fasilitasperlu;

        // foto
        $this->foto = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_foto', 'foto', '`foto`', '`foto`', 200, 255, -1, true, '`foto`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->foto->Sortable = true; // Allow sort
        $this->foto->UploadMultiple = true;
        $this->foto->Upload->UploadMultiple = true;
        $this->foto->UploadMaxFileCount = 0;
        $this->foto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto->Param, "CustomMsg");
        $this->Fields['foto'] = &$this->foto;

        // dokumen
        $this->dokumen = new DbField('fasilitasusaha', 'fasilitasusaha', 'x_dokumen', 'dokumen', '`dokumen`', '`dokumen`', 200, 255, -1, true, '`dokumen`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->dokumen->Sortable = false; // Allow sort
        $this->dokumen->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dokumen->Param, "CustomMsg");
        $this->Fields['dokumen'] = &$this->dokumen;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "pesantren") {
            if ($this->pid->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id`", $this->pid->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "pesantren") {
            if ($this->pid->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`pid`", $this->pid->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_pesantren()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_pesantren()
    {
        return "`pid`=@pid@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`fasilitasusaha`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            if ($this->getCurrentMasterTable() == "pesantren" || $this->getCurrentMasterTable() == "") {
                $filter = $this->addDetailUserIDFilter($filter, "pesantren"); // Add detail User ID filter
            }
        }
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->pid->DbValue = $row['pid'];
        $this->namausaha->DbValue = $row['namausaha'];
        $this->bidangusaha->DbValue = $row['bidangusaha'];
        $this->badanhukum->DbValue = $row['badanhukum'];
        $this->siup->DbValue = $row['siup'];
        $this->bpom->DbValue = $row['bpom'];
        $this->irt->DbValue = $row['irt'];
        $this->potensiblm->DbValue = $row['potensiblm'];
        $this->aset->DbValue = $row['aset'];
        $this->_modal->DbValue = $row['modal'];
        $this->hasilsetahun->DbValue = $row['hasilsetahun'];
        $this->kendala->DbValue = $row['kendala'];
        $this->fasilitasperlu->DbValue = $row['fasilitasperlu'];
        $this->foto->Upload->DbValue = $row['foto'];
        $this->dokumen->Upload->DbValue = $row['dokumen'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['foto']) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $row['foto']);
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->foto->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['dokumen']) ? [] : [$row['dokumen']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->dokumen->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->dokumen->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("FasilitasusahaList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "FasilitasusahaView") {
            return $Language->phrase("View");
        } elseif ($pageName == "FasilitasusahaEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "FasilitasusahaAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "FasilitasusahaView";
            case Config("API_ADD_ACTION"):
                return "FasilitasusahaAdd";
            case Config("API_EDIT_ACTION"):
                return "FasilitasusahaEdit";
            case Config("API_DELETE_ACTION"):
                return "FasilitasusahaDelete";
            case Config("API_LIST_ACTION"):
                return "FasilitasusahaList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "FasilitasusahaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("FasilitasusahaView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("FasilitasusahaView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "FasilitasusahaAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "FasilitasusahaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("FasilitasusahaEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("FasilitasusahaAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("FasilitasusahaDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "pesantren" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id", $this->pid->CurrentValue ?? $this->pid->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // dokumen
        if (!EmptyValue($this->dokumen->Upload->DbValue)) {
            $this->dokumen->ViewValue = $this->dokumen->Upload->DbValue;
        } else {
            $this->dokumen->ViewValue = "";
        }
        $this->dokumen->ViewCustomAttributes = "";

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

        // dokumen
        $this->dokumen->LinkCustomAttributes = "";
        $this->dokumen->HrefValue = "";
        $this->dokumen->ExportHrefValue = $this->dokumen->UploadPath . $this->dokumen->Upload->DbValue;
        $this->dokumen->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

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
            $this->pid->EditValue = $this->pid->CurrentValue;
        }

        // namausaha
        $this->namausaha->EditAttrs["class"] = "form-control";
        $this->namausaha->EditCustomAttributes = "";
        if (!$this->namausaha->Raw) {
            $this->namausaha->CurrentValue = HtmlDecode($this->namausaha->CurrentValue);
        }
        $this->namausaha->EditValue = $this->namausaha->CurrentValue;

        // bidangusaha
        $this->bidangusaha->EditAttrs["class"] = "form-control";
        $this->bidangusaha->EditCustomAttributes = "";
        if (!$this->bidangusaha->Raw) {
            $this->bidangusaha->CurrentValue = HtmlDecode($this->bidangusaha->CurrentValue);
        }
        $this->bidangusaha->EditValue = $this->bidangusaha->CurrentValue;

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
        $this->siup->EditValue = $this->siup->CurrentValue;

        // bpom
        $this->bpom->EditAttrs["class"] = "form-control";
        $this->bpom->EditCustomAttributes = "";
        if (!$this->bpom->Raw) {
            $this->bpom->CurrentValue = HtmlDecode($this->bpom->CurrentValue);
        }
        $this->bpom->EditValue = $this->bpom->CurrentValue;

        // irt
        $this->irt->EditAttrs["class"] = "form-control";
        $this->irt->EditCustomAttributes = "";
        if (!$this->irt->Raw) {
            $this->irt->CurrentValue = HtmlDecode($this->irt->CurrentValue);
        }
        $this->irt->EditValue = $this->irt->CurrentValue;

        // potensiblm
        $this->potensiblm->EditAttrs["class"] = "form-control";
        $this->potensiblm->EditCustomAttributes = "";
        if (!$this->potensiblm->Raw) {
            $this->potensiblm->CurrentValue = HtmlDecode($this->potensiblm->CurrentValue);
        }
        $this->potensiblm->EditValue = $this->potensiblm->CurrentValue;

        // aset
        $this->aset->EditAttrs["class"] = "form-control";
        $this->aset->EditCustomAttributes = "";
        if (!$this->aset->Raw) {
            $this->aset->CurrentValue = HtmlDecode($this->aset->CurrentValue);
        }
        $this->aset->EditValue = $this->aset->CurrentValue;

        // modal
        $this->_modal->EditAttrs["class"] = "form-control";
        $this->_modal->EditCustomAttributes = "";
        if (!$this->_modal->Raw) {
            $this->_modal->CurrentValue = HtmlDecode($this->_modal->CurrentValue);
        }
        $this->_modal->EditValue = $this->_modal->CurrentValue;

        // hasilsetahun
        $this->hasilsetahun->EditAttrs["class"] = "form-control";
        $this->hasilsetahun->EditCustomAttributes = "";
        if (!$this->hasilsetahun->Raw) {
            $this->hasilsetahun->CurrentValue = HtmlDecode($this->hasilsetahun->CurrentValue);
        }
        $this->hasilsetahun->EditValue = $this->hasilsetahun->CurrentValue;

        // kendala
        $this->kendala->EditAttrs["class"] = "form-control";
        $this->kendala->EditCustomAttributes = "";
        if (!$this->kendala->Raw) {
            $this->kendala->CurrentValue = HtmlDecode($this->kendala->CurrentValue);
        }
        $this->kendala->EditValue = $this->kendala->CurrentValue;

        // fasilitasperlu
        $this->fasilitasperlu->EditAttrs["class"] = "form-control";
        $this->fasilitasperlu->EditCustomAttributes = "";
        $this->fasilitasperlu->EditValue = $this->fasilitasperlu->CurrentValue;

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

        // dokumen
        $this->dokumen->EditAttrs["class"] = "form-control";
        $this->dokumen->EditCustomAttributes = "";
        if (!EmptyValue($this->dokumen->Upload->DbValue)) {
            $this->dokumen->EditValue = $this->dokumen->Upload->DbValue;
        } else {
            $this->dokumen->EditValue = "";
        }
        if (!EmptyValue($this->dokumen->CurrentValue)) {
            $this->dokumen->Upload->FileName = $this->dokumen->CurrentValue;
        }

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->pid);
                    $doc->exportCaption($this->namausaha);
                    $doc->exportCaption($this->bidangusaha);
                    $doc->exportCaption($this->badanhukum);
                    $doc->exportCaption($this->siup);
                    $doc->exportCaption($this->bpom);
                    $doc->exportCaption($this->irt);
                    $doc->exportCaption($this->potensiblm);
                    $doc->exportCaption($this->aset);
                    $doc->exportCaption($this->_modal);
                    $doc->exportCaption($this->hasilsetahun);
                    $doc->exportCaption($this->kendala);
                    $doc->exportCaption($this->fasilitasperlu);
                    $doc->exportCaption($this->foto);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->pid);
                    $doc->exportCaption($this->namausaha);
                    $doc->exportCaption($this->bidangusaha);
                    $doc->exportCaption($this->badanhukum);
                    $doc->exportCaption($this->siup);
                    $doc->exportCaption($this->bpom);
                    $doc->exportCaption($this->irt);
                    $doc->exportCaption($this->potensiblm);
                    $doc->exportCaption($this->aset);
                    $doc->exportCaption($this->_modal);
                    $doc->exportCaption($this->hasilsetahun);
                    $doc->exportCaption($this->kendala);
                    $doc->exportCaption($this->fasilitasperlu);
                    $doc->exportCaption($this->foto);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id);
                        $doc->exportField($this->pid);
                        $doc->exportField($this->namausaha);
                        $doc->exportField($this->bidangusaha);
                        $doc->exportField($this->badanhukum);
                        $doc->exportField($this->siup);
                        $doc->exportField($this->bpom);
                        $doc->exportField($this->irt);
                        $doc->exportField($this->potensiblm);
                        $doc->exportField($this->aset);
                        $doc->exportField($this->_modal);
                        $doc->exportField($this->hasilsetahun);
                        $doc->exportField($this->kendala);
                        $doc->exportField($this->fasilitasperlu);
                        $doc->exportField($this->foto);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->pid);
                        $doc->exportField($this->namausaha);
                        $doc->exportField($this->bidangusaha);
                        $doc->exportField($this->badanhukum);
                        $doc->exportField($this->siup);
                        $doc->exportField($this->bpom);
                        $doc->exportField($this->irt);
                        $doc->exportField($this->potensiblm);
                        $doc->exportField($this->aset);
                        $doc->exportField($this->_modal);
                        $doc->exportField($this->hasilsetahun);
                        $doc->exportField($this->kendala);
                        $doc->exportField($this->fasilitasperlu);
                        $doc->exportField($this->foto);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Add master User ID filter
    public function addMasterUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "pesantren") {
            $filterWrk = Container("pesantren")->addUserIDFilter($filterWrk);
        }
        return $filterWrk;
    }

    // Add detail User ID filter
    public function addDetailUserIDFilter($filter, $currentMasterTable)
    {
        $filterWrk = $filter;
        if ($currentMasterTable == "pesantren") {
            $mastertable = Container("pesantren");
            if (!$mastertable->userIdAllow()) {
                $subqueryWrk = $mastertable->getUserIDSubquery($this->pid, $mastertable->id);
                AddFilter($filterWrk, $subqueryWrk);
            }
        }
        return $filterWrk;
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'foto') {
            $fldName = "foto";
            $fileNameFld = "foto";
        } elseif ($fldparm == 'dokumen') {
            $fldName = "dokumen";
            $fileNameFld = "dokumen";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
