<?php

namespace App\Models;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Class BaseModel
 * @package App
 * @method EloquentModel|Collection|null static $this find($id, $columns = ['*']) Find a model by its primary key.
 * @method EloquentModel|EloquentBuilder|null first($columns = ['*']) Execute the query and get the first result.
 * @method EloquentModel|EloquentBuilder firstOrFail($columns = ['*']) Execute the query and get the first result or throw an exception.
 * @method Collection|EloquentBuilder[] get($columns = ['*']) Execute the query as a "select" statement.
 * @method mixed value($column) Get a single column's value from the first result of a query.
 * @method mixed pluck($column) Get a single column's value from the first result of a query.
 * @method void chunk($count, callable $callback) Chunk the results of the query.
 * @method \Illuminate\Support\Collection lists($column, $key = null) Get an array with the values of a given column.
 * @method LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null) Paginate the given query.
 * @method Paginator simplePaginate($perPage = null, $columns = ['*'], $pageName = 'page') Paginate the given query into a simple paginator.
 * @method int increment($column, $amount = 1, array $extra = []) Increment a column's value by a given amount.
 * @method int decrement($column, $amount = 1, array $extra = []) Decrement a column's value by a given amount.
 * @method void onDelete(Closure $callback) Register a replacement for the default delete function.
 * @method EloquentModel[] getModels($columns = ['*']) Get the hydrated models without eager loading.
 * @method array eagerLoadRelations(array $models) Eager load the relationships for the models.
 * @method array loadRelation(array $models, $name, Closure $constraints) Eagerly load the relationship on a set of models.
 * @method static EloquentBuilder where($column, $operator = null, $value = null, $boolean = 'and') Add a basic where clause to the query.
 * @method EloquentBuilder orWhere($column, $operator = null, $value = null) Add an "or where" clause to the query.
 * @method EloquentBuilder has($relation, $operator = '>=', $count = 1, $boolean = 'and', Closure $callback = null) Add a relationship count condition to the query.
 * @method static EloquentBuilder find($value)
 * @method static EloquentBuilder orderBy($column, $direction = 'asc')
 * @method static EloquentBuilder select($columns = ['*'])
 *
 *
 * @method static QueryBuilder whereRaw($sql, array $bindings = [])
 * @method static QueryBuilder whereBetween($column, array $values)
 * @method static QueryBuilder whereNotBetween($column, array $values)
 * @method static QueryBuilder whereNested(Closure $callback)
 * @method static QueryBuilder addNestedWhereQuery($query)
 * @method static QueryBuilder whereExists(Closure $callback)
 * @method static QueryBuilder whereNotExists(Closure $callback)
 * @method static QueryBuilder whereIn($column, $values)
 * @method static QueryBuilder whereNotIn($column, $values)
 * @method static QueryBuilder whereNull($column)
 * @method static QueryBuilder whereNotNull($column)
 * @method static QueryBuilder orWhereRaw($sql, array $bindings = [])
 * @method static QueryBuilder orWhereBetween($column, array $values)
 * @method static QueryBuilder orWhereNotBetween($column, array $values)
 * @method static QueryBuilder orWhereExists(Closure $callback)
 * @method static QueryBuilder orWhereNotExists(Closure $callback)
 * @method static QueryBuilder orWhereIn($column, $values)
 * @method static QueryBuilder orWhereNotIn($column, $values)
 * @method static QueryBuilder orWhereNull($column)
 * @method static QueryBuilder orWhereNotNull($column)
 * @method static QueryBuilder whereDate($column, $operator, $value)
 * @method static QueryBuilder whereDay($column, $operator, $value)
 * @method static QueryBuilder whereMonth($column, $operator, $value)
 * @method static QueryBuilder whereYear($column, $operator, $value)
 */
abstract class BaseModel extends Model
{

}
