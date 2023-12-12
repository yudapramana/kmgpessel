<?php

use App\Models\RefDataSubKlasifikasi;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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


Route::post('/poststatus/switch', function (Request $request) {

    $data = $request->input();
    $message = '';
    $success = false;


    try {
        if (isset($request->switch_status)) {
            $post = \App\Models\Post::find($data['id_post']);
            $post->status = $request->string_status;
            $post->save();
            $success = true;
        }
    } catch (\Exception $e) {
        $message = $e->getMessage();
    }

    return response()
        ->json(['success' => $success, 'message' => $message]);
})->name('post.status.switch');


Route::get('/cd_upload_test', function (Request $request) {
    $url = 'https://sumbar.kemenag.go.id/v2/uploads/images/image_600x460_65426b3f5b50c.jpg';
    $uploadedFileUrl = Cloudinary::upload($url)->getSecurePath();
    return $uploadedFileUrl;
});

Route::get('/time_now', function (Request $request) {
    $timenow = \Carbon\Carbon::now();
    return $timenow;
});

Route::get('/db_old/migrate/posts', function (Request $request) {

    $newpostoldid = \App\Models\Post::where('old_id', '!=', 0)->orderBy('id', 'desc')->first()->old_id;

    $posts = \App\Models\OldPost::where('id', '>', $newpostoldid)->get();


    if (Count($posts) > 0) {
        foreach ($posts as $post) {
            $convertuserid = $post->user_id;

            switch ($convertuserid) {
                case 1:
                    // adminrina
                    $convertuserid = 7;
                    break;

                case 13:
                    // adminrina
                    $convertuserid = 4;
                    break;

                case 49:
                    // adminfitradewi
                    $convertuserid = 4;
                    break;

                case 296:
                    // adminrhama
                    $convertuserid = 2;
                    break;

                case 480:
                    // admineri
                    $convertuserid = 3;
                    break;

                case 562:
                    // adminvethriarahmi
                    $convertuserid = 5;
                    break;

                default:
                    # code...
                    break;
            }

            if ($post->image_big != null) {
                $image_url_raw = 'https://sumbar.kemenag.go.id/v2/' . $post->image_big;
                $image_url = Cloudinary::upload($image_url_raw)->getSecurePath();

                $fPost = \App\Models\Post::where('title', $post->title)->first();
                if (!$fPost) {
                    $newPost                    = new \App\Models\Post();
                    $newPost->created_at        = $post->created_at;
                    $newPost->cover             = $image_url;
                    $newPost->title             = $post->title;
                    $newPost->slug              = Str::slug($post->title);
                    $newPost->user_id           = $convertuserid;
                    $newPost->category_id       = Str::contains(strtolower($post->content), ['jakarta']) ? 3 : 1;
                    $newPost->desc              = $post->content;
                    $newPost->keywords          = $post->keywords;
                    $newPost->meta_desc         = $post->title;
                    $newPost->id_kabkota        = $post->daerah;
                    $newPost->is_featured       = 1;
                    $newPost->is_slider         = 0;
                    $newPost->is_recommended    = 0;
                    $newPost->is_breaking       = 0;
                    $newPost->old_id            = $post->id;
                    $newPost->save();
                }
            }
        }
        return 'done';
    } else {
        return 'data has been updated';
    }
});

Route::get('/users/all', function (Request $request) {

    //    $users = \App\Models\User::select('name', 'username', 'plain_password')->get();
    $users = DB::table('users')->select('name', 'username', 'plain_password as password')->get();
    return $users;
});

Route::get('permohonan', [App\Http\Controllers\PermohonanController::class, 'index'])->name('permohonan.index');
Route::post('permohonan/switch', [App\Http\Controllers\PermohonanController::class, 'switchStatus'])->name('permohonan.status.switch');


Route::get('/gallery/t/{type?}', [App\Http\Controllers\SectController::class, 'gallery'])->name('sect.gallery');


Route::get('sect/permohonan_informasi', [App\Http\Controllers\SectController::class, 'permohonan'])->name('sect.permohonan');
Route::post('sect/permohonan/store', [App\Http\Controllers\SectController::class, 'storePermohonan'])->name('permohonan.store');

Route::post('/captcha-validation', [\App\Http\Controllers\CaptchaServiceController::class, 'capthcaFormValidate']);
Route::get('/reload-captcha', [\App\Http\Controllers\CaptchaServiceController::class, 'reloadCaptcha'])->name('reload.captcha');

