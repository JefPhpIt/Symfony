<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserVideoGameHour;
use App\Entity\VideoGame;
use App\Form\SearchVideoGameType;
use App\Form\UserHourVideoGameType;
use App\Form\VideoGameType;
use App\Repository\UserRepository;
use App\Repository\UserVideoGameHourRepository;
use App\Repository\VideoGameRepository;
use App\Service\VideoGameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/video-game')]
class VideoGameController extends AbstractController
{
    #[Route('/', name: 'app_video_game_index', methods: ['GET'])]
    public function index(VideoGameRepository $videoGameRepository): Response
    {
        return $this->render('video_game/index.html.twig', [
            'video_games' => $videoGameRepository->findAll(),
        ]);
    }

    #[Route('/search/{user}', name: 'app_video_game_search', methods: ['POST', 'GET'])]
    public function search(Request $request, VideoGameService $videoGameService, User $user): Response
    {
        // Form
        $form = $this->createForm(SearchVideoGameType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = ($form->getData());
            // Search in api
            $games = $videoGameService->searchByName($search['search']);

            return $this->render('video_game/result.html.twig', [
                'games' => $games['results'] ?? null,
                'user' => $user
            ]);
        }

        return $this->render('video_game/search.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);

    }

    #[Route('/add-hour/{user}', name: 'app_video_game_add_hour', methods: ['GET', 'POST'])]
    public function AddHour(User $user, Request $request, UserRepository $userRepository,
                            UserVideoGameHourRepository $userVideoGameHourRepository): Response
    {
        $form = $this->createForm(UserHourVideoGameType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_user_index');
        }
        return $this->render('video_game/hourVideoGame.html.twig', [
            'form' => $form->createView(),
            'videoGames' => $userVideoGameHourRepository->findBy(['user' => $user])
        ]);
    }

    #[Route('/add-video_game/{id}/{user}', name: 'app_video_game_add', methods: ['GET'])]
    public function addVideoGame(VideoGameRepository $videoGameRepository,
                                 int $id, VideoGameService $videoGameService, User $user,
                                 UserVideoGameHourRepository $userVideoGameHourRepository,
                                 UserRepository $userRepository): RedirectResponse
    {
        $game = $videoGameService->searchById($id);
        $gameExist = $videoGameRepository->findOneBy(['apiId' => $id]);
        $videoGameHour = new UserVideoGameHour();

        if (!$gameExist) {
            $videoGame = new VideoGame();
            $videoGame->setApiId($game['id']);
            $videoGame->setName($game['name']);
            $videoGame->setReleased(new \DateTime($game['released']));
            $videoGame->setRating($game['rating']);
            $videoGame->setUrlImg($game['background_image']);
            $videoGame->addUser($user);
            $videoGameRepository->save($videoGame, true);
            $videoGameHour->setVideoGame($videoGame);
        } else {
            $user->addVideoGame($gameExist);
            $userRepository->save($user, true);
            $videoGameHour->setVideoGame($gameExist);
        }

        $videoGameHour->setUser($user);
        $userVideoGameHourRepository->save($videoGameHour, true);

        $this->addFlash('success', 'Jeux ajouté avec succès');

        return $this-> redirectToRoute('app_video_game_search', ['user' => $user->getId()]);

    }

    #[Route('/new', name: 'app_video_game_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VideoGameRepository $videoGameRepository): Response
    {
        $videoGame = new VideoGame();
        $form = $this->createForm(VideoGameType::class, $videoGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videoGameRepository->save($videoGame, true);

            return $this->redirectToRoute('app_video_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('video_game/new.html.twig', [
            'video_game' => $videoGame,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_video_game_show', methods: ['GET'])]
    public function show(VideoGame $videoGame): Response
    {
        return $this->render('video_game/show.html.twig', [
            'video_game' => $videoGame,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_video_game_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VideoGame $videoGame, VideoGameRepository $videoGameRepository): Response
    {
        $form = $this->createForm(VideoGameType::class, $videoGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videoGameRepository->save($videoGame, true);

            return $this->redirectToRoute('app_video_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video_game/edit.html.twig', [
            'video_game' => $videoGame,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_video_game_delete', methods: ['POST'])]
    public function delete(Request $request, VideoGame $videoGame, VideoGameRepository $videoGameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$videoGame->getId(), $request->request->get('_token'))) {
            $videoGameRepository->remove($videoGame, true);
        }

        return $this->redirectToRoute('app_video_game_index', [], Response::HTTP_SEE_OTHER);
    }

}
