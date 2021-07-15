<?php

namespace PHPMaker2021\nuportal;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions

// Database Connecting event
function Database_Connecting(&$info)
{
    // Example:
    //var_dump($info);
    //if ($info["id"] == "DB" && IsLocal()) { // Testing on local PC
    //    $info["host"] = "locahost";
    //    $info["user"] = "root";
    //    $info["pass"] = "";
    //}
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

function Api_Action($app)
{
    $app->get('/pesantren[/{params:.*}]', function ($request, $response, $args) {
        $params = $args['params'] ?? null;
        $param = [];
        $filter = "";
        $limit = 10;                    
        if($params !== null){
            $paramRaw = explode("&", $params);
            foreach($paramRaw as $row){
                $parse = explode("=", $row);
                $param[$parse[0]] = $parse[1];
            }
            $nama = $param["nama"] ?? null;
            if($nama !== null){
                $filter .= "AND nama LIKE '%$nama%'";   
            }
            $kode = $param['kode'] ?? null;
            if($kode !== null){
                $filter .= "AND kode LIKE '%$kode%'";   
            }
            $propinsi = $param['propinsi'] ?? null;
            if($propinsi !== null){
                $filter .= "AND propinsi = $propinsi";  
            }
            $kabupaten = $param['kabupaten'] ?? null;
            if($kabupaten !== null){
                $filter .= "AND kabupaten = $kabupaten";    
            }
            $kecamatan = $param['kecamatan'] ?? null;
            if($kecamatan !== null){
                $filter .= "AND kecamatan = $kecamatan";    
            }
            $desa = $param['desa'] ?? null;
            if($desa !== null){
                $filter .= "AND desa = $desa";  
            }       
            $kodepos = $param['kodepos'] ?? null;
            if(isset($param['kodepos']) || !empty($param['kodepos'])){
                $filter .= "AND kodepos LIKE '%$kodepos%'"; 
            }
        }
        $sqlPageNum = ExecuteRows("SELECT * FROM pesantren WHERE validasi = 1 ".$filter);
        $countRow = count($sqlPageNum);
        $pageCount = ceil($countRow / $limit);
        $page = $param['page'] ?? null;
        if($page === null || empty($page) || $page == 0 || $page == 1){
            $filter .= "LIMIT $limit";  
        }else{
            $offset = intval($page) * $limit - $limit;
            $filter .= "LIMIT $offset, $limit";
        }
        $sql = "SELECT * FROM pesantren WHERE validasi = 1 ".$filter;
        $query = ExecuteRows($sql);
        return $response->withJson([
            "success" => true,
            "message" => "Success",
            "data" => $query,
            "page" => ["total_page" => $pageCount, "total_data" => $countRow],
            "param" => $param
        ]);
    });    
    $app->get('/berita[/{params:.*}]', function ($request, $response, $args) {
        $params = $args['params'] ?? null;
        $param = [];
        $filter = "";
        $limit = 10;
        if($params !== null){
            $paramRaw = explode("&", $params);
            foreach($paramRaw as $row){
                $parse = explode("=", $row);
                $param[$parse[0]] = $parse[1];
            }
            $judul = $param["nama"] ?? null;
            if($judul !== null){
                $filter .= "AND judul LIKE '%$judul%'"; 
            }
        }
        $sqlPageNum = ExecuteRows("SELECT * FROM berita WHERE status = 'Publish'".$filter);
        $countRow = count($sqlPageNum);
        $pageCount = ceil($countRow / $limit);
        $page = $param['page'] ?? null;
        if($page === null || empty($page) || $page == 0 || $page == 1){
            $filter .= "LIMIT $limit";  
        }else{
            $offset = intval($page) * $limit - $limit;
            $filter .= "LIMIT $offset, $limit";
        }
        $sql = "SELECT * FROM berita WHERE status = 'Publish'".$filter;
        $query = ExecuteRows($sql);        
        return $response->withJson([
            "success" => true,
            "message" => "Success",
            "data" => $query,
            "page" => ["total_page" => $pageCount, "total_data" => $countRow],
            "param" => $args]);
    });
    $app->get('/pesantren-detail/{id}', function ($request, $response, $args) {
        $id = $args['id'] ?? null;
        $query = ExecuteRow("SELECT * FROM pesantren WHERE validasi = 1 AND id = $id");
        if($query == false){
            $query = (object) [];
        }
        return $response->withJson(["success" => true, "message" => "Success", "data" => $query, "param" => $args]);
    });
    $app->get('/berita-detail/{id}', function ($request, $response, $args) {
        $id = $args["id"] ?? "null";
        $query = ExecuteRow("SELECT * FROM berita WHERE status = 'Publish' AND id = $id"); 
        if($query == false){
            $query = (object) [];
        }
        return $response->withJson(["success" => true, "message" => "Success", "data" => $query, "param" => $args]);
    });
    $app->get('/test[/{params:.*}]', function ($request, $response, $args) {
        $param = explode("&", $args['params']);
        $paramNew = [];
        foreach($param as $row){
            $parse = explode("=", $row);
            $paramNew[$parse[0]] = $parse[1];
        }
        return $response->withJson(["success" => true, "message" => "Success", "data" => $paramNew['page'], "param" => $args]);
    });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function getKodePesantren($idpropinsi) {
	$kode_terakhir = ExecuteRow("SELECT kode, propinsi FROM `pesantren` WHERE `propinsi` = {$idpropinsi} AND kode != '' AND kode IS NOT NULL ORDER BY `id` DESC LIMIT 1");
	$kode_propinsi = ExecuteRow("SELECT `kode` FROM `provinsis` WHERE `id` = {$idpropinsi}");
	if (empty($kode_terakhir)) {
		$kode = 1;
	} else {
		$kode = substr($kode_terakhir['kode'], -5);
        $kode += 1;
	}
    return $kode_propinsi['kode'].date('Ym').str_pad($kode, 5, 0, STR_PAD_LEFT);
}
