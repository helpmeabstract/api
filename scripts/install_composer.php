#!/usr/bin/env php
<?php
define('SIGNATURE_URL', 'https://composer.github.io/installer.sig');
define('SIGNATURE_FILE', '/tmp/composer.sig');
define('INSTALLER_URL', 'https://getcomposer.org/installer');
define('INSTALLER_FILE', '/tmp/composer-setup.php');

function exit_script($status = 0)
{
    unlink(SIGNATURE_FILE);
    unlink(INSTALLER_FILE);
    exit($status);
}

copy(SIGNATURE_URL, SIGNATURE_FILE);
copy(INSTALLER_URL, INSTALLER_FILE);

$expected_hash = trim(file_get_contents(SIGNATURE_FILE));
$installer_hash = hash_file('SHA384', INSTALLER_FILE);

echo "Verifying installer with hash $expected_hash" . PHP_EOL;
echo "Installer file hash: $installer_hash" . PHP_EOL;

if (hash_file('SHA384', INSTALLER_FILE) !== $expected_hash) {
    echo 'Installer corrupt. Exiting.' . PHP_EOL;
    exit_script(-1);
}

echo 'Installer verified. Proceeding with composer installation.' . PHP_EOL;
passthru('php ' . INSTALLER_FILE . ' --install-dir=/usr/bin --filename=composer');
exit_script(0);
