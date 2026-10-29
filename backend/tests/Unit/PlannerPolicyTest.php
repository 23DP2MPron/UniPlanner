<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Subject;
use App\Models\Task;
use App\Models\User;
use App\Policies\EventPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TaskPolicy;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PlannerPolicyTest extends TestCase
{
    #[DataProvider('plannerRecords')]
    public function test_owner_can_view_update_and_delete_their_record(
        object $policy,
        object $record
    ): void {
        $owner = new User;
        $owner->id = 10;
        $record->user_id = 10;

        $this->assertTrue($policy->view($owner, $record));
        $this->assertTrue($policy->update($owner, $record));
        $this->assertTrue($policy->delete($owner, $record));
        $this->assertTrue($policy->restore($owner, $record));
        $this->assertTrue($policy->forceDelete($owner, $record));
    }

    #[DataProvider('plannerRecords')]
    public function test_user_cannot_access_another_users_record(
        object $policy,
        object $record
    ): void {
        $user = new User;
        $user->id = 11;
        $record->user_id = 10;

        $this->assertFalse($policy->view($user, $record));
        $this->assertFalse($policy->update($user, $record));
        $this->assertFalse($policy->delete($user, $record));
        $this->assertFalse($policy->restore($user, $record));
        $this->assertFalse($policy->forceDelete($user, $record));
    }

    public static function plannerRecords(): array
    {
        return [
            'subject' => [new SubjectPolicy, new Subject],
            'task' => [new TaskPolicy, new Task],
            'event' => [new EventPolicy, new Event],
        ];
    }
}
