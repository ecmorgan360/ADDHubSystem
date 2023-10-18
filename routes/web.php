<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NavigationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxonomyformController;
use App\Http\Controllers\LocationformController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'App\Http\Controllers\DashboardController@index'])->middleware(['auth', 'verified']);
Route::post('/dashboard', ['as' => 'dashboard.result', 'uses' => 'App\Http\Controllers\DashboardController@result'])->middleware(['auth', 'verified']);

# Get to search page
Route::get('/search', ['as' => 'search.index', 'uses' => 'App\Http\Controllers\SearchController@index']);
Route::post('/search', ['as' => 'search.result', 'uses' => 'App\Http\Controllers\SearchController@result']);

# Get to extract form
Route::get('/extractform', ['as' => 'extractform.index', 'uses' => 'App\Http\Controllers\ExtractformController@index'])->middleware('auth', 'role:'.config('global.role_extract').','.config('global.role_admin'));
Route::get('/extractform/{extract}', ['as' => 'extractform.edit', 'uses' => 'App\Http\Controllers\ExtractformController@edit'])->middleware('auth', 'role:'.config('global.role_extract').','.config('global.role_admin'));
Route::post('/extractform/{extract}', ['as' => 'extractform.edit', 'uses' => 'App\Http\Controllers\ExtractformController@edit'])->middleware('auth', 'role:'.config('global.role_extract').','.config('global.role_admin'));
Route::post('/extractform', ['as' => 'extractform.store', 'uses' => 'App\Http\Controllers\ExtractformController@store'])->middleware('auth', 'role:'.config('global.role_extract').','.config('global.role_admin'));
Route::put('/extractform/{extract}', ['as' => 'extractform.update', 'uses' => 'App\Http\Controllers\ExtractformController@update'])->middleware('auth', 'role:'.config('global.role_extract').','.config('global.role_admin'));


# Get to fraction form
Route::get('/fractionform', ['as' => 'fractionform.index', 'uses' => 'App\Http\Controllers\FractionformController@index'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));
Route::get('/fractionform/{fraction}', ['as' => 'fractionform.edit', 'uses' => 'App\Http\Controllers\FractionformController@edit'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));
Route::post('/fractionform/{fraction}', ['as' => 'fractionform.edit', 'uses' => 'App\Http\Controllers\FractionformController@edit'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));
Route::post('/fractionform', ['as' => 'fractionform.store', 'uses' => 'App\Http\Controllers\FractionformController@store'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));
Route::put('/fractionform/{fraction}', ['as' => 'fractionform.update', 'uses' => 'App\Http\Controllers\FractionformController@update'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));

# Get to derivedpurecomp form
Route::get('/derivedpurecompform', ['as' => 'derivedpurecompform.index', 'uses' => 'App\Http\Controllers\DerivedpurecompformController@index'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));
Route::get('/derivedpurecompform/{derivedpurecomp}', ['as' => 'derivedpurecompform.edit', 'uses' => 'App\Http\Controllers\DerivedpurecompformController@edit'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));
Route::post('/derivedpurecompform/{derivedpurecomp}', ['as' => 'derivedpurecompform.edit', 'uses' => 'App\Http\Controllers\DerivedpurecompformController@edit'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));
Route::post('/derivedpurecompform', ['as' => 'derivedpurecompform.store', 'uses' => 'App\Http\Controllers\DerivedpurecompformController@store'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));
Route::put('/derivedpurecompform/{derivedpurecomp}', ['as' => 'derivedpurecompform.update', 'uses' => 'App\Http\Controllers\DerivedpurecompformController@update'])->middleware('auth', 'role:'.config('global.role_fraction').','.config('global.role_admin'));

