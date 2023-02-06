<?php

declare(strict_types=1);

namespace App\Dto;

readonly class VideoGamePaginatedListDto
{
    public function __construct(
        public int $page,
        public int $limit,
        public int $nbPage,
        public int $total,
        public array $videoGames,
    ) {
    }
}
