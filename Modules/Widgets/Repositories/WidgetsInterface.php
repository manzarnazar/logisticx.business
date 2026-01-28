<?php

namespace Modules\Widgets\Repositories;

interface WidgetsInterface
{
    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function get(string $orderBy = 'id', string $sortBy = 'desc');
    public function activeHeaderFooter();
    public function getFind($id);
    public function store($request);
    public function update($request, $id);
    public function delete($id);
    public function statusUpdate($id);

    public function getWidget($status = null, array $where = [], int $paginate = null, $orderBy = 'position');

    public function activeDeliveryCalculator();
    public function activeChargeListSection();
}
