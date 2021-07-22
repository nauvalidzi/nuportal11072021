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
$sideMenu->addMenuItem(53, "mi_kodepos", $MenuLanguage->MenuPhrase("53", "MenuText"), $MenuRelativePath . "KodeposList", -1, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}kodepos'), false, false, "", "", false);
$sideMenu->addMenuItem(12, "mi_berita", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "BeritaList", -1, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}berita'), false, false, "far fa-newspaper fa-xs", "", false);
$sideMenu->addMenuItem(6, "mi_pesantren", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "PesantrenList", -1, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}pesantren'), false, false, "far fa-building fa-xs", "", false);
$sideMenu->addMenuItem(27, "mci_Master_Data", $MenuLanguage->MenuPhrase("27", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "far fa-list-alt fa-xs", "", false);
$sideMenu->addMenuItem(8, "mi_user", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "UserList", 27, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}user'), false, false, "far fa-circle fa-xs", "", false);
$sideMenu->addMenuItem(10, "mi_userlevels", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "UserlevelsList", 27, "", AllowListMenu('{1FAB4C92-5B97-4B2C-B4F4-C3AA3E8F827A}userlevels'), false, false, "far fa-circle fa-xs", "", false);
echo $sideMenu->toScript();
