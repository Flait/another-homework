<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

class ProductRepository
{
    public function __construct(
        private Explorer $db,
    ) {
    }

    /** @return Product[] */
    public function findAll(): array
    {
        $rows = $this->db->table('products')->fetchAll();

        return array_map([$this, 'mapRowToProduct'], $rows);
    }

    public function findById(int $id): ?Product
    {
        $row = $this->db->table('products')->get($id);
        if (!$row) {
            return null;
        }

        return $this->mapRowToProduct($row);
    }

    public function insert(string $name, float $price): int
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $row = $this->db->table('products')->insert([
            'name'       => $name,
            'price'      => $price,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        if (!$row instanceof \Nette\Database\Table\ActiveRow) {
            throw new \RuntimeException('Insert into products failed.');
        }

        return (int) $row->id;
    }

    public function update(int $id, string $name, float $price): bool
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        return $this->db->table('products')->where('id', $id)->update([
                'name'       => $name,
                'price'      => $price,
                'updated_at' => $now,
            ]) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->db->table('products')->where('id', $id)->delete() > 0;
    }

    private function mapRowToProduct(ActiveRow $row): Product
    {
        return new Product(
            id: (int) $row->id,
            name: (string) $row->name,
            price: (float) $row->price,
            createdAt: new \DateTimeImmutable($row->created_at->format('Y-m-d H:i:s')),
            updatedAt: new \DateTimeImmutable($row->updated_at->format('Y-m-d H:i:s')),
        );
    }
}
