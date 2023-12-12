<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Kabkota, Post, Tag};
use Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = null;
        if ($request->has('category')) {
            $category = $request->input('category');
        } else {
            $category = 'utama';
        }

        $user = Auth::user();
        $pQuery = Post::query();;


        if ($user->hasRole('kontributor_daerah')) {
            $id_kabkota = $user->id_kabkota;
            $pQuery = $pQuery->where('id_kabkota', $id_kabkota);
        }

        $pQuery = $pQuery->whereHas('category', function ($q) use ($category) {
            $q->where('slug', $category);
        });
        $pQuery = $pQuery->orderBy('created_at', 'desc');
        $posts = $pQuery->get();


        if ($request->ajax()) {


            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('title_can', function ($post) {
                    $text = '<span style="font-weight:bolder;">' . $post->title . ' &nbsp; <br> <span class="text-muted" style="font-size:x-small">' . $post->created_at->format('d-m-Y') . '</span><br>
                            <span class="text-muted preserveLines" style="font-size:smaller">Slug: ' . $post->slug . ' </span><br>
                            <span class="text-muted preserveLines" style="font-size:xx-small">Keywords: ' . $post->keywords . ' </span><br>
                            <span class="text-muted preserveLines" style="font-size:xx-small">Meta:' . $post->meta_desc . ' </span>';
                    return $text;
                })
                ->addColumn('action', function ($post) {
                    $btn = '';

                    $btn .= '<a href="' . route('posts.edit', $post->id) . '" class="btn btn-sm btn-warning btn-xs"><i class="bi bi-pencil-square"></i></a>&nbsp;';
                    // $btn .= '<button id="editBtn" type="button" class="btn btn-sm btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#tambahGroup" data-bs-title="Edit Data" data-title="Edit Data Pengguna"><i class="bi bi-pencil-square"></i></button>&nbsp;';
                    $btn .= '<button id="destroyBtn" type="button" class="btn btn-sm btn-danger btn-xs" data-bs-id_item="' . $post->id  . '" data-id_item="' .  $post->id  . '"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })
                ->addColumn('datastatus', function ($item) use($user) {
                    $statusArr = ['published', 'draft', 'archived'];
                    $colorArr = ['success', 'warning', 'danger'];
                    $nowColor = null;
                    $statusNow = $item->status;
                    if (($key = array_search($statusNow, $statusArr)) !== false) {
                        unset($statusArr[$key]);
                        $nowColor = $colorArr[$key];
                    }
    
                    if( $user->hasRole('super_administrator') || $user->hasRole('administrator') || $user->hasRole('kontributor_utama')) {
                        $btn = '<span class="badge bg-'.$nowColor.' dropdown-toggle" id="btnGroupDrop1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-original-title="" title="">'.$statusNow.'</span>';
                        $btn .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';

                        foreach ($statusArr as $stat) {
                            $btn .= '<button id="switchBtn" class="dropdown-item" tabindex="0" aria-controls="defTbl" title="" data-bs-original-title="Switch Status" type="button" data-status="'.$stat.'"><span>ubah menjadi '.$stat.'</span></button>';
                        }

                        $btn .=    '</div>';
                    } else {
                        $btn = '<span class="badge bg-'.$nowColor.' " id="btnGroupDrop1" type="button" data-bs-original-title="" title="">'.$statusNow.'</span>';
                    }
                    return $btn;
                })
                ->addColumn('desc_beautify', function ($post) {
                    $html = '';
                    $html .=  \Illuminate\Support\Str::limit($post->desc, 200, $end = '...');
                    $html .= '<br>';
                    $html .= '<span class="text-muted preserveLines" style="font-size:smaller">View Count: ' . $post->view_count . ' Reads</span>';
                    return $html;
                })
                ->rawColumns(['action', 'desc_beautify', 'title_can', 'datastatus'])
                ->make(true);
        }
        return view(
            'admin.posts.index',
            [
                'title'  => 'Berita',
                'br1'  => 'Berita',
                'br2'  => ucwords($category),
                'category'  => $category,
            ],

        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $category = $request->has('category') ? $request->input('category') : null;
        $categoryRow = Category::where('slug', $category)->firstOrFail();
        $categoryID = $category ? $categoryRow->id : null;
        $categories = Category::all();
        $tags       = Tag::all();
        $kabkotas = Kabkota::all();
        $title = 'Posts';
        $br1 = 'Create';
        $br2 = 'Posts';
        return view('admin.posts.create', compact('categories', 'tags', 'title', 'br1', 'br2', 'kabkotas', 'category', 'categoryID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->input();


        $validator = Validator::make($request->all(), [
            "title"     => "required|unique:posts,title",
            "desc"      => "required",
            "category"  => "required",
            "tags"      => "array|required",
            "keywords"  => "required",
            "meta_desc" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post               = new Post();
        $post->cover        = isset($request->cover) ? $request->cover : null;
        $post->title        = $request->title;
        $post->slug         = \Str::slug($request->title);
        $post->user_id      = Auth::user()->id;
        $post->category_id  = $request->category;
        $post->desc         = $request->desc;
        $post->keywords     = $request->keywords;
        $post->meta_desc    = $request->meta_desc;
        $post->id_kabkota    = $request->kabkota;

        if ($user->hasRole('kontributor_daerah')) {
            $post->status = 'draft';
        }


        $post->save();

        $post->tags()->attach($request->tags);

        $categorySlug = \App\Models\Category::find($request->category)->slug;

        return redirect()->route('posts.index', ['category' => $categorySlug])->with('success', 'Data added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        $kabkotas = Kabkota::all();

        $title = 'Posts';
        $br1 = 'Edit';
        $br2 = 'Posts';
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'title', 'br1', 'br2', 'kabkotas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "title"     => "required|unique:posts,title," . $id,
            "desc"      => "required",
            "category"  => "required",
            "tags"      => "array|required",
            "keywords"  => "required",
            "meta_desc" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        $post = Post::findOrFail($id);
        $post->cover        = isset($request->cover) ? $request->cover : null;
        $post->title        = $request->title;
        $post->slug         = $request->slug;
        $post->category_id  = $request->category;
        $post->desc         = $request->desc;
        $post->keywords     = $request->keywords;
        $post->meta_desc    = $request->meta_desc;
        $post->id_kabkota    = $request->kabkota;
        $post->save();

        $post->tags()->sync($request->tags);

        return redirect()->route('posts.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $success = false;
        $message = '';

        try {
            $res = Post::findOrFail($id);
            $res->delete();
            $success = true;
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()
            ->json(['success' => $success, 'message' => $message]);
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()->get();

        return view('admin.posts.trash', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if ($post->trashed()) {
            $post->restore();
            return redirect()->back()->with('success', 'Data successfully restored');
        } else {
            return redirect()->back()->with('error', 'Data is not in trash');
        }
    }

    public function deletePermanent($id)
    {

        $post = Post::withTrashed()->findOrFail($id);

        if (!$post->trashed()) {

            return redirect()->back()->with('error', 'Data is not in trash');
        } else {

            $post->tags()->detach();


            if ($post->cover && file_exists(storage_path('app/public/' . $post->cover))) {
                \Storage::delete('public/' . $post->cover);
            }

            $post->forceDelete();

            return redirect()->back()->with('success', 'Data deleted successfully');
        }
    }
}
