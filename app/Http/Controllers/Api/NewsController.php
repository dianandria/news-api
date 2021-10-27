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

    /**
     * @OA\Get(
     *      path="/api/news",
     *      operationId="getNewsList",
     *      tags={"News"},
     *      summary="Get list of news",
     *      description="Returns list of news",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *     )
     */

    public function index()
    {
        $data = $this->news->showNews();
        
        return response()->json($data, 200);
    }

    /**
     * @OA\Post(
     *      path="/api/news",
     *      operationId="storeNews",
     *      tags={"News Post"},
     *      summary="Store new news",
     *      description="Returns news data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          type="object",
     *              @OA\Property(property="news_category_id", type="integer"),
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="short_description", type="string"),
     *              @OA\Property(property="full_content", type="string"),
     *              @OA\Property(property="thumbnail", type="string"),
     *              @OA\Property(property="thumbnail_caption", type="string"),
     *              @OA\Property(property="is_publish", type="boolean"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     * )
     */
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

    /**
     * @OA\Get(
     *      path="/api/news/{id}",
     *      operationId="getNews",
     *      tags={"News"},
     *      summary="Get news by id",
     *      description="Returns news by id",
     *      @OA\Parameter(
     *          name="id",
     *          description="news id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
    *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *     )
     */
    public function show($id)
    {
        $data = $this->news->getNews($id);
        return response()->json($data, 200);
    }

    /**
     * @OA\Put(
     *      path="/api/news/{id}",
     *      operationId="updateNews",
     *      tags={"News Update"},
     *      summary="Update news",
     *      description="Returns news data",
     *      @OA\Parameter(
     *          name="id",
     *          description="news id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *          type="object",
     *              @OA\Property(property="news_category_id", type="integer"),
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="short_description", type="string"),
     *              @OA\Property(property="full_content", type="string"),
     *              @OA\Property(property="thumbnail", type="string"),
     *              @OA\Property(property="thumbnail_caption", type="string"),
     *              @OA\Property(property="is_publish", type="boolean"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     * )
     */
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

    /**
     * @OA\Delete(
     *      path="/api/news/{id}",
     *      operationId="deleteNews",
     *      tags={"News Delete"},
     *      summary="Delete existing news",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="news id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($id)
    {
        $this->news->deleteNews($id);
        return response()->json(['status'=>true],204);
    }
}
