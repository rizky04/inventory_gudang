<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AgentConversationMessage extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'conversation_id', 'user_id', 'agent',
        'role', 'content', 'attachments', 'tool_calls',
        'tool_results', 'usage', 'meta',
    ];

    protected $attributes = [
        'attachments'  => '[]',
        'tool_calls'   => '[]',
        'tool_results' => '[]',
        'usage'        => '{}',
        'meta'         => '{}',
    ];

    protected static function booting(): void
    {
        static::creating(function (self $model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function conversation()
    {
        return $this->belongsTo(AgentConversation::class, 'conversation_id');
    }
}
