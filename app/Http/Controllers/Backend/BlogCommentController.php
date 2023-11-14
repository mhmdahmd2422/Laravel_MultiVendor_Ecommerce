<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogCommentsDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\User;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index(BlogCommentsDataTable $dataTable)
    {
        return $dataTable->render('admin.blog-comment.index');
    }

    public function destroy(string $id)
    {
        $comment = BlogComment::findOrFail($id);;
        $comment->delete();

        return response(['status' => 'success', 'message' => 'Comment Has Been Deleted']);
    }

    public function ban(string $id)
    {
        $user = User::findOrFail($id);
        if($user->role === 'user'){
            $user->status = 'inactive';
            $user->save();
            $comments = BlogComment::where('user_id', $user->id)->get();
            foreach ($comments as $comment){
                $comment->delete();
            }
            return response(['status' => 'success', 'message' => 'User Has Been Banned']);
        }else{
            return response(['status' => 'error', 'message' => 'Cannot Ban '.ucfirst($user->role).' User']);
        }
    }
}
