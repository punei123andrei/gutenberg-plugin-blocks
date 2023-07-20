<?php return array(
    'root' => array(
        'name' => 'your-vendor/your-plugin',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'brick/math' => array(
            'pretty_version' => '0.11.0',
            'version' => '0.11.0.0',
            'reference' => '0ad82ce168c82ba30d1c01ec86116ab52f589478',
            'type' => 'library',
            'install_path' => __DIR__ . '/../brick/math',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'composer/installers' => array(
            'pretty_version' => 'v1.12.0',
            'version' => '1.12.0.0',
            'reference' => 'd20a64ed3c94748397ff5973488761b22f6d3f19',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'ramsey/collection' => array(
            'pretty_version' => '2.0.0',
            'version' => '2.0.0.0',
            'reference' => 'a4b48764bfbb8f3a6a4d1aeb1a35bb5e9ecac4a5',
            'type' => 'library',
            'install_path' => __DIR__ . '/../ramsey/collection',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'ramsey/uuid' => array(
            'pretty_version' => '4.7.4',
            'version' => '4.7.4.0',
            'reference' => '60a4c63ab724854332900504274f6150ff26d286',
            'type' => 'library',
            'install_path' => __DIR__ . '/../ramsey/uuid',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'rhumsaa/uuid' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '4.7.4',
            ),
        ),
        'roundcube/plugin-installer' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
        'shama/baton' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '*',
            ),
        ),
        'your-vendor/your-plugin' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
