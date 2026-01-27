<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Get all approved comments for a product
     */
    public function index($productId)
    {
        try {
            $comments = ProductComment::where('product_id', $productId)
                ->where('is_approved', true)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $comments,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching comments: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new comment from a guest
     */
    public function store(Request $request, $productId)
    {
        try {
            $validated = $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|email',
                'comment_text' => 'required|string|min:5|max:1000',
                'rating' => 'required|integer|min:1|max:5',
            ]);

            // Verify product exists
            $product = \App\Models\Product::findOrFail($productId);

            $comment = ProductComment::create([
                'product_id' => $productId,
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'comment_text' => $validated['comment_text'],
                'rating' => $validated['rating'],
                'is_approved' => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'data' => $comment,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding comment: ' . $e->getMessage(),
            ], 500);
        }
    }
}
