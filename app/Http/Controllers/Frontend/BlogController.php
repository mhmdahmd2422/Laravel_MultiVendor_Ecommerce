<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(string $slug)
    {
        $blog = Blog::activeNewest()->firstOrFail();
        $categories = BlogCategory::where('status', 1)->take(8)->get();
        $more_blogs = Blog::where('slug', '!=', $slug)->activeNewest()->take(8)->get();
        $comments = BlogComment::where(['blog_id' => $blog->id])->paginate(4);
        $popular_posts = Blog::active()->get()->sortByDesc(function ($popular_posts){return $popular_posts->comments->count();})->take(1);
        return view('frontend.pages.blog-details',
            compact(
                'blog',
                'more_blogs',
                'categories',
                'comments',
                'popular_posts'
            ));
    }

    public function blog(Request $request)
    {
        if($request->has('search')){
            $blogs = Blog::activeNewest()->where('title', 'like', '%'.$request->get('search').'%')->paginate(8);
        }else if($request->has('category')){
            $category = BlogCategory::where('slug', $request->get('category'))->where('status', 1)->first();
            if($category){
                $blogs = Blog::activeNewest()->where('category_id', $category->id)->paginate(8);
            }else{
                $blogs = collect([]); //as no search result
            }
        }else {
            $blogs = Blog::activeNewest()->paginate(8);
        }
        return view('frontend.pages.blog', compact('blogs'));
    }

    public function comment(Request $request)
    {
        $request->validate([
           'comment' => ['required', 'string', 'max:500'],
        ]);
        $comments = BlogComment::where(['user_id' => auth()->id(), 'blog_id' => $request->blog_id])->count();
        if(auth()->check()){
            if($comments > 5){
                toastr('You Reached Your Maximum Comments For This Post!', 'error', 'error');
                return redirect()->back();
            }else{
                $comment = new BlogComment();
                $comment->user_id = auth()->id();
                $comment->blog_id = $request->blog_id;
                $comment->comment = $request->comment;
                $comment->save();

                toastr('Your Comment Is Posted!', 'success', 'success');
                return redirect()->back();
            }
        }else{
            return response(['status' => 'error']);
        }
    }
}
