<?php

use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    return json_encode([__FILE__ => __LINE__]);
});