Route::post('image-upload', [App\Http\Controllers\ImageUploadController::class, 'storeImage'])->name('image.upload');

Route::get('/migrate-fresh', function () {
    // Artisan::call('vendor:publish');
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('migrate:fresh', ['--seed' => true]);

    return 'Migration and seeding has been succeed, click <a href="/">here</a> to return to home page';
});

Route::get('/xdown/{view}', function ($view) {
    Artisan::call('down', ['--secret' => 'devmode', '--render' => 'errors.' . $view]);

    return 'Web Down with command view: ' . $view;
});

Route::get('/xup', function () {
    Artisan::call('up');
    return 'Web Up';
});

Route::group(['middleware' => ['web']], function () {
    // your routes here

    Route::get('/visitor', [App\Http\Controllers\Visitor\DashboardController::class, 'index'])->name('visitor.index');

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('landing.index');

    Route::get('/contact', function () {
        return view('landing.v2.contact', [
            'title' => 'Contact - Web Kemenag Kanwil Prov Sumbar',
            'accountfb' => 'Kanwil Kemenag Sumbar',
            'account' => 'Kanwil Kemenag Sumbar',
            'channel' =>  '@Kanwil Kemenag Sumbar'
        ]);
    });

    // Route::get('/gallery/{type}', function ($type) {

    //     $galleries = \App\Models\Gallery::where('type', $type)->get();
    //     // $galleries = $galleries->shuffle();

    //     $filterTags = $galleries->pluck('filter_tag')->unique();

    //     return view('landing.gallery', [
    //         'title' => 'Gallery Web Kemenag Kanwil Prov Sumbar',
    //         'accountfb' => 'Kanwil Kemenag Sumbar',
    //         'account' => 'Kanwil Kemenag Sumbar',
    //         'channel' =>  '@Kanwil Kemenag Sumbar',
    //         'galleries' =>  $galleries,
    //         'filterTags' =>  $filterTags,
    //     ]);
    // });

    Route::get('/aboutus', function () {

        return view('landing.aboutus', [
            'title' => 'Web Kemenag Kanwil Prov Sumbar - About Us',
            'accountfb' => 'Kanwil Kemenag Sumbar',
            'account' => 'Kanwil Kemenag Sumbar',
            'channel' =>  '@Kanwil Kemenag Sumbar'
        ]);
    });

    Route::get('regulasi', function () {
        return view(
            'landing.v2.regulasi',
            [
                'title' => 'Web - Regulasi',
            ]
        );
    });


    Route::get('/service/{slug}', function ($slug) {

        $service = \App\Models\Services::where('slug', $slug)->first();
        $products = \App\Models\Products::where('id_service', $service->id_service)->get();

        return view('landing.service-detail', [
            'accountfb' => 'pandanviewmandeh',
            'account' => 'pandanviewmandeh',
            'channel' =>  '@pandanviewmandehofficial4919',
            'service' =>  $service,
            'products' =>  $products
        ]);
    });

    Route::get('/all-services', function () {
        $services = \App\Models\Services::where('listed', 'yes')->get();

        return view('landing.all-services', [
            'title' => 'Web Kemenag Kanwil Prov Sumbar - Semua Layanan',
            'accountfb' => 'pandanviewmandeh',
            'account' => 'pandanviewmandeh',
            'channel' =>  '@pandanviewmandehofficial4919',
            'services' =>  $services
        ]);
    });

    Route::get('/blog', function (Request $request) {

        $kabkotaname = '';
        if ($request->has('search')) {
            $search = $request->input('search');
            $posts = \App\Models\Post::where('status', 'published')->where('title', 'LIKE', "%{$search}%")
                ->orWhere('desc', 'LIKE', "%{$search}%")->orderBy('created_at', 'DESC')->paginate(4);
        } elseif ($request->has('category')) {
            $search = $request->input('category');

            if ($request->has('id_kabkota')) {
                $kabkotaname = \App\Models\Kabkota::find($request->input('id_kabkota'))->name;
                $posts = \App\Models\Post::where('status', 'published')->whereHas('category', function ($q) use ($search) {
                    $q->where('slug', $search);
                })
                    ->where('id_kabkota', $request->input('id_kabkota'))
                    ->orderBy('created_at', 'DESC')->paginate(8);
            } else {
                $posts = \App\Models\Post::where('status', 'published')->whereHas('category', function ($q) use ($search) {
                    $q->where('slug', $search);
                })->orderBy('created_at', 'DESC')->paginate(8);
            }
        } elseif ($request->has('tag')) {
            $search = $request->input('tag');
            $posts = \App\Models\Post::where('status', 'published')->whereHas('tags', function ($q) use ($search) {
                $q->where('slug', $search);
            })->orderBy('created_at', 'DESC')->paginate(8);
        } elseif ($request->has('author')) {
            $search = $request->input('author');
            $posts = \App\Models\Post::where('status', 'published')->whereHas('user', function ($q) use ($search) {
                $q->where('name', $search);
            })->orderBy('created_at', 'DESC')->paginate(8);
        } else {
            $posts = \App\Models\Post::where('status', 'published')->orderBy('created_at', 'DESC')->paginate(8);
        }

        $posts->appends(request()->input())->links();


        $categories = \App\Models\Category::withCount('posts')->get();
        $tags = \App\Models\Tag::all();
        $recent_posts = \App\Models\Post::where('status', 'published')->whereHas('category', function ($q) {
            $q->where('slug', 'utama');
        })->take(3)->get();

        return view('landing.v2.blog', [
            'title' => 'Blog Web Kemenag Kanwil Prov Sumbar',
            'accountfb' => 'pandanviewmandeh',
            'account' => 'pandanviewmandeh',
            'channel' =>  '@pandanviewmandehofficial4919',
            'categories' =>  $categories,
            'posts' => $posts,
            'recent_posts' => $recent_posts,
            'tags' => $tags,
            'kabkotaname' => $kabkotaname,
        ]);
    })->name('blog.list');

    // Route::get('/berita', function (Request $request) {

    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $posts = \App\Models\Post::whereHas('category', function ($q) {
    //             $q->where('slug', 'utama');
    //         })->where('title', 'LIKE', "%{$search}%")
    //             ->orWhere('desc', 'LIKE', "%{$search}%")->orderBy('created_at', 'DESC')->paginate(4);
    //     } elseif ($request->has('category')) {
    //         $search = $request->input('category');
    //         $posts = \App\Models\Post::whereHas('category', function ($q) {
    //             $q->where('slug', 'utama');
    //         })->whereHas('category', function ($q) use ($search) {
    //             $q->where('slug', $search);
    //         })->orderBy('created_at', 'DESC')->paginate(4);
    //     } elseif ($request->has('tag')) {
    //         $search = $request->input('tag');
    //         $posts = \App\Models\Post::whereHas('category', function ($q) {
    //             $q->where('slug', 'utama');
    //         })->whereHas('tags', function ($q) use ($search) {
    //             $q->where('slug', $search);
    //         })->orderBy('created_at', 'DESC')->paginate(4);
    //     } else {
    //         $posts = \App\Models\Post::whereHas('category', function ($q) {
    //             $q->where('slug', 'utama');
    //         })->orderBy('created_at', 'DESC')->paginate(4);
    //     }

    //     $posts->appends(request()->input())->links();


    //     $categories = \App\Models\Category::withCount('posts')->get();
    //     $tags = \App\Models\Tag::all();
    //     $recent_posts = \App\Models\Post::whereHas('category', function ($q) {
    //         $q->where('slug', 'utama');
    //     })->take(3)->get();

    //     return view('landing.v2.news', [
    //         'title' => 'Berita Web Kemenag Kanwil Prov Sumbar',
    //         'accountfb' => 'pandanviewmandeh',
    //         'account' => 'pandanviewmandeh',
    //         'channel' =>  '@pandanviewmandehofficial4919',
    //         'categories' =>  $categories,
    //         'posts' => $posts,
    //         'recent_posts' => $recent_posts,
    //         'tags' => $tags
    //     ]);
    // });

    Route::get('/aktifitas', function (Request $request) {

        $activities = \App\Models\Activity::orderBy('created_at', 'DESC')->paginate(4);


        $categories = \App\Models\Category::withCount('posts')->get();
        $tags = \App\Models\Tag::all();
        $recent_posts = \App\Models\Post::whereHas('category', function ($q) {
            $q->where('slug', 'utama');
        })->take(3)->get();

        return view('landing.v2.activities', [
            'title' => 'Aktifitas KemenagPessel',
            'accountfb' => 'pandanviewmandeh',
            'account' => 'pandanviewmandeh',
            'channel' =>  '@pandanviewmandehofficial4919',
            'categories' =>  $categories,
            'activities' => $activities,
            'recent_posts' => $recent_posts,
            'tags' => $tags
        ]);
    });

    Route::get('cookie/{slug}', function (Request $request, $slug) {
        $cookie_name = (\Str::replace('.', '', ($request->ip())) . '-' . $slug);

        $cookie_value = \Cookie::get($cookie_name);
        if ($cookie_value === null) {
            $cookie = cookie($cookie_name, '1', 60); //set the cookie
        }

        return $cookie;
    });

    Route::get('post/{slug}', function (Request $request, $slug) {
        $post = \App\Models\Post::where('slug', $slug)->first();

        $cookie_name = (\Str::replace('.', '', ($request->ip())) . '-' . $post->id);

        $cookie = \Cookie::get($cookie_name);
        if ($cookie == '') { //check if cookie is set
            $cookie = cookie($cookie_name, '1', 60); //set the cookie
            $post->incrementReadCount(); //count the view
        }

        if ($post->showPost()) { // this will test if the user viwed the post or not
            // return $post;
        } else {
            \App\Models\PostView::createViewLog($post);
        }

        $categories = \App\Models\Category::withCount('posts')->get();
        $tags = \App\Models\Tag::all();
        $recent_posts = \App\Models\Post::whereHas('category', function ($q) {
            $q->where('slug', 'utama');
        })->take(3)->get();
        return view('landing.v2.post', [
            'accountfb' => 'pandanviewmandeh',
            'account' => 'pandanviewmandeh',
            'channel' =>  '@pandanviewmandehofficial4919',
            'categories' =>  $categories,
            'recent_posts' => $recent_posts,
            'tags' => $tags,
            'post' => $post
        ])->withCookie($cookie); //store the cookie;

    });

    Route::get('/lang/home', [App\Http\Controllers\LangController::class, 'index']);
    Route::get('/lang/change', [App\Http\Controllers\LangController::class, 'change'])->name('changeLang');

    Route::post('/messages/store', [\App\Http\Controllers\Visitor\MessageController::class, 'store'])->name('messages.store');;
});

// Auth::routes();
Auth::routes(['login' => false]);

Route::prefix('controlcenter')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login.index');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
});

Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');

