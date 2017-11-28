<?php

namespace App\Models;

use OlajosCs\Repository\Exceptions\ValidationException;
use OlajosCs\Repository\Model;

/**
 * Class Category
 *
 * Entity of the category
 */
class Category extends Model
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;


    /**
     * Validate the model
     *
     * @return void
     * @throws ValidationException
     */
    public function validate(): void
    {
        if (empty($this->name)) {
            throw new ValidationException('Property: name is empty in category');
        }

        if (empty($this->url)) {
            throw new ValidationException('Property: url is empty in category');
        }
    }


    /**
     * Return the name of the table in the database, which stores the model
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'categories';
    }


    /**
     * Return the name of the id field of the model if exists
     *
     * @return string
     */
    public static function getIdField(): string
    {
        return 'id';
    }


    /**
     * Return the name of the category
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Set the name of the category
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }


    /**
     * Return the url of the category
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }


    /**
     * Set the url of the category
     *
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

}
