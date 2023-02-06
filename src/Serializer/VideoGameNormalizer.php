<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Developer;
use App\Entity\Franchise;
use App\Entity\Genre;
use App\Entity\Platform;
use App\Entity\Publisher;
use App\Entity\VideoGame;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class VideoGameNormalizer
{
    public function __construct(
        private NormalizerInterface $normalizer,
    ) {
    }

    public function normalize(VideoGame $videoGame): array
    {
        return $this->normalizer->normalize($videoGame, context: $this->getSerializerContext());
    }

    protected function getSerializerContext(): array
    {
        return [
            AbstractNormalizer::CALLBACKS => [
                'genre' => fn (Collection $genres) => $genres->map(static fn (Genre $genre) => $genre->getName()),
                'platform' => fn (Collection $platforms) => $platforms->map(static fn (Platform $platform) => $platform->getName()),
                'developer' => fn (Collection $developers) => $developers->map(static fn (Developer $developer) => $developer->getName()),
                'franchise' => fn (Collection $franchises) => $franchises->map(static fn (Franchise $franchise) => $franchise->getName()),
                'publisher' => fn (Collection $publishers) => $publishers->map(static fn (Publisher $publisher) => $publisher->getName()),
            ],
        ];
    }
}
