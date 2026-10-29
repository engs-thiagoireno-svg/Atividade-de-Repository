<?php

namespace App\Repositories;
use App\Models\Produto;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProdutoRepositoryInterface
{
  public function create (array $dados): Produto;

  public function update (Produto $produto, array$dados): Produto;

  public function delete(Produto $produto): void;

  public function search(array $filtro = [], int $porPagina = 10): LengthAwarePaginator;
}