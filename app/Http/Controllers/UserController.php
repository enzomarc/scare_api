<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	/**
	 * Get all the users.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		$users = User::all();
		
		return response()->json($users);
	}
	
	/**
	 * Get the requested user.
	 *
	 * @param int $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $user)
	{
		try {
			$user = User::find($user);
			
			if ($user == null)
				return response()->json(['message' => 'Unable to find the user.'], 404);
			
			return response()->json($user);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unable to find the user.', 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Create a user.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$data = $this->validate($request, [
			'first_name' => 'required',
			'phone' => 'required|numeric|min:9',
			'email' => 'required',
			'clinic' => 'required|numeric',
			'password' => 'required',
		]);
		
		$data['last_name'] = $request->input('last_name');
		$data['password'] = Hash::make($data['password']);
		$user = new User($data);
		
		try {
			if ($user->save())
				return response()->json(['message' => 'User successfully created.', 'user' => $user], 201);
			else
				return response()->json(['message' => 'Unable to create the user.'], 500);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unale to create the user.', 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Update the given user.
	 *
	 * @param Request $request
	 * @param int $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, int $user)
	{
		try {
			$data = $request->input();
			$user = User::findOrFail($user);
			
			if ($user->update($data))
				return response()->json(['message' => 'User successfully updated.', 'user' => $user]);
			else
				return response()->json(['message' => 'Unable to update the user.']);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unable to update the user.', 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Delete the given user.
	 *
	 * @param int $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(int $user)
	{
		try {
			$user = User::findOrFail($user);
			
			if ($user->delete())
				return response()->json(['message' => 'User successfully deleted.']);
			else
				return response()->json(['message' => 'Unable to delete the user.']);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unable to delete the user.', 'exception' => $e->getMessage()], 500);
		}
	}
	
	/**
	 * Toggle user activation state.
	 *
	 * @param int $user
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function toggle(int $user)
	{
		try {
			$user = User::findOrFail($user);
			
			if ($user->update(['active' => $user->active == 0 ? 1 : 0]))
				return response()->json([
					'message' => $user->active == 0 ? 'User was successfully deactivated.' : 'User was successfully activated.',
					'user' => $user
				]);
			else
				return response()->json(['message' => 'Unable to toggle the user activation state.'], 500);
		} catch (\Exception $e) {
			return response()->json(['message' => 'Unable to toggle the user activation state.', 'exception' => $e->getMessage()], 500);
		}
	}
}
