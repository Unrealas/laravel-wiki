<?php

namespace App\Http\Controllers;

use App\Category;
use App\File;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index($cat_id = null)
    {
        Storage::disk('public')->put('file.txt', 'Contents');

        // Cache::put('posts', Post::all(), 1);

        // echo env("ADMIN_MAIL");
        // Session::put('raktas','reiksme');
        // echo Session::get('raktas','reiksme');
        if (is_null($cat_id))
            $posts = Post::orderby('updated_at', "DESC")->paginate(3);
        else
            $posts = Post::where('category', $cat_id)->orderBy('updated_at', "DESC")->paginate(3);
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Category::all();
        return view('posts.create', ['cat' => $cat]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($_FILES['file']);
        // dd($request->file('file'));


        $validatedData = $request->validate([
            'title' => 'required|max:250|min:3',
            'content' => 'required|min:5',
            'file' => 'max:1200',
        ]);

        $data = $request->all();
        // dd($data); laravelinis var_dump

        $post = new Post();
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->category = 1;
        $post->user = Auth::user()->id;
        $post->save();

        foreach ($data['cat'] as $cat_id) {
            /*  DB::table('category_post')->insert([
                'category_id' => $cat_id,
                'post_id' => $post->id]);*/
            $post->cat()->attach($cat_id);
        }
        if ($request->hasFile('file')) {
            foreach($request->file as $file):
                /**
                 * pasiimam originalu pavadinima per metoda
                 * nes failo pavadinimo kintamasis yra private
                 */
                $original_name = $file->getClientOriginalName();
                /**
                 * Ikeliam faila i public diska -> antras metodo store argumentas
                 * Ikelimo rezultatas tai kelias iki to failo
                 */
                $path = $file->store('files/'.$post->id, 'public');

                $file = new File();
                $file->post_id = $post->id;
                $file->name = $original_name;
                $file->path = $path;
                $file->save();
            endforeach;
        }
        $request->session()->flash('status', 'Good job!');

        return redirect(route('home'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // kai naudojom su in_array
        // $selected_cats = $post->cat->pluck('id')->toArray();

        $selected_cats = $post->cat->pluck('id');
        $user = Auth::user();
        $cat = Category::all();

        if ($user->can('edit', $post))
            return view('posts.edit', [
                'post' => $post,
                'cat' => $cat,
                'selected_cats' => $selected_cats]);
        else
            return redirect(route('home'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:250|min:3',
            'content' => 'required|min:5',
        ]);

        $data = $request->all();

        $post = Post::find($id);

        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->category = $data['cat'];
        $post->user = Auth::user()->id;

        $post->save();

        $request->session()->flash('status', 'Post updated!');

        return redirect(route('posts.show', ['id' => $post->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $user = Auth::user();

        if ($user->cant('edit', $post))
            return redirect(route('home'));

        $post->delete();
        Session::flash('status', 'Post has been deleted!');

        return redirect(route('home'));

    }

    // sukurt mygtuka postu kurimui,

    public function fakePost()
    {
        Artisan::call('fakePost', [
            'params' =>
                [10, 100]
        ]);
    }
    public function downloadFile($id){
        $file = File::find($id);
        return Storage::disk('public')->download($file->path, $file->name);
    }
}
