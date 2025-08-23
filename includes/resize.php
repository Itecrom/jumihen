<?php
function resizeImage($srcPath, $destPath, $maxWidth, $watermarkPath = null, $opacity = 50) {
    list($width, $height, $type) = getimagesize($srcPath);
    if (!in_array($type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP])) return false;

    $ratio = $width / $height;
    $newWidth = $maxWidth;
    $newHeight = intval($maxWidth / $ratio);

    // Load source image
    switch ($type) {
        case IMAGETYPE_JPEG: $srcImg = imagecreatefromjpeg($srcPath); break;
        case IMAGETYPE_PNG:  $srcImg = imagecreatefrompng($srcPath); break;
        case IMAGETYPE_GIF:  $srcImg = imagecreatefromgif($srcPath); break;
        case IMAGETYPE_WEBP: $srcImg = imagecreatefromwebp($srcPath); break;
    }

    // Create destination image
    $dstImg = imagecreatetruecolor($newWidth, $newHeight);

    // Handle transparency for PNG and GIF
    if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF])) {
        imagecolortransparent($dstImg, imagecolorallocatealpha($dstImg, 0, 0, 0, 127));
        imagealphablending($dstImg, false);
        imagesavealpha($dstImg, true);
    }

    // Resize original image into new one
    imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // If watermark logo provided
    if ($watermarkPath && file_exists($watermarkPath)) {
        list($wmWidth, $wmHeight, $wmType) = getimagesize($watermarkPath);
        switch ($wmType) {
            case IMAGETYPE_PNG: $watermark = imagecreatefrompng($watermarkPath); break;
            case IMAGETYPE_JPEG: $watermark = imagecreatefromjpeg($watermarkPath); break;
            case IMAGETYPE_GIF: $watermark = imagecreatefromgif($watermarkPath); break;
            default: $watermark = null;
        }

        if ($watermark) {
            // Scale watermark to 25% of image width
            $targetW = intval($newWidth * 0.25);
            $scaleRatio = $targetW / $wmWidth;
            $targetH = intval($wmHeight * $scaleRatio);

            $resizedWM = imagecreatetruecolor($targetW, $targetH);

            // Preserve transparency
            imagecolortransparent($resizedWM, imagecolorallocatealpha($resizedWM, 0, 0, 0, 127));
            imagealphablending($resizedWM, false);
            imagesavealpha($resizedWM, true);

            imagecopyresampled($resizedWM, $watermark, 0, 0, 0, 0, $targetW, $targetH, $wmWidth, $wmHeight);

            // Merge watermark onto bottom-right with opacity
            $dstX = $newWidth - $targetW - 10;
            $dstY = $newHeight - $targetH - 10;

            imagecopymerge_alpha($dstImg, $resizedWM, $dstX, $dstY, 0, 0, $targetW, $targetH, $opacity);

            imagedestroy($watermark);
            imagedestroy($resizedWM);
        }
    }

    // Save image
    $saved = false;
    switch ($type) {
        case IMAGETYPE_JPEG: $saved = imagejpeg($dstImg, $destPath, 80); break;
        case IMAGETYPE_PNG:  $saved = imagepng($dstImg, $destPath); break;
        case IMAGETYPE_GIF:  $saved = imagegif($dstImg, $destPath); break;
        case IMAGETYPE_WEBP: $saved = imagewebp($dstImg, $destPath); break;
    }

    imagedestroy($srcImg);
    imagedestroy($dstImg);
    return $saved;
}

// Helper function to merge with alpha
function imagecopymerge_alpha($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $opacity) {
    $opacity = max(0, min(100, $opacity));
    $tmp = imagecreatetruecolor($src_w, $src_h);
    imagealphablending($tmp, false);
    imagesavealpha($tmp, true);
    imagecopy($tmp, $dst, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
    imagecopy($tmp, $src, 0, 0, $src_x, $src_y, $src_w, $src_h);
    imagecopymerge($dst, $tmp, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $opacity);
    imagedestroy($tmp);
}
?>
