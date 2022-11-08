<?php

namespace netvod\action;

interface Action
{
    public function execute(): string;
}