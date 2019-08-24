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
		
		$data = (new Product)
			->all()
			->toArray();

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
		return $this->saveData($request);
	}

// -------------------------------------------------------

	public function edit(string $id)
	{
		$data = $this->getData($id);

		return view('product.edit', compact("id", "data"));
	}

// -------------------------------------------------------

	public function update(Request $request, string $id)
	{
		return $this->saveData($request, $id);
	}

// -------------------------------------------------------

	public function destroy(string $id)
	{
		$data = $this->getData($id);

		$data->delete();

		return Redirect::route('product.index');				
	}

// -------------------------------------------------------

	public function show($id)
	{
		$data = $this->getData($id);

		return view('product.show', compact('data', 'id'));
	}

// -------------------------------------------------------

	private function getData(string $id) {
		// $data = DB::table("products")
		// 	->where("id", "=", $id)
		// 	->first();

		// $data = collect($data);

		$data = (new Product)
			->where("id", "=", $id)
			->first();

		if (is_null($data)) {
			abort(404);
		}

		return $data;
	}

// -------------------------------------------------------

	private function saveData(Request $request, string $id = null)
	{
		// get form data
		$inputData = $request->all();

		// validate form data
		$rules = [
			'sku' => "required|min:7|unique:products,sku,$id,id,deleted_at,NULL",
			'name' => 'required|min:7',
			'stock' => 'required|numeric|min:0',
			'price' => 'required|numeric|min:0',
			'description' => 'nullable',
		];

		$customMessages = [
			// 'name.required' => 'butuh name',
		];

		$validation = Validator::make($inputData, $rules, $customMessages);
		if ($validation->fails()) {
			return Redirect::back()
				->withErrors($validation)
				->withInput();
		}

		// clean up form data
		unset($inputData['_token']);
		unset($inputData['_method']);

		// save form data to DB
		$data = (new Product);

		if (!is_null($id)) {
			$data = $this->getData($id);
		}

		DB::beginTransaction();
		try {
			foreach ($inputData as $column => $value) {
				$data->{$column} = $value;
			}
			
			$data->save();
		} catch (Exception $e) {
			DB::rollback();

			return Redirect::back()
				->withErrors(['error' => $e->getMessage()])
				->withInput();
		}
		DB::commit();

		return Redirect::route('product.index');
	}
}