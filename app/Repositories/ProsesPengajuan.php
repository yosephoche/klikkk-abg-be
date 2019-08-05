<?php

namespace App\Repositories;

class ProsesPengajuan extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function model(){
        return 'App\Models\ProsesPengajuan';
    }
}
