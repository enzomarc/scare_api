<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;

class AuthMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param $request
	 * @param Closure $next
	 * @return \Illuminate\Http\JsonResponse|mixed
	 * @throws \Exception
	 */
	public function handle($request, Closure $next)
	{
		if (!$request->hasHeader('Authorization'))
			return response()->json('Authorization Header not found.', 401);

		$token = $request->header('Authorization');

		if ($token == null)
			return response()->json('No token provided.', 401);

		try {
			$client = new Client();
			$response = $client->get('http://127.0.0.1:3000/api/validate/' . $token);

			if ($response->getStatusCode() != 200)
				return response()->json($response->getBody(), $response->getStatusCode());
		} catch (\Exception $e) {
			return response()->json($e->getMessage(), $e->getCode());
		}

		return $next($request);
	}
}
