<?php

namespace App\Http\Controllers\Api;

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

		return $this->constructSuccessResponse([
			"products" => $data,
		]);

// api/products?page=1&search=asd&sort=-name&category=car,bike&status=ACTIVE
		
	// 	return response()->json([
	// 		"status" => "SUCCESS",
	// 		"code" => "000",
	// 		"data" => ["products" => $data],
	// 		"meta" => [
	// 			"page" => [
	// 				"current" => 1,
	// 				"total" => 3,
	// 			],
	// 			"list" => [
	// 				"current" => 15,
	// 				"total" => 40,
	// 			],
	// 			"search" => [
	// 				"seachables" => [
	// 					"name",
	// 					"sku",
	// 				],
	// 				"active" => "asd",
	// 			],
	// 			"sort" => [
	// 				"sortables" => [
	// 					"name",
	// 					"posted_date",
	// 				],
	// 				"active" => "-name",
	// 			],
	// 			"filter" => [
	// 				"filterables" => [
	// 					// "category" => (new Category)->get(),
	// 					"category" => [
	// 						"car",
	// 						"bike",
	// 						"ship",
	// 					],
	// 					"owner" => [
	// 						"user1",
	// 						"user2",
	// 					],
	// 					"status" => [
	// 						"ACTIVE",
	// 						"INACTIVE",
	// 					],
	// 				],
	// 				"active" => [
	// 					"category" => [
	// 						"car",
	// 						"bike",
	// 					],
	// 					"status" => [
	// 						"ACTIVE"
	// 					],
	// 				],
	// 			],
	// 		],
	// 	]);
	}

// -------------------------------------------------------
	
	// public function create()
	// {
	// 	return view('product.create');
	// }

// -------------------------------------------------------

	public function store(Request $request)
	{
		$data = $this->saveData($request);

		if (isset($data["error"])) {
			return $this->constructSuccessResponse($data["error"]);
		}

		return $this->constructSuccessResponse([
			"created_id" => $data->id,
			"product" => $data,
		]);
	}

// -------------------------------------------------------

	// public function edit(string $id)
	// {
	// 	$data = $this->getData($id);

	// 	return view('product.edit', compact("id", "data"));
	// }

// -------------------------------------------------------

	public function update(Request $request, string $id)
	{
		$data = $this->saveData($request, $id);

		if (isset($data["error"])) {
			return $this->constructSuccessResponse($data["error"]);
		}

		return $this->constructSuccessResponse([
			"updated_id" => $id,
			"product" => $data,
		]);
	}

// -------------------------------------------------------

	public function destroy(string $id)
	{
		$data = $this->getData($id);

		$data->delete();

		return $this->constructSuccessResponse([
			"deleted_id" => $id,
		]);			
	}

// -------------------------------------------------------

	public function show($id)
	{
		$data = $this->getData($id);

		return $this->constructSuccessResponse([
			"product" => $data,
		]);
	}

// -------------------------------------------------------

	private function constructerrorResponse($errors)
	{
		return response()->json([
			"status" => "ERROR",
			"code" => "911",
			"message" => implode("|", $errors),
		]);
	}

// -------------------------------------------------------

	private function constructSuccessResponse($data)
	{
		return response()->json([
			"status" => "SUCCESS",
			"code" => "000",
			"data" => $data,
		]);
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

			return ["error" => $validation->errors()->all()];
			
			// return Redirect::back()
			// 	->withErrors($validation)
			// 	->withInput();
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

			return ["error" => $e->getMessage()];

			// return Redirect::back()
			// 	->withErrors(['error' => $e->getMessage()])
			// 	->withInput();
		}
		DB::commit();

		return $data;
	}
}