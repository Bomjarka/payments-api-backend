<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class PaymentSystem extends Model
{
    use HasFactory;

    protected $table = 'payment_system';

    protected $fillable = ['id', 'name'];

    public const AWESOMEPAY = 'awesomepay';
    public const SCARYPAY = 'scarypay';

    public const PAYMENT_SYSTEMS = [
        self::AWESOMEPAY => 6,
        self::SCARYPAY => 816,
    ];
}