# Get to massspec form
Route::get('/massspecform', ['as' => 'massspecform.index', 'uses' => 'App\Http\Controllers\MassspecformController@index'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::get('/massspecform{massspec}', ['as' => 'massspecform.add', 'uses' => 'App\Http\Controllers\MassspecformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/massspecform{massspec}', ['as' => 'massspecform.add', 'uses' => 'App\Http\Controllers\MassspecformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/massspecform', ['as' => 'massspecform.store', 'uses' => 'App\Http\Controllers\MassspecformController@store'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::put('/massspecform{massspec}', ['as' => 'massspecform.update', 'uses' => 'App\Http\Controllers\MassspecformController@update'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));

# Get to nmr form
Route::get('/nmrform', ['as' => 'nmrform.index', 'uses' => 'App\Http\Controllers\NmrformController@index'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::get('/nmrform/{nmr}', ['as' => 'nmrform.add', 'uses' => 'App\Http\Controllers\NmrformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/nmrform/{nmr}', ['as' => 'nmrform.add', 'uses' => 'App\Http\Controllers\NmrformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/nmrform', ['as' => 'nmrform.store', 'uses' => 'App\Http\Controllers\NmrformController@store'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::put('/nmrform/{nmr}', ['as' => 'nmrform.update', 'uses' => 'App\Http\Controllers\NmrformController@update'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));

# Get to hplc form
Route::get('/hplcform', ['as' => 'hplcform.index', 'uses' => 'App\Http\Controllers\HplcformController@index'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::get('/hplcform/{hplc}', ['as' => 'hplcform.add', 'uses' => 'App\Http\Controllers\HplcformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/hplcform/{hplc}', ['as' => 'hplcform.add', 'uses' => 'App\Http\Controllers\HplcformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/hplcform', ['as' => 'hplcform.store', 'uses' => 'App\Http\Controllers\HplcformController@store'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::put('/hplcform/{hplc}', ['as' => 'hplcform.update', 'uses' => 'App\Http\Controllers\HplcformController@update'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));

# Get to bioassay form
Route::get('/bioassayform', ['as' => 'bioassayform.index', 'uses' => 'App\Http\Controllers\BioassayformController@index'])->middleware('auth', 'role:'.config('global.role_bioassay').','.config('global.role_admin'));
Route::get('/bioassayform/{bioassay}', ['as' => 'bioassayform.add', 'uses' => 'App\Http\Controllers\BioassayformController@add'])->middleware('auth', 'role:'.config('global.role_bioassay').','.config('global.role_admin'));
Route::post('/bioassayform/{bioassay}', ['as' => 'bioassayform.add', 'uses' => 'App\Http\Controllers\BioassayformController@add'])->middleware('auth', 'role:'.config('global.role_bioassay').','.config('global.role_admin'));
Route::post('/bioassayform', ['as' => 'bioassayform.store', 'uses' => 'App\Http\Controllers\BioassayformController@store'])->middleware('auth', 'role:'.config('global.role_bioassay').','.config('global.role_admin'));
Route::put('/bioassayform/{bioassay}', ['as' => 'bioassayform.update', 'uses' => 'App\Http\Controllers\BioassayformController@update'])->middleware('auth', 'role:'.config('global.role_bioassay').','.config('global.role_admin'));

# Get to process form
Route::get('/processform', ['as' => 'processform.index', 'uses' => 'App\Http\Controllers\ProcessformController@index'])->middleware('auth', 'role:'.config('global.role_process').','.config('global.role_admin'));
Route::post('/processform', ['as' => 'processform.store', 'uses' => 'App\Http\Controllers\ProcessformController@store'])->middleware('auth', 'role:'.config('global.role_process').','.config('global.role_admin'));
Route::get('/processform/{supplier_id}/{supplier_type}', ['as' => 'processform.index', 'uses' => 'App\Http\Controllers\ProcessformController@index'])->middleware('auth', 'role:'.config('global.role_process').','.config('global.role_admin'));
Route::post('/processform/{supplier_id}/{supplier_type}', ['as' => 'processform.index', 'uses' => 'App\Http\Controllers\ProcessformController@index'])->middleware('auth', 'role:'.config('global.role_process').','.config('global.role_admin'));
Route::get('/processform/{process}', ['as' => 'processform.edit', 'uses' => 'App\Http\Controllers\ProcessformController@edit'])->middleware('auth', 'role:'.config('global.role_process').','.config('global.role_admin'));
Route::post('/processform/{process}', ['as' => 'processform.edit', 'uses' => 'App\Http\Controllers\ProcessformController@edit'])->middleware('auth', 'role:'.config('global.role_process').','.config('global.role_admin'));
Route::put('/processform/{process}', ['as' => 'processform.update', 'uses' => 'App\Http\Controllers\ProcessformController@update'])->middleware('auth', 'role:'.config('global.role_process').','.config('global.role_admin'));

# Get to collection form
Route::get('/collectionform', ['as' => 'collectionform.index', 'uses' => 'App\Http\Controllers\CollectionformController@index'])->middleware('auth', 'role:'.config('global.role_collect').','.config('global.role_admin'));
Route::post('/collectionform/{collection}', ['as' => 'collectionform.edit', 'uses' => 'App\Http\Controllers\CollectionformController@edit'])->middleware('auth', 'role:'.config('global.role_collect').','.config('global.role_admin'));
Route::post('/collectionform', ['as' => 'collectionform.store', 'uses' => 'App\Http\Controllers\CollectionformController@store'])->middleware('auth', 'role:'.config('global.role_collect').','.config('global.role_admin'));
Route::put('/collectionform/{collection}', ['as' => 'collectionform.update', 'uses' => 'App\Http\Controllers\CollectionformController@update'])->middleware('auth', 'role:'.config('global.role_collect').','.config('global.role_admin'));

# Get to strain form
Route::get('/strainform', ['as' => 'strainform.index', 'uses' => 'App\Http\Controllers\StrainformController@index'])->middleware('auth', 'role:'.config('global.role_collect').','.config('global.role_admin'));
Route::post('/strainform/{strain}', ['as' => 'strainform.edit', 'uses' => 'App\Http\Controllers\StrainformController@edit'])->middleware('auth', 'role:'.config('global.role_collect').','.config('global.role_admin'));
Route::post('/strainform', ['as' => 'strainform.store', 'uses' => 'App\Http\Controllers\StrainformController@store'])->middleware('auth', 'role:'.config('global.role_collect').','.config('global.role_admin'));
Route::put('/strainform/{strain}', ['as' => 'strainform.update', 'uses' => 'App\Http\Controllers\StrainformController@update'])->middleware('auth', 'role:'.config('global.role_collect').','.config('global.role_admin'));

# Get to process information page
Route::get('/process/{process_id}/{supplier_id}/{supplier_type}', ['as' => 'process.index', 'uses' => 'App\Http\Controllers\ProcessController@index'])->middleware('auth');
Route::post('/process/{process_id}/{supplier_id}/{supplier_type}', ['as' => 'process.index', 'uses' => 'App\Http\Controllers\ProcessController@index'])->middleware('auth');
Route::post('/process/{id}/{process_id}/{supplier_id}/{download}', ['as' => 'process.download', 'uses' => 'App\Http\Controllers\ProcessController@download'])->middleware('auth');

# Get to massspec information page
Route::get('/massspec/{massspec}/{process_id}', ['as' => 'massspec.index', 'uses' => 'App\Http\Controllers\MassspecController@index'])->middleware('auth');
Route::post('/massspec/{massspec}/{process_id}', ['as' => 'massspec.index', 'uses' => 'App\Http\Controllers\MassspecController@index'])->middleware('auth');
// Route::post('/massspec/{massspeccsv}/{process_id}/{download}', ['as' => 'massspec.csvDownload', 'uses' => 'App\Http\Controllers\MassspecController@csvDownload'])->middleware('auth');
Route::post('/massspec/{id}/{process_id}/{download}', ['as' => 'massspec.download', 'uses' => 'App\Http\Controllers\MassspecController@download'])->middleware('auth');

# Get to msmgf form page
Route::get('/msmgfform/{massspec_id}', ['as' => 'msmgfform.add', 'uses' => 'App\Http\Controllers\MassspecmgfformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/msmgfform/{massspec_id}', ['as' => 'msmgfform.add', 'uses' => 'App\Http\Controllers\MassspecmgfformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/msmgfform/{massspec_id}/{massspecmgf}', ['as' => 'msmgfform.edit', 'uses' => 'App\Http\Controllers\MassspecmgfformController@edit'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/msmgfform', ['as' => 'msmgfform.store', 'uses' => 'App\Http\Controllers\MassspecmgfformController@store'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::put('/msmgfform/{massspecmgf}', ['as' => 'msmgfform.update', 'uses' => 'App\Http\Controllers\MassspecmgfformController@update'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));

# Get to mscsv form page
Route::get('/mscsvform/{massspec_id}', ['as' => 'mscsvform.add', 'uses' => 'App\Http\Controllers\MassspeccsvformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/mscsvform/{massspec_id}', ['as' => 'mscsvform.add', 'uses' => 'App\Http\Controllers\MassspeccsvformController@add'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/mscsvform/{massspec_id}/{massspeccsv}', ['as' => 'mscsvform.edit', 'uses' => 'App\Http\Controllers\MassspeccsvformController@edit'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::post('/mscsvform', ['as' => 'mscsvform.store', 'uses' => 'App\Http\Controllers\MassspeccsvformController@store'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));
Route::put('/mscsvform/{massspeccsv}', ['as' => 'mscsvform.update', 'uses' => 'App\Http\Controllers\MassspeccsvformController@update'])->middleware('auth', 'role:'.config('global.role_chemist').','.config('global.role_admin'));

# Get to extract supplier information page
Route::get('/supplier/{supplier_id}', ['as' => 'supplier.index', 'uses' => 'App\Http\Controllers\SupplierController@index'])->middleware('auth');
Route::post('/supplier/{supplier_id}', ['as' => 'supplier.index', 'uses' => 'App\Http\Controllers\SupplierController@index'])->middleware('auth');
Route::post('/supplier/{id}/{supplier_id}/{download}', ['as' => 'supplier.download', 'uses' => 'App\Http\Controllers\SupplierController@download'])->middleware('auth');

# Get to adhocassay information page
Route::get('/adhocassay/{derivedpurecomp}', ['as' => 'adhocassay.index', 'uses' => 'App\Http\Controllers\AdhocassayController@index'])->middleware('auth');
Route::post('/adhocassay/{derivedpurecomp}', ['as' => 'adhocassay.index', 'uses' => 'App\Http\Controllers\AdhocassayController@index'])->middleware('auth');
Route::post('/adhocassay/{derivedpurecomp}/{adhocassay}/{download}', ['as' => 'adhocassay.download', 'uses' => 'App\Http\Controllers\AdhocassayController@download'])->middleware('auth');

# Get to adhocassay form
Route::get('/adhocassayform/{derivedpurecomp}', ['as' => 'adhocassayform.add', 'uses' => 'App\Http\Controllers\AdhocassayformController@add'])->middleware('auth', 'role:'.config('global.role_bioassay'));
Route::post('/adhocassayform/{derivedpurecomp}', ['as' => 'adhocassayform.add', 'uses' => 'App\Http\Controllers\AdhocassayformController@add'])->middleware('auth', 'role:'.config('global.role_bioassay'));
Route::post('/adhocassayform/{derivedpurecomp}/{adhocassay}', ['as' => 'adhocassayform.edit', 'uses' => 'App\Http\Controllers\AdhocassayformController@edit'])->middleware('auth', 'role:'.config('global.role_bioassay'));
Route::post('/adhocassayform', ['as' => 'adhocassayform.store', 'uses' => 'App\Http\Controllers\AdhocassayformController@store'])->middleware('auth', 'role:'.config('global.role_bioassay'));
Route::put('/adhocassayform/{adhocassay}', ['as' => 'adhocassayform.update', 'uses' => 'App\Http\Controllers\AdhocassayformController@update'])->middleware('auth', 'role:'.config('global.role_bioassay'));

# Get to role assign form page
Route::get('/roleform', ['as' => 'roleform.index', 'uses' => 'App\Http\Controllers\RoleformController@index'])->middleware('auth', 'role:'.config('global.role_admin'));
Route::post('/roleform', ['as' => 'roleform.store', 'uses' => 'App\Http\Controllers\RoleformController@store'])->middleware('auth', 'role:'.config('global.role_admin'));
Route::post('/roleform/{roleuser}', ['as' => 'roleform.remove', 'uses' => 'App\Http\Controllers\RoleformController@remove'])->middleware('auth', 'role:'.config('global.role_admin'));

# Get to 16sraw form page
Route::get('/gen16sform', ['as' => 'gen16sform.index', 'uses' => 'App\Http\Controllers\Gen16sformController@index'])->middleware('auth', 'role:'.config('global.role_genomics').','.config('global.role_admin'));
Route::post('/gen16sform/{gen16s}', ['as' => 'gen16sform.edit', 'uses' => 'App\Http\Controllers\Gen16sformController@edit'])->middleware('auth', 'role:'.config('global.role_genomics').','.config('global.role_admin'));
Route::post('/gen16sform', ['as' => 'gen16sform.store', 'uses' => 'App\Http\Controllers\Gen16sformController@store'])->middleware('auth', 'role:'.config('global.role_genomics').','.config('global.role_admin'));
Route::put('/gen16sform/{gen16s}', ['as' => 'gen16sform.update', 'uses' => 'App\Http\Controllers\Gen16sformController@update'])->middleware('auth', 'role:'.config('global.role_genomics').','.config('global.role_admin'));

# Get to metagenome form page
Route::get('/metagenomeform', ['as' => 'metagenomeform.index', 'uses' => 'App\Http\Controllers\MetagenomeformController@index'])->middleware('auth', 'role:'.config('global.role_genomics').','.config('global.role_admin'));
Route::post('/metagenomeform/{metagenome}', ['as' => 'metagenomeform.edit', 'uses' => 'App\Http\Controllers\MetagenomeformController@edit'])->middleware('auth', 'role:'.config('global.role_genomics').','.config('global.role_admin'));
Route::post('/metagenomeform', ['as' => 'metagenomeform.store', 'uses' => 'App\Http\Controllers\MetagenomeformController@store'])->middleware('auth', 'role:'.config('global.role_genomics').','.config('global.role_admin'));
Route::put('/metagenomeform/{metagenome}', ['as' => 'metagenomeform.update', 'uses' => 'App\Http\Controllers\MetagenomeformController@update'])->middleware('auth', 'role:'.config('global.role_genomics').','.config('global.role_admin'));


# Get to taxonomy form
Route::get('/taxonomyform', ['as' => 'taxonomyform.index', 'uses' => 'App\Http\Controllers\TaxonomyformController@index'])->middleware('auth', 'role:'.config('global.role_identify').','.config('global.role_admin'));
Route::post('/taxonomyform', ['as' => 'taxonomyform.store', 'uses' => 'App\Http\Controllers\TaxonomyformController@store'])->middleware('auth', 'role:'.config('global.role_identify').','.config('global.role_admin'));
Route::post('api/fetch-phylums', [TaxonomyformController::class, 'fetchPhylum']);
Route::post('api/fetch-subphylums', [TaxonomyformController::class, 'fetchSubphylum']);
Route::post('api/fetch-classes', [TaxonomyformController::class, 'fetchClass']);
Route::post('api/fetch-subclasses', [TaxonomyformController::class, 'fetchSubclass']);
Route::post('api/fetch-superorders', [TaxonomyformController::class, 'fetchSuperorder']);
Route::post('api/fetch-orders', [TaxonomyformController::class, 'fetchOrder']);
Route::post('api/fetch-suborders', [TaxonomyformController::class, 'fetchSuborder']);
Route::post('api/fetch-families', [TaxonomyformController::class, 'fetchFamily']);
Route::post('api/fetch-subfamilies', [TaxonomyformController::class, 'fetchSubfamily']);
Route::post('api/fetch-geni', [TaxonomyformController::class, 'fetchGenus']);
Route::post('api/fetch-subgeni', [TaxonomyformController::class, 'fetchSubgenus']);
Route::post('api/fetch-species', [TaxonomyformController::class, 'fetchSpecies']);

# Get to location form
Route::get('/locationform', ['as' => 'locationform.index', 'uses' => 'App\Http\Controllers\LocationformController@index'])->middleware('auth', 'role:'.config('global.role_admin'));
Route::post('/locationform', ['as' => 'locationform.store', 'uses' => 'App\Http\Controllers\LocationformController@store'])->middleware('auth', 'role:'.config('global.role_admin'));
Route::post('api/fetch-regions', [LocationformController::class, 'fetchRegion']);
Route::post('api/fetch-cities', [LocationformController::class, 'fetchCity']);
Route::post('api/fetch-localareas', [LocationformController::class, 'fetchLocalarea']);
Route::post('api/fetch-stations', [LocationformController::class, 'fetchStation']);
Route::post('api/fetch-sites', [LocationformController::class, 'fetchSite']);

# Get to orphan fractions page
Route::get('/orphanfractions', ['as' => 'report.orphanfractionIndex', 'uses' => 'App\Http\Controllers\ReportController@orphanfractionIndex'])->middleware('auth');
Route::post('/orphanfractions', ['as' => 'report.orphanfractionResult', 'uses' => 'App\Http\Controllers\ReportController@orphanfractionResult'])->middleware('auth');
# Write to Excel spreadsheet
Route::get('/exportOrphanFractions', ['as' => 'exportOrphanFractions', 'uses' => 'App\Http\Controllers\ReportController@exportOrphanFractions'])->middleware('auth');
Route::post('/exportOrphanFractions', ['as' => 'exportOrphanFractions', 'uses' => 'App\Http\Controllers\ReportController@exportOrphanFractions'])->middleware('auth');

# Get to orphan pure compounds page
Route::get('/orphancompounds', ['as' => 'report.orphancompoundIndex', 'uses' => 'App\Http\Controllers\ReportController@orphancompoundIndex'])->middleware('auth');
Route::post('/orphancompounds', ['as' => 'report.orphancompoundResult', 'uses' => 'App\Http\Controllers\ReportController@orphancompoundResult'])->middleware('auth');
# Write to Excel spreadsheet
Route::get('/exportOrphanCompounds', ['as' => 'exportOrphanCompounds', 'uses' => 'App\Http\Controllers\ReportController@exportOrphanCompounds'])->middleware('auth');
Route::post('/exportOrphanCompounds', ['as' => 'exportOrphanCompounds', 'uses' => 'App\Http\Controllers\ReportController@exportOrphanCompounds'])->middleware('auth');

# Get bioassay report page
Route::get('/bioassayreport', ['as' => 'report.bioassayreportIndex', 'uses' => 'App\Http\Controllers\ReportController@bioassayreportIndex'])->middleware('auth');
Route::post('/bioassayreport', ['as' => 'report.bioassayreportResult', 'uses' => 'App\Http\Controllers\ReportController@bioassayreportResult'])->middleware('auth');
# Write to Excel spreadsheet
Route::get('/exportBioassayReports', ['as' => 'exportBioassayReports', 'uses' => 'App\Http\Controllers\ReportController@exportBioassayReports'])->middleware('auth');
Route::post('/exportBioassayReports', ['as' => 'exportBioassayReports', 'uses' => 'App\Http\Controllers\ReportController@exportBioassayReports'])->middleware('auth');

// Route::get('/search', function() {
//     return view('search');
// })->middleware(['auth'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
