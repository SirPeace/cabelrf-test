<?php

namespace App;

class ProductThumbnailManager extends UploadManager
{
    const PATH = 'public/product-images';
    const SUPPORTED_MIME_TYPES = ['image/png', 'image/jpeg'];
    const DEFAULT_FILE = '/default.png';
}
