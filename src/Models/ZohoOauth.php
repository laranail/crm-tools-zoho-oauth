<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Database\Factories\ZohoOAuthFactory;

class ZohoOauth extends Model
{
    use HasFactory;

    protected $table = 'zoho_oauth';

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected $guarded = [];

    protected $appends = [
        'auth_token', 'is_expired',
    ];

    /** The factory lives in the package namespace, where Laravel's naming guess cannot find it. */
    protected static function newFactory(): ZohoOAuthFactory
    {
        return ZohoOAuthFactory::new();
    }

    protected function getAuthTokenAttribute()
    {
        return "Zoho-oauthtoken {$this->access_token}";
    }

    protected function getIsExpiredAttribute()
    {
        return $this->expires_at->isPast();
    }
}
