<?php

namespace App\Services\Notification\Repositories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Notification\Repositories\Contracts\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function all(): Collection
    {
        return Notification::all();
    }

    public function find(int $id): ?Notification
    {
        return Notification::find($id);
    }

    public function create(array $data): Notification
    {
        return Notification::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $notification = $this->find($id);
        if (!$notification) {
            return false;
        }
        return $notification->update($data);
    }

    public function delete(int $id): bool
    {
        $notification = $this->find($id);
        if (!$notification) {
            return false;
        }
        return $notification->delete();
    }
}
