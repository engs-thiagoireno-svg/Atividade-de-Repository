<?php

namespace App\Services;

use App\Models\Produto;
use App\Repositories\ProdutoRepositoryInterface;
use Illuminate\Validation\ValidationException;

class ProdutoService
{
    public function __construct(
        private ProdutoRepositoryInterface $repository
    ) {}

    public function create(array $dados)
    {
        $this->verificarMargem($dados['preco'], $dados['preco_custo']);

        return $this->repository->create($dados);
    }

    public function update(Produto $produto, array $dados)
    {
        $preco = $dados['preco'] ?? $produto->preco;
        $custo = $dados['preco_custo'] ?? $produto->preco_custo;

        $this->verificarMargem((float) $preco, (float) $custo);

        return $this->repository->update($produto, $dados);
    }

    public function delete(Produto $produto): void
    {
        $this->repository->delete($produto);
    }

    public function listar(array $filtros)
    {
        return $this->repository->search($filtros);
    }

    private function verificarMargem(float $preco, float $custo)
    {
        $valor = $custo + (0.1 * $custo);
        $preco_minimo = round($valor, 2);

        if ($preco < $preco_minimo) {
            throw ValidationException::withMessages([
                'preco' => sprintf('O preco deve ser mais do que 10%% do valor de custo:%.2f', $preco_minimo),
            ]);
        }
    }
}