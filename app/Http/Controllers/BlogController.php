<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    /**
     * @var int
     */
    protected $paginate = 10;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $blogs = Blog::published()->paginate(
            $this->paginate
        );

        return view('blog.index', [
            'blogs' => $blogs,
            'title' => 'Blogs',
            'open_graph' => [
                'title' => 'Blogs',
                'image' => asset('assets/logo.jpeg'),
                'url' => $this->request->url(),
                'description' => 'A blog website to share tutorials and tips !',
                'keywords' => 'A Laravel Blog, Tips, Tutorials',
            ],
        ]);
    }

    /**
     * @param $slug
     */
    public function view($slug)
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog.view', [
            'blog' => $blog,
            'open_graph' => [
                'title' => $blog->title,
                'image' => asset('assets/preview.jpeg'),
                'url' => $this->request->url(),
                'description' => $blog->excerpt,
            ],
        ]);
    }
}
