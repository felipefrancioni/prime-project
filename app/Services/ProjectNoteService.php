<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:11
 */

namespace SdcProject\Services;

use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;
use SdcProject\Repositories\ProjectNoteRepository;
use SdcProject\Validators\ProjectNoteValidator;


class ProjectNoteService
{

    protected $projectNoteRepository;
    protected $projectNoteValidator;

    /**
     * @param ProjectNoteRepository $projectNoteRepository
     * @param ProjectNoteValidator $projectNoteValidator
     */
    public function __construct(ProjectNoteRepository $projectNoteRepository, ProjectNoteValidator $projectNoteValidator)
    {
        $this->projectNoteRepository = $projectNoteRepository;
        $this->projectNoteValidator = $projectNoteValidator;
    }

    public function create(array $data)
    {
        try {
            $this->projectNoteValidator->with($data)->passesOrFail();
            return $this->projectNoteRepository->create($data);
        } catch (QueryException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }


    /**
     * @param array $data
     * @param $projectId
     * @param $noteId
     * @return array|mixed
     * @throws ValidatorException
     * @throws \Exception
     */
    public function update(array $data, $projectId, $noteId)
    {
        $this->projectNoteValidator->with($data)->passesOrFail();

        $note = $this->projectNoteRepository->findWhere([
            'project_id' => $projectId,
            'id' => $noteId
        ]);
        if (count($note) > 0) {
            return $this->projectNoteRepository->update($data, $noteId);
        }

        throw new \Exception("O Note que voce quer atualizar nao existe para o projeto selecionado.");

    }

    public function delete($projectId, $noteId)
    {
        $note = $this->projectNoteRepository->findWhere([
            'project_id' => $projectId,
            'id' => $noteId
        ]);
        if (count($note) > 0) {
            $this->projectNoteRepository->delete($noteId);
        } else {
            throw new \Exception("O Note que voce quer excluir nao existe para o projeto selecionado.");
        }
    }
}