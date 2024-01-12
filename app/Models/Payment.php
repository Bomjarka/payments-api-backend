<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $payment_system_id
 * @property int $external_payment_id
 * @property string $status
 * @property int $amount
 * @property int $amount_paid
 * @property array $data
 * @method static Builder|Payment whereExternalPaymentId($value)
 */
class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $fillable = [
        'user_id',
        'payment_system_id',
        'external_payment_id',
        'status',
        'amount',
        'amount_paid',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        ];

    public const STATUS_NEW = 'new';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_REJECTED = 'rejected';
    public const STATUSES_ALL = [
        self::STATUS_NEW,
        self::STATUS_PROCESSING,
        self::STATUS_COMPLETED,
        self::STATUS_EXPIRED,
        self::STATUS_REJECTED,
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
