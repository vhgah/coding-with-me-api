<?php

namespace App\Http\Controllers\Admin;

use App\Actions\CreateCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\RepositoryInterfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {
        //   
    }

    public function index(Request $request)
    {
        $options = [
            'keyword' => $request->input('keyword'),
            'status' => $request->input('status'),
            'sort_field' => 'created_at',
            'sort_order' => 'desc',
        ];

        $categories = $this->categoryRepository
            ->paginate($options)
            ->through(function (Category $category) {
                return $this->getResource($category);
            });

        return response()->json($categories);
    }

    public function store(CreateCategoryRequest $request)
    {
        $data = $request->validated();

        $category = CreateCategory::make($data)->execute();

        return response()->json(
            $this->getResource($category),
            201
        );
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $category->update($data);

        return response()->json(
            $this->getResource($category)
        );
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return response()->json([
                'message' => sprintf('The %s category contains posts and cannot be deleted', $category->name),
                'errors' => [],
            ], 400);
        }

        $category->delete();

        return response()->json(null, 204);
    }

    private function getResource(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'position' => $category->position,
        ];
    }
}
