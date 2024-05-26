<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BaranjaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Md5Controller;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\VerificationEmailController;



// chech the default connection
Route::get('/check-db-connection', function () {
    try {
        DB::connection()->getPdo();
        return "Connected to database: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});


// check the connection with 20.40
Route::get('/check-db-connection-twent-forty', function () {
    try {
        // Try executing a simple query to check the database connection
        DB::connection('testConnection')->getPdo();
        return "Connected to the database successfully!";
    } catch (\Exception $e) {
        return "Failed to connect to the database: " . $e->getMessage();
    }
});


//  'verified'

Route::group(['middleware' => ['auth']], function () {

    Route::get('/tasks/ajax-search', [SearchController::class, 'ajaxSearch'])->name('tasks.ajaxSearch');


    Route::get('/index', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/show/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/update/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/delete/{task}', [TaskController::class, 'destroy'])->name('tasks.delete');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');    
});

Route::post("/register", [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class,'login'])->name('login.post');

Route::get('/', [AuthController::class, 'default_authentication']);
Route::get("/register", [AuthController::class, 'register_index'])->name('register.get');
Route::get('/login', [AuthController::class,'login_index'])->name('login.get');

Route::get('/email/verify', [VerificationEmailController::class, 'show'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationEmailController::class, 'verify'])->name('verification.verify')->middleware(['auth', 'signed']);
Route::post('/email/resend', [VerificationEmailController::class, 'resend'])->name('verification.resend')->middleware(['auth', 'throttle:6,1']);













/********************************************************************************** */
/********************************************************************************** */
/********************************************************************************** */

Route::get('/allUsersWithEmail', [AuthController::class, 'allUsersWithEmail']);

// from baranja
Route::get('/retrieveAllUsersFromBaranja', [BaranjaController::class, 'retrieveAllUsersFromBaranja']); // DB way 
Route::get('/allEmailsFromBaranjaDB', [BaranjaController::class, 'allEmailsFromBaranjaDB']); // DB way 
Route::get('/allActiveEmailsBaranjaModel', [BaranjaController::class, 'allActiveEmailsBaranjaModel']); // Model way 




// use App\Http\Controllers\DownloadInDatoteka;
// Route::get('/download-txt', [DownloadInDatoteka::class, 'downloadTxt'])->name('download.txt');



Route::get('/decrypt-password', [PasswordController::class, 'decryptPassword']);
Route::get('/encrypt-password', [PasswordController::class, 'encryptPassword']);

Route::get('/verify-password', [PasswordController::class, 'verifyPassword']);


Route::get('/compare/{plainText}/{hash}', function ($plainText, $hash) {
    $isMatching = Hash::check($plainText, $hash);

    return response()->json([
        'plain_text' => $plainText,
        'hash' => $hash,
        'is_matching' => $isMatching,
    ]);
});

Route::get('/hash/{plainText}', function ($plainText) {
    $hash = Hash::make($plainText);

    return response()->json([
        'plain_text' => $plainText,
        'hash' => $hash,
    ]);
});

Route::get('/compare/{plainText}/{hash}', function ($plainText, $hash) {
    $isMatching = Hash::check($plainText, $hash);

    return response()->json([
        'plain_text' => $plainText,
        'hash' => $hash,
        'is_matching' => $isMatching,
    ]);
});




Route::get('/custom-md5-hash/{password}', [Md5Controller::class, 'customMd5Hash']);


// za verifikacija 
Route::get('/verify-md5-hash/{password}/{storedHash}', function ($password, $storedHash) {
    $controller = new Md5Controller();
    $isValid = $controller->verifyMd5Hash($password, $storedHash);
    
    return response()->json(['is_valid' => $isValid]);
});


Route::get('/change-password', function () {


    $password = "admin12345";
    
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    echo $hashedPassword;
    
    
    });
