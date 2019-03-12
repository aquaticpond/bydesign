<?php

namespace Aquatic\ByDesign\Model;

class USPSServiceType
{
    public $id;
    public $realtime_type_id;
    public $service_type;
    public $package_size;
    public $container_type;
    public $machinable;

    public function __construct(
        int $id,
        int $realtime_type_id,
        string $service_type,
        string $package_size,
        string $container_type,
        string $machinable
    ) {
        $this->id = $id;
        $this->realtime_type_id = $realtime_type_id;
        $this->service_type = $service_type;
        $this->package_size = $package_size;
        $this->container_type = $container_type;
        $this->machinable = $machinable;
    }
}
