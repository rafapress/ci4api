<?php

echo "🔧 Iniciando build da API CodeIgniter 4 para produção...\n";

// 1. Instala apenas dependências de produção
echo "📦 Instalando dependências de produção com Composer...\n";
exec('composer install --no-dev');

// 2. Cria pasta temporária para o build
$buildDir = 'build';
@mkdir("$buildDir/public_html", 0777, true);

// 3. Copia e ajusta o index.php
echo "📁 Copiando public/ e ajustando index.php...\n";
$publicFiles = scandir('public');
foreach ($publicFiles as $file) {
    if ($file !== '.' && $file !== '..') {
        copy("public/$file", "$buildDir/public_html/$file");
    }
}

// Ajuste nos paths do index.php
$index = file_get_contents('public/index.php');
$index = str_replace(
    "require FCPATH . '../vendor/autoload.php';",
    "require __DIR__ . '/../vendor/autoload.php';",
    $index
);
$index = str_replace(
    "require_once FCPATH . '../app/Config/Paths.php';",
    "require_once __DIR__ . '/../app/Config/Paths.php';",
    $index
);
file_put_contents("$buildDir/public_html/index.php", $index);

// 4. Copia pastas importantes
echo "📁 Copiando diretórios: app/, vendor/, writable/\n";
$folders = ['app', 'vendor', 'writable'];
foreach ($folders as $folder) {
    if (PHP_OS_FAMILY === 'Windows') {
        exec("xcopy /E /I /Y $folder $buildDir\\$folder");
    } else {
        exec("cp -r $folder $buildDir/");
    }
}

// 5. Copia e edita o .env para produção
echo "⚙️  Configurando .env para ambiente de produção...\n";
$envContent = file_exists('.env') ? file_get_contents('.env') : '';
$envContent = preg_replace(
    '/^CI_ENVIRONMENT\s*=.*$/m',
    'CI_ENVIRONMENT = production',
    $envContent
);
file_put_contents("$buildDir/.env", $envContent);

// 6. Copia composer.json
copy('composer.json', "$buildDir/composer.json");

// 7. Cria o pacote zip
echo "🗜️  Compactando build final em ci4_api_package.zip...\n";
$zip = new ZipArchive();
$zip->open('ci4_api_package.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($buildDir),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen(realpath($buildDir)) + 1);
        $zip->addFile($filePath, $relativePath);
    }
}

$zip->close();

echo "✅ Build finalizado com sucesso: ci4_api_package.zip\n";
