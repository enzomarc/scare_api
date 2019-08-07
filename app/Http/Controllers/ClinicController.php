<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clinic;

class ClinicController extends Controller
{
	/**
	 * Get all the clinics.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		$clinics = Clinic::all();
		
		return response()->json($clinics);
	}
	
	/**
	 * Get the requested clinic.
	 *
	 * @param int $clinic
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $clinic)
	{
		try {
			$clinic = Clinic::find($clinic);
			
			if ($clinic == null)
				return response()->json(['message' => 'Unable to find the clinic.'], 404);
			
			return response()->json($clinic);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unable to find the clinic.', 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Create a clinic.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$temp = $this->validate($request, [
			'clinic_name' => 'required',
			'clinic_country' => 'required',
			'clinic_region' => 'required',
			'clinic_city' => 'required',
			'clinic_phone' => 'required|numeric|min:9',
		]);
		
		$data['name'] = $temp['clinic_name'];
		$data['country'] = $temp['clinic_country'];
		$data['region'] = $temp['clinic_region'];
		$data['city'] = $temp['clinic_city'];
		$data['phone'] = $temp['clinic_phone'];
		$data['email'] = $request->input('clinic_email');
		
		$clinic = new Clinic($data);
		
		try {
			if ($clinic->save())
				return response()->json(['message' => 'Clinic successfully created.', 'clinic' => $clinic], 201);
			else
				return response()->json(['message' => 'Unable to create the clinic.'], 500);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unale to create the clinic.', 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Update the given clinic.
	 *
	 * @param Request $request
	 * @param int $clinic
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, int $clinic)
	{
		try {
			$data = $request->input();
			$clinic = Clinic::findOrFail($clinic);
			
			if ($clinic->update($data))
				return response()->json(['message' => 'Clinic successfully updated.', 'clinic' => $clinic]);
			else
				return response()->json(['message' => 'Unable to update the clinic.']);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unable to update the clinic.', 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Delete the given clinic.
	 *
	 * @param int $clinic
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(int $clinic)
	{
		try {
			$clinic = Clinic::findOrFail($clinic);
			
			if ($clinic->delete())
				return response()->json(['message' => 'Clinic successfully deleted.']);
			else
				return response()->json(['message' => 'Unable to delete the clinic.']);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unable to delete the clinic.', 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Toggle clinic activation state.
	 *
	 * @param int $clinic
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function toggle(int $clinic)
	{
		try {
			$clinic = Clinic::findOrFail($clinic);
			
			if ($clinic->update(['active' => $clinic->active == 0 ? 1 : 0]))
				return response()->json([
					'message' => $clinic->active == 0 ? 'Clinic was successfully deactivated.' : 'Clinic was successfully activated.',
					'clinic' => $clinic
				]);
			else
				return response()->json(['message' => 'Unable to toggle the clinic activation state.'], 500);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unable to toggle the clinic activation state.', 'exception' => $e->getMessage()], 500);
		}
	}
}
