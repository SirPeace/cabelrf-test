<?php

namespace App;

class AvatarManager extends UploadManager
{
    const PATH = 'public/avatars';
    const SUPPORTED_MIME_TYPES = ['image/png', 'image/jpeg'];
    const DEFAULT_FILE = '/default.jpg';
}
