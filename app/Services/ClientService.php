<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:11
 */

namespace SdcProject\Services;


use Prettus\Validator\Exceptions\ValidatorException;
use SdcProject\Repositories\ClientRepository;
use SdcProject\Validators\ClientValidator;

class ClientService {

    protected $clientRepository;
    protected $clientValidator;

    /**
     * @param ClientRepository $clientRepository
     * @param ClientValidator $clientValidator
     */
    public function __construct(ClientRepository $clientRepository, ClientValidator $clientValidator) {
        $this->clientRepository = $clientRepository;
        $this->clientValidator = $clientValidator;
    }

    public function create(array $data) {
        try {
            $this->clientValidator->with($data)->passesOrFail();
            return $this->clientRepository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function update(array $data, $id) {
        try {
            $this->clientValidator->with($data)->passesOrFail();
            return $this->clientRepository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }


}