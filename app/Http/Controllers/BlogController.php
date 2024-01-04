<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\blog;
use App\Traits\APIResponseTrait;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller{

    use APIResponseTrait;

    public function index(): JsonResponse{
        return $this->successResponse(
            'List of blog posts',
            BlogResource::collection(Blog::all())
        );
    }

    public function store(BlogRequest $request): JsonResponse{
        try{
            $blog = new Blog();
            $this->uploadBlogImg($request, $blog);
            $blog->fill($request->except('cover_image'));
            $blog->save();
            return $this->successResponse('Blog was created', new BlogResource($blog));
        }catch (\Exception $e){
            return $this->errorResponse('Error occurred while creating blog', $e->getMessage(), 500);
        }
    }

    public function show(blog $blog): JsonResponse{
        try{
            return $this->successResponse('Blog Post Listing', new BlogResource($blog));
        }catch (\Exception $e){
            return $this->errorResponse('Error occurred while fetching blog', $e->getMessage(), 500);
        }
    }

    public function update(BlogRequest $request, blog $blog): JsonResponse{
        try{
            $this->uploadBlogImg($request, $blog);
            $blog->update($request->except('cover_image'));
            $blog->refresh();
            return $this->successResponse('Blog was updated!', $blog);
        }catch(\Exception $e){
            return $this->errorResponse('Error occurred while updating blog', [], 500);
        }
    }

    public function destroy(blog $blog): JsonResponse{
        return $blog->delete() ?
            $this->successResponse('Record was deleted!', [], 200) :
            $this->successResponse('Error occurred while deleting record!', [], 500);
    }

    private function uploadBlogImg(BlogRequest $request, Blog $blog): void{
        if($request->file('cover_image')){
            $img = $request->file('cover_image');
            $coverImg = $img->hashName();
            $blog->cover_image = $coverImg;
            $img->move(public_path('storage/images/blogs/'), $coverImg);
        }
    }
}
