<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Enum\ProductFilter;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Utils\Paginator;

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
        return $row ? $this->mapRowToProduct($row) : null;
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
        if (!$row instanceof ActiveRow) {
            throw new \RuntimeException('Insert into products failed.');
        }
        return (int) $row->id;
    }

    public function update(int $id, string $name, float $price): bool
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        return $this->db->table('products')
                ->where('id', $id)
                ->update([
                    'name'       => $name,
                    'price'      => $price,
                    'updated_at' => $now,
                ]) > 0;
    }

    public function delete(int $id): bool
    {
        return $this->db->table('products')->where('id', $id)->delete() > 0;
    }

    /**
     * @param array<ProductFilter, mixed> $filters
     *
     * @return array{
     *   data: Product[],
     *   meta: array{current_page:int,per_page:int,total:int,last_page:int}
     * }
     */
    public function findFilteredPaginated(
        array $filters = [],
        int $page = 1,
        int $perPage = 20
    ): array {
        $table = $this->db->table('products');

        if (isset($filters[ProductFilter::MIN_PRICE->value])) {
            $table->where('price >= ?', $filters[ProductFilter::MIN_PRICE->value]);
        }
        if (isset($filters[ProductFilter::MAX_PRICE->value])) {
            $table->where('price <= ?', $filters[ProductFilter::MAX_PRICE->value]);
        }

        $total = (int) $table->count('*');

        $paginator = new Paginator();
        $paginator->setItemCount($total);
        $paginator->setItemsPerPage($perPage);
        $paginator->setPage(max(1, $page));


        $itemCount = (int) $paginator->getItemCount();
        $lastPage = (int) $paginator->getPageCount();

        $rows = $table
            ->limit($paginator->getLength(), $paginator->getOffset())
            ->fetchAll();

        $products = array_map([$this, 'mapRowToProduct'], $rows);

        return [
            'data' => $products,
            'meta' => [
                'current_page' => $paginator->getPage(),
                'per_page'     => $paginator->getItemsPerPage(),
                'total'        => $itemCount,
                'last_page'    => $lastPage,
            ],
        ];
    }

    private function mapRowToProduct(ActiveRow $row): Product
    {
        return new Product(
            id:        (int) $row->id,
            name:      (string) $row->name,
            price:     (float) $row->price,
            createdAt: new \DateTimeImmutable($row->created_at->format('Y-m-d H:i:s')),
            updatedAt: new \DateTimeImmutable($row->updated_at->format('Y-m-d H:i:s')),
        );
    }
}
