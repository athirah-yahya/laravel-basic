<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use DB;
use Exception;

use App\Models\Product;


class ProductController extends Controller
{
	public function index(Request $request)
	{
		
		dd(
			(new Product)
				->all()
				->toArray()
		);

		return view('product.index', compact('data'));
	}

// -------------------------------------------------------
	
	public function create()
	{
		return view('product.create');
	}

// -------------------------------------------------------

	public function store(Request $request)
	{
		// get form data
		$data = $request->all();

		// validate form data
		$rules = [
			'sku' => 'required|min:7|unique:products,sku,null,id,deleted_at,NULL',
			'name' => 'required|min:7',
			'stock' => 'required|numeric|min:0',
			'price' => 'required|numeric|min:0',
			'description' => 'nullable',
		];

		$customMessages = [
			// 'name.required' => 'butuh name',
		];

		$validation = Validator::make($data, $rules, $customMessages);
		if ($validation->fails()) {
			return Redirect::back()
				->withErrors($validation)
				->withInput();
		}

		// clean up form data
		unset($data['_token']);

		// save form data to DB
		$product = (new Product);

		DB::beginTransaction();
		try {
			foreach ($data as $column => $value) {
				$product->{$column} = $value;
			}
			
			$product->save();
		} catch (Exception $e) {
			DB::rollback();

			return Redirect::back()
				->withErrors(['error' => $e->getMessage()])
				->withInput();
		}
		DB::commit();

		return Redirect::route('product.index');
	}

// -------------------------------------------------------

	public function show($id)
	{
		return view('product.show', compact('id'));
	}

}