<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for pengasuhppwanita
 */
class Pengasuhppwanita extends DbTable
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
    public $nama;
    public $nik;
    public $alamat;
    public $hp;
    public $md;
    public $mts;
    public $ma;
    public $pesantren;
    public $s1;
    public $s2;
    public $s3;
    public $organisasi;
    public $jabatandiorganisasi;
    public $tglawalorganisasi;
    public $tglakhirorganisasi;
    public $pemerintah;
    public $jabatandipemerintah;
    public $tglmenjabat;
    public $tglakhirjabatan;
    public $foto;
    public $ijazah;
    public $sertifikat;
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
        $this->TableVar = 'pengasuhppwanita';
        $this->TableName = 'pengasuhppwanita';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`pengasuhppwanita`";
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
        $this->id = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // pid
        $this->pid = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_pid', 'pid', '`pid`', '`pid`', 3, 11, -1, false, '`pid`', false, false, false, 'FORMATTED TEXT', 'TEXT');
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

        // nama
        $this->nama = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // nik
        $this->nik = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_nik', 'nik', '`nik`', '`nik`', 200, 255, -1, false, '`nik`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nik->Sortable = true; // Allow sort
        $this->nik->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nik->Param, "CustomMsg");
        $this->Fields['nik'] = &$this->nik;

        // alamat
        $this->alamat = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, 255, -1, false, '`alamat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamat->Sortable = true; // Allow sort
        $this->alamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat->Param, "CustomMsg");
        $this->Fields['alamat'] = &$this->alamat;

        // hp
        $this->hp = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_hp', 'hp', '`hp`', '`hp`', 200, 255, -1, false, '`hp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->hp->Sortable = true; // Allow sort
        $this->hp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->hp->Param, "CustomMsg");
        $this->Fields['hp'] = &$this->hp;

        // md
        $this->md = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_md', 'md', '`md`', '`md`', 200, 255, -1, false, '`md`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->md->Sortable = true; // Allow sort
        $this->md->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->md->Param, "CustomMsg");
        $this->Fields['md'] = &$this->md;

        // mts
        $this->mts = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_mts', 'mts', '`mts`', '`mts`', 200, 255, -1, false, '`mts`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->mts->Sortable = true; // Allow sort
        $this->mts->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->mts->Param, "CustomMsg");
        $this->Fields['mts'] = &$this->mts;

        // ma
        $this->ma = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_ma', 'ma', '`ma`', '`ma`', 200, 255, -1, false, '`ma`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ma->Sortable = true; // Allow sort
        $this->ma->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ma->Param, "CustomMsg");
        $this->Fields['ma'] = &$this->ma;

        // pesantren
        $this->pesantren = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_pesantren', 'pesantren', '`pesantren`', '`pesantren`', 200, 255, -1, false, '`pesantren`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pesantren->Sortable = true; // Allow sort
        $this->pesantren->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pesantren->Param, "CustomMsg");
        $this->Fields['pesantren'] = &$this->pesantren;

        // s1
        $this->s1 = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_s1', 's1', '`s1`', '`s1`', 200, 255, -1, false, '`s1`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->s1->Sortable = true; // Allow sort
        $this->s1->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->s1->Param, "CustomMsg");
        $this->Fields['s1'] = &$this->s1;

        // s2
        $this->s2 = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_s2', 's2', '`s2`', '`s2`', 200, 255, -1, false, '`s2`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->s2->Sortable = true; // Allow sort
        $this->s2->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->s2->Param, "CustomMsg");
        $this->Fields['s2'] = &$this->s2;

        // s3
        $this->s3 = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_s3', 's3', '`s3`', '`s3`', 200, 255, -1, false, '`s3`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->s3->Sortable = true; // Allow sort
        $this->s3->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->s3->Param, "CustomMsg");
        $this->Fields['s3'] = &$this->s3;

        // organisasi
        $this->organisasi = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_organisasi', 'organisasi', '`organisasi`', '`organisasi`', 200, 255, -1, false, '`organisasi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->organisasi->Sortable = true; // Allow sort
        $this->organisasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->organisasi->Param, "CustomMsg");
        $this->Fields['organisasi'] = &$this->organisasi;

        // jabatandiorganisasi
        $this->jabatandiorganisasi = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_jabatandiorganisasi', 'jabatandiorganisasi', '`jabatandiorganisasi`', '`jabatandiorganisasi`', 200, 255, -1, false, '`jabatandiorganisasi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jabatandiorganisasi->Sortable = true; // Allow sort
        $this->jabatandiorganisasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jabatandiorganisasi->Param, "CustomMsg");
        $this->Fields['jabatandiorganisasi'] = &$this->jabatandiorganisasi;

        // tglawalorganisasi
        $this->tglawalorganisasi = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_tglawalorganisasi', 'tglawalorganisasi', '`tglawalorganisasi`', CastDateFieldForLike("`tglawalorganisasi`", 7, "DB"), 133, 10, 7, false, '`tglawalorganisasi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglawalorganisasi->Sortable = true; // Allow sort
        $this->tglawalorganisasi->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tglawalorganisasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglawalorganisasi->Param, "CustomMsg");
        $this->Fields['tglawalorganisasi'] = &$this->tglawalorganisasi;

        // tglakhirorganisasi
        $this->tglakhirorganisasi = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_tglakhirorganisasi', 'tglakhirorganisasi', '`tglakhirorganisasi`', CastDateFieldForLike("`tglakhirorganisasi`", 0, "DB"), 133, 10, 0, false, '`tglakhirorganisasi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglakhirorganisasi->Sortable = false; // Allow sort
        $this->tglakhirorganisasi->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglakhirorganisasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglakhirorganisasi->Param, "CustomMsg");
        $this->Fields['tglakhirorganisasi'] = &$this->tglakhirorganisasi;

        // pemerintah
        $this->pemerintah = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_pemerintah', 'pemerintah', '`pemerintah`', '`pemerintah`', 200, 255, -1, false, '`pemerintah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pemerintah->Sortable = true; // Allow sort
        $this->pemerintah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pemerintah->Param, "CustomMsg");
        $this->Fields['pemerintah'] = &$this->pemerintah;

        // jabatandipemerintah
        $this->jabatandipemerintah = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_jabatandipemerintah', 'jabatandipemerintah', '`jabatandipemerintah`', '`jabatandipemerintah`', 200, 255, -1, false, '`jabatandipemerintah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jabatandipemerintah->Sortable = true; // Allow sort
        $this->jabatandipemerintah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jabatandipemerintah->Param, "CustomMsg");
        $this->Fields['jabatandipemerintah'] = &$this->jabatandipemerintah;

        // tglmenjabat
        $this->tglmenjabat = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_tglmenjabat', 'tglmenjabat', '`tglmenjabat`', CastDateFieldForLike("`tglmenjabat`", 0, "DB"), 133, 10, 0, false, '`tglmenjabat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglmenjabat->Sortable = true; // Allow sort
        $this->tglmenjabat->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglmenjabat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglmenjabat->Param, "CustomMsg");
        $this->Fields['tglmenjabat'] = &$this->tglmenjabat;

        // tglakhirjabatan
        $this->tglakhirjabatan = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_tglakhirjabatan', 'tglakhirjabatan', '`tglakhirjabatan`', CastDateFieldForLike("`tglakhirjabatan`", 0, "DB"), 133, 10, 0, false, '`tglakhirjabatan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglakhirjabatan->Sortable = false; // Allow sort
        $this->tglakhirjabatan->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglakhirjabatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglakhirjabatan->Param, "CustomMsg");
        $this->Fields['tglakhirjabatan'] = &$this->tglakhirjabatan;

        // foto
        $this->foto = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_foto', 'foto', '`foto`', '`foto`', 200, 255, -1, true, '`foto`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->foto->Sortable = true; // Allow sort
        $this->foto->UploadMultiple = true;
        $this->foto->Upload->UploadMultiple = true;
        $this->foto->UploadMaxFileCount = 0;
        $this->foto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto->Param, "CustomMsg");
        $this->Fields['foto'] = &$this->foto;

        // ijazah
        $this->ijazah = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_ijazah', 'ijazah', '`ijazah`', '`ijazah`', 200, 255, -1, true, '`ijazah`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->ijazah->Sortable = true; // Allow sort
        $this->ijazah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ijazah->Param, "CustomMsg");
        $this->Fields['ijazah'] = &$this->ijazah;

        // sertifikat
        $this->sertifikat = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_sertifikat', 'sertifikat', '`sertifikat`', '`sertifikat`', 200, 255, -1, true, '`sertifikat`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->sertifikat->Sortable = true; // Allow sort
        $this->sertifikat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sertifikat->Param, "CustomMsg");
        $this->Fields['sertifikat'] = &$this->sertifikat;

        // dokumen
        $this->dokumen = new DbField('pengasuhppwanita', 'pengasuhppwanita', 'x_dokumen', 'dokumen', '`dokumen`', '`dokumen`', 200, 255, -1, true, '`dokumen`', false, false, false, 'FORMATTED TEXT', 'FILE');
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`pengasuhppwanita`";
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
        $this->nama->DbValue = $row['nama'];
        $this->nik->DbValue = $row['nik'];
        $this->alamat->DbValue = $row['alamat'];
        $this->hp->DbValue = $row['hp'];
        $this->md->DbValue = $row['md'];
        $this->mts->DbValue = $row['mts'];
        $this->ma->DbValue = $row['ma'];
        $this->pesantren->DbValue = $row['pesantren'];
        $this->s1->DbValue = $row['s1'];
        $this->s2->DbValue = $row['s2'];
        $this->s3->DbValue = $row['s3'];
        $this->organisasi->DbValue = $row['organisasi'];
        $this->jabatandiorganisasi->DbValue = $row['jabatandiorganisasi'];
        $this->tglawalorganisasi->DbValue = $row['tglawalorganisasi'];
        $this->tglakhirorganisasi->DbValue = $row['tglakhirorganisasi'];
        $this->pemerintah->DbValue = $row['pemerintah'];
        $this->jabatandipemerintah->DbValue = $row['jabatandipemerintah'];
        $this->tglmenjabat->DbValue = $row['tglmenjabat'];
        $this->tglakhirjabatan->DbValue = $row['tglakhirjabatan'];
        $this->foto->Upload->DbValue = $row['foto'];
        $this->ijazah->Upload->DbValue = $row['ijazah'];
        $this->sertifikat->Upload->DbValue = $row['sertifikat'];
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
        $oldFiles = EmptyValue($row['ijazah']) ? [] : [$row['ijazah']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->ijazah->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->ijazah->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['sertifikat']) ? [] : [$row['sertifikat']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->sertifikat->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->sertifikat->oldPhysicalUploadPath() . $oldFile);
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
        return $_SESSION[$name] ?? GetUrl("PengasuhppwanitaList");
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
        if ($pageName == "PengasuhppwanitaView") {
            return $Language->phrase("View");
        } elseif ($pageName == "PengasuhppwanitaEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "PengasuhppwanitaAdd") {
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
                return "PengasuhppwanitaView";
            case Config("API_ADD_ACTION"):
                return "PengasuhppwanitaAdd";
            case Config("API_EDIT_ACTION"):
                return "PengasuhppwanitaEdit";
            case Config("API_DELETE_ACTION"):
                return "PengasuhppwanitaDelete";
            case Config("API_LIST_ACTION"):
                return "PengasuhppwanitaList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "PengasuhppwanitaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PengasuhppwanitaView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PengasuhppwanitaView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PengasuhppwanitaAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "PengasuhppwanitaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("PengasuhppwanitaEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("PengasuhppwanitaAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("PengasuhppwanitaDelete", $this->getUrlParm());
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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
        $this->tglakhirorganisasi->CellCssStyle = "white-space: nowrap;";

        // pemerintah

        // jabatandipemerintah

        // tglmenjabat

        // tglakhirjabatan
        $this->tglakhirjabatan->CellCssStyle = "white-space: nowrap;";

        // foto

        // ijazah

        // sertifikat

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

        // tglakhirorganisasi
        $this->tglakhirorganisasi->ViewValue = $this->tglakhirorganisasi->CurrentValue;
        $this->tglakhirorganisasi->ViewValue = FormatDateTime($this->tglakhirorganisasi->ViewValue, 0);
        $this->tglakhirorganisasi->ViewCustomAttributes = "";

        // pemerintah
        $this->pemerintah->ViewValue = $this->pemerintah->CurrentValue;
        $this->pemerintah->ViewCustomAttributes = "";

        // jabatandipemerintah
        $this->jabatandipemerintah->ViewValue = $this->jabatandipemerintah->CurrentValue;
        $this->jabatandipemerintah->ViewCustomAttributes = "";

        // tglmenjabat
        $this->tglmenjabat->ViewValue = $this->tglmenjabat->CurrentValue;
        $this->tglmenjabat->ViewValue = FormatDateTime($this->tglmenjabat->ViewValue, 0);
        $this->tglmenjabat->ViewCustomAttributes = "";

        // tglakhirjabatan
        $this->tglakhirjabatan->ViewValue = $this->tglakhirjabatan->CurrentValue;
        $this->tglakhirjabatan->ViewValue = FormatDateTime($this->tglakhirjabatan->ViewValue, 0);
        $this->tglakhirjabatan->ViewCustomAttributes = "";

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

        // tglakhirorganisasi
        $this->tglakhirorganisasi->LinkCustomAttributes = "";
        $this->tglakhirorganisasi->HrefValue = "";
        $this->tglakhirorganisasi->TooltipValue = "";

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

        // tglakhirjabatan
        $this->tglakhirjabatan->LinkCustomAttributes = "";
        $this->tglakhirjabatan->HrefValue = "";
        $this->tglakhirjabatan->TooltipValue = "";

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

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;

        // nik
        $this->nik->EditAttrs["class"] = "form-control";
        $this->nik->EditCustomAttributes = "";
        if (!$this->nik->Raw) {
            $this->nik->CurrentValue = HtmlDecode($this->nik->CurrentValue);
        }
        $this->nik->EditValue = $this->nik->CurrentValue;

        // alamat
        $this->alamat->EditAttrs["class"] = "form-control";
        $this->alamat->EditCustomAttributes = "";
        if (!$this->alamat->Raw) {
            $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
        }
        $this->alamat->EditValue = $this->alamat->CurrentValue;

        // hp
        $this->hp->EditAttrs["class"] = "form-control";
        $this->hp->EditCustomAttributes = "";
        if (!$this->hp->Raw) {
            $this->hp->CurrentValue = HtmlDecode($this->hp->CurrentValue);
        }
        $this->hp->EditValue = $this->hp->CurrentValue;

        // md
        $this->md->EditAttrs["class"] = "form-control";
        $this->md->EditCustomAttributes = "";
        if (!$this->md->Raw) {
            $this->md->CurrentValue = HtmlDecode($this->md->CurrentValue);
        }
        $this->md->EditValue = $this->md->CurrentValue;

        // mts
        $this->mts->EditAttrs["class"] = "form-control";
        $this->mts->EditCustomAttributes = "";
        if (!$this->mts->Raw) {
            $this->mts->CurrentValue = HtmlDecode($this->mts->CurrentValue);
        }
        $this->mts->EditValue = $this->mts->CurrentValue;

        // ma
        $this->ma->EditAttrs["class"] = "form-control";
        $this->ma->EditCustomAttributes = "";
        if (!$this->ma->Raw) {
            $this->ma->CurrentValue = HtmlDecode($this->ma->CurrentValue);
        }
        $this->ma->EditValue = $this->ma->CurrentValue;

        // pesantren
        $this->pesantren->EditAttrs["class"] = "form-control";
        $this->pesantren->EditCustomAttributes = "";
        if (!$this->pesantren->Raw) {
            $this->pesantren->CurrentValue = HtmlDecode($this->pesantren->CurrentValue);
        }
        $this->pesantren->EditValue = $this->pesantren->CurrentValue;

        // s1
        $this->s1->EditAttrs["class"] = "form-control";
        $this->s1->EditCustomAttributes = "";
        if (!$this->s1->Raw) {
            $this->s1->CurrentValue = HtmlDecode($this->s1->CurrentValue);
        }
        $this->s1->EditValue = $this->s1->CurrentValue;

        // s2
        $this->s2->EditAttrs["class"] = "form-control";
        $this->s2->EditCustomAttributes = "";
        if (!$this->s2->Raw) {
            $this->s2->CurrentValue = HtmlDecode($this->s2->CurrentValue);
        }
        $this->s2->EditValue = $this->s2->CurrentValue;

        // s3
        $this->s3->EditAttrs["class"] = "form-control";
        $this->s3->EditCustomAttributes = "";
        if (!$this->s3->Raw) {
            $this->s3->CurrentValue = HtmlDecode($this->s3->CurrentValue);
        }
        $this->s3->EditValue = $this->s3->CurrentValue;

        // organisasi
        $this->organisasi->EditAttrs["class"] = "form-control";
        $this->organisasi->EditCustomAttributes = "";
        if (!$this->organisasi->Raw) {
            $this->organisasi->CurrentValue = HtmlDecode($this->organisasi->CurrentValue);
        }
        $this->organisasi->EditValue = $this->organisasi->CurrentValue;

        // jabatandiorganisasi
        $this->jabatandiorganisasi->EditAttrs["class"] = "form-control";
        $this->jabatandiorganisasi->EditCustomAttributes = "";
        if (!$this->jabatandiorganisasi->Raw) {
            $this->jabatandiorganisasi->CurrentValue = HtmlDecode($this->jabatandiorganisasi->CurrentValue);
        }
        $this->jabatandiorganisasi->EditValue = $this->jabatandiorganisasi->CurrentValue;

        // tglawalorganisasi
        $this->tglawalorganisasi->EditAttrs["class"] = "form-control";
        $this->tglawalorganisasi->EditCustomAttributes = "";
        $this->tglawalorganisasi->EditValue = FormatDateTime($this->tglawalorganisasi->CurrentValue, 7);

        // tglakhirorganisasi
        $this->tglakhirorganisasi->EditAttrs["class"] = "form-control";
        $this->tglakhirorganisasi->EditCustomAttributes = "";
        $this->tglakhirorganisasi->EditValue = FormatDateTime($this->tglakhirorganisasi->CurrentValue, 8);

        // pemerintah
        $this->pemerintah->EditAttrs["class"] = "form-control";
        $this->pemerintah->EditCustomAttributes = "";
        if (!$this->pemerintah->Raw) {
            $this->pemerintah->CurrentValue = HtmlDecode($this->pemerintah->CurrentValue);
        }
        $this->pemerintah->EditValue = $this->pemerintah->CurrentValue;

        // jabatandipemerintah
        $this->jabatandipemerintah->EditAttrs["class"] = "form-control";
        $this->jabatandipemerintah->EditCustomAttributes = "";
        if (!$this->jabatandipemerintah->Raw) {
            $this->jabatandipemerintah->CurrentValue = HtmlDecode($this->jabatandipemerintah->CurrentValue);
        }
        $this->jabatandipemerintah->EditValue = $this->jabatandipemerintah->CurrentValue;

        // tglmenjabat
        $this->tglmenjabat->EditAttrs["class"] = "form-control";
        $this->tglmenjabat->EditCustomAttributes = "";
        $this->tglmenjabat->EditValue = FormatDateTime($this->tglmenjabat->CurrentValue, 8);

        // tglakhirjabatan
        $this->tglakhirjabatan->EditAttrs["class"] = "form-control";
        $this->tglakhirjabatan->EditCustomAttributes = "";
        $this->tglakhirjabatan->EditValue = FormatDateTime($this->tglakhirjabatan->CurrentValue, 8);

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
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->nik);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->hp);
                    $doc->exportCaption($this->md);
                    $doc->exportCaption($this->mts);
                    $doc->exportCaption($this->ma);
                    $doc->exportCaption($this->pesantren);
                    $doc->exportCaption($this->s1);
                    $doc->exportCaption($this->s2);
                    $doc->exportCaption($this->s3);
                    $doc->exportCaption($this->organisasi);
                    $doc->exportCaption($this->jabatandiorganisasi);
                    $doc->exportCaption($this->tglawalorganisasi);
                    $doc->exportCaption($this->pemerintah);
                    $doc->exportCaption($this->jabatandipemerintah);
                    $doc->exportCaption($this->tglmenjabat);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->ijazah);
                    $doc->exportCaption($this->sertifikat);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->pid);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->nik);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->hp);
                    $doc->exportCaption($this->md);
                    $doc->exportCaption($this->mts);
                    $doc->exportCaption($this->ma);
                    $doc->exportCaption($this->pesantren);
                    $doc->exportCaption($this->s1);
                    $doc->exportCaption($this->s2);
                    $doc->exportCaption($this->s3);
                    $doc->exportCaption($this->organisasi);
                    $doc->exportCaption($this->jabatandiorganisasi);
                    $doc->exportCaption($this->tglawalorganisasi);
                    $doc->exportCaption($this->pemerintah);
                    $doc->exportCaption($this->jabatandipemerintah);
                    $doc->exportCaption($this->tglmenjabat);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->ijazah);
                    $doc->exportCaption($this->sertifikat);
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
                        $doc->exportField($this->nama);
                        $doc->exportField($this->nik);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->hp);
                        $doc->exportField($this->md);
                        $doc->exportField($this->mts);
                        $doc->exportField($this->ma);
                        $doc->exportField($this->pesantren);
                        $doc->exportField($this->s1);
                        $doc->exportField($this->s2);
                        $doc->exportField($this->s3);
                        $doc->exportField($this->organisasi);
                        $doc->exportField($this->jabatandiorganisasi);
                        $doc->exportField($this->tglawalorganisasi);
                        $doc->exportField($this->pemerintah);
                        $doc->exportField($this->jabatandipemerintah);
                        $doc->exportField($this->tglmenjabat);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->ijazah);
                        $doc->exportField($this->sertifikat);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->pid);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->nik);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->hp);
                        $doc->exportField($this->md);
                        $doc->exportField($this->mts);
                        $doc->exportField($this->ma);
                        $doc->exportField($this->pesantren);
                        $doc->exportField($this->s1);
                        $doc->exportField($this->s2);
                        $doc->exportField($this->s3);
                        $doc->exportField($this->organisasi);
                        $doc->exportField($this->jabatandiorganisasi);
                        $doc->exportField($this->tglawalorganisasi);
                        $doc->exportField($this->pemerintah);
                        $doc->exportField($this->jabatandipemerintah);
                        $doc->exportField($this->tglmenjabat);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->ijazah);
                        $doc->exportField($this->sertifikat);
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
        } elseif ($fldparm == 'ijazah') {
            $fldName = "ijazah";
            $fileNameFld = "ijazah";
        } elseif ($fldparm == 'sertifikat') {
            $fldName = "sertifikat";
            $fileNameFld = "sertifikat";
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
