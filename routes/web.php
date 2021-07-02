<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route di login
Route::get('login', 'LoginController@login');
Route::post('login', 'LoginController@checkLogin');
Route::get('logout', 'LoginController@logout');

//Route della pagina home
Route::get('home', 'HomeController@index');
Route::get('pizzerie', 'HomeController@pizzerie');
Route::get('preferiti', 'HomeController@preferiti');
Route::get("aggiungiPreferito/{pizzeria_id}", 'HomeController@aggiungiPreferito');
Route::get("rimuoviPreferito/{pizzeria_id}", 'HomeController@rimuoviPreferito');
Route::get('isCartEmpty', 'HomeController@isCartEmpty');

//Route della pagina pizze
Route::get('pizze', 'PizzeController@index');
Route::get('getPizze', 'PizzeController@getPizze');

//Route della pagina del carrello
Route::get('carrello', 'CarrelloController@index');
Route::post('aggiungiCarrello', 'CarrelloController@aggiungiCarrello');
Route::get('rimuoviCarrello/{pizza}/{pizzeria}', 'CarrelloController@rimuoviCarrello');
Route::get('getCarrello', 'CarrelloController@getCarrello');
Route::get('isCartEmpty', 'CarrelloController@isCartEmpty');
Route::post('inviaOrdine', 'CarrelloController@inviaOrdine');

//Route della pagina i miei ordini
Route::get('i_miei_ordini', 'OrdiniController@index');
Route::get('getOrdini', 'OrdiniController@getOrdini');

//Route della pagina pizze preferite
Route::get('pizze_preferite', 'PizzePreferiteController@index');
Route::get('getPizzaPreferita', 'PizzePreferiteController@getPizzaPreferita');

//Route per effettuare la richiesta alla API REST
Route::get('edamam_API/{ricetta}', 'HomeController@getRicette');