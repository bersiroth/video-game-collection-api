<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\VideoGameRepository;
use App\Serializer\VideoGamePaginatedListDtoNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VideoGameController extends AbstractController
{
    #[Route(
        '/video-games',
        name: 'list_game',
        methods: 'GET',
        format: 'application/json'
    )]
    public function index(Request $request, VideoGameRepository $videoGameRepository, VideoGamePaginatedListDtoNormalizer $videoGamePaginationListDtoNormalizer): JsonResponse
    {
        $videoGameListPaginated = $videoGameRepository->getListPaginated(
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5),
        );

        return $this->json(
            $videoGamePaginationListDtoNormalizer->normalize($videoGameListPaginated)
        );
    }
}
