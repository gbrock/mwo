<?php

namespace MWO\Repositories;

interface PostRepository {
    public static function getAll();

    public static function getTableHeaders();

    public static function getTableRows();
}
