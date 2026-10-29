<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SubjectManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_subject_list_contains_only_the_authenticated_users_subjects(): void
    {
        $user = User::factory()->create();
        $subject = $user->subjects()->create(['name' => 'Biology']);
        User::factory()->create()->subjects()->create(['name' => 'Chemistry']);

        $this->actingAs($user)->get(route('subjects.index'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Subjects/Index', false)
                ->has('subjects', 1)
                ->where('subjects.0.id', $subject->id)
                ->where('subjects.0.name', 'Biology'));
    }

    public function test_user_can_create_a_subject(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('subjects.store'), [
            'name' => 'Biology',
            'description' => 'Life sciences',
            'color' => '#123456',
        ])->assertSessionHasNoErrors()->assertRedirect(route('subjects.index'));

        $this->assertDatabaseHas('subjects', [
            'user_id' => $user->id,
            'name' => 'Biology',
            'description' => 'Life sciences',
            'color' => '#123456',
        ]);
    }

    public function test_subject_creation_requires_a_name_and_limits_color_length(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->from(route('subjects.create'))->post(route('subjects.store'), [
            'name' => '',
            'color' => '#1234567',
        ])->assertSessionHasErrors(['name', 'color']);

        $this->assertDatabaseCount('subjects', 0);
    }

    public function test_user_can_update_and_delete_their_subject(): void
    {
        $user = User::factory()->create();
        $subject = $user->subjects()->create(['name' => 'Biology']);

        $this->actingAs($user)->put(route('subjects.update', $subject), [
            'name' => 'Marine Biology',
            'description' => 'Ocean life',
            'color' => '#abcdef',
        ])->assertSessionHasNoErrors()->assertRedirect(route('subjects.index'));

        $this->assertDatabaseHas('subjects', [
            'id' => $subject->id,
            'name' => 'Marine Biology',
            'description' => 'Ocean life',
            'color' => '#abcdef',
        ]);

        $this->actingAs($user)->delete(route('subjects.destroy', $subject))
            ->assertRedirect(route('subjects.index'));

        $this->assertDatabaseMissing('subjects', ['id' => $subject->id]);
    }

    public function test_deleting_a_subject_detaches_its_tasks_and_events(): void
    {
        $user = User::factory()->create();
        $subject = $user->subjects()->create(['name' => 'Biology']);
        $task = $subject->tasks()->create([
            'user_id' => $user->id,
            'title' => 'Read chapter',
        ]);
        $event = $subject->events()->create([
            'user_id' => $user->id,
            'title' => 'Lecture',
            'start_date' => '2026-11-01',
        ]);

        $this->actingAs($user)->delete(route('subjects.destroy', $subject))
            ->assertRedirect(route('subjects.index'));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'subject_id' => null]);
        $this->assertDatabaseHas('events', ['id' => $event->id, 'subject_id' => null]);
    }

    #[DataProvider('subjectActions')]
    public function test_other_users_cannot_view_or_change_a_subject(string $method, string $route): void
    {
        $subject = User::factory()->create()->subjects()->create(['name' => 'Private']);
        $otherUser = User::factory()->create();

        $this->actingAs($otherUser)->{$method}(route($route, $subject), [
            'name' => 'Unauthorized update',
        ])->assertForbidden();

        $this->assertDatabaseHas('subjects', ['id' => $subject->id, 'name' => 'Private']);
    }

    #[DataProvider('subjectActions')]
    public function test_guests_are_redirected_to_login_for_subject_actions(string $method, string $route): void
    {
        $subject = User::factory()->create()->subjects()->create(['name' => 'Private']);

        $this->{$method}(route($route, $subject))->assertRedirect(route('login'));
    }

    public static function subjectActions(): array
    {
        return [
            'view' => ['get', 'subjects.show'],
            'edit' => ['get', 'subjects.edit'],
            'update' => ['put', 'subjects.update'],
            'delete' => ['delete', 'subjects.destroy'],
        ];
    }
}
