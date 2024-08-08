# ElegantGlacier

ElegantGlacier is a minimal PHP library designed to integrate Twig templating with WordPress. It provides utility functions that wrap around WordPress functions to make them more readable and maintainable.

## Installation

To install ElegantGlacier, follow these steps:

1. Navigate to your WordPress theme directory.
2. Run the following command to require ElegantGlacier using Composer:

   ```sh
   composer require elegant-glacier/elegant-glacier
   ```

Usage

To use ElegantGlacier in your WordPress theme, follow these steps:
1. Initialize ElegantGlacier

Add the following lines to your theme’s functions.php file to initialize ElegantGlacier:

```php
<?php

// Load Composer dependencies.
require_once __DIR__ . '/vendor/autoload.php';


// Initialize ElegantGlacier.
ElegantGlacier::init(__DIR__);
?>
```

2. Render a Template

In your template files (e.g., index.php), you can render Twig templates using the ElegantGlacier::render method. Here is an example:

```php
<?php

use ElegantGlacier\ElegantGlacier;

// Render the template.
ElegantGlacier::render('index.twig', [
    'title' => 'Welcome to ElegantGlacier',
    'content' => 'This is a sample page using ElegantGlacier.'
]);
?>
```

3. Create a Template
First create the template directory in the theme folder and then create a `index.twig` file
```
<h1>{{ title }}</h1>
```

Utility Functions

ElegantGlacier provides several utility functions that wrap around WordPress functions to make them more readable. Here are a few examples:
getTitle: Gets the title of the current post or page.
```php
 $ title = ElegantGlacier::getTitle();
```
getContent: Gets the content of the current post or page.
```php
$content = ElegantGlacier::getContent();
```
getPosts: Gets a list of posts based on the specified query arguments.
```php
$posts = ElegantGlacier::getPosts([
'post_type' => 'post',
'posts_per_page' => 10
]);
?>
```


## Contributing
If you would like to contribute to ElegantGlacier, please fork the repository and submit a pull request. We welcome contributions of all kinds, including documentation improvements, bug fixes, and new features.
License

ElegantGlacier is open-source software licensed under the MIT license.

This README file provides clear installation instructions, usage examples, and a brief overview of the utility functions included in the `ElegantGlacier` library. It should help developers get started quickly and understand how to integrate the library into their WordPress themes.
