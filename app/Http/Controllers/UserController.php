<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Http\Request;

use LucaDegasperi\OAuth2Server\Authorizer;
use SdcProject\Http\Requests;
use SdcProject\Http\Controllers\Controller;
use SdcProject\Repositories\UserRepository;

class UserController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Authorizer
     */
    private $authorizer;


    public function authenticated()
    {
        $userId = $this->authorizer->getResourceOwnerId();
        return $this->userRepository->find($userId);
    }


    public function __construct(UserRepository $userRepository, Authorizer $authorizer)
    {
        $this->userRepository = $userRepository;
        $this->authorizer = $authorizer;
    }

    public function index()
    {
        return $this->userRepository->all();
    }


}
