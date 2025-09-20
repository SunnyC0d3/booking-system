<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicrosoftToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_identifier',
        'access_token',
        'refresh_token',
        'token_type',
        'expires_in',
        'expires_at',
        'scope',
        'tenant_id',
        'is_active',
        'last_refreshed_at'
    ];

    protected $casts = [
        'scope' => 'array',
        'expires_at' => 'datetime',
        'last_refreshed_at' => 'datetime',
        'is_active' => 'boolean',
        'expires_in' => 'integer',
    ];

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    public function scopeExpiringSoon($query, int $minutes = 5)
    {
        return $query->where('expires_at', '<', now()->addMinutes($minutes));
    }

    public function scopeForUser($query, string $userIdentifier)
    {
        return $query->where('user_identifier', $userIdentifier);
    }

    public function scopeValid($query)
    {
        return $query->active()
            ->where('expires_at', '>', now());
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isExpiringSoon(int $minutes = 5): bool
    {
        return $this->expires_at && $this->expires_at->isBefore(now()->addMinutes($minutes));
    }

    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    public function needsRefresh(): bool
    {
        return $this->isExpiringSoon() || $this->isExpired();
    }

    public function hasScope(string $scope): bool
    {
        return in_array($scope, $this->scope ?? []);
    }

    public function hasRequiredScopes(): bool
    {
        $requiredScopes = [
            'Calendars.ReadWrite',
            'offline_access'
        ];

        foreach ($requiredScopes as $scope) {
            if (!$this->hasScope($scope)) {
                return false;
            }
        }

        return true;
    }

    public function updateTokenData(array $tokenData): void
    {
        $this->update([
            'access_token' => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'] ?? $this->refresh_token,
            'token_type' => $tokenData['token_type'] ?? 'Bearer',
            'expires_in' => $tokenData['expires_in'],
            'expires_at' => now()->addSeconds($tokenData['expires_in']),
            'scope' => isset($tokenData['scope']) ? explode(' ', $tokenData['scope']) : $this->scope,
            'last_refreshed_at' => now(),
            'is_active' => true,
        ]);
    }

    public function refreshToken(): void
    {
        $this->update([
            'last_refreshed_at' => now(),
        ]);
    }

    public function deactivate(): void
    {
        $this->update([
            'is_active' => false,
        ]);
    }

    public function activate(): void
    {
        $this->update([
            'is_active' => true,
        ]);
    }

    public function getExpiresInMinutesAttribute(): ?int
    {
        if (!$this->expires_at) {
            return null;
        }

        return (int) now()->diffInMinutes($this->expires_at, false);
    }

    public function getTimeUntilExpiryAttribute(): ?string
    {
        if (!$this->expires_at) {
            return null;
        }

        if ($this->isExpired()) {
            return 'Expired';
        }

        return $this->expires_at->diffForHumans();
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if ($this->isExpired()) {
            return 'expired';
        }

        if ($this->isExpiringSoon()) {
            return 'expiring_soon';
        }

        return 'valid';
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'valid' => 'success',
            'expiring_soon' => 'warning',
            'expired' => 'danger',
            'inactive' => 'secondary',
            default => 'secondary'
        };
    }

    public function getScopeDisplayAttribute(): string
    {
        return implode(', ', $this->scope ?? []);
    }

    public static function getValidTokenForUser(string $userIdentifier): ?self
    {
        return static::forUser($userIdentifier)->valid()->first();
    }

    public static function createFromResponse(string $userIdentifier, array $tokenData, ?string $tenantId = null): self
    {
        static::forUser($userIdentifier)->update(['is_active' => false]);

        return static::create([
            'user_identifier' => $userIdentifier,
            'access_token' => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'],
            'token_type' => $tokenData['token_type'] ?? 'Bearer',
            'expires_in' => $tokenData['expires_in'],
            'expires_at' => now()->addSeconds($tokenData['expires_in']),
            'scope' => isset($tokenData['scope']) ? explode(' ', $tokenData['scope']) : [],
            'tenant_id' => $tenantId,
            'is_active' => true,
        ]);
    }
}
