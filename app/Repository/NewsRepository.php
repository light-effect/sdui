<?php

namespace App\Repository;

use App\Models\News;
use DateTimeInterface;

class NewsRepository
{
    public function all()
    {
        return News::all();
    }

    public function deleteByDate(DateTimeInterface $dateTime): void
    {
        News::where('created_at', '<', $dateTime)->delete();
    }
}
