<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    //
    public function index(){
        
        $comments = Comment::all();

        if(count($comments) > 0){
            return response()->json($comments, 200);
        }

        return response()->json([],200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'comment'=>'required|string',
            'assessment'=>'required|integer',
            'user_id'=> 'required|exists:users,id',
            'product_id'=> 'required|exists:product,id',
        ]);


        if($validator->fails()){
            return response()->json([
                'meesage' => 'Validator error', 
                'errors'=> $validator->errors()
            ],400);
        }

        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->assessment = $request->input('assessment');
        $comment->user_id = $request->input('user_id');
        $comment->product_id = $request->input('product_id');

        $comment->save();

        return response()->json(['message'=>'Successfully registered'],201);
    }

    function show($id){

        $comment = Comment::join('users','users.id','=','comment.user_id')
        ->join('product','product.id','=','comment.product_id')
        ->where('product.id','=',$id)
        ->select('*')
        ->get();

        return response()->json($comment,200);
    }

    public function indexByProduct($productId)
{
    // Obtener los comentarios del producto específico
    $comments = Comment::where('product_id', $productId)->get();
    return response()->json($comments, 200);
}

public function storeForProduct(Request $request, $productId)
{
    $validator = Validator::make($request->all(), [
        'comment' => 'required|string',
        'assessment' => 'required|integer|min:1|max:5',
        'user_id' => 'required|exists:users,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 400);
    }

    $comment = new Comment();
    $comment->comment = $request->input('comment');
    $comment->assessment = $request->input('assessment');
    $comment->user_id = $request->input('user_id');
    $comment->product_id = $productId;  

    $comment->save();

    return response()->json(['message' => 'Successfully registered'], 201);
}

}
