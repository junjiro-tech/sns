<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Tweet;

class TimelineController extends Controller
{
    
    //ツイート画面表示,順番に15個ずつ表示
    public function showTimelinePage(Request $request)
    {   
        if($request->has('keyword')) {
        // SQLのlike句でitemsテーブルを検索する
            $items = Tweet::where('tweet', 'like', '%'.$request->get('keyword').'%')->paginate(16);
        } else {
            //latest()はデータの結果を簡単に整列できる,デフォルトで、結果はcreated_atカラムによりソートされる
            $tweets = Tweet::latest()->get(); //ソートキーとしてカラム名を渡すこともできる
                                         //$tweets = Tweet::latest()->get();でツイートテーブルに保存されたツイートを新着順で降順で取得
            $tweets = Tweet::latest('tweet')->paginate(15); //orderByにすると第1引数は対象カラム名,第2引数は昇降順指定,
                                                            //ascは昇順 【例】1,2,3,4,5…  descは降順 例】5,4,3,2,1…
        }
        
        return view('auth.timeline', compact('tweets'));//compact('tweets')とする事で$tweetsに送っている,もしくは['tweets' => $tweets]
    }
    
    
    //ツイートのバリデーションとデータベースへの保存
    public function postTweet(Request $request)
    {
        $validate = $request->validate([
            'tweet' => ['required', 'string', 'max:280'],
        ]);
        
        Tweet::create([
            'user_id' => Auth::user()->id,
            'tweet' => $request->tweet,
        ]);
        
        return back(); ///timelineにリダイレクト
        //back()は、バリデーションエラーなど直前のページにリダイレクトさせたい時に使用。
        //この機能はセッションを利用しているためback関数を使用するルートは、webミドルウェアグループに属しているか
        //セッションミドルウェアが適用されることを確認 AuthenticatedUsersのwebを確認？
    }
    
    
}
