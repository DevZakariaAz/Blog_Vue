<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
  public function index(){

    $articles = Article::all();
    return response()->json($articles);
  }
  public function store(Request $request){
    $article = new Article;
    $article->title = $request->title;
    $article->content = $request->content;
    $article->save();
    return response()->json($article);
  }
}
