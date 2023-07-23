# Recursive Category Library
This library provides functionality to handle hierarchical categories and render them recursively.

## Usage

```php
// Usage example:
$recursiveCategory = new RecursiveCategory();

// Add root-level categories
$recursiveCategory->addRootCategory(1, 'Category A');
$recursiveCategory->addRootCategory(2, 'Category B');

// Add child categories
$recursiveCategory->addChildCategory(1, 3, 'Category A Child 1');
$recursiveCategory->addChildCategory(1, 4, 'Category A Child 2');
$recursiveCategory->addChildCategory(2, 5, 'Category B Child 1');

// Render the categories as HTML list
echo $recursiveCategory->render();
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Authors

- [Ramazan Çetinkaya](https://github.com/ramazancetinkaya)

## Copyright

Copyright © 2023 Ramazan Çetinkaya
