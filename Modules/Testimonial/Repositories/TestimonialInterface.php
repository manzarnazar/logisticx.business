<?php

namespace Modules\Testimonial\Repositories;

interface TestimonialInterface
{

    public function all(string $orderBy = 'id', string $sortBy = 'desc');
    public function activeTestimonial();
    public function get(string $orderBy = 'id', string $sortBy = 'desc');
    public function getFind($id);
    public function store($request);
    public function update($id, $request);
    public function delete($id);
    public function statusUpdate($id);
}
