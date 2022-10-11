<?php

declare(strict_types=1);

namespace Synetic\Migator\Service\Migration;

interface MigrationGeneratorInterface {

    public function generateMigration($up, $down);

}
