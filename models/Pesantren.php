<?php

namespace PHPMaker2021\nuportal;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for pesantren
 */
class Pesantren extends DbTable
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
    public $kode;
    public $nama;
    public $deskripsi;
    public $jalan;
    public $propinsi;
    public $kabupaten;
    public $kecamatan;
    public $desa;
    public $kodepos;
    public $latitude;
    public $longitude;
    public $telpon;
    public $web;
    public $_email;
    public $nspp;
    public $nspptglmulai;
    public $nspptglakhir;
    public $dokumennspp;
    public $yayasan;
    public $noakta;
    public $tglakta;
    public $namanotaris;
    public $alamatnotaris;
    public $noaktaperubahan;
    public $tglubah;
    public $namanotarisubah;
    public $alamatnotarisubah;
    public $_userid;
    public $foto;
    public $ktp;
    public $dokumen;
    public $validasi;
    public $validator;
    public $validasi_pusat;
    public $validator_pusat;
    public $created_at;
    public $updated_at;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'pesantren';
        $this->TableName = 'pesantren';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`pesantren`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_DEFAULT; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('pesantren', 'pesantren', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // kode
        $this->kode = new DbField('pesantren', 'pesantren', 'x_kode', 'kode', '`kode`', '`kode`', 200, 255, -1, false, '`kode`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kode->Sortable = true; // Allow sort
        $this->kode->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kode->Param, "CustomMsg");
        $this->Fields['kode'] = &$this->kode;

        // nama
        $this->nama = new DbField('pesantren', 'pesantren', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // deskripsi
        $this->deskripsi = new DbField('pesantren', 'pesantren', 'x_deskripsi', 'deskripsi', '`deskripsi`', '`deskripsi`', 201, 500, -1, false, '`deskripsi`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->deskripsi->Sortable = true; // Allow sort
        $this->deskripsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->deskripsi->Param, "CustomMsg");
        $this->Fields['deskripsi'] = &$this->deskripsi;

        // jalan
        $this->jalan = new DbField('pesantren', 'pesantren', 'x_jalan', 'jalan', '`jalan`', '`jalan`', 200, 255, -1, false, '`jalan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jalan->Sortable = true; // Allow sort
        $this->jalan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jalan->Param, "CustomMsg");
        $this->Fields['jalan'] = &$this->jalan;

        // propinsi
        $this->propinsi = new DbField('pesantren', 'pesantren', 'x_propinsi', 'propinsi', '`propinsi`', '`propinsi`', 200, 255, -1, false, '`propinsi`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->propinsi->Sortable = true; // Allow sort
        $this->propinsi->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->propinsi->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->propinsi->Lookup = new Lookup('propinsi', 'provinsis', false, 'id', ["name","","",""], [], ["x_kabupaten"], [], [], [], [], '', '');
                break;
            default:
                $this->propinsi->Lookup = new Lookup('propinsi', 'provinsis', false, 'id', ["name","","",""], [], ["x_kabupaten"], [], [], [], [], '', '');
                break;
        }
        $this->propinsi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->propinsi->Param, "CustomMsg");
        $this->Fields['propinsi'] = &$this->propinsi;

        // kabupaten
        $this->kabupaten = new DbField('pesantren', 'pesantren', 'x_kabupaten', 'kabupaten', '`kabupaten`', '`kabupaten`', 200, 255, -1, false, '`kabupaten`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->kabupaten->Sortable = true; // Allow sort
        $this->kabupaten->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->kabupaten->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->kabupaten->Lookup = new Lookup('kabupaten', 'kabupatens', false, 'id', ["name","","",""], ["x_propinsi"], ["x_kecamatan"], ["provinsi_id"], ["x_provinsi_id"], [], [], '', '');
                break;
            default:
                $this->kabupaten->Lookup = new Lookup('kabupaten', 'kabupatens', false, 'id', ["name","","",""], ["x_propinsi"], ["x_kecamatan"], ["provinsi_id"], ["x_provinsi_id"], [], [], '', '');
                break;
        }
        $this->kabupaten->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kabupaten->Param, "CustomMsg");
        $this->Fields['kabupaten'] = &$this->kabupaten;

        // kecamatan
        $this->kecamatan = new DbField('pesantren', 'pesantren', 'x_kecamatan', 'kecamatan', '`kecamatan`', '`kecamatan`', 200, 255, -1, false, '`kecamatan`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->kecamatan->Sortable = true; // Allow sort
        $this->kecamatan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->kecamatan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->kecamatan->Lookup = new Lookup('kecamatan', 'kecamatans', false, 'id', ["name","","",""], ["x_kabupaten"], ["x_desa"], ["kabupaten_id"], ["x_kabupaten_id"], [], [], '', '');
                break;
            default:
                $this->kecamatan->Lookup = new Lookup('kecamatan', 'kecamatans', false, 'id', ["name","","",""], ["x_kabupaten"], ["x_desa"], ["kabupaten_id"], ["x_kabupaten_id"], [], [], '', '');
                break;
        }
        $this->kecamatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kecamatan->Param, "CustomMsg");
        $this->Fields['kecamatan'] = &$this->kecamatan;

        // desa
        $this->desa = new DbField('pesantren', 'pesantren', 'x_desa', 'desa', '`desa`', '`desa`', 200, 255, -1, false, '`desa`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->desa->Sortable = true; // Allow sort
        $this->desa->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->desa->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->desa->Lookup = new Lookup('desa', 'kelurahans', false, 'id', ["name","","",""], ["x_kecamatan"], [], ["kecamatan_id"], ["x_kecamatan_id"], [], [], '', '');
                break;
            default:
                $this->desa->Lookup = new Lookup('desa', 'kelurahans', false, 'id', ["name","","",""], ["x_kecamatan"], [], ["kecamatan_id"], ["x_kecamatan_id"], [], [], '', '');
                break;
        }
        $this->desa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->desa->Param, "CustomMsg");
        $this->Fields['desa'] = &$this->desa;

        // kodepos
        $this->kodepos = new DbField('pesantren', 'pesantren', 'x_kodepos', 'kodepos', '`kodepos`', '`kodepos`', 200, 255, -1, false, '`kodepos`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodepos->Sortable = true; // Allow sort
        $this->kodepos->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodepos->Param, "CustomMsg");
        $this->Fields['kodepos'] = &$this->kodepos;

        // latitude
        $this->latitude = new DbField('pesantren', 'pesantren', 'x_latitude', 'latitude', '`latitude`', '`latitude`', 200, 255, -1, false, '`latitude`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->latitude->Sortable = true; // Allow sort
        $this->latitude->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->latitude->Param, "CustomMsg");
        $this->Fields['latitude'] = &$this->latitude;

        // longitude
        $this->longitude = new DbField('pesantren', 'pesantren', 'x_longitude', 'longitude', '`longitude`', '`longitude`', 200, 255, -1, false, '`longitude`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->longitude->Sortable = true; // Allow sort
        $this->longitude->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->longitude->Param, "CustomMsg");
        $this->Fields['longitude'] = &$this->longitude;

        // telpon
        $this->telpon = new DbField('pesantren', 'pesantren', 'x_telpon', 'telpon', '`telpon`', '`telpon`', 200, 255, -1, false, '`telpon`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->telpon->Sortable = true; // Allow sort
        $this->telpon->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->telpon->Param, "CustomMsg");
        $this->Fields['telpon'] = &$this->telpon;

        // web
        $this->web = new DbField('pesantren', 'pesantren', 'x_web', 'web', '`web`', '`web`', 200, 255, -1, false, '`web`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->web->Sortable = true; // Allow sort
        $this->web->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->web->Param, "CustomMsg");
        $this->Fields['web'] = &$this->web;

        // email
        $this->_email = new DbField('pesantren', 'pesantren', 'x__email', 'email', '`email`', '`email`', 200, 255, -1, false, '`email`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_email->Sortable = true; // Allow sort
        $this->_email->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_email->Param, "CustomMsg");
        $this->Fields['email'] = &$this->_email;

        // nspp
        $this->nspp = new DbField('pesantren', 'pesantren', 'x_nspp', 'nspp', '`nspp`', '`nspp`', 200, 255, -1, false, '`nspp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nspp->Sortable = true; // Allow sort
        $this->nspp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nspp->Param, "CustomMsg");
        $this->Fields['nspp'] = &$this->nspp;

        // nspptglmulai
        $this->nspptglmulai = new DbField('pesantren', 'pesantren', 'x_nspptglmulai', 'nspptglmulai', '`nspptglmulai`', CastDateFieldForLike("`nspptglmulai`", 7, "DB"), 133, 10, 7, false, '`nspptglmulai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nspptglmulai->Sortable = true; // Allow sort
        $this->nspptglmulai->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->nspptglmulai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nspptglmulai->Param, "CustomMsg");
        $this->Fields['nspptglmulai'] = &$this->nspptglmulai;

        // nspptglakhir
        $this->nspptglakhir = new DbField('pesantren', 'pesantren', 'x_nspptglakhir', 'nspptglakhir', '`nspptglakhir`', CastDateFieldForLike("`nspptglakhir`", 7, "DB"), 133, 10, 7, false, '`nspptglakhir`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nspptglakhir->Sortable = true; // Allow sort
        $this->nspptglakhir->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->nspptglakhir->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nspptglakhir->Param, "CustomMsg");
        $this->Fields['nspptglakhir'] = &$this->nspptglakhir;

        // dokumennspp
        $this->dokumennspp = new DbField('pesantren', 'pesantren', 'x_dokumennspp', 'dokumennspp', '`dokumennspp`', '`dokumennspp`', 200, 255, -1, true, '`dokumennspp`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->dokumennspp->Sortable = true; // Allow sort
        $this->dokumennspp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dokumennspp->Param, "CustomMsg");
        $this->Fields['dokumennspp'] = &$this->dokumennspp;

        // yayasan
        $this->yayasan = new DbField('pesantren', 'pesantren', 'x_yayasan', 'yayasan', '`yayasan`', '`yayasan`', 200, 255, -1, false, '`yayasan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->yayasan->Sortable = true; // Allow sort
        $this->yayasan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->yayasan->Param, "CustomMsg");
        $this->Fields['yayasan'] = &$this->yayasan;

        // noakta
        $this->noakta = new DbField('pesantren', 'pesantren', 'x_noakta', 'noakta', '`noakta`', '`noakta`', 200, 255, -1, false, '`noakta`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->noakta->Sortable = true; // Allow sort
        $this->noakta->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->noakta->Param, "CustomMsg");
        $this->Fields['noakta'] = &$this->noakta;

        // tglakta
        $this->tglakta = new DbField('pesantren', 'pesantren', 'x_tglakta', 'tglakta', '`tglakta`', CastDateFieldForLike("`tglakta`", 7, "DB"), 133, 10, 7, false, '`tglakta`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglakta->Sortable = true; // Allow sort
        $this->tglakta->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tglakta->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglakta->Param, "CustomMsg");
        $this->Fields['tglakta'] = &$this->tglakta;

        // namanotaris
        $this->namanotaris = new DbField('pesantren', 'pesantren', 'x_namanotaris', 'namanotaris', '`namanotaris`', '`namanotaris`', 200, 255, -1, false, '`namanotaris`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namanotaris->Sortable = true; // Allow sort
        $this->namanotaris->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namanotaris->Param, "CustomMsg");
        $this->Fields['namanotaris'] = &$this->namanotaris;

        // alamatnotaris
        $this->alamatnotaris = new DbField('pesantren', 'pesantren', 'x_alamatnotaris', 'alamatnotaris', '`alamatnotaris`', '`alamatnotaris`', 200, 255, -1, false, '`alamatnotaris`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamatnotaris->Sortable = true; // Allow sort
        $this->alamatnotaris->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamatnotaris->Param, "CustomMsg");
        $this->Fields['alamatnotaris'] = &$this->alamatnotaris;

        // noaktaperubahan
        $this->noaktaperubahan = new DbField('pesantren', 'pesantren', 'x_noaktaperubahan', 'noaktaperubahan', '`noaktaperubahan`', '`noaktaperubahan`', 200, 255, -1, false, '`noaktaperubahan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->noaktaperubahan->Sortable = false; // Allow sort
        $this->noaktaperubahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->noaktaperubahan->Param, "CustomMsg");
        $this->Fields['noaktaperubahan'] = &$this->noaktaperubahan;

        // tglubah
        $this->tglubah = new DbField('pesantren', 'pesantren', 'x_tglubah', 'tglubah', '`tglubah`', CastDateFieldForLike("`tglubah`", 7, "DB"), 133, 10, 7, false, '`tglubah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglubah->Sortable = false; // Allow sort
        $this->tglubah->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
        $this->tglubah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglubah->Param, "CustomMsg");
        $this->Fields['tglubah'] = &$this->tglubah;

        // namanotarisubah
        $this->namanotarisubah = new DbField('pesantren', 'pesantren', 'x_namanotarisubah', 'namanotarisubah', '`namanotarisubah`', '`namanotarisubah`', 200, 255, -1, false, '`namanotarisubah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namanotarisubah->Sortable = false; // Allow sort
        $this->namanotarisubah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namanotarisubah->Param, "CustomMsg");
        $this->Fields['namanotarisubah'] = &$this->namanotarisubah;

        // alamatnotarisubah
        $this->alamatnotarisubah = new DbField('pesantren', 'pesantren', 'x_alamatnotarisubah', 'alamatnotarisubah', '`alamatnotarisubah`', '`alamatnotarisubah`', 200, 255, -1, false, '`alamatnotarisubah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamatnotarisubah->Sortable = false; // Allow sort
        $this->alamatnotarisubah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamatnotarisubah->Param, "CustomMsg");
        $this->Fields['alamatnotarisubah'] = &$this->alamatnotarisubah;

        // userid
        $this->_userid = new DbField('pesantren', 'pesantren', 'x__userid', 'userid', '`userid`', '`userid`', 3, 11, -1, false, '`userid`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->_userid->Sortable = true; // Allow sort
        $this->_userid->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->_userid->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->_userid->Lookup = new Lookup('userid', 'user', false, 'id', ["namapendaftar","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->_userid->Lookup = new Lookup('userid', 'user', false, 'id', ["namapendaftar","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->_userid->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->_userid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_userid->Param, "CustomMsg");
        $this->Fields['userid'] = &$this->_userid;

        // foto
        $this->foto = new DbField('pesantren', 'pesantren', 'x_foto', 'foto', '`foto`', '`foto`', 200, 255, -1, true, '`foto`', false, false, false, 'IMAGE', 'FILE');
        $this->foto->Sortable = true; // Allow sort
        $this->foto->UploadMultiple = true;
        $this->foto->Upload->UploadMultiple = true;
        $this->foto->UploadMaxFileCount = 0;
        $this->foto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto->Param, "CustomMsg");
        $this->Fields['foto'] = &$this->foto;

        // ktp
        $this->ktp = new DbField('pesantren', 'pesantren', 'x_ktp', 'ktp', '`ktp`', '`ktp`', 200, 255, -1, true, '`ktp`', false, false, false, 'IMAGE', 'FILE');
        $this->ktp->Sortable = true; // Allow sort
        $this->ktp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ktp->Param, "CustomMsg");
        $this->Fields['ktp'] = &$this->ktp;

        // dokumen
        $this->dokumen = new DbField('pesantren', 'pesantren', 'x_dokumen', 'dokumen', '`dokumen`', '`dokumen`', 200, 255, -1, true, '`dokumen`', false, false, false, 'IMAGE', 'FILE');
        $this->dokumen->Sortable = true; // Allow sort
        $this->dokumen->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dokumen->Param, "CustomMsg");
        $this->Fields['dokumen'] = &$this->dokumen;

        // validasi
        $this->validasi = new DbField('pesantren', 'pesantren', 'x_validasi', 'validasi', '`validasi`', '`validasi`', 16, 4, -1, false, '`validasi`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->validasi->Sortable = true; // Allow sort
        $this->validasi->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->validasi->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->validasi->Lookup = new Lookup('validasi', 'pesantren', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->validasi->Lookup = new Lookup('validasi', 'pesantren', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->validasi->OptionCount = 3;
        $this->validasi->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->validasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->validasi->Param, "CustomMsg");
        $this->Fields['validasi'] = &$this->validasi;

        // validator
        $this->validator = new DbField('pesantren', 'pesantren', 'x_validator', 'validator', '`validator`', '`validator`', 3, 11, -1, false, '`validator`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->validator->Sortable = true; // Allow sort
        $this->validator->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->validator->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->validator->Lookup = new Lookup('validator', 'user', false, 'id', ["namapesantren","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->validator->Lookup = new Lookup('validator', 'user', false, 'id', ["namapesantren","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->validator->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->validator->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->validator->Param, "CustomMsg");
        $this->Fields['validator'] = &$this->validator;

        // validasi_pusat
        $this->validasi_pusat = new DbField('pesantren', 'pesantren', 'x_validasi_pusat', 'validasi_pusat', '`validasi_pusat`', '`validasi_pusat`', 16, 4, -1, false, '`validasi_pusat`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->validasi_pusat->Sortable = true; // Allow sort
        $this->validasi_pusat->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->validasi_pusat->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->validasi_pusat->Lookup = new Lookup('validasi_pusat', 'pesantren', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->validasi_pusat->Lookup = new Lookup('validasi_pusat', 'pesantren', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->validasi_pusat->OptionCount = 3;
        $this->validasi_pusat->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->validasi_pusat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->validasi_pusat->Param, "CustomMsg");
        $this->Fields['validasi_pusat'] = &$this->validasi_pusat;

        // validator_pusat
        $this->validator_pusat = new DbField('pesantren', 'pesantren', 'x_validator_pusat', 'validator_pusat', '`validator_pusat`', '`validator_pusat`', 3, 11, -1, false, '`validator_pusat`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->validator_pusat->Sortable = true; // Allow sort
        $this->validator_pusat->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->validator_pusat->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->validator_pusat->Lookup = new Lookup('validator_pusat', 'user', false, 'id', ["namapesantren","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->validator_pusat->Lookup = new Lookup('validator_pusat', 'user', false, 'id', ["namapesantren","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->validator_pusat->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->validator_pusat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->validator_pusat->Param, "CustomMsg");
        $this->Fields['validator_pusat'] = &$this->validator_pusat;

        // created_at
        $this->created_at = new DbField('pesantren', 'pesantren', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('pesantren', 'pesantren', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;
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

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "fasilitasusaha") {
            $detailUrl = Container("fasilitasusaha")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "pendidikanumum") {
            $detailUrl = Container("pendidikanumum")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "pengasuhpppria") {
            $detailUrl = Container("pengasuhpppria")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "pengasuhppwanita") {
            $detailUrl = Container("pengasuhppwanita")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "kitabkuning") {
            $detailUrl = Container("kitabkuning")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "fasilitaspesantren") {
            $detailUrl = Container("fasilitaspesantren")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "PesantrenList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`pesantren`";
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
        $this->DefaultFilter = CurrentUserLevel() == 1 ? "kabupaten IN (SELECT idkabupatens FROM wilayah WHERE iduser = ".CurrentUserID().")" : (CurrentUserLevel() == 2 ? "userid = ".CurrentUserID() : "");
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
            $filter = $this->addUserIDFilter($filter);
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
        // Cascade Update detail table 'fasilitasusaha'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'pid'
            $cascadeUpdate = true;
            $rscascade['pid'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("fasilitasusaha")->loadRs("`pid` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("fasilitasusaha")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("fasilitasusaha")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("fasilitasusaha")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'pendidikanumum'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'pid'
            $cascadeUpdate = true;
            $rscascade['pid'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("pendidikanumum")->loadRs("`pid` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("pendidikanumum")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("pendidikanumum")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("pendidikanumum")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'pengasuhpppria'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'pid'
            $cascadeUpdate = true;
            $rscascade['pid'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("pengasuhpppria")->loadRs("`pid` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("pengasuhpppria")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("pengasuhpppria")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("pengasuhpppria")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'pengasuhppwanita'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'pid'
            $cascadeUpdate = true;
            $rscascade['pid'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("pengasuhppwanita")->loadRs("`pid` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("pengasuhppwanita")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("pengasuhppwanita")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("pengasuhppwanita")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'kitabkuning'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'pid'
            $cascadeUpdate = true;
            $rscascade['pid'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("kitabkuning")->loadRs("`pid` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("kitabkuning")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("kitabkuning")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("kitabkuning")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'fasilitaspesantren'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'pid'
            $cascadeUpdate = true;
            $rscascade['pid'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("fasilitaspesantren")->loadRs("`pid` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("fasilitaspesantren")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("fasilitaspesantren")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("fasilitaspesantren")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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

        // Cascade delete detail table 'fasilitasusaha'
        $dtlrows = Container("fasilitasusaha")->loadRs("`pid` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("fasilitasusaha")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("fasilitasusaha")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("fasilitasusaha")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'pendidikanumum'
        $dtlrows = Container("pendidikanumum")->loadRs("`pid` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("pendidikanumum")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("pendidikanumum")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("pendidikanumum")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'pengasuhpppria'
        $dtlrows = Container("pengasuhpppria")->loadRs("`pid` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("pengasuhpppria")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("pengasuhpppria")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("pengasuhpppria")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'pengasuhppwanita'
        $dtlrows = Container("pengasuhppwanita")->loadRs("`pid` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("pengasuhppwanita")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("pengasuhppwanita")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("pengasuhppwanita")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'kitabkuning'
        $dtlrows = Container("kitabkuning")->loadRs("`pid` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("kitabkuning")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("kitabkuning")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("kitabkuning")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'fasilitaspesantren'
        $dtlrows = Container("fasilitaspesantren")->loadRs("`pid` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("fasilitaspesantren")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("fasilitaspesantren")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("fasilitaspesantren")->rowDeleted($dtlrow);
            }
        }
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
        $this->kode->DbValue = $row['kode'];
        $this->nama->DbValue = $row['nama'];
        $this->deskripsi->DbValue = $row['deskripsi'];
        $this->jalan->DbValue = $row['jalan'];
        $this->propinsi->DbValue = $row['propinsi'];
        $this->kabupaten->DbValue = $row['kabupaten'];
        $this->kecamatan->DbValue = $row['kecamatan'];
        $this->desa->DbValue = $row['desa'];
        $this->kodepos->DbValue = $row['kodepos'];
        $this->latitude->DbValue = $row['latitude'];
        $this->longitude->DbValue = $row['longitude'];
        $this->telpon->DbValue = $row['telpon'];
        $this->web->DbValue = $row['web'];
        $this->_email->DbValue = $row['email'];
        $this->nspp->DbValue = $row['nspp'];
        $this->nspptglmulai->DbValue = $row['nspptglmulai'];
        $this->nspptglakhir->DbValue = $row['nspptglakhir'];
        $this->dokumennspp->Upload->DbValue = $row['dokumennspp'];
        $this->yayasan->DbValue = $row['yayasan'];
        $this->noakta->DbValue = $row['noakta'];
        $this->tglakta->DbValue = $row['tglakta'];
        $this->namanotaris->DbValue = $row['namanotaris'];
        $this->alamatnotaris->DbValue = $row['alamatnotaris'];
        $this->noaktaperubahan->DbValue = $row['noaktaperubahan'];
        $this->tglubah->DbValue = $row['tglubah'];
        $this->namanotarisubah->DbValue = $row['namanotarisubah'];
        $this->alamatnotarisubah->DbValue = $row['alamatnotarisubah'];
        $this->_userid->DbValue = $row['userid'];
        $this->foto->Upload->DbValue = $row['foto'];
        $this->ktp->Upload->DbValue = $row['ktp'];
        $this->dokumen->Upload->DbValue = $row['dokumen'];
        $this->validasi->DbValue = $row['validasi'];
        $this->validator->DbValue = $row['validator'];
        $this->validasi_pusat->DbValue = $row['validasi_pusat'];
        $this->validator_pusat->DbValue = $row['validator_pusat'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['dokumennspp']) ? [] : [$row['dokumennspp']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->dokumennspp->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->dokumennspp->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['foto']) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $row['foto']);
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->foto->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['ktp']) ? [] : [$row['ktp']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->ktp->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->ktp->oldPhysicalUploadPath() . $oldFile);
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
        return $_SESSION[$name] ?? GetUrl("PesantrenList");
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
        if ($pageName == "PesantrenView") {
            return $Language->phrase("View");
        } elseif ($pageName == "PesantrenEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "PesantrenAdd") {
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
                return "PesantrenView";
            case Config("API_ADD_ACTION"):
                return "PesantrenAdd";
            case Config("API_EDIT_ACTION"):
                return "PesantrenEdit";
            case Config("API_DELETE_ACTION"):
                return "PesantrenDelete";
            case Config("API_LIST_ACTION"):
                return "PesantrenList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "PesantrenList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PesantrenView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PesantrenView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "PesantrenAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "PesantrenAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("PesantrenEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PesantrenEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        if ($parm != "") {
            $url = $this->keyUrl("PesantrenAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("PesantrenAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        return $this->keyUrl("PesantrenDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
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
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id
        $this->id->CellCssStyle = "white-space: nowrap;";

        // kode

        // nama
        $this->nama->CellCssStyle = "white-space: nowrap;";

        // deskripsi

        // jalan

        // propinsi
        $this->propinsi->CellCssStyle = "white-space: nowrap;";

        // kabupaten
        $this->kabupaten->CellCssStyle = "white-space: nowrap;";

        // kecamatan

        // desa

        // kodepos

        // latitude

        // longitude

        // telpon
        $this->telpon->CellCssStyle = "white-space: nowrap;";

        // web

        // email

        // nspp
        $this->nspp->CellCssStyle = "white-space: nowrap;";

        // nspptglmulai
        $this->nspptglmulai->CellCssStyle = "white-space: nowrap;";

        // nspptglakhir
        $this->nspptglakhir->CellCssStyle = "white-space: nowrap;";

        // dokumennspp

        // yayasan
        $this->yayasan->CellCssStyle = "white-space: nowrap;";

        // noakta

        // tglakta

        // namanotaris

        // alamatnotaris

        // noaktaperubahan
        $this->noaktaperubahan->CellCssStyle = "white-space: nowrap;";

        // tglubah
        $this->tglubah->CellCssStyle = "white-space: nowrap;";

        // namanotarisubah
        $this->namanotarisubah->CellCssStyle = "white-space: nowrap;";

        // alamatnotarisubah
        $this->alamatnotarisubah->CellCssStyle = "white-space: nowrap;";

        // userid
        $this->_userid->CellCssStyle = "white-space: nowrap;";

        // foto

        // ktp

        // dokumen

        // validasi
        $this->validasi->CellCssStyle = "white-space: nowrap;";

        // validator
        $this->validator->CellCssStyle = "white-space: nowrap;";

        // validasi_pusat
        $this->validasi_pusat->CellCssStyle = "white-space: nowrap;";

        // validator_pusat
        $this->validator_pusat->CellCssStyle = "white-space: nowrap;";

        // created_at

        // updated_at

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

        // latitude
        $this->latitude->ViewValue = $this->latitude->CurrentValue;
        $this->latitude->ViewCustomAttributes = "";

        // longitude
        $this->longitude->ViewValue = $this->longitude->CurrentValue;
        $this->longitude->ViewCustomAttributes = "";

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

        // noaktaperubahan
        $this->noaktaperubahan->ViewValue = $this->noaktaperubahan->CurrentValue;
        $this->noaktaperubahan->ViewCustomAttributes = "";

        // tglubah
        $this->tglubah->ViewValue = $this->tglubah->CurrentValue;
        $this->tglubah->ViewValue = FormatDateTime($this->tglubah->ViewValue, 7);
        $this->tglubah->ViewCustomAttributes = "";

        // namanotarisubah
        $this->namanotarisubah->ViewValue = $this->namanotarisubah->CurrentValue;
        $this->namanotarisubah->ViewCustomAttributes = "";

        // alamatnotarisubah
        $this->alamatnotarisubah->ViewValue = $this->alamatnotarisubah->CurrentValue;
        $this->alamatnotarisubah->ViewCustomAttributes = "";

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

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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

        // latitude
        $this->latitude->LinkCustomAttributes = "";
        $this->latitude->HrefValue = "";
        $this->latitude->TooltipValue = "";

        // longitude
        $this->longitude->LinkCustomAttributes = "";
        $this->longitude->HrefValue = "";
        $this->longitude->TooltipValue = "";

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

        // noaktaperubahan
        $this->noaktaperubahan->LinkCustomAttributes = "";
        $this->noaktaperubahan->HrefValue = "";
        $this->noaktaperubahan->TooltipValue = "";

        // tglubah
        $this->tglubah->LinkCustomAttributes = "";
        $this->tglubah->HrefValue = "";
        $this->tglubah->TooltipValue = "";

        // namanotarisubah
        $this->namanotarisubah->LinkCustomAttributes = "";
        $this->namanotarisubah->HrefValue = "";
        $this->namanotarisubah->TooltipValue = "";

        // alamatnotarisubah
        $this->alamatnotarisubah->LinkCustomAttributes = "";
        $this->alamatnotarisubah->HrefValue = "";
        $this->alamatnotarisubah->TooltipValue = "";

        // userid
        $this->_userid->LinkCustomAttributes = "";
        $this->_userid->HrefValue = "";
        $this->_userid->TooltipValue = "";

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

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

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
        $this->nama->EditValue = $this->nama->CurrentValue;

        // deskripsi
        $this->deskripsi->EditAttrs["class"] = "form-control";
        $this->deskripsi->EditCustomAttributes = "";
        $this->deskripsi->EditValue = $this->deskripsi->CurrentValue;

        // jalan
        $this->jalan->EditAttrs["class"] = "form-control";
        $this->jalan->EditCustomAttributes = "";
        if (!$this->jalan->Raw) {
            $this->jalan->CurrentValue = HtmlDecode($this->jalan->CurrentValue);
        }
        $this->jalan->EditValue = $this->jalan->CurrentValue;

        // propinsi
        $this->propinsi->EditAttrs["class"] = "form-control";
        $this->propinsi->EditCustomAttributes = "";

        // kabupaten
        $this->kabupaten->EditAttrs["class"] = "form-control";
        $this->kabupaten->EditCustomAttributes = "";

        // kecamatan
        $this->kecamatan->EditAttrs["class"] = "form-control";
        $this->kecamatan->EditCustomAttributes = "";

        // desa
        $this->desa->EditAttrs["class"] = "form-control";
        $this->desa->EditCustomAttributes = "";

        // kodepos
        $this->kodepos->EditAttrs["class"] = "form-control";
        $this->kodepos->EditCustomAttributes = "";
        if (!$this->kodepos->Raw) {
            $this->kodepos->CurrentValue = HtmlDecode($this->kodepos->CurrentValue);
        }
        $this->kodepos->EditValue = $this->kodepos->CurrentValue;

        // latitude
        $this->latitude->EditAttrs["class"] = "form-control";
        $this->latitude->EditCustomAttributes = "";
        if (!$this->latitude->Raw) {
            $this->latitude->CurrentValue = HtmlDecode($this->latitude->CurrentValue);
        }
        $this->latitude->EditValue = $this->latitude->CurrentValue;

        // longitude
        $this->longitude->EditAttrs["class"] = "form-control";
        $this->longitude->EditCustomAttributes = "";
        if (!$this->longitude->Raw) {
            $this->longitude->CurrentValue = HtmlDecode($this->longitude->CurrentValue);
        }
        $this->longitude->EditValue = $this->longitude->CurrentValue;

        // telpon
        $this->telpon->EditAttrs["class"] = "form-control";
        $this->telpon->EditCustomAttributes = "";
        if (!$this->telpon->Raw) {
            $this->telpon->CurrentValue = HtmlDecode($this->telpon->CurrentValue);
        }
        $this->telpon->EditValue = $this->telpon->CurrentValue;

        // web
        $this->web->EditAttrs["class"] = "form-control";
        $this->web->EditCustomAttributes = "";
        if (!$this->web->Raw) {
            $this->web->CurrentValue = HtmlDecode($this->web->CurrentValue);
        }
        $this->web->EditValue = $this->web->CurrentValue;

        // email
        $this->_email->EditAttrs["class"] = "form-control";
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;

        // nspp
        $this->nspp->EditAttrs["class"] = "form-control";
        $this->nspp->EditCustomAttributes = "";
        if (!$this->nspp->Raw) {
            $this->nspp->CurrentValue = HtmlDecode($this->nspp->CurrentValue);
        }
        $this->nspp->EditValue = $this->nspp->CurrentValue;

        // nspptglmulai
        $this->nspptglmulai->EditAttrs["class"] = "form-control";
        $this->nspptglmulai->EditCustomAttributes = "";
        $this->nspptglmulai->EditValue = FormatDateTime($this->nspptglmulai->CurrentValue, 7);

        // nspptglakhir
        $this->nspptglakhir->EditAttrs["class"] = "form-control";
        $this->nspptglakhir->EditCustomAttributes = "";
        $this->nspptglakhir->EditValue = FormatDateTime($this->nspptglakhir->CurrentValue, 7);

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

        // yayasan
        $this->yayasan->EditAttrs["class"] = "form-control";
        $this->yayasan->EditCustomAttributes = "";
        if (!$this->yayasan->Raw) {
            $this->yayasan->CurrentValue = HtmlDecode($this->yayasan->CurrentValue);
        }
        $this->yayasan->EditValue = $this->yayasan->CurrentValue;

        // noakta
        $this->noakta->EditAttrs["class"] = "form-control";
        $this->noakta->EditCustomAttributes = "";
        if (!$this->noakta->Raw) {
            $this->noakta->CurrentValue = HtmlDecode($this->noakta->CurrentValue);
        }
        $this->noakta->EditValue = $this->noakta->CurrentValue;

        // tglakta
        $this->tglakta->EditAttrs["class"] = "form-control";
        $this->tglakta->EditCustomAttributes = "";
        $this->tglakta->EditValue = FormatDateTime($this->tglakta->CurrentValue, 7);

        // namanotaris
        $this->namanotaris->EditAttrs["class"] = "form-control";
        $this->namanotaris->EditCustomAttributes = "";
        if (!$this->namanotaris->Raw) {
            $this->namanotaris->CurrentValue = HtmlDecode($this->namanotaris->CurrentValue);
        }
        $this->namanotaris->EditValue = $this->namanotaris->CurrentValue;

        // alamatnotaris
        $this->alamatnotaris->EditAttrs["class"] = "form-control";
        $this->alamatnotaris->EditCustomAttributes = "";
        if (!$this->alamatnotaris->Raw) {
            $this->alamatnotaris->CurrentValue = HtmlDecode($this->alamatnotaris->CurrentValue);
        }
        $this->alamatnotaris->EditValue = $this->alamatnotaris->CurrentValue;

        // noaktaperubahan
        $this->noaktaperubahan->EditAttrs["class"] = "form-control";
        $this->noaktaperubahan->EditCustomAttributes = "";
        if (!$this->noaktaperubahan->Raw) {
            $this->noaktaperubahan->CurrentValue = HtmlDecode($this->noaktaperubahan->CurrentValue);
        }
        $this->noaktaperubahan->EditValue = $this->noaktaperubahan->CurrentValue;

        // tglubah
        $this->tglubah->EditAttrs["class"] = "form-control";
        $this->tglubah->EditCustomAttributes = "";
        $this->tglubah->EditValue = FormatDateTime($this->tglubah->CurrentValue, 7);

        // namanotarisubah
        $this->namanotarisubah->EditAttrs["class"] = "form-control";
        $this->namanotarisubah->EditCustomAttributes = "";
        if (!$this->namanotarisubah->Raw) {
            $this->namanotarisubah->CurrentValue = HtmlDecode($this->namanotarisubah->CurrentValue);
        }
        $this->namanotarisubah->EditValue = $this->namanotarisubah->CurrentValue;

        // alamatnotarisubah
        $this->alamatnotarisubah->EditAttrs["class"] = "form-control";
        $this->alamatnotarisubah->EditCustomAttributes = "";
        if (!$this->alamatnotarisubah->Raw) {
            $this->alamatnotarisubah->CurrentValue = HtmlDecode($this->alamatnotarisubah->CurrentValue);
        }
        $this->alamatnotarisubah->EditValue = $this->alamatnotarisubah->CurrentValue;

        // userid
        $this->_userid->EditAttrs["class"] = "form-control";
        $this->_userid->EditCustomAttributes = "";
        if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("info")) { // Non system admin
            $this->_userid->CurrentValue = CurrentUserID();
            $curVal = trim(strval($this->_userid->CurrentValue));
            if ($curVal != "") {
                $this->_userid->EditValue = $this->_userid->lookupCacheOption($curVal);
                if ($this->_userid->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->_userid->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->_userid->Lookup->renderViewRow($rswrk[0]);
                        $this->_userid->EditValue = $this->_userid->displayValue($arwrk);
                    } else {
                        $this->_userid->EditValue = $this->_userid->CurrentValue;
                    }
                }
            } else {
                $this->_userid->EditValue = null;
            }
            $this->_userid->ViewCustomAttributes = "";
        } else {
        }

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

        // validasi
        $this->validasi->EditAttrs["class"] = "form-control";
        $this->validasi->EditCustomAttributes = "";
        $this->validasi->EditValue = $this->validasi->options(true);

        // validator
        $this->validator->EditAttrs["class"] = "form-control";
        $this->validator->EditCustomAttributes = "";

        // validasi_pusat
        $this->validasi_pusat->EditAttrs["class"] = "form-control";
        $this->validasi_pusat->EditCustomAttributes = "";
        $this->validasi_pusat->EditValue = $this->validasi_pusat->options(true);

        // validator_pusat
        $this->validator_pusat->EditAttrs["class"] = "form-control";
        $this->validator_pusat->EditCustomAttributes = "";

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, 8);

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
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->deskripsi);
                    $doc->exportCaption($this->jalan);
                    $doc->exportCaption($this->propinsi);
                    $doc->exportCaption($this->kabupaten);
                    $doc->exportCaption($this->kecamatan);
                    $doc->exportCaption($this->desa);
                    $doc->exportCaption($this->kodepos);
                    $doc->exportCaption($this->latitude);
                    $doc->exportCaption($this->longitude);
                    $doc->exportCaption($this->telpon);
                    $doc->exportCaption($this->web);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->nspp);
                    $doc->exportCaption($this->nspptglmulai);
                    $doc->exportCaption($this->nspptglakhir);
                    $doc->exportCaption($this->dokumennspp);
                    $doc->exportCaption($this->yayasan);
                    $doc->exportCaption($this->noakta);
                    $doc->exportCaption($this->tglakta);
                    $doc->exportCaption($this->namanotaris);
                    $doc->exportCaption($this->alamatnotaris);
                    $doc->exportCaption($this->_userid);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->ktp);
                    $doc->exportCaption($this->dokumen);
                    $doc->exportCaption($this->validasi);
                    $doc->exportCaption($this->validator);
                    $doc->exportCaption($this->validasi_pusat);
                    $doc->exportCaption($this->validator_pusat);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->kode);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->jalan);
                    $doc->exportCaption($this->propinsi);
                    $doc->exportCaption($this->kabupaten);
                    $doc->exportCaption($this->kecamatan);
                    $doc->exportCaption($this->desa);
                    $doc->exportCaption($this->kodepos);
                    $doc->exportCaption($this->latitude);
                    $doc->exportCaption($this->longitude);
                    $doc->exportCaption($this->telpon);
                    $doc->exportCaption($this->web);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->nspp);
                    $doc->exportCaption($this->nspptglmulai);
                    $doc->exportCaption($this->nspptglakhir);
                    $doc->exportCaption($this->dokumennspp);
                    $doc->exportCaption($this->yayasan);
                    $doc->exportCaption($this->noakta);
                    $doc->exportCaption($this->tglakta);
                    $doc->exportCaption($this->namanotaris);
                    $doc->exportCaption($this->alamatnotaris);
                    $doc->exportCaption($this->_userid);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->ktp);
                    $doc->exportCaption($this->dokumen);
                    $doc->exportCaption($this->validasi);
                    $doc->exportCaption($this->validator);
                    $doc->exportCaption($this->validasi_pusat);
                    $doc->exportCaption($this->validator_pusat);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
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
                        $doc->exportField($this->kode);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->deskripsi);
                        $doc->exportField($this->jalan);
                        $doc->exportField($this->propinsi);
                        $doc->exportField($this->kabupaten);
                        $doc->exportField($this->kecamatan);
                        $doc->exportField($this->desa);
                        $doc->exportField($this->kodepos);
                        $doc->exportField($this->latitude);
                        $doc->exportField($this->longitude);
                        $doc->exportField($this->telpon);
                        $doc->exportField($this->web);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->nspp);
                        $doc->exportField($this->nspptglmulai);
                        $doc->exportField($this->nspptglakhir);
                        $doc->exportField($this->dokumennspp);
                        $doc->exportField($this->yayasan);
                        $doc->exportField($this->noakta);
                        $doc->exportField($this->tglakta);
                        $doc->exportField($this->namanotaris);
                        $doc->exportField($this->alamatnotaris);
                        $doc->exportField($this->_userid);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->ktp);
                        $doc->exportField($this->dokumen);
                        $doc->exportField($this->validasi);
                        $doc->exportField($this->validator);
                        $doc->exportField($this->validasi_pusat);
                        $doc->exportField($this->validator_pusat);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->kode);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->jalan);
                        $doc->exportField($this->propinsi);
                        $doc->exportField($this->kabupaten);
                        $doc->exportField($this->kecamatan);
                        $doc->exportField($this->desa);
                        $doc->exportField($this->kodepos);
                        $doc->exportField($this->latitude);
                        $doc->exportField($this->longitude);
                        $doc->exportField($this->telpon);
                        $doc->exportField($this->web);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->nspp);
                        $doc->exportField($this->nspptglmulai);
                        $doc->exportField($this->nspptglakhir);
                        $doc->exportField($this->dokumennspp);
                        $doc->exportField($this->yayasan);
                        $doc->exportField($this->noakta);
                        $doc->exportField($this->tglakta);
                        $doc->exportField($this->namanotaris);
                        $doc->exportField($this->alamatnotaris);
                        $doc->exportField($this->_userid);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->ktp);
                        $doc->exportField($this->dokumen);
                        $doc->exportField($this->validasi);
                        $doc->exportField($this->validator);
                        $doc->exportField($this->validasi_pusat);
                        $doc->exportField($this->validator_pusat);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
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

    // Add User ID filter
    public function addUserIDFilter($filter = "")
    {
        global $Security;
        $filterWrk = "";
        $id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
        if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
            $filterWrk = $Security->userIdList();
            if ($filterWrk != "") {
                $filterWrk = '`userid` IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM `pesantren`";
        $filter = $this->addUserIDFilter("");
        if ($filter != "") {
            $sql .= " WHERE " . $filter;
        }

        // List all values
        if ($rs = Conn($UserTable->Dbid)->executeQuery($sql)->fetchAll(\PDO::FETCH_NUM)) {
            foreach ($rs as $row) {
                if ($wrk != "") {
                    $wrk .= ",";
                }
                $wrk .= QuotedValue($row[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
            }
        }
        if ($wrk != "") {
            $wrk = $fld->Expression . " IN (" . $wrk . ")";
        } else { // No User ID value found
            $wrk = "0=1";
        }
        return $wrk;
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
        if ($fldparm == 'dokumennspp') {
            $fldName = "dokumennspp";
            $fileNameFld = "dokumennspp";
        } elseif ($fldparm == 'foto') {
            $fldName = "foto";
            $fileNameFld = "foto";
        } elseif ($fldparm == 'ktp') {
            $fldName = "ktp";
            $fileNameFld = "ktp";
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
        $myResult = ExecuteUpdate("UPDATE pesantren SET created_at='".date('Y-m-d H:i:s')."', updated_at='".date('Y-m-d H:i:s')."' WHERE id=".$rsnew['id']."");
        return true;
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
        if(CurrentUserLevel()=='-1'){
        	if($rsnew['validasi_pusat']!=$rsold['validasi_pusat']){
        		$rsnew['validator_pusat']="-1";
        		$kode = ($rsnew['validasi_pusat'] != 1) ? "" : ", kode = '".getKodePesantren($rsold['propinsi'])."'";
        		$myResult = ExecuteUpdate("UPDATE pesantren SET validator_pusat=".CurrentUserID()." {$kode} WHERE id=".$rsold['id']);
        	}
        	if($rsnew['validasi']!=$rsold['validasi']){
        		$rsnew['validator']="-1";
        		$myResult = ExecuteUpdate("UPDATE pesantren SET validator=".CurrentUserID()." WHERE id=".$rsold['id']);
        	}
        } elseif(CurrentUserLevel()=='1'){
        	if($rsnew['validasi']!=$rsold['validasi']){
        		//$rsnew['validator']=CurrentUserID();
        		$myResult = ExecuteUpdate("UPDATE pesantren SET validator=".CurrentUserID()." WHERE id=".$rsold['id']);
        	}
        } elseif(CurrentUserLevel()=='3'){
        	if($rsnew['validasi_pusat']!=$rsold['validasi_pusat']){
        		if($rsnew['validasi_pusat']==1){
        			$created_date = ExecuteScalar("SELECT created_at FROM pesantren WHERE id=".$rsold['id']);
        			$created_date_array = explode("-",$created_date);
        			$tahun = $created_date_array[0];
        			$bulan = $created_date_array[1];
        			if($rsold['id']<10){
        				$no_urut="0000".$rsold['id'];
        			}
        			else if($rsold['id']<100 && $rsold['id']>9){
        				$no_urut="000".$rsold['id'];
        			}
        			else if($rsold['id']<1000 && $rsold['id']>99){
        				$no_urut="00".$rsold['id'];
        			}
        			else if($rsold['id']<10000 && $rsold['id']>999){
        				$no_urut="0".$rsold['id'];
        			}
        			else if($rsold['id']>9999){
        				$no_urut=$rsold['id'];
        			}
        			$no_anggota = $tahun."".$bulan."".$no_urut;
        			$kondisi = "validator_pusat=".CurrentUserID().", kode=".$no_anggota;
        		}
        		else{
        			$kondisi = "validator_pusat=".CurrentUserID();
        		}
        		$myResult = ExecuteUpdate("UPDATE pesantren SET $kondisi WHERE id=".$rsold['id']);
        		//$rsnew['validator_pusat']=CurrentUserID();
        	}
        }
        $myResult = ExecuteUpdate("UPDATE pesantren SET updated_at='".date('Y-m-d H:i:s')."' WHERE id=".$rsold['id']);
       // $rsnew['updated_at']=date("Y-m-d H:i:s");
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
