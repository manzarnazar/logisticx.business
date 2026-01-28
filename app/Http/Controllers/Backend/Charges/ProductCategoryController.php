<?php

namespace App\Http\Controllers\Backend\Charges;

use App\Http\Controllers\Controller;
use App\Http\Requests\Charges\ProductCategory\ProductCategoryStoreRequest;
use App\Http\Requests\Charges\ProductCategory\ProductCategoryUpdateRequest;
use App\Repositories\ProductCategory\ProductCategoryInterface;

class ProductCategoryController extends Controller
{
    private $repo;

    public function __construct(ProductCategoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $categories = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.product_category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.product_category.create');
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('productCategory')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $category = $this->repo->single($id);
        return view('backend.product_category.update', compact('category'));
    }

    public function update(ProductCategoryUpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('productCategory')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->repo->delete($id);

        if ($result['status']) :
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = ___('alert.something_went_wrong');
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }
}
