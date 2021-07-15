<?php

namespace PHPMaker2021\nuportal;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(12, "mi_berita", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "BeritaList", -1, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}berita'), false, false, "far fa-newspaper fa-xs", "", false);
$sideMenu->addMenuItem(6, "mi_pesantren", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "PesantrenList", -1, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}pesantren'), false, false, "far fa-building fa-xs", "", false);
$sideMenu->addMenuItem(52, "mci_Pendidikan", $MenuLanguage->MenuPhrase("52", "MenuText"), "", -1, "", true, false, true, "fas fa-graduation-cap", "", false);
$sideMenu->addMenuItem(3, "mi_pendidikanumum", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "PendidikanumumList?cmd=resetall", 52, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}pendidikanumum'), false, false, "far fa-circle fa-xs", "", false);
$sideMenu->addMenuItem(2, "mi_kitabkuning", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "KitabkuningList?cmd=resetall", 52, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}kitabkuning'), false, false, "far fa-circle fa-xs", "", false);
$sideMenu->addMenuItem(32, "mi_pendidikanpesantren", $MenuLanguage->MenuPhrase("32", "MenuText"), $MenuRelativePath . "PendidikanpesantrenList", 52, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}pendidikanpesantren'), false, false, "far fa-circle fa-xs", "", false);
$sideMenu->addMenuItem(27, "mci_Master_Data", $MenuLanguage->MenuPhrase("27", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "far fa-list-alt fa-xs", "", false);
$sideMenu->addMenuItem(8, "mi_user", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "UserList", 27, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}user'), false, false, "far fa-circle fa-xs", "", false);
$sideMenu->addMenuItem(10, "mi_userlevels", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "UserlevelsList", 27, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}userlevels'), false, false, "far fa-circle fa-xs", "", false);
echo $sideMenu->toScript();
