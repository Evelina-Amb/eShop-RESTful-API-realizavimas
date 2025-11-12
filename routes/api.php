<?php
use App\Http\Controllers\Api\{
    SalisController, MiestasController, AdresasController,
    KategorijaController, SkelbimuNuotraukaController,
    AtsiliepimasController, KrepselisController,
    IsimintiController, PirkimasController, PirkimoPrekeController, 
    UserController, SkelbimasController
};

Route::apiResources([
    'salis' => SalisController::class,
    'miestai' => MiestasController::class,
    'adresai' => AdresasController::class,
    'kategorijos' => KategorijaController::class,
    'nuotraukos' => SkelbimuNuotraukaController::class,
    'atsiliepimai' => AtsiliepimasController::class,
    'krepselis' => KrepselisController::class,
    'isiminti' => IsimintiController::class,
    'pirkimai' => PirkimasController::class,
    'pirkimo-prekes' => PirkimoPrekeController::class,
    'users' => UserController::class,
    'skelbimai'=> SkelbimasController::class,
]);
