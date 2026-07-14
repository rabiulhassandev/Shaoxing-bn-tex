<?php

namespace App\Services;

use App\Models\Fabric;
use Illuminate\Support\Collection;

class InquiryBasket
{
    private const string SESSION_KEY = 'inquiry_basket';

    public function add(Fabric $fabric): void
    {
        $ids = $this->ids();

        if (! in_array($fabric->id, $ids, true)) {
            $ids[] = $fabric->id;
            session()->put(self::SESSION_KEY, $ids);
        }
    }

    public function remove(Fabric $fabric): void
    {
        $ids = array_values(array_filter($this->ids(), fn (int $id): bool => $id !== $fabric->id));

        session()->put(self::SESSION_KEY, $ids);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function contains(Fabric $fabric): bool
    {
        return in_array($fabric->id, $this->ids(), true);
    }

    public function count(): int
    {
        return count($this->ids());
    }

    /**
     * @return array<int, int>
     */
    public function ids(): array
    {
        return session(self::SESSION_KEY, []);
    }

    /**
     * @return Collection<int, Fabric>
     */
    public function fabrics(): Collection
    {
        return Fabric::query()
            ->active()
            ->with('category')
            ->whereIn('id', $this->ids())
            ->orderBy('name')
            ->get();
    }
}
