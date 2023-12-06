<?php

namespace App\Services;
use App\DTO\UserAuthDTO;
use App\DTO\UserRegisterDTO;
use App\Models\User;
use App\Response\GlobalResponse;
use App\Services\Notfications\MailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;
use Carbon\Carbon;

class UserService
{
    /**
     * @param UserRegisterDTO $data
     * @return bool
     */
    public function createNewUser(UserRegisterDTO $data): bool
    {

        User::create($data->toArray());

        $mailService = new MailService();
        $mailService->config($data)->send("confirm");

        return true;

    }

    public function confirmEmail(string $email_confirm_code): bool
    {
        $result = User::whereAccessToken($email_confirm_code)->first();

        if($result === null) {
            return false;
        }

        $result->access_token = Str::random(200);
        $result->email_verified_at = Carbon::now();;
        $result->save();

        return true;

    }

    public function auth(UserAuthDTO $data): array | null
    {

        $globalResponse = new GlobalResponse();

        # check email
        $user = User::whereEmail($data->email)->first();
        if ($user === null) {
            return null;
        }

        # check password
        if (!Hash::check($data->password, $user->password)) {
            return null;
        }

        # check if confirmed email
        if($user->email_verified_at === null) {
            return null;
        }

        return $globalResponse->success()
            ->setData([
            "name" => $user->name,
            "access_token" => $user->access_token,
            "email" => $user->email
        ])->get();
    }

    public function getUserIDByToken(string $token) {
        $user =  User::whereAccessToken($token)->first();
        return $user->id;
    }
}
