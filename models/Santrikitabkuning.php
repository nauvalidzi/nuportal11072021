<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for santrikitabkuning
 */
class Santrikitabkuning extends DbTable
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
    public $santri;
    public $nik;
    public $kk;
    public $alamat;
    public $ortu;
    public $mulaimasuk;
    public $kitabselesai;
    public $keterangan;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'santrikitabkuning';
        $this->TableName = 'santrikitabkuning';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`santrikitabkuning`";
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
        $this->id = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // pid
        $this->pid = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_pid', 'pid', '`pid`', '`pid`', 3, 11, -1, false, '`pid`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pid->IsForeignKey = true; // Foreign key field
        $this->pid->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->pid->Lookup = new Lookup('pid', 'kitabkuning', false, 'id', ["metode","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->pid->Lookup = new Lookup('pid', 'kitabkuning', false, 'id', ["metode","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->pid->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->pid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pid->Param, "CustomMsg");
        $this->Fields['pid'] = &$this->pid;

        // santri
        $this->santri = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_santri', 'santri', '`santri`', '`santri`', 200, 255, -1, false, '`santri`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->santri->Sortable = true; // Allow sort
        $this->santri->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->santri->Param, "CustomMsg");
        $this->Fields['santri'] = &$this->santri;

        // nik
        $this->nik = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_nik', 'nik', '`nik`', '`nik`', 200, 255, -1, false, '`nik`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nik->Sortable = true; // Allow sort
        $this->nik->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nik->Param, "CustomMsg");
        $this->Fields['nik'] = &$this->nik;

        // kk
        $this->kk = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_kk', 'kk', '`kk`', '`kk`', 200, 255, -1, false, '`kk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kk->Sortable = true; // Allow sort
        $this->kk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kk->Param, "CustomMsg");
        $this->Fields['kk'] = &$this->kk;

        // alamat
        $this->alamat = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, 255, -1, false, '`alamat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamat->Sortable = true; // Allow sort
        $this->alamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat->Param, "CustomMsg");
        $this->Fields['alamat'] = &$this->alamat;

        // ortu
        $this->ortu = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_ortu', 'ortu', '`ortu`', '`ortu`', 200, 255, -1, false, '`ortu`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ortu->Sortable = true; // Allow sort
        $this->ortu->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ortu->Param, "CustomMsg");
        $this->Fields['ortu'] = &$this->ortu;

        // mulaimasuk
        $this->mulaimasuk = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_mulaimasuk', 'mulaimasuk', '`mulaimasuk`', CastDateFieldForLike("`mulaimasuk`", 7, "DB"), 133, 10, 7, false, '`mulaimasuk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->mulaimasuk->Sortable = true; // Allow sort
        $this->mulaimasuk->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->mulaimasuk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->mulaimasuk->Param, "CustomMsg");
        $this->Fields['mulaimasuk'] = &$this->mulaimasuk;

        // kitabselesai
        $this->kitabselesai = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_kitabselesai', 'kitabselesai', '`kitabselesai`', '`kitabselesai`', 200, 255, -1, false, '`kitabselesai`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->kitabselesai->Sortable = true; // Allow sort
        $this->kitabselesai->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->kitabselesai->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->kitabselesai->Lookup = new Lookup('kitabselesai', 'santrikitabkuning', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->kitabselesai->Lookup = new Lookup('kitabselesai', 'santrikitabkuning', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->kitabselesai->OptionCount = 4;
        $this->kitabselesai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kitabselesai->Param, "CustomMsg");
        $this->Fields['kitabselesai'] = &$this->kitabselesai;

        // keterangan
        $this->keterangan = new DbField('santrikitabkuning', 'santrikitabkuning', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, 255, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;
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
        if ($this->getCurrentMasterTable() == "kitabkuning") {
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
        if ($this->getCurrentMasterTable() == "kitabkuning") {
            if ($this->pid->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`pid`", $this->pid->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_kitabkuning()
    {
        return "`id`=@id@";
    }
    // Detail filter
    public function sqlDetailFilter_kitabkuning()
    {
        return "`pid`=@pid@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`santrikitabkuning`";
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
        $this->santri->DbValue = $row['santri'];
        $this->nik->DbValue = $row['nik'];
        $this->kk->DbValue = $row['kk'];
        $this->alamat->DbValue = $row['alamat'];
        $this->ortu->DbValue = $row['ortu'];
        $this->mulaimasuk->DbValue = $row['mulaimasuk'];
        $this->kitabselesai->DbValue = $row['kitabselesai'];
        $this->keterangan->DbValue = $row['keterangan'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
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
        return $_SESSION[$name] ?? GetUrl("SantrikitabkuningList");
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
        if ($pageName == "SantrikitabkuningView") {
            return $Language->phrase("View");
        } elseif ($pageName == "SantrikitabkuningEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "SantrikitabkuningAdd") {
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
                return "SantrikitabkuningView";
            case Config("API_ADD_ACTION"):
                return "SantrikitabkuningAdd";
            case Config("API_EDIT_ACTION"):
                return "SantrikitabkuningEdit";
            case Config("API_DELETE_ACTION"):
                return "SantrikitabkuningDelete";
            case Config("API_LIST_ACTION"):
                return "SantrikitabkuningList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "SantrikitabkuningList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("SantrikitabkuningView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SantrikitabkuningView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "SantrikitabkuningAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "SantrikitabkuningAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("SantrikitabkuningEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("SantrikitabkuningAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("SantrikitabkuningDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "kitabkuning" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
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
        $this->santri->setDbValue($row['santri']);
        $this->nik->setDbValue($row['nik']);
        $this->kk->setDbValue($row['kk']);
        $this->alamat->setDbValue($row['alamat']);
        $this->ortu->setDbValue($row['ortu']);
        $this->mulaimasuk->setDbValue($row['mulaimasuk']);
        $this->kitabselesai->setDbValue($row['kitabselesai']);
        $this->keterangan->setDbValue($row['keterangan']);
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

        // santri

        // nik

        // kk

        // alamat

        // ortu

        // mulaimasuk

        // kitabselesai

        // keterangan

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewValue = FormatNumber($this->id->ViewValue, 0, -2, -2, -2);
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

        // santri
        $this->santri->ViewValue = $this->santri->CurrentValue;
        $this->santri->ViewCustomAttributes = "";

        // nik
        $this->nik->ViewValue = $this->nik->CurrentValue;
        $this->nik->ViewCustomAttributes = "";

        // kk
        $this->kk->ViewValue = $this->kk->CurrentValue;
        $this->kk->ViewCustomAttributes = "";

        // alamat
        $this->alamat->ViewValue = $this->alamat->CurrentValue;
        $this->alamat->ViewCustomAttributes = "";

        // ortu
        $this->ortu->ViewValue = $this->ortu->CurrentValue;
        $this->ortu->ViewCustomAttributes = "";

        // mulaimasuk
        $this->mulaimasuk->ViewValue = $this->mulaimasuk->CurrentValue;
        $this->mulaimasuk->ViewValue = FormatDateTime($this->mulaimasuk->ViewValue, 7);
        $this->mulaimasuk->ViewCustomAttributes = "";

        // kitabselesai
        if (strval($this->kitabselesai->CurrentValue) != "") {
            $this->kitabselesai->ViewValue = $this->kitabselesai->optionCaption($this->kitabselesai->CurrentValue);
        } else {
            $this->kitabselesai->ViewValue = null;
        }
        $this->kitabselesai->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // pid
        $this->pid->LinkCustomAttributes = "";
        $this->pid->HrefValue = "";
        $this->pid->TooltipValue = "";

        // santri
        $this->santri->LinkCustomAttributes = "";
        $this->santri->HrefValue = "";
        $this->santri->TooltipValue = "";

        // nik
        $this->nik->LinkCustomAttributes = "";
        $this->nik->HrefValue = "";
        $this->nik->TooltipValue = "";

        // kk
        $this->kk->LinkCustomAttributes = "";
        $this->kk->HrefValue = "";
        $this->kk->TooltipValue = "";

        // alamat
        $this->alamat->LinkCustomAttributes = "";
        $this->alamat->HrefValue = "";
        $this->alamat->TooltipValue = "";

        // ortu
        $this->ortu->LinkCustomAttributes = "";
        $this->ortu->HrefValue = "";
        $this->ortu->TooltipValue = "";

        // mulaimasuk
        $this->mulaimasuk->LinkCustomAttributes = "";
        $this->mulaimasuk->HrefValue = "";
        $this->mulaimasuk->TooltipValue = "";

        // kitabselesai
        $this->kitabselesai->LinkCustomAttributes = "";
        $this->kitabselesai->HrefValue = "";
        $this->kitabselesai->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

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
        $this->id->EditValue = FormatNumber($this->id->EditValue, 0, -2, -2, -2);
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

        // santri
        $this->santri->EditAttrs["class"] = "form-control";
        $this->santri->EditCustomAttributes = "";
        if (!$this->santri->Raw) {
            $this->santri->CurrentValue = HtmlDecode($this->santri->CurrentValue);
        }
        $this->santri->EditValue = $this->santri->CurrentValue;

        // nik
        $this->nik->EditAttrs["class"] = "form-control";
        $this->nik->EditCustomAttributes = "";
        if (!$this->nik->Raw) {
            $this->nik->CurrentValue = HtmlDecode($this->nik->CurrentValue);
        }
        $this->nik->EditValue = $this->nik->CurrentValue;

        // kk
        $this->kk->EditAttrs["class"] = "form-control";
        $this->kk->EditCustomAttributes = "";
        if (!$this->kk->Raw) {
            $this->kk->CurrentValue = HtmlDecode($this->kk->CurrentValue);
        }
        $this->kk->EditValue = $this->kk->CurrentValue;

        // alamat
        $this->alamat->EditAttrs["class"] = "form-control";
        $this->alamat->EditCustomAttributes = "";
        if (!$this->alamat->Raw) {
            $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
        }
        $this->alamat->EditValue = $this->alamat->CurrentValue;

        // ortu
        $this->ortu->EditAttrs["class"] = "form-control";
        $this->ortu->EditCustomAttributes = "";
        if (!$this->ortu->Raw) {
            $this->ortu->CurrentValue = HtmlDecode($this->ortu->CurrentValue);
        }
        $this->ortu->EditValue = $this->ortu->CurrentValue;

        // mulaimasuk
        $this->mulaimasuk->EditAttrs["class"] = "form-control";
        $this->mulaimasuk->EditCustomAttributes = "";
        $this->mulaimasuk->EditValue = FormatDateTime($this->mulaimasuk->CurrentValue, 7);

        // kitabselesai
        $this->kitabselesai->EditAttrs["class"] = "form-control";
        $this->kitabselesai->EditCustomAttributes = "";
        $this->kitabselesai->EditValue = $this->kitabselesai->options(true);

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;

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
                    $doc->exportCaption($this->santri);
                    $doc->exportCaption($this->nik);
                    $doc->exportCaption($this->kk);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->ortu);
                    $doc->exportCaption($this->mulaimasuk);
                    $doc->exportCaption($this->kitabselesai);
                    $doc->exportCaption($this->keterangan);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->pid);
                    $doc->exportCaption($this->santri);
                    $doc->exportCaption($this->nik);
                    $doc->exportCaption($this->kk);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->ortu);
                    $doc->exportCaption($this->mulaimasuk);
                    $doc->exportCaption($this->kitabselesai);
                    $doc->exportCaption($this->keterangan);
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
                        $doc->exportField($this->santri);
                        $doc->exportField($this->nik);
                        $doc->exportField($this->kk);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->ortu);
                        $doc->exportField($this->mulaimasuk);
                        $doc->exportField($this->kitabselesai);
                        $doc->exportField($this->keterangan);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->pid);
                        $doc->exportField($this->santri);
                        $doc->exportField($this->nik);
                        $doc->exportField($this->kk);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->ortu);
                        $doc->exportField($this->mulaimasuk);
                        $doc->exportField($this->kitabselesai);
                        $doc->exportField($this->keterangan);
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

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
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
