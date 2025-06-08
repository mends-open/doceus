<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Feature\Revision\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $dispatched_at
 * @property string $created_at
 * @property int|null $organization_id
 * @property int|null $user_id
 * @property int|null $revisionable_id
 * @property string $revisionable_type
 * @property string $type
 * @property array<array-key, mixed>|null $data
 * @property string|null $meta
 * @property string|null $session_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $url
 * @property-read Organization|null $organization
 * @property-read Model|\Eloquent|null $revisionable
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereDispatchedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereRevisionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereRevisionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereUserAgent($value)
 */
	class Revision extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $person_id
 * @property mixed $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Person $person
 * @method static \Database\Factories\EmailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Email whereUpdatedAt($value)
 */
	class Email extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property OrganizationType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 * @property-read string|null $sqid
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Person> $people
 * @property-read int|null $people_count
 * @property-read \App\Models\OrganizationUser|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\OrganizationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization withoutTrashed()
 * @mixin \Eloquent
 */
	class Organization extends \Eloquent implements \App\Feature\Revision\Interfaces\Revisionable, \App\Feature\Sqid\Interfaces\Sqidable {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $organization_id
 * @property string $user_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser whereUserId($value)
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganizationUser whereId($value)
 * @mixin \Eloquent
 */
	class OrganizationUser extends \Eloquent implements \App\Feature\Revision\Interfaces\Revisionable {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $pesel
 * @property string|null $id_number
 * @property \App\Feature\Identity\Enums\Gender|null $gender
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string $email
 * @property string $phone
 * @property int $organization_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string|null $sqid
 * @property-read \App\Models\Organization|null $organization
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person wherePesel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Email> $emails
 * @property-read int|null $emails_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Phone> $phones
 * @property-read int|null $phones_count
 * @method static \Database\Factories\PersonFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Person whereIdNumber($value)
 */
	class Person extends \Eloquent implements \App\Feature\Revision\Interfaces\Revisionable, \App\Feature\Sqid\Interfaces\Sqidable {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $person_id
 * @property mixed $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Person $person
 * @method static \Database\Factories\PhoneFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Phone whereUpdatedAt($value)
 */
	class Phone extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $email
 * @property mixed|null $first_name
 * @property mixed|null $last_name
 * @property mixed|null $pesel
 * @property string|null $language
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read string $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePesel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @property-read string|null $sqid
 * @property-read \App\Models\OrganizationUser|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Organization> $organizations
 * @property-read int|null $organizations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Filament\Models\Contracts\HasTenants, \Illuminate\Contracts\Auth\MustVerifyEmail, \App\Feature\Revision\Interfaces\Revisionable, \App\Feature\Sqid\Interfaces\Sqidable {}
}

