<?php



//porduction
Route::get('/productions', 'ProductionController@index')->name('production.index');
Route::POST('/productions/table','ProductionController@production_dataTable')->name('production.dataTable');
Route::get('/productions/{production}', 'ProductionController@showEdit')->name('production.showEdit');
Route::get('/productions/show/{production}', 'ProductionController@show')->name('production.show');
Route::POST('/productions/{production}/edit','ProductionController@update')->name('production.update');
Route::GET('/productions/ajouter/production','ProductionController@ShowAdd')->name('production.add');
Route::POST('/productions/ajouter/add','ProductionController@store')->name('production.store');
Route::POST('/productions/{production}/info','ProductionController@info')->name('production.info');
Route::POST('/productions/taux/CommBr','ProductionController@tauxCommBr')->name('production.tauxCommBr');
Route::POST('/productions/taux/tva','ProductionController@tauxTva')->name('production.tauxTva');
Route::post('productions/delete/Prod', 'ProductionController@deleteProductionId')->name('production.deleteProd');
