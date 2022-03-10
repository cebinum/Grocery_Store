<?php

namespace App\Repositories;

use App\MysteryMarket;

class MysteryMarketRepository
{
    /**
     * Get the latest mystery market day
     * @return Collection
     */
    public function market()
    {
        return MysteryMarket::isToday()->first();
    }
}
