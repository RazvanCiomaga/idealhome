<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Authentication Endpoints"
 * )
 */
class ApiAuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate and get access token valid for 1 year",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client_id", "client_secret"},
     *             @OA\Property(property="client_id", type="string", example="b5d5c78f-xxxx-xxxx-xxxx-xxxxxxxx"),
     *             @OA\Property(property="client_secret", type="string", example="p$asdf234jk23n"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful authentication",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|qwertyuiopasdfghjklzxcvbnm123456")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Unauthorized"),
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'client_id' => 'required',
            'client_secret' => 'required',
        ]);

        /** @var ApiUser|null $user */
        $user = ApiUser::query()
            ->where('client_id', $request->client_id)
            ->where('client_secret', $request->client_secret)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$user->is_active) {
            return response()->json(['error' => 'User is not active'], 403);
        }

        $token = $user->createToken('API Access')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
