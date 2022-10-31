@php
echo '<?php';
@endphp

namespace {{$namespace}};

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Infrastructure\Security\CustomSanctumToken;
use Laravel\Sanctum\HasApiTokens;
use Modules\TwoFactorAuth\Models\TwoFactor;
use Modules\User\Data\RBAC;


abstract class {{$modelName}} extends {{$extends}}
{
    protected $table = '{{$table}}';
}
