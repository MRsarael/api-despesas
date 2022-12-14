<?php

namespace app\Services\User;

use App\Repositories\UserRepository;

use App\FormRequests\User\NewUserFormRequest;

use App\Services\Auth\AuthService;

use App\Utils\Util;
use Carbon\Carbon;
use Exception;
use Validator;

class UserService
{
    private $userRepository;
    private $authService;

    public function __construct(AuthService $authService, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }

    public function newUser(array $requestData)
    {
        $validator = Validator::make($requestData, (new NewUserFormRequest)->rules());

        if ($validator->fails()) {
            throw new Exception(Util::convertMessageErrorFormRequest($validator->errors()->messages()));
        }
        
        if($this->userExists($requestData['email'])) {
            throw new Exception("Already exists a registered user with this email address");
        }

        $password = bcrypt($requestData['password']);
        $user = $this->userRepository->newUser($requestData['email'], $requestData['name'], $password);
        
        return $this->authService->execute([
            'password' => $requestData['password'],
            'email'    => $requestData['email']
        ]);
    }

    private function userExists($emailAddress)
    {
        $user = $this->userRepository->searchuserFromEmail($emailAddress);
        return $user !== null && $user->count() > 0;
    }
}