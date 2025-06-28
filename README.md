# 📦 Laravel Media

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bakkali/laravel-media.svg?style=flat-square)](https://packagist.org/packages/bakkali/laravel-media)
[![Total Downloads](https://img.shields.io/packagist/dt/bakkali/laravel-media.svg?style=flat-square)](https://packagist.org/packages/bakkali/laravel-media)
[![License](https://img.shields.io/packagist/l/bakkali/laravel-media.svg?style=flat-square)](https://packagist.org/packages/bakkali/laravel-media)

Simple, lightweight **polymorphic media library** for Laravel.  
Attach, retrieve, and manage media files (images, documents, etc.) on any Eloquent model.

> 🛠 Created by [Yusuf Bakkali](https://github.com/yusufbakkali12)

## ✨ Features

- Polymorphic relation: attach media to any Eloquent model
- Custom collection names (e.g., 'gallery', 'cover')
- JSON fields for flexible metadata
- Easily add / get / remove media files
- Designed to be simple & extendable

---

## ⚡ Installation


###  1️⃣ Require the package

```php
 composer require bakkali/laravel-media:dev-main
```

### 2️⃣ Publish migration & migrate

```php
- php artisan vendor:publish --tag=media-migrations
- php artisan migrate
```

### 3️⃣ Keep your package updated

- composer update bakkali/laravel-media


# 🧩 Usage

```php
use Bakkali\Media\Traits\HasMedia;

class Post extends Model
{
    use HasMedia;

    // your code...
}
```

## 📥 Add media to a model

```php
$post = Post::find(1);

// Add a media file to 'images' collection
$post->addMedia('/path/to/file.jpg', 'images');

```

## 📂 Get media by collection

```php
$images = $post->getMedia('images');

foreach ($images as $media) {
    echo $media->file_name;
    echo $media->disk;
}
```

## ✏ Update media attributes

```php
$post->updateMedia($mediaId, [
    'name' => 'New name'
]);
```

## 🧹 Soft delete media (alias)

```php

$post->destroyMedia($mediaId);

```

## ❌ Permanently delete media

```php

$post->forceDeleteMedia($mediaId);

```


# 🛠 Development & Updates

- composer update bakkali/laravel-media