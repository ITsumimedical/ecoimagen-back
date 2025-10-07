<?php

namespace App\Http\Modules\Transcripciones\Transcripcion\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;

class TranscripcionRepository extends RepositoryBase {

    protected $transcripcionModel;

    public function __construct() {
        $this->transcripcionModel = new Transcripcione();
        parent::__construct($this->transcripcionModel);
    }
}
