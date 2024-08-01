<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();

        return response()->json([
            "authors" => new AuthorCollection($authors)
        ]);
    }

    public function store(AuthorRequest $request)
    {
        $author = Author::create($request->validated());

        return response()->json([
            "message" => "Author created successfully",
            "author" => new AuthorResource($author)
        ], 201);
    }

    public function show(Author $author)
    {
        return response()->json([
            "author" => new AuthorResource($author)
        ]);
    }

    public function update(AuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        return response()->json([
            "message" => "Author updated successfully",
            "author" => new AuthorResource($author)
        ], 200);
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return response()->noContent();
    }
}
