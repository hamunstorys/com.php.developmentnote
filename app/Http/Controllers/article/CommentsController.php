<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->can('create', Comment::class)) {

            $this->validate($request, [
                'comment' => 'required',
            ]);

            $article = Article::findOrFail($request->get('id'));
            $user = $request->user();

            $comment = new Comment;
            $comment->fill([
                'comment' => $request->comment,
            ]);

            $user->comments()->save($comment);
            $comment->save();
            $article->comments()->attach($comment);

            flash('댓글이 작성되었습니다.');
            return redirect()->back();

        } else {

            flash('승인되지 않은 사용자 행위입니다.');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if ($request->user()->can('create', $comment)) {
            return view('article.comment.edit', compact('comment'));
        } else {
            flash('승인되지 않은 사용자 행위입니다.');
            return redirect()->back();
        }
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
        $this->validate($request, [
            'comment' => 'required',
        ]);
        $comment = Comment::findOrFail($id);
        $comment->fill($request->all());
        $comment->save();
        $article = $comment->articles()->first()->id;
        return redirect(route('article.show', $article));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if ($request->user()->can('create', $comment)) {
            $comment->delete();
            flash('댓글이 삭제되었습니다.');
            return redirect(route('article.index'));
        } else {
            flash('승인되지 않은 사용자 행위입니다.');
            return redirect()->back();
        }
    }
}
