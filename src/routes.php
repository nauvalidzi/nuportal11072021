<?php

namespace PHPMaker2021\nuportal;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // fasilitasusaha
    $app->any('/FasilitasusahaList[/{id}]', FasilitasusahaController::class . ':list')->add(PermissionMiddleware::class)->setName('FasilitasusahaList-fasilitasusaha-list'); // list
    $app->any('/FasilitasusahaAdd[/{id}]', FasilitasusahaController::class . ':add')->add(PermissionMiddleware::class)->setName('FasilitasusahaAdd-fasilitasusaha-add'); // add
    $app->any('/FasilitasusahaView[/{id}]', FasilitasusahaController::class . ':view')->add(PermissionMiddleware::class)->setName('FasilitasusahaView-fasilitasusaha-view'); // view
    $app->any('/FasilitasusahaEdit[/{id}]', FasilitasusahaController::class . ':edit')->add(PermissionMiddleware::class)->setName('FasilitasusahaEdit-fasilitasusaha-edit'); // edit
    $app->any('/FasilitasusahaDelete[/{id}]', FasilitasusahaController::class . ':delete')->add(PermissionMiddleware::class)->setName('FasilitasusahaDelete-fasilitasusaha-delete'); // delete
    $app->any('/FasilitasusahaPreview', FasilitasusahaController::class . ':preview')->add(PermissionMiddleware::class)->setName('FasilitasusahaPreview-fasilitasusaha-preview'); // preview
    $app->group(
        '/fasilitasusaha',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', FasilitasusahaController::class . ':list')->add(PermissionMiddleware::class)->setName('fasilitasusaha/list-fasilitasusaha-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', FasilitasusahaController::class . ':add')->add(PermissionMiddleware::class)->setName('fasilitasusaha/add-fasilitasusaha-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', FasilitasusahaController::class . ':view')->add(PermissionMiddleware::class)->setName('fasilitasusaha/view-fasilitasusaha-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', FasilitasusahaController::class . ':edit')->add(PermissionMiddleware::class)->setName('fasilitasusaha/edit-fasilitasusaha-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', FasilitasusahaController::class . ':delete')->add(PermissionMiddleware::class)->setName('fasilitasusaha/delete-fasilitasusaha-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', FasilitasusahaController::class . ':preview')->add(PermissionMiddleware::class)->setName('fasilitasusaha/preview-fasilitasusaha-preview-2'); // preview
        }
    );

    // kitabkuning
    $app->any('/KitabkuningList[/{id}]', KitabkuningController::class . ':list')->add(PermissionMiddleware::class)->setName('KitabkuningList-kitabkuning-list'); // list
    $app->any('/KitabkuningAdd[/{id}]', KitabkuningController::class . ':add')->add(PermissionMiddleware::class)->setName('KitabkuningAdd-kitabkuning-add'); // add
    $app->any('/KitabkuningView[/{id}]', KitabkuningController::class . ':view')->add(PermissionMiddleware::class)->setName('KitabkuningView-kitabkuning-view'); // view
    $app->any('/KitabkuningEdit[/{id}]', KitabkuningController::class . ':edit')->add(PermissionMiddleware::class)->setName('KitabkuningEdit-kitabkuning-edit'); // edit
    $app->any('/KitabkuningDelete[/{id}]', KitabkuningController::class . ':delete')->add(PermissionMiddleware::class)->setName('KitabkuningDelete-kitabkuning-delete'); // delete
    $app->any('/KitabkuningPreview', KitabkuningController::class . ':preview')->add(PermissionMiddleware::class)->setName('KitabkuningPreview-kitabkuning-preview'); // preview
    $app->group(
        '/kitabkuning',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KitabkuningController::class . ':list')->add(PermissionMiddleware::class)->setName('kitabkuning/list-kitabkuning-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KitabkuningController::class . ':add')->add(PermissionMiddleware::class)->setName('kitabkuning/add-kitabkuning-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KitabkuningController::class . ':view')->add(PermissionMiddleware::class)->setName('kitabkuning/view-kitabkuning-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KitabkuningController::class . ':edit')->add(PermissionMiddleware::class)->setName('kitabkuning/edit-kitabkuning-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KitabkuningController::class . ':delete')->add(PermissionMiddleware::class)->setName('kitabkuning/delete-kitabkuning-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', KitabkuningController::class . ':preview')->add(PermissionMiddleware::class)->setName('kitabkuning/preview-kitabkuning-preview-2'); // preview
        }
    );

    // pendidikanumum
    $app->any('/PendidikanumumList[/{id}]', PendidikanumumController::class . ':list')->add(PermissionMiddleware::class)->setName('PendidikanumumList-pendidikanumum-list'); // list
    $app->any('/PendidikanumumAdd[/{id}]', PendidikanumumController::class . ':add')->add(PermissionMiddleware::class)->setName('PendidikanumumAdd-pendidikanumum-add'); // add
    $app->any('/PendidikanumumView[/{id}]', PendidikanumumController::class . ':view')->add(PermissionMiddleware::class)->setName('PendidikanumumView-pendidikanumum-view'); // view
    $app->any('/PendidikanumumEdit[/{id}]', PendidikanumumController::class . ':edit')->add(PermissionMiddleware::class)->setName('PendidikanumumEdit-pendidikanumum-edit'); // edit
    $app->any('/PendidikanumumDelete[/{id}]', PendidikanumumController::class . ':delete')->add(PermissionMiddleware::class)->setName('PendidikanumumDelete-pendidikanumum-delete'); // delete
    $app->any('/PendidikanumumPreview', PendidikanumumController::class . ':preview')->add(PermissionMiddleware::class)->setName('PendidikanumumPreview-pendidikanumum-preview'); // preview
    $app->group(
        '/pendidikanumum',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PendidikanumumController::class . ':list')->add(PermissionMiddleware::class)->setName('pendidikanumum/list-pendidikanumum-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PendidikanumumController::class . ':add')->add(PermissionMiddleware::class)->setName('pendidikanumum/add-pendidikanumum-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PendidikanumumController::class . ':view')->add(PermissionMiddleware::class)->setName('pendidikanumum/view-pendidikanumum-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PendidikanumumController::class . ':edit')->add(PermissionMiddleware::class)->setName('pendidikanumum/edit-pendidikanumum-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PendidikanumumController::class . ':delete')->add(PermissionMiddleware::class)->setName('pendidikanumum/delete-pendidikanumum-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', PendidikanumumController::class . ':preview')->add(PermissionMiddleware::class)->setName('pendidikanumum/preview-pendidikanumum-preview-2'); // preview
        }
    );

    // pengasuhpppria
    $app->any('/PengasuhpppriaList[/{id}]', PengasuhpppriaController::class . ':list')->add(PermissionMiddleware::class)->setName('PengasuhpppriaList-pengasuhpppria-list'); // list
    $app->any('/PengasuhpppriaAdd[/{id}]', PengasuhpppriaController::class . ':add')->add(PermissionMiddleware::class)->setName('PengasuhpppriaAdd-pengasuhpppria-add'); // add
    $app->any('/PengasuhpppriaView[/{id}]', PengasuhpppriaController::class . ':view')->add(PermissionMiddleware::class)->setName('PengasuhpppriaView-pengasuhpppria-view'); // view
    $app->any('/PengasuhpppriaEdit[/{id}]', PengasuhpppriaController::class . ':edit')->add(PermissionMiddleware::class)->setName('PengasuhpppriaEdit-pengasuhpppria-edit'); // edit
    $app->any('/PengasuhpppriaDelete[/{id}]', PengasuhpppriaController::class . ':delete')->add(PermissionMiddleware::class)->setName('PengasuhpppriaDelete-pengasuhpppria-delete'); // delete
    $app->any('/PengasuhpppriaPreview', PengasuhpppriaController::class . ':preview')->add(PermissionMiddleware::class)->setName('PengasuhpppriaPreview-pengasuhpppria-preview'); // preview
    $app->group(
        '/pengasuhpppria',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PengasuhpppriaController::class . ':list')->add(PermissionMiddleware::class)->setName('pengasuhpppria/list-pengasuhpppria-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PengasuhpppriaController::class . ':add')->add(PermissionMiddleware::class)->setName('pengasuhpppria/add-pengasuhpppria-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PengasuhpppriaController::class . ':view')->add(PermissionMiddleware::class)->setName('pengasuhpppria/view-pengasuhpppria-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PengasuhpppriaController::class . ':edit')->add(PermissionMiddleware::class)->setName('pengasuhpppria/edit-pengasuhpppria-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PengasuhpppriaController::class . ':delete')->add(PermissionMiddleware::class)->setName('pengasuhpppria/delete-pengasuhpppria-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', PengasuhpppriaController::class . ':preview')->add(PermissionMiddleware::class)->setName('pengasuhpppria/preview-pengasuhpppria-preview-2'); // preview
        }
    );

    // pengasuhppwanita
    $app->any('/PengasuhppwanitaList[/{id}]', PengasuhppwanitaController::class . ':list')->add(PermissionMiddleware::class)->setName('PengasuhppwanitaList-pengasuhppwanita-list'); // list
    $app->any('/PengasuhppwanitaAdd[/{id}]', PengasuhppwanitaController::class . ':add')->add(PermissionMiddleware::class)->setName('PengasuhppwanitaAdd-pengasuhppwanita-add'); // add
    $app->any('/PengasuhppwanitaView[/{id}]', PengasuhppwanitaController::class . ':view')->add(PermissionMiddleware::class)->setName('PengasuhppwanitaView-pengasuhppwanita-view'); // view
    $app->any('/PengasuhppwanitaEdit[/{id}]', PengasuhppwanitaController::class . ':edit')->add(PermissionMiddleware::class)->setName('PengasuhppwanitaEdit-pengasuhppwanita-edit'); // edit
    $app->any('/PengasuhppwanitaDelete[/{id}]', PengasuhppwanitaController::class . ':delete')->add(PermissionMiddleware::class)->setName('PengasuhppwanitaDelete-pengasuhppwanita-delete'); // delete
    $app->any('/PengasuhppwanitaPreview', PengasuhppwanitaController::class . ':preview')->add(PermissionMiddleware::class)->setName('PengasuhppwanitaPreview-pengasuhppwanita-preview'); // preview
    $app->group(
        '/pengasuhppwanita',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PengasuhppwanitaController::class . ':list')->add(PermissionMiddleware::class)->setName('pengasuhppwanita/list-pengasuhppwanita-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PengasuhppwanitaController::class . ':add')->add(PermissionMiddleware::class)->setName('pengasuhppwanita/add-pengasuhppwanita-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PengasuhppwanitaController::class . ':view')->add(PermissionMiddleware::class)->setName('pengasuhppwanita/view-pengasuhppwanita-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PengasuhppwanitaController::class . ':edit')->add(PermissionMiddleware::class)->setName('pengasuhppwanita/edit-pengasuhppwanita-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PengasuhppwanitaController::class . ':delete')->add(PermissionMiddleware::class)->setName('pengasuhppwanita/delete-pengasuhppwanita-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', PengasuhppwanitaController::class . ':preview')->add(PermissionMiddleware::class)->setName('pengasuhppwanita/preview-pengasuhppwanita-preview-2'); // preview
        }
    );

    // pesantren
    $app->any('/PesantrenList[/{id}]', PesantrenController::class . ':list')->add(PermissionMiddleware::class)->setName('PesantrenList-pesantren-list'); // list
    $app->any('/PesantrenAdd[/{id}]', PesantrenController::class . ':add')->add(PermissionMiddleware::class)->setName('PesantrenAdd-pesantren-add'); // add
    $app->any('/PesantrenView[/{id}]', PesantrenController::class . ':view')->add(PermissionMiddleware::class)->setName('PesantrenView-pesantren-view'); // view
    $app->any('/PesantrenEdit[/{id}]', PesantrenController::class . ':edit')->add(PermissionMiddleware::class)->setName('PesantrenEdit-pesantren-edit'); // edit
    $app->any('/PesantrenDelete[/{id}]', PesantrenController::class . ':delete')->add(PermissionMiddleware::class)->setName('PesantrenDelete-pesantren-delete'); // delete
    $app->group(
        '/pesantren',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PesantrenController::class . ':list')->add(PermissionMiddleware::class)->setName('pesantren/list-pesantren-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PesantrenController::class . ':add')->add(PermissionMiddleware::class)->setName('pesantren/add-pesantren-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PesantrenController::class . ':view')->add(PermissionMiddleware::class)->setName('pesantren/view-pesantren-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PesantrenController::class . ':edit')->add(PermissionMiddleware::class)->setName('pesantren/edit-pesantren-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PesantrenController::class . ':delete')->add(PermissionMiddleware::class)->setName('pesantren/delete-pesantren-delete-2'); // delete
        }
    );

    // user
    $app->any('/UserList[/{id}]', UserController::class . ':list')->add(PermissionMiddleware::class)->setName('UserList-user-list'); // list
    $app->any('/UserAdd[/{id}]', UserController::class . ':add')->add(PermissionMiddleware::class)->setName('UserAdd-user-add'); // add
    $app->any('/UserView[/{id}]', UserController::class . ':view')->add(PermissionMiddleware::class)->setName('UserView-user-view'); // view
    $app->any('/UserEdit[/{id}]', UserController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserEdit-user-edit'); // edit
    $app->any('/UserDelete[/{id}]', UserController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserDelete-user-delete'); // delete
    $app->group(
        '/user',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', UserController::class . ':list')->add(PermissionMiddleware::class)->setName('user/list-user-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', UserController::class . ':add')->add(PermissionMiddleware::class)->setName('user/add-user-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', UserController::class . ':view')->add(PermissionMiddleware::class)->setName('user/view-user-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', UserController::class . ':edit')->add(PermissionMiddleware::class)->setName('user/edit-user-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', UserController::class . ':delete')->add(PermissionMiddleware::class)->setName('user/delete-user-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->any('/UserlevelpermissionsList', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsList-userlevelpermissions-list'); // list
    $app->any('/UserlevelpermissionsAdd', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsAdd-userlevelpermissions-add'); // add
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
        }
    );

    // userlevels
    $app->any('/UserlevelsList', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelsList-userlevels-list'); // list
    $app->any('/UserlevelsAdd', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelsAdd-userlevels-add'); // add
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
        }
    );

    // fasilitaspesantren
    $app->any('/FasilitaspesantrenList[/{id}]', FasilitaspesantrenController::class . ':list')->add(PermissionMiddleware::class)->setName('FasilitaspesantrenList-fasilitaspesantren-list'); // list
    $app->any('/FasilitaspesantrenAdd[/{id}]', FasilitaspesantrenController::class . ':add')->add(PermissionMiddleware::class)->setName('FasilitaspesantrenAdd-fasilitaspesantren-add'); // add
    $app->any('/FasilitaspesantrenView[/{id}]', FasilitaspesantrenController::class . ':view')->add(PermissionMiddleware::class)->setName('FasilitaspesantrenView-fasilitaspesantren-view'); // view
    $app->any('/FasilitaspesantrenEdit[/{id}]', FasilitaspesantrenController::class . ':edit')->add(PermissionMiddleware::class)->setName('FasilitaspesantrenEdit-fasilitaspesantren-edit'); // edit
    $app->any('/FasilitaspesantrenDelete[/{id}]', FasilitaspesantrenController::class . ':delete')->add(PermissionMiddleware::class)->setName('FasilitaspesantrenDelete-fasilitaspesantren-delete'); // delete
    $app->any('/FasilitaspesantrenPreview', FasilitaspesantrenController::class . ':preview')->add(PermissionMiddleware::class)->setName('FasilitaspesantrenPreview-fasilitaspesantren-preview'); // preview
    $app->group(
        '/fasilitaspesantren',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', FasilitaspesantrenController::class . ':list')->add(PermissionMiddleware::class)->setName('fasilitaspesantren/list-fasilitaspesantren-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', FasilitaspesantrenController::class . ':add')->add(PermissionMiddleware::class)->setName('fasilitaspesantren/add-fasilitaspesantren-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', FasilitaspesantrenController::class . ':view')->add(PermissionMiddleware::class)->setName('fasilitaspesantren/view-fasilitaspesantren-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', FasilitaspesantrenController::class . ':edit')->add(PermissionMiddleware::class)->setName('fasilitaspesantren/edit-fasilitaspesantren-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', FasilitaspesantrenController::class . ':delete')->add(PermissionMiddleware::class)->setName('fasilitaspesantren/delete-fasilitaspesantren-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', FasilitaspesantrenController::class . ':preview')->add(PermissionMiddleware::class)->setName('fasilitaspesantren/preview-fasilitaspesantren-preview-2'); // preview
        }
    );

    // berita
    $app->any('/BeritaList[/{id}]', BeritaController::class . ':list')->add(PermissionMiddleware::class)->setName('BeritaList-berita-list'); // list
    $app->any('/BeritaAdd[/{id}]', BeritaController::class . ':add')->add(PermissionMiddleware::class)->setName('BeritaAdd-berita-add'); // add
    $app->any('/BeritaView[/{id}]', BeritaController::class . ':view')->add(PermissionMiddleware::class)->setName('BeritaView-berita-view'); // view
    $app->any('/BeritaEdit[/{id}]', BeritaController::class . ':edit')->add(PermissionMiddleware::class)->setName('BeritaEdit-berita-edit'); // edit
    $app->any('/BeritaDelete[/{id}]', BeritaController::class . ':delete')->add(PermissionMiddleware::class)->setName('BeritaDelete-berita-delete'); // delete
    $app->group(
        '/berita',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', BeritaController::class . ':list')->add(PermissionMiddleware::class)->setName('berita/list-berita-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', BeritaController::class . ':add')->add(PermissionMiddleware::class)->setName('berita/add-berita-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', BeritaController::class . ':view')->add(PermissionMiddleware::class)->setName('berita/view-berita-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', BeritaController::class . ':edit')->add(PermissionMiddleware::class)->setName('berita/edit-berita-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', BeritaController::class . ':delete')->add(PermissionMiddleware::class)->setName('berita/delete-berita-delete-2'); // delete
        }
    );

    // kabupatens
    $app->any('/KabupatensList[/{id}]', KabupatensController::class . ':list')->add(PermissionMiddleware::class)->setName('KabupatensList-kabupatens-list'); // list
    $app->any('/KabupatensAdd[/{id}]', KabupatensController::class . ':add')->add(PermissionMiddleware::class)->setName('KabupatensAdd-kabupatens-add'); // add
    $app->any('/KabupatensView[/{id}]', KabupatensController::class . ':view')->add(PermissionMiddleware::class)->setName('KabupatensView-kabupatens-view'); // view
    $app->any('/KabupatensEdit[/{id}]', KabupatensController::class . ':edit')->add(PermissionMiddleware::class)->setName('KabupatensEdit-kabupatens-edit'); // edit
    $app->any('/KabupatensDelete[/{id}]', KabupatensController::class . ':delete')->add(PermissionMiddleware::class)->setName('KabupatensDelete-kabupatens-delete'); // delete
    $app->group(
        '/kabupatens',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KabupatensController::class . ':list')->add(PermissionMiddleware::class)->setName('kabupatens/list-kabupatens-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KabupatensController::class . ':add')->add(PermissionMiddleware::class)->setName('kabupatens/add-kabupatens-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KabupatensController::class . ':view')->add(PermissionMiddleware::class)->setName('kabupatens/view-kabupatens-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KabupatensController::class . ':edit')->add(PermissionMiddleware::class)->setName('kabupatens/edit-kabupatens-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KabupatensController::class . ':delete')->add(PermissionMiddleware::class)->setName('kabupatens/delete-kabupatens-delete-2'); // delete
        }
    );

    // kecamatans
    $app->any('/KecamatansList[/{id}]', KecamatansController::class . ':list')->add(PermissionMiddleware::class)->setName('KecamatansList-kecamatans-list'); // list
    $app->any('/KecamatansAdd[/{id}]', KecamatansController::class . ':add')->add(PermissionMiddleware::class)->setName('KecamatansAdd-kecamatans-add'); // add
    $app->any('/KecamatansView[/{id}]', KecamatansController::class . ':view')->add(PermissionMiddleware::class)->setName('KecamatansView-kecamatans-view'); // view
    $app->any('/KecamatansEdit[/{id}]', KecamatansController::class . ':edit')->add(PermissionMiddleware::class)->setName('KecamatansEdit-kecamatans-edit'); // edit
    $app->any('/KecamatansDelete[/{id}]', KecamatansController::class . ':delete')->add(PermissionMiddleware::class)->setName('KecamatansDelete-kecamatans-delete'); // delete
    $app->group(
        '/kecamatans',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KecamatansController::class . ':list')->add(PermissionMiddleware::class)->setName('kecamatans/list-kecamatans-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KecamatansController::class . ':add')->add(PermissionMiddleware::class)->setName('kecamatans/add-kecamatans-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KecamatansController::class . ':view')->add(PermissionMiddleware::class)->setName('kecamatans/view-kecamatans-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KecamatansController::class . ':edit')->add(PermissionMiddleware::class)->setName('kecamatans/edit-kecamatans-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KecamatansController::class . ':delete')->add(PermissionMiddleware::class)->setName('kecamatans/delete-kecamatans-delete-2'); // delete
        }
    );

    // kelurahans
    $app->any('/KelurahansList[/{id}]', KelurahansController::class . ':list')->add(PermissionMiddleware::class)->setName('KelurahansList-kelurahans-list'); // list
    $app->any('/KelurahansAdd[/{id}]', KelurahansController::class . ':add')->add(PermissionMiddleware::class)->setName('KelurahansAdd-kelurahans-add'); // add
    $app->any('/KelurahansView[/{id}]', KelurahansController::class . ':view')->add(PermissionMiddleware::class)->setName('KelurahansView-kelurahans-view'); // view
    $app->any('/KelurahansEdit[/{id}]', KelurahansController::class . ':edit')->add(PermissionMiddleware::class)->setName('KelurahansEdit-kelurahans-edit'); // edit
    $app->any('/KelurahansDelete[/{id}]', KelurahansController::class . ':delete')->add(PermissionMiddleware::class)->setName('KelurahansDelete-kelurahans-delete'); // delete
    $app->group(
        '/kelurahans',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KelurahansController::class . ':list')->add(PermissionMiddleware::class)->setName('kelurahans/list-kelurahans-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KelurahansController::class . ':add')->add(PermissionMiddleware::class)->setName('kelurahans/add-kelurahans-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KelurahansController::class . ':view')->add(PermissionMiddleware::class)->setName('kelurahans/view-kelurahans-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KelurahansController::class . ':edit')->add(PermissionMiddleware::class)->setName('kelurahans/edit-kelurahans-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KelurahansController::class . ':delete')->add(PermissionMiddleware::class)->setName('kelurahans/delete-kelurahans-delete-2'); // delete
        }
    );

    // provinsis
    $app->any('/ProvinsisList[/{id}]', ProvinsisController::class . ':list')->add(PermissionMiddleware::class)->setName('ProvinsisList-provinsis-list'); // list
    $app->any('/ProvinsisAdd[/{id}]', ProvinsisController::class . ':add')->add(PermissionMiddleware::class)->setName('ProvinsisAdd-provinsis-add'); // add
    $app->group(
        '/provinsis',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', ProvinsisController::class . ':list')->add(PermissionMiddleware::class)->setName('provinsis/list-provinsis-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', ProvinsisController::class . ':add')->add(PermissionMiddleware::class)->setName('provinsis/add-provinsis-add-2'); // add
        }
    );

    // jenispendidikanumum
    $app->any('/JenispendidikanumumList[/{id}]', JenispendidikanumumController::class . ':list')->add(PermissionMiddleware::class)->setName('JenispendidikanumumList-jenispendidikanumum-list'); // list
    $app->any('/JenispendidikanumumAdd[/{id}]', JenispendidikanumumController::class . ':add')->add(PermissionMiddleware::class)->setName('JenispendidikanumumAdd-jenispendidikanumum-add'); // add
    $app->any('/JenispendidikanumumView[/{id}]', JenispendidikanumumController::class . ':view')->add(PermissionMiddleware::class)->setName('JenispendidikanumumView-jenispendidikanumum-view'); // view
    $app->any('/JenispendidikanumumEdit[/{id}]', JenispendidikanumumController::class . ':edit')->add(PermissionMiddleware::class)->setName('JenispendidikanumumEdit-jenispendidikanumum-edit'); // edit
    $app->any('/JenispendidikanumumDelete[/{id}]', JenispendidikanumumController::class . ':delete')->add(PermissionMiddleware::class)->setName('JenispendidikanumumDelete-jenispendidikanumum-delete'); // delete
    $app->group(
        '/jenispendidikanumum',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', JenispendidikanumumController::class . ':list')->add(PermissionMiddleware::class)->setName('jenispendidikanumum/list-jenispendidikanumum-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', JenispendidikanumumController::class . ':add')->add(PermissionMiddleware::class)->setName('jenispendidikanumum/add-jenispendidikanumum-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', JenispendidikanumumController::class . ':view')->add(PermissionMiddleware::class)->setName('jenispendidikanumum/view-jenispendidikanumum-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', JenispendidikanumumController::class . ':edit')->add(PermissionMiddleware::class)->setName('jenispendidikanumum/edit-jenispendidikanumum-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', JenispendidikanumumController::class . ':delete')->add(PermissionMiddleware::class)->setName('jenispendidikanumum/delete-jenispendidikanumum-delete-2'); // delete
        }
    );

    // wilayah
    $app->any('/WilayahList[/{id}]', WilayahController::class . ':list')->add(PermissionMiddleware::class)->setName('WilayahList-wilayah-list'); // list
    $app->any('/WilayahAdd[/{id}]', WilayahController::class . ':add')->add(PermissionMiddleware::class)->setName('WilayahAdd-wilayah-add'); // add
    $app->any('/WilayahView[/{id}]', WilayahController::class . ':view')->add(PermissionMiddleware::class)->setName('WilayahView-wilayah-view'); // view
    $app->any('/WilayahEdit[/{id}]', WilayahController::class . ':edit')->add(PermissionMiddleware::class)->setName('WilayahEdit-wilayah-edit'); // edit
    $app->any('/WilayahDelete[/{id}]', WilayahController::class . ':delete')->add(PermissionMiddleware::class)->setName('WilayahDelete-wilayah-delete'); // delete
    $app->any('/WilayahPreview', WilayahController::class . ':preview')->add(PermissionMiddleware::class)->setName('WilayahPreview-wilayah-preview'); // preview
    $app->group(
        '/wilayah',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', WilayahController::class . ':list')->add(PermissionMiddleware::class)->setName('wilayah/list-wilayah-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', WilayahController::class . ':add')->add(PermissionMiddleware::class)->setName('wilayah/add-wilayah-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', WilayahController::class . ':view')->add(PermissionMiddleware::class)->setName('wilayah/view-wilayah-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', WilayahController::class . ':edit')->add(PermissionMiddleware::class)->setName('wilayah/edit-wilayah-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', WilayahController::class . ':delete')->add(PermissionMiddleware::class)->setName('wilayah/delete-wilayah-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', WilayahController::class . ':preview')->add(PermissionMiddleware::class)->setName('wilayah/preview-wilayah-preview-2'); // preview
        }
    );

    // jenispendidikanpesantren
    $app->any('/JenispendidikanpesantrenList[/{id}]', JenispendidikanpesantrenController::class . ':list')->add(PermissionMiddleware::class)->setName('JenispendidikanpesantrenList-jenispendidikanpesantren-list'); // list
    $app->any('/JenispendidikanpesantrenAdd[/{id}]', JenispendidikanpesantrenController::class . ':add')->add(PermissionMiddleware::class)->setName('JenispendidikanpesantrenAdd-jenispendidikanpesantren-add'); // add
    $app->any('/JenispendidikanpesantrenView[/{id}]', JenispendidikanpesantrenController::class . ':view')->add(PermissionMiddleware::class)->setName('JenispendidikanpesantrenView-jenispendidikanpesantren-view'); // view
    $app->any('/JenispendidikanpesantrenEdit[/{id}]', JenispendidikanpesantrenController::class . ':edit')->add(PermissionMiddleware::class)->setName('JenispendidikanpesantrenEdit-jenispendidikanpesantren-edit'); // edit
    $app->any('/JenispendidikanpesantrenDelete[/{id}]', JenispendidikanpesantrenController::class . ':delete')->add(PermissionMiddleware::class)->setName('JenispendidikanpesantrenDelete-jenispendidikanpesantren-delete'); // delete
    $app->group(
        '/jenispendidikanpesantren',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', JenispendidikanpesantrenController::class . ':list')->add(PermissionMiddleware::class)->setName('jenispendidikanpesantren/list-jenispendidikanpesantren-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', JenispendidikanpesantrenController::class . ':add')->add(PermissionMiddleware::class)->setName('jenispendidikanpesantren/add-jenispendidikanpesantren-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', JenispendidikanpesantrenController::class . ':view')->add(PermissionMiddleware::class)->setName('jenispendidikanpesantren/view-jenispendidikanpesantren-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', JenispendidikanpesantrenController::class . ':edit')->add(PermissionMiddleware::class)->setName('jenispendidikanpesantren/edit-jenispendidikanpesantren-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', JenispendidikanpesantrenController::class . ':delete')->add(PermissionMiddleware::class)->setName('jenispendidikanpesantren/delete-jenispendidikanpesantren-delete-2'); // delete
        }
    );

    // pendidikanpesantren
    $app->any('/PendidikanpesantrenList[/{id}]', PendidikanpesantrenController::class . ':list')->add(PermissionMiddleware::class)->setName('PendidikanpesantrenList-pendidikanpesantren-list'); // list
    $app->any('/PendidikanpesantrenAdd[/{id}]', PendidikanpesantrenController::class . ':add')->add(PermissionMiddleware::class)->setName('PendidikanpesantrenAdd-pendidikanpesantren-add'); // add
    $app->any('/PendidikanpesantrenView[/{id}]', PendidikanpesantrenController::class . ':view')->add(PermissionMiddleware::class)->setName('PendidikanpesantrenView-pendidikanpesantren-view'); // view
    $app->any('/PendidikanpesantrenEdit[/{id}]', PendidikanpesantrenController::class . ':edit')->add(PermissionMiddleware::class)->setName('PendidikanpesantrenEdit-pendidikanpesantren-edit'); // edit
    $app->any('/PendidikanpesantrenDelete[/{id}]', PendidikanpesantrenController::class . ':delete')->add(PermissionMiddleware::class)->setName('PendidikanpesantrenDelete-pendidikanpesantren-delete'); // delete
    $app->any('/PendidikanpesantrenPreview', PendidikanpesantrenController::class . ':preview')->add(PermissionMiddleware::class)->setName('PendidikanpesantrenPreview-pendidikanpesantren-preview'); // preview
    $app->group(
        '/pendidikanpesantren',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PendidikanpesantrenController::class . ':list')->add(PermissionMiddleware::class)->setName('pendidikanpesantren/list-pendidikanpesantren-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PendidikanpesantrenController::class . ':add')->add(PermissionMiddleware::class)->setName('pendidikanpesantren/add-pendidikanpesantren-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PendidikanpesantrenController::class . ':view')->add(PermissionMiddleware::class)->setName('pendidikanpesantren/view-pendidikanpesantren-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PendidikanpesantrenController::class . ':edit')->add(PermissionMiddleware::class)->setName('pendidikanpesantren/edit-pendidikanpesantren-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PendidikanpesantrenController::class . ':delete')->add(PermissionMiddleware::class)->setName('pendidikanpesantren/delete-pendidikanpesantren-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', PendidikanpesantrenController::class . ':preview')->add(PermissionMiddleware::class)->setName('pendidikanpesantren/preview-pendidikanpesantren-preview-2'); // preview
        }
    );

    // kodepos
    $app->any('/KodeposList[/{id}]', KodeposController::class . ':list')->add(PermissionMiddleware::class)->setName('KodeposList-kodepos-list'); // list
    $app->any('/KodeposAdd[/{id}]', KodeposController::class . ':add')->add(PermissionMiddleware::class)->setName('KodeposAdd-kodepos-add'); // add
    $app->any('/KodeposView[/{id}]', KodeposController::class . ':view')->add(PermissionMiddleware::class)->setName('KodeposView-kodepos-view'); // view
    $app->any('/KodeposEdit[/{id}]', KodeposController::class . ':edit')->add(PermissionMiddleware::class)->setName('KodeposEdit-kodepos-edit'); // edit
    $app->any('/KodeposDelete[/{id}]', KodeposController::class . ':delete')->add(PermissionMiddleware::class)->setName('KodeposDelete-kodepos-delete'); // delete
    $app->group(
        '/kodepos',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', KodeposController::class . ':list')->add(PermissionMiddleware::class)->setName('kodepos/list-kodepos-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', KodeposController::class . ':add')->add(PermissionMiddleware::class)->setName('kodepos/add-kodepos-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', KodeposController::class . ':view')->add(PermissionMiddleware::class)->setName('kodepos/view-kodepos-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', KodeposController::class . ':edit')->add(PermissionMiddleware::class)->setName('kodepos/edit-kodepos-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', KodeposController::class . ':delete')->add(PermissionMiddleware::class)->setName('kodepos/delete-kodepos-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // reset_password
    $app->any('/resetpassword', OthersController::class . ':resetpassword')->add(PermissionMiddleware::class)->setName('resetpassword');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // register
    $app->any('/register', OthersController::class . ':register')->add(PermissionMiddleware::class)->setName('register');

    // userpriv
    $app->any('/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // captcha
    $app->any('/captcha[/{page}]', OthersController::class . ':captcha')->add(PermissionMiddleware::class)->setName('captcha');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
