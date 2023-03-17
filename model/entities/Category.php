<?php
// Les entities correspondent nos tables en base de donnée.
namespace Model\Entities;

use App\Entity;

final class Category extends Entity
{

    private $category;
    private $categoryName;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    /**
     * Get the value of category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of categoryName
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Set the value of categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }
}
?>