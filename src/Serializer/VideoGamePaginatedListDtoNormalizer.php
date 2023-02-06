<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Dto\VideoGamePaginatedListDto;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class VideoGamePaginatedListDtoNormalizer
{
    public function __construct(
        private NormalizerInterface $normalizer,
        private VideoGameNormalizer $videoGameNormalizer
    ) {
    }

    public function normalize(VideoGamePaginatedListDto $videoGamePaginationListDto): array
    {
        return $this->normalizer->normalize($videoGamePaginationListDto, context: $this->getSerializerContext());
    }

    protected function getSerializerContext(): array
    {
        return [
            AbstractNormalizer::CALLBACKS => [
                'videoGames' => function ($innerObject) {
                    return array_map(fn ($videoGame) => $this->videoGameNormalizer->normalize($videoGame), $innerObject);
                },
            ],
        ];
    }
}
