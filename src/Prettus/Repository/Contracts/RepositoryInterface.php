<?php
namespace Prettus\Repository\Contracts;

/**
 * Interface RepositoryInterface
 * @package Prettus\Repository\Contracts
 */
interface RepositoryInterface
{

    /**
     * Retrieve data array for populate field select
     *
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function lists($column, $key = null);

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null  $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*']);

    /**
     * Retrieve all data of repository, simple paginated
     *
     * @param null  $limit
     * @param array $columns
     *
     * @return mixed
     */
    public function simplePaginate($limit = null, $columns = ['*']);

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value, $columns = ['*']);

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*']);

    /**
     * Find data by a field being null
     *
     * @param       $field
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNull($field, $columns = ['*']);

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * Find data by excluding multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*']);

    /**
     * Find data using a raw SQL string and optional search parameters
     *
     * @param       $searchSql      The SQL string
     * @param array $searchValues   Values that can be used as parameters with the searchSQL as a prepared statement
     *
     * @return mixed
     */
    public function findSQL($searchSql='', array $searchValues=array());

    /**
     * Return a new default model
     *
     * @param array $overrideDefaults an array to use to override any defaults that are set in the class itself
     * @return mixed
     */
    public function newDefault(array $overrideDefaults=array());

    /**
     * Set the defaults for a new model
     *
     * @return array
     */
    public function setDefaults();

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function update(array $attributes, $id);

    /**
     * Update entities in repository by a where clause
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param array $where
     *
     * @return mixed
     */
    public function updateWhere(array $attributes, array $where);

    /**
     * Update or Create an entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param array $values
     *
     * @return mixed
     */
    public function updateOrCreate(array $attributes, array $values = []);

    /**
     * Delete a entity in repository by id
     *
     * @param $id
     *
     * @return int
     */
    public function delete($id);

    /**
     * Delete entities in repository by where clause
     *
     * @param   array   $where  The where clause to use
     *
     * @return int
     */
    public function deleteWhere(array $where);

    /**
     * Flush the repository
     *
     * @return int
     */
    public function flush();

    /**
     * Order collection by a given column
     *
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc');

    /**
     * Load relations
     *
     * @param $relations
     *
     * @return $this
     */
    public function with($relations);

    /**
     * Set hidden fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function hidden(array $fields);

    /**
     * Set visible fields
     *
     * @param array $fields
     *
     * @return $this
     */
    public function visible(array $fields);

    /**
     * Query Scope
     *
     * @param \Closure $scope
     *
     * @return $this
     */
    public function scopeQuery(\Closure $scope);

    /**
     * Reset Query Scope
     *
     * @return $this
     */
    public function resetScope();

    /**
     * Get Searchable Fields
     *
     * @return array
     */
    public function getFieldsSearchable();

    /**
     * Set Presenter
     *
     * @param $presenter
     *
     * @return mixed
     */
    public function setPresenter($presenter);

    /**
     * Skip Presenter Wrapper
     *
     * @param bool $status
     *
     * @return $this
     */
    public function skipPresenter($status = true);

    /**
     * Get the ID to use for the cache key. This method can be overridden if the class shortname is not appropriate
     * for some reason
     *
     * @return string   The ID for the cache key, defaulted to the called_class
     */
    public function getCacheId();
}