Route::get('/information/services', [\App\Http\Controllers\Admin\ServicesController::class, 'index'])->name('services.index');
Route::post('/information/services/store', [\App\Http\Controllers\Admin\ServicesController::class, 'store'])->name('services.store');

Route::get('/information/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
Route::post('/information/products/store', [\App\Http\Controllers\Admin\ProductController::class, 'store']);

Route::get('/information/activities', [\App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('activities.index');
Route::post('/information/activities/store', [\App\Http\Controllers\Admin\ActivityController::class, 'store'])->name('activities.store');
Route::delete('/information/destroy/{id}', [\App\Http\Controllers\Admin\ActivityController::class, 'destroy'])->name('activities.destroy');


Route::get('/information/galleries', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('galleries.index');
Route::post('/information/galleries/store', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('galleries.store');

Route::get('/information/carousels', [\App\Http\Controllers\Admin\CarouselController::class, 'index'])->name('carousels.index');
Route::post('/information/carousels/store', [\App\Http\Controllers\Admin\CarouselController::class, 'store'])->name('carousels.store');

Route::get('/information/testimonies', [\App\Http\Controllers\Admin\TestimonyController::class, 'index'])->name('testimonies.index');
Route::post('/information/testimonies/store', [\App\Http\Controllers\Admin\TestimonyController::class, 'store']);




Route::get('/data/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');

Route::get('/data/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
Route::post('/data/users/store', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
Route::delete('/data/users/{id}/destroy', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

Route::get('/data/roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
Route::post('/data/roles/store', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store');
Route::delete('/data/roles/{id}/destroy', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy');



Route::resource('/setting/categories', App\Http\Controllers\CategoryController::class);
Route::resource('/setting/tags', App\Http\Controllers\TagController::class);
// Manage Posts
Route::get('/blog/posts/trash', [App\Http\Controllers\PostController::class, 'trash'])->name('posts.trash');
Route::post('/blog/posts/trash/{id}/restore', [App\Http\Controllers\PostController::class, 'restore'])->name('posts.restore');
Route::delete('blog/posts/delete-permanent/{id}', [App\Http\Controllers\PostController::class, 'deletePermanent'])->name('posts.deletePermanent');
Route::delete('/blog/posts/destroy/{id}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('posts.delete');

Route::resource('/blog/posts', App\Http\Controllers\PostController::class);
Route::post('ckeditor/upload', 'CKEditorController@upload')->name('ckeditor.image-upload');


Route::get('/blog/news/trash', [App\Http\Controllers\NewsController::class, 'trash'])->name('news.trash');
Route::post('/blog/news/trash/{id}/restore', [App\Http\Controllers\NewsController::class, 'restore'])->name('news.restore');
Route::delete('blog/news/delete-permanent/{id}', [App\Http\Controllers\NewsController::class, 'deletePermanent'])->name('news.deletePermanent');
Route::resource('/blog/news', App\Http\Controllers\NewsController::class);


Route::get('/setting/menus/{id?}',  [\App\Http\Controllers\Admin\MenuController::class, 'index'])->name('menus.index');
Route::post('create-menu',  [\App\Http\Controllers\Admin\MenuController::class, 'store']);
Route::get('add-categories-to-menu',  [\App\Http\Controllers\Admin\MenuController::class, 'addCategory']);
Route::post('save-menu',  [\App\Http\Controllers\Admin\MenuController::class, 'saveMenu']);
Route::get('add-posts-to-menu',  [\App\Http\Controllers\Admin\MenuController::class, 'addPost']);
Route::get('add-custom-link',  [\App\Http\Controllers\Admin\MenuController::class, 'addCustomLink']);
Route::post('update-menuitem/{id}/{k1}/{k2?}/{k3?}',  [\App\Http\Controllers\Admin\MenuController::class, 'updateItem']);
Route::get('delete-menuitem/{id}/{k1}/{k2?}/{k3?}',  [\App\Http\Controllers\Admin\MenuController::class, 'deleteItem']);



// Route::resource('reservations', App\Http\Controllers\Admin\ReservationController::class);

Route::get('/reservations/{yearMonth?}', [\App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('reservations.index');
Route::post('/reservations/store', [\App\Http\Controllers\Admin\ReservationController::class, 'store'])->name('reservations.store');
Route::delete('/reservations/destroy/{id_reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('reservations.destroy');

Route::get('/deleted-reservations/{yearMonth?}', [\App\Http\Controllers\Admin\ReservationController::class, 'deleted'])->name('reservations.deleted');
Route::delete('/reservations/restore/{id_reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'restore'])->name('reservations.restore');


Route::get('/reservation/audits/{id_reservation}', function ($id_reservation) {
    $res = \App\Models\Reservation::where('id_reservation', $id_reservation)->withTrashed()->first();
    $all = $res->audits()->with('user')->get();
    return $all;
});



Route::get('/audits', [\App\Http\Controllers\Admin\AuditController::class, 'index'])->name('audits.index');
Route::get('/audits/fetch/{id_reservation}', [\App\Http\Controllers\Admin\AuditController::class, 'fetch'])->name('audits.fetch');


Route::get('/informasi', [\App\Http\Controllers\Admin\InfoController::class, 'index'])->name('info.index');
Route::post('/informasi/store', [\App\Http\Controllers\Admin\InfoController::class, 'store'])->name('info.store');
Route::delete('/informasi/delete/{id}', [\App\Http\Controllers\Admin\InfoController::class, 'destroy'])->name('info.destroy');


Route::post('/upload-file/upload', [\App\Http\Controllers\UploadFileController::class, 'upload'])->name('file.upload');
Route::delete('/upload-file/destroy/{id}', [\App\Http\Controllers\UploadFileController::class, 'destroy'])->name('file.destroy');

Route::get('/search/{param}', [\App\Http\Controllers\SearchController::class, 'search'])->name('search.param');


Route::post('/data/all', [\App\Http\Controllers\HomeController::class, 'all'])->name('data.all');
Route::get('/info/{sect}', [\App\Http\Controllers\HomeController::class, 'info'])->name('guest.info');


Route::get('/data/detail/{idx}', [\App\Http\Controllers\Landing\PostController::class, 'index'])->name('data.index');
Route::get('/data/download/{idx}', [\App\Http\Controllers\Landing\PostController::class, 'download'])->name('data.download');



Route::put('/kategori/add', [\App\Http\Controllers\MasterController::class, 'addKategori'])->name('kategori.add');
Route::put('/instansi/add', [\App\Http\Controllers\MasterController::class, 'addInstansi'])->name('instansi.add');
Route::put('/tag/add', [\App\Http\Controllers\MasterController::class, 'addTag'])->name('tag.add');


Route::get('/subklasifikasi', function () {
    $subklasifikasi = RefDataSubKlasifikasi::all();
    return $subklasifikasi;
});

Route::get('/getusers', function () {
    $users = \App\Models\User::select('name', 'username', 'password')->where('email', '!=', '199407292022031002@kemenag.go.id')->with('roles')->get();
    return $users;
});
