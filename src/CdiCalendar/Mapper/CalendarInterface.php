<?php

namespace CdiCalendar\Mapper;

interface CalendarInterface
{

    public function findById($id);

    public function insert($user);

    public function update($user);
}