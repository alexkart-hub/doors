<?php

namespace app\classes\Db\Query;

interface SqlData
{
    public function getQuery();
    public function getError();
}