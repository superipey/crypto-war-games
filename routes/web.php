<?php

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

/* Login */

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@doLogin');
Route::get('/logout', 'Auth\LoginController@logout');

/* Register */
Route::get('/register', 'HomeController@registrasi');
Route::post('/register', 'HomeController@doRegister');

Route::group(['middleware'=>['auth:web']], function() {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::post('/submit-cipher', 'HomeController@submitCipher');
    Route::post('/submit-enemies', 'HomeController@answer');
    Route::post('/guess', 'HomeController@guess');

    Route::get('/create_soal', 'HomeController@soal');
});

Route::get("/teamlist", function() {
    $teams = \App\Team::all();
    echo "<table>";
    echo "  <tr>";
    echo "    <th>No</th>";
    echo "    <th>Kelas</th>";
    echo "    <th>Nama Team</th>";
    echo "    <th>Anggota</th>";
    echo "    <th>Status Cipher</th>";
    echo "  </tr>";
    $i = 1;
    foreach ($teams as $team) {
        echo "<tr>";
        echo "  <td>".$i++."</td>";
        $members = $team->members;
        $name = [];
        $cipher = [];
        $kelas = '';
        foreach ($members as $player) {
            if (!empty($player->cipher)) $cipher[] = $player->cipher->id;
            $name[] = $player->name;
            $kelas = $player->kelas;
        }
        $name = implode("<br>", $name);
        echo "  <td>$kelas</td>";
        echo "  <td>$team->team_name</td>";
        echo "  <td>$name</td>";

        $cipher = implode("<br>", $cipher);

        echo "  <td>".(!empty($cipher) ? 'OK':'Revisi')."</td>";

        echo "</tr>";
    }
    echo "</table>";
});