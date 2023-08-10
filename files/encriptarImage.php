<?php
function encryptImage($inputFile, $outputFile, $key) {
    $inputImage = file_get_contents($inputFile);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CFB'));
    $encryptedImage = openssl_encrypt($inputImage, 'AES-256-CFB', $key, OPENSSL_RAW_DATA, $iv);

    $dataToWrite = $iv . $encryptedImage;
    file_put_contents($outputFile, $dataToWrite);
}

// Replace 'your_image.jpg' with the path to your image file
$inputImageFile = 'image.jpg';

// Replace 'encrypted_image.jpg' with the desired name for the encrypted output file
$outputEncryptedFile = 'encrypted_image.jpg';

// Replace 'your_secret_key' with your encryption key
$encryptionKey = 'your_secret_key';

encryptImage($inputImageFile, $outputEncryptedFile, $encryptionKey);

echo 'Image encrypted successfully!';
?>
