<?php 

//////////////////
// ROOT CONTEXT //
//////////////////

Route::get('dashboard', [
    'as'   => 'dashboard',
    'uses' => 'RootController@getIndex',
]);

Route::get('sudo/{userId}', [
    'as'   => 'sudo',
    'uses' => 'RootController@getSudo',
])->where('userId', '\d*');
