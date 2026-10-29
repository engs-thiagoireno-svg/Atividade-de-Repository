# Atividade de Repository - API de Produtos

API em Laravel com CRUD de produtos, usando o padrão Controller → Service → Repository.

## Onde está cada parte

| O que | Arquivo |
|---|---|
| Rotas, validação e respostas | `app/Http/Controllers/Api/ProdutoController.php` |
| Regras de negócio | `app/Services/ProdutoService.php` |
| Contrato do Repository | `app/Repositories/ProdutoRepositoryInterface.php` |
| Repository com create, update, delete e search | `app/Repositories/EloquentProdutoRepository.php` |
| Ligação Interface → Eloquent | `app/Providers/AppServiceProvider.php` |

## Filtros do `search`

`GET /api/produtos` aceita estes filtros, todos opcionais e combináveis:

- `search` — nome contém o texto
- `preco_min` e `preco_max` — faixa de preço
- `descricao` — descrição contém o texto, filtro novo
- `quantidade_min` — estoque mínimo, filtro novo

## Update e Delete

- `PUT /api/produtos/{id}` — atualiza, aceita campos parciais
- `DELETE /api/produtos/{id}` — remove e retorna `204`

## Como testar

Com um produto cadastrado: nome `Teste`, descricao `produto de exemplo`, preco_custo `100`, preco `120` e quantidade `5`.

| Requisição | Resultado esperado |
|---|---|
| `GET http://127.0.0.1:8000/api/produtos?preco_min=50&preco_max=200` | traz o produto |
| `GET http://127.0.0.1:8000/api/produtos?preco_min=130` | lista vazia, pois 120 fica fora |
| `GET http://127.0.0.1:8000/api/produtos?search=Teste&preco_max=200` | traz o produto |
| `GET http://127.0.0.1:8000/api/produtos?descricao=exemplo` | traz o produto |
| `GET http://127.0.0.1:8000/api/produtos?quantidade_min=10` | lista vazia, pois 5 fica fora |
| `PUT http://127.0.0.1:8000/api/produtos/1` com `{"preco": 150}` | `200` e preço atualizado |
| `DELETE http://127.0.0.1:8000/api/produtos/1` | `204 No Content` |

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```