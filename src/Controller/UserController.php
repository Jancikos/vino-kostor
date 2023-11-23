<?php

namespace App\Controller;

use App\Model\User;
use App\Model\UserQuery;
use App\Utils\JsonResponse\FlashMessageType;
use App\Utils\JsonResponse\JsonDataResponse;
use App\Utils\JsonResponse\JsonValidationResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/users", name="admin_users_")
 */
class UserController extends AdminController
{
    public function __construct()
    {
        $this->addBreadcrumb('Používatelia', 'admin_users_index');
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->renderAdminPage(
            'Používatelia',
            'users',
            [
                'users' => UserQuery::create()->find()
            ]
        );
    }

    /**
     * @Route("/form/{pk}", name="form", defaults={"pk": 0})
     */
    public function form($pk = 0): Response
    {
        $user = UserQuery::create()->findOneByPk($pk);
        $editMode = true;
        if ($user === null) {
            if ($pk !== 0) {
                $this->addFlash(FlashMessageType::DANGER, 'Používateľ nebol nájdený.');
                return $this->redirectToRoute('admin_users_index');
            }

            $user = new User();
            $editMode = false;
            $this->addBreadcrumb('Nový používateľ', 'admin_users_form');
        } else {
            $this->addBreadcrumb('Používateľ ' . $user->getUsername(), 'admin_users_form');
        }

        return $this->renderAdminPage(
            'Používateľ - formulár',
            'user_form',
            [
                'userModel' => $user,
                'editMode' => $editMode
            ]
        );
    }

    /**
     * @Route("/save", name="save", methods={"POST"})
     */
    public function save(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        /** @var User $user */
        $user = UserQuery::create()->findOneByPk($request->request->get('pk'));
        $isNew = false;
        if ($user === null) {
            $user = new User();
            $isNew = true;
            $user->setRoles(['ROLE_ADMIN']);
        }

        $user->setUsername($request->request->get('username'));

        $newRawPassword = $request->request->get('newPassword', '');
        if ($newRawPassword !== '') {
            $hashedPassword = $passwordHasher->hashPassword($user, $newRawPassword);
            $user->setPassword($hashedPassword);
        }

        $validationResponse = JsonValidationResponse::ValidateModel($user);

        if ($validationResponse->getSuccess()) {
            $user->save();
            $this->addFlash(FlashMessageType::SUCCESS, 'Užívateľ bol ' . ($isNew ? 'vytvorený' : 'upravený') . '.');
        }
        
        return $validationResponse->toJsonResponse();
    }
    
    /**
     * @Route("/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request): Response
    {
        /** @var User $user */
        $user = UserQuery::create()->findPk($request->request->get('pk_'));
        
        if ($user === null) {
            return JsonDataResponse::FailedResponse("Užívateľ nebol nájdený.")->toJsonResponse();
        }

        $user->delete();
        $this->addFlash(FlashMessageType::SUCCESS, 'Užívateľ bol vymazaný.');
        
        return JsonDataResponse::SuccessResponse()->toJsonResponse();
    }
}
