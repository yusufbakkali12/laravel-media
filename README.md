# 📦 Laravel Media

Simple, lightweight **polymorphic media library** for Laravel.  
Attach, retrieve and manage media files (images, documents, etc.) on any model.

> 🛠 Created by [Yusuf Bakkali](https://github.com/yusufbakkali12)

---

## ✨ Features

- Polymorphic relation: attach media to any Eloquent model
- Custom collection names (e.g., 'gallery', 'cover')
- JSON fields for flexible metadata
- Easily add / get / remove media files
- Designed to be simple & extendable

---

## ⚡ Installation

### 1️⃣ Add repository to your Laravel project

In your Laravel project's `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/yusufbakkali12/laravel-media"
    }
]
```

### 2️⃣ Require the package

- composer require bakkali/laravel-media:dev-main


### 3️⃣ Publish migration & migrate

- php artisan vendor:publish --tag=media-migrations
- php artisan migrate

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

## 🗑 Remove media by ID

```php

$post->removeMedia($mediaId);

```

# 🛠 Development & Updates

- composer update bakkali/laravel-media