<?php

namespace App\Http\Controllers;

use App\DTO\ListDTO;
use App\Http\Requests\GetUserListRequest;
use App\Http\Requests\UserListRequest;
use App\Http\Requests\UserListUpdateRequest;
use App\Http\Requests\UserListDeleteRequest;
use App\Models\User;
use App\Models\Userlist;
use App\Response\GlobalResponse;
use App\Services\ListService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserListController extends Controller
{

    private string $user_id;

    public function getUserID(string $token) {
        $userService = new UserService();
        $this->user_id = $userService->getUserIDByToken($token);
    }

    /**
     * @OA\Post(
     *   path="/api/list",
     *   tags={"List"},
     *   operationId="getList",
     *   summary="Get or search list",
     *   description="# Получить список записей пользователя",
     *   security={{"bearer_token":{}}},
     *
     *
     *   @OA\RequestBody(
     *     description = "Поле search по умолчанию должно быть как * - все записи, или первые буквы для поиска по title",
     *     @OA\JsonContent(
     *       required={"search"},
     *       @OA\Property(property="search", type="string", format="string", example="*"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *   ),
     * )
     */
    public function getList(Request $request, GlobalResponse $globalResponse, ListService $listService) {

        # get userID
        $this->getUserID($request->bearerToken());

        $result = $listService->getList($this->user_id);

        $response = $globalResponse->success()->setData($result)->get();
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *   path="/api/list/create",
     *   tags={"List"},
     *   operationId="setList",
     *   summary="Create new record in list",
     *   description="# Создать новую запись",
     *   security={{"bearer_token":{}}},
     *
     *
     *   @OA\RequestBody(
     *     description = "Поле description не обязательно",
     *     @OA\JsonContent(
     *       required={"title", "login", "password"},
     *       @OA\Property(property="title", type="string", format="string", example="google"),
     *       @OA\Property(property="login", type="string", format="string", example="user1@gmail.com"),
     *       @OA\Property(property="password", type="string", format="string", example="Aa123456#"),
     *       @OA\Property(property="description", type="string", format="string", example=""),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *   ),
     * )
     */
    public function setList(UserListRequest $request, ListService $listService, GlobalResponse $globalResponse, UserService $userService): \Illuminate\Http\JsonResponse
    {

        # get userID
        $this->getUserID($request->bearerToken());

        $userList = new ListDTO(
            $request->get("title"),
            $request->get("login"),
            $request->get("password"),
            $request->get("description", "") ?? "",
            $this->user_id
        );


        if($listService->createNewList($userList)) {
            $response = $globalResponse
                ->success()
                ->setMessage("Запись успешно создана")
                ->get();
            return response()->json($response);
        }

        $response = $globalResponse
            ->error()
            ->setMessage("Невозможно создать запись, обратитесь к администратору")
            ->get();
        return response()->json($response, 422);
    }


    /**
     * @OA\Post(
     *   path="/api/list/update",
     *   tags={"List"},
     *   operationId="updateList",
     *   summary="Update record in list by ID",
     *   description="# Изменить запись",
     *   security={{"bearer_token":{}}},
     *
     *
     *   @OA\RequestBody(
     *     description = "Поле description не обязательно",
     *     @OA\JsonContent(
     *       required={"title", "login", "password", "id"},
     *       @OA\Property(property="title", type="string", format="string", example="google"),
     *       @OA\Property(property="login", type="string", format="string", example="user1@gmail.com"),
     *       @OA\Property(property="password", type="string", format="string", example="Aa123456#"),
     *       @OA\Property(property="description", type="string", format="string", example=""),
     *       @OA\Property(property="id", type="string", format="string", example="9ab8717c-c16c-4c22-8951-a44d531b0efb"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *   ),
     * )
     */
    public function updateList(UserListUpdateRequest $request, ListService $listService, GlobalResponse $globalResponse): \Illuminate\Http\JsonResponse
    {

        # get userID
        $this->getUserID($request->bearerToken());


        $userList = new ListDTO(
            Crypt::encrypt($request->get("title"),false),
            Crypt::encrypt($request->get("login"),false),
            Crypt::encrypt($request->get("password"),false),
            Crypt::encrypt($request->get("description", ""),false),
            $this->user_id
        );
        $id = $request->get("id");


        if($listService->updateList($id, $userList)) {
            $response = $globalResponse
                ->success()
                ->setMessage("Запись успешно обновлена")
                ->get();
            return response()->json($response);
        }

        $response = $globalResponse
            ->error()
            ->setMessage("Невозможно обновить запись, обратитесь к администратору")
            ->get();
        return response()->json($response, 422);
    }

    /**
     * @OA\Post(
     *   path="/api/list/delete",
     *   tags={"List"},
     *   operationId="deleteList",
     *   summary="Delete record in list by ID",
     *   description="# Удалить запись",
     *   security={{"bearer_token":{}}},
     *
     *
     *   @OA\RequestBody(
     *     description = "Поле description не обязательно",
     *     @OA\JsonContent(
     *       required={"id"},
     *       @OA\Property(property="id", type="string", format="string", example="9ab8717c-c16c-4c22-8951-a44d531b0efb"),
     *     ),
     *   ),
     *
     *   @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *   ),
     * )
     */
    public function deleteList(UserListDeleteRequest $request, ListService $listService, GlobalResponse $globalResponse) {
        $id = $request->get("id", "empty");

        # get userID
        $this->getUserID($request->bearerToken());

        if($listService->deleteList($id, $this->user_id)) {
            $response = $globalResponse
                ->success()
                ->setMessage("Запись успешно удалена")
                ->get();
            return response()->json($response);
        }

        $response = $globalResponse
            ->error()
            ->setMessage("Невозможно удалить запись, обратитесь к администратору")
            ->get();
        return response()->json($response, 422);
    }
}

