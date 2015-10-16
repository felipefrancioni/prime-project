<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Http\Request;
use SdcProject\Http\Requests;
use SdcProject\Repositories\ClientRepository;
use SdcProject\Services\ClientService;

class ClientController extends Controller {

    private $clientRepository;
    private $clientService;

    /**
     * @param ClientRepository $clientRepository
     * @param ClientService $clientService
     */
    public function __construct(ClientRepository $clientRepository, ClientService $clientService) {
        $this->clientRepository = $clientRepository;
        $this->clientService = $clientService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->clientRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return $this->clientService->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return $this->clientRepository->find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        return $this->clientService->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->clientRepository->find($id)->delete();
    }
}
