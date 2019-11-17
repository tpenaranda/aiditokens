<?php

namespace TPenaranda\Aiditokens;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ModelToken extends Model
{
    protected $table = 'tpenaranda_aiditokens_model_tokens';

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'expire_at' => 'date',
    ];

    public static function find($token, $columns = ['*'])
    {
        if (is_string($token) && !is_numeric($token)) {
            return self::whereValue($token)->first($columns);
        }

        return self::whereKey($token)->first($columns);
    }

    public function getModelAttribute()
    {
        return $this->model_class::find($this->model_id);
    }

    public function expire(): self
    {
        if (empty($this->expire_at) || $this->expire_at->gt(now())) {
            $this->expire_at = now();
            $this->save();
        }

        return $this;
    }
}
