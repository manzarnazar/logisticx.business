<?php
namespace Modules\Section\Repositories;
interface SectionInterface
{
    public function get();
    public function getFind($type);
    public function update($request);
    public function themeAppearance();
}
