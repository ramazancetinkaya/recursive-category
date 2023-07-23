<?php
/**
 * Recursive Category Library
 *
 * This library provides functionality to handle hierarchical categories and render them recursively.
 *
 * @category  Library
 * @package   RecursiveCategory
 * @version   1.0.0
 * @author    Ramazan Çetinkaya <cetinkayaramazan@protonmail.com>
 * @license   MIT License <https://opensource.org/licenses/MIT>
 * @link      https://github.com/ramazancetinkaya/recursive-category
 */

/**
 * CategoryNode Class
 *
 * Represents a single category node with children and parent references.
 */
class CategoryNode
{
    /**
     * @var int The category ID.
     */
    public $id;

    /**
     * @var string The name of the category.
     */
    public $name;

    /**
     * @var CategoryNode[] An array of child CategoryNode objects.
     */
    public $children = [];

    /**
     * @var CategoryNode|null Reference to the parent CategoryNode object.
     */
    public $parent;

    /**
     * CategoryNode constructor.
     *
     * @param int $id The category ID.
     * @param string $name The name of the category.
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Add a child node to the category.
     *
     * @param CategoryNode $child The child category node to add.
     */
    public function addChild(CategoryNode $child)
    {
        $child->parent = $this;
        $this->children[] = $child;
    }
}

/**
 * RecursiveCategory Class
 *
 * Represents a collection of hierarchical categories and provides rendering functionality.
 */
class RecursiveCategory
{
    /**
     * @var CategoryNode[] An array of root-level CategoryNode objects.
     */
    private $rootCategories = [];

    /**
     * Add a category to the root level.
     *
     * @param int $id The category ID.
     * @param string $name The name of the category.
     */
    public function addRootCategory(int $id, string $name)
    {
        $this->rootCategories[] = new CategoryNode($id, $name);
    }

    /**
     * Add a child category to an existing category node.
     *
     * @param int $parentId The ID of the parent category.
     * @param int $id The category ID.
     * @param string $name The name of the category.
     * @return bool True if the parent category is found and the child is added; false otherwise.
     */
    public function addChildCategory(int $parentId, int $id, string $name): bool
    {
        $parent = $this->findCategoryById($parentId);
        if ($parent) {
            $parent->addChild(new CategoryNode($id, $name));
            return true;
        }
        return false;
    }

    /**
     * Find a category node by its ID.
     *
     * @param int $id The category ID to search for.
     * @param CategoryNode|null $node The starting node for the search (used recursively).
     * @return CategoryNode|null The found category node or null if not found.
     */
    private function findCategoryById(int $id, ?CategoryNode $node = null): ?CategoryNode
    {
        if (!$node) {
            foreach ($this->rootCategories as $rootCategory) {
                $result = $this->findCategoryById($id, $rootCategory);
                if ($result) {
                    return $result;
                }
            }
        } else {
            if ($node->id === $id) {
                return $node;
            }
            foreach ($node->children as $child) {
                $result = $this->findCategoryById($id, $child);
                if ($result) {
                    return $result;
                }
            }
        }
        return null;
    }

    /**
     * Render the categories recursively as an HTML list.
     *
     * @param CategoryNode[] $categories The array of CategoryNode objects to render.
     * @return string The HTML representation of the categories as a nested list.
     */
    private function renderCategories(array $categories): string
    {
        $html = '<ul>';
        foreach ($categories as $category) {
            $html .= '<li>' . htmlspecialchars($category->name, ENT_QUOTES) . '</li>';
            if (!empty($category->children)) {
                $html .= $this->renderCategories($category->children);
            }
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * Render all root-level categories as an HTML list.
     *
     * @return string The HTML representation of all root-level categories as a nested list.
     */
    public function render()
    {
        return $this->renderCategories($this->rootCategories);
    }
}
