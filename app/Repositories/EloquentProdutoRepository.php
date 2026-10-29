<?php

namespace App\Repositories;

use App\Models\Produto;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentProdutoRepository implements ProdutoRepositoryInterface
{
    public function create(array $dados): Produto
    {
        return Produto::create($dados);
    }

    public function update(Produto $produto, array $dados): Produto
    {
        $produto->update($dados);

        return $produto->refresh();
    }

    public function delete(Produto $produto): void
    {
        $produto->delete();
    }

    public function search(array $filtro = [], int $porPagina = 10): LengthAwarePaginator
    {
        return Produto::query()
            ->when(
                $filtro['search'] ?? null,
                fn ($query, $pedaco) => $query->where('nome', 'LIKE', "%{$pedaco}%")
            )
            ->when(
                isset($filtro['preco_min']),
                fn ($query) => $query->where('preco', '>=', $filtro['preco_min'])
            )
            ->when(
                isset($filtro['preco_max']),
                fn ($query) => $query->where('preco', '<=', $filtro['preco_max'])
            )
            // filtro novo 1: busca na descrição
            ->when(
                $filtro['descricao'] ?? null,
                fn ($query, $texto) => $query->where('descricao', 'LIKE', "%{$texto}%")
            )
            // filtro novo 2: quantidade mínima em estoque
            ->when(
                isset($filtro['quantidade_min']),
                fn ($query) => $query->where('quantidade', '>=', $filtro['quantidade_min'])
            )
            ->paginate($porPagina);
    }
}