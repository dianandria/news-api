<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\News;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->news = new News;
    }

    public function index()
    {
        $data = $this->news->showNews();
        
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'news_category_id' => 'required',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'full_content' => 'required',
            'thumbnail' => 'required',
            'thumbnail_caption' => 'required|string',
            'is_publish' => 'required|in:0,1',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = ([
            'news_category_id' => $request->news_category_id,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'full_content' => $request->full_content,
            'thumbnail' => $request->thumbnail,
            'thumbnail_caption' => $request->thumbnail_caption,
            'is_publish' => $request->is_publish,
        ]);

        $result = $this->news->storeNews($data);

        return response()->json($result, 201);
    }

    public function show($id)
    {
        $data = $this->news->getNews($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'news_category_id' => 'required',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'full_content' => 'required',
            'thumbnail' => 'required',
            'thumbnail_caption' => 'required|string',
            'is_publish' => 'required|in:0,1',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = ([
            'news_category_id' => $request->news_category_id,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'full_content' => $request->full_content,
            'thumbnail' => $request->thumbnail,
            'thumbnail_caption' => $request->thumbnail_caption,
            'is_publish' => $request->is_publish,
        ]);

        $result = $this->news->updateNews($data, $id);
        if ($result==1) {
            return response()->json([
                'status'=>true,
            ], 201);
        }else{
            return response()->json([
                'status'=>false,
            ], 404);
        }
    }

    public function destroy($id)
    {
        $this->news->deleteNews($id);
        return response()->json(['status'=>true],204);
    }
}
