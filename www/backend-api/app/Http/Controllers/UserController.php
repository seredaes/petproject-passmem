<?php

namespace App\Http\Controllers;

use App\DTO\UserAuthDTO;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UserAuthRequest;
use App\Http\Requests\UserRequest;
use App\Mail\ConfirmEmail;
use App\Models\User;
use App\Response\GlobalResponse;
use App\Response\UserResponse;
use App\Services\UserService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;
use App\DTO\UserRegisterDTO;
use function Termwind\render;

class UserController extends Controller
{
    public function ping(Request $request, GlobalResponse $globalResponse): \Illuminate\Http\JsonResponse
    {
        $response = $globalResponse->success()
            ->setMessage("Pong")
            ->get();
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *      path="/api/auth",
     *      tags={"Auth"},
     *      operationId="makeAuth",
     *      summary="Make auth in project",
     *      description="Return token if auth is correct",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *     )
     */
    public function makeAuth(UserAuthRequest $request, UserService $userService, GlobalResponse $globalResponse)
    {
        $userDTO = new UserAuthDTO(
            $request->get("email"),
            $request->get("password")
        );

        $checkResult = $userService->auth($userDTO);
        if($checkResult === null) {
            $response = $globalResponse->error()
                ->setMessage("Ошибка авторизации. Проверьте email и пароль.")
                ->get();
            return response()->json($response, 422);
        } else {
            return response()->json($checkResult);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/registration",
     *      tags={"Auth"},
     *      operationId="makeRegistration",
     *      summary="Make registration in project",
     *      description="# Регистрация пользователя",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *     description = "Пароль от **8** до **16** символов. ",
     *     @OA\JsonContent(
     *           required={"email","password", "name", "password_confirmation"},
     *           @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *           @OA\Property(property="name", type="string", format="string", example="User 1"),
     *           @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *           @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
     *        ),
     *     ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *     )
     */
    public function makeRegistration(UserRequest $request, UserService $userService, GlobalResponse $globalResponse): \Illuminate\Http\JsonResponse
    {

        $userDTO = new UserRegisterDTO(
            $request->get("name"),
            $request->get("email"),
            Hash::make($request->get("password")),
            Str::random(200)
        );

        if ($userService->createNewUser($userDTO)) {
            $response = $globalResponse
                ->success()
                ->setMessage("Пользователь $userDTO->email успешно зарегистрирован! Подтвердите свою почту.")
                ->get();
            return response()->json($response);
        }

        $response = $globalResponse
            ->error()
            ->setMessage("Пользователь $userDTO->email не создан. Обратитесь к администратору.")
            ->get();
        return response()->json($response, 422);

    }


    /**
     * @param $confirm_code
     * @param UserService $userService
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function makeEmailConfirmation($confirm_code, UserService $userService)
    {

        if ($userService->confirmEmail($confirm_code)) {
            return view("confirm_email.success");
        }

        return view("confirm_email.error");
    }
}
