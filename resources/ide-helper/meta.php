<?= '<?php' ?> namespace PHPSTORM_META {

   /**
    * PhpStorm Meta file, to provide autocomplete information for PhpStorm
    * Generated on <?= date("Y-m-d") ?>.
    *
    * @author Barry vd. Heuvel <barryvdh@gmail.com>
    * @see https://github.com/barryvdh/laravel-ide-helper
    */

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
<?php foreach($methods as $method): ?>
        <?= $method ?>('') => [
            'config' instanceof \Laradic\Config\Repository,
<?php foreach($bindings as $abstract => $class): ?>
            '<?= $abstract ?>' instanceof \<?= $class ?>,
<?php endforeach ?>        ],
<?php endforeach ?>
    ];
}
